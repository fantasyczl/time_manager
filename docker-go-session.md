# Go 容器与 Laravel 共用 Session（解决「没有登陆 - 获取用户信息失败」）

## 1. 卷已这样配

- Laravel 的 session 目录已挂到 Go 容器的 **`/app/session_storage`**：
  - `./storage/framework/sessions:/app/session_storage`
- 环境变量：`SESSION_PATH=/app/session_storage`，`APP_KEY=${APP_KEY:-}`（从 time_manage 的 `.env` 读）。

Go **必须**从「容器内」的 `/app/session_storage` 读 session，不能再用宿主机路径。

---

## 2. 必须改 Go 的配置文件（conf）

你的 conf 挂载自：`.../time_manager_go/conf` → 容器内 `/app/conf`。  
若 Go **只读配置文件**、不读 `SESSION_PATH`，则配置里一定要写成**容器内路径**。

在 **`conf/config.yaml`**（或你实际用的配置文件名）里改成：

```yaml
key: base64:xxxx   # 与 Laravel .env 的 APP_KEY 完全一致（整行复制）

session:
  path: /app/session_storage
  cookie_name: laravel_session
  lifetime: 1440
```

保存后重启：

```bash
docker compose restart timemanager_go
```

---

## 3. 必须让 Laravel 的 APP_KEY 进容器

在 **time_manage** 目录下要有 **`.env`**，且含与 Laravel 一致的 `APP_KEY`，例如：

```bash
APP_KEY=base64:你Laravel的APP_KEY
```

compose 里已用 `APP_KEY=${APP_KEY:-}`，这样 Go 容器才能拿到同一 key 解密 cookie。

---

## 4. 登录与访问顺序

1. 用浏览器打开 **同一域名/端口**：`http://localhost:8080`。
2. 先走 **Laravel 登录**（例如 `http://localhost:8080/login`）登录一次，让浏览器带上 `laravel_session` cookie。
3. 再访问 `http://localhost:8080/time_manage_go/tasks`。  
   不要先访问 Go 再访问 Laravel，也不要换端口/域名，否则 cookie 可能不带上。

---

## 5. 仍提示「没有登陆」时自检

| 检查项 | 做法 |
|--------|------|
| **conf 里 session.path** | 必须是 **`/app/session_storage`**，不能是宿主机路径（如 `/Users/...`）。 |
| **conf 里 cookie_name** | 必须是 **`laravel_session`**。 |
| **conf 里 key** | 与 Laravel `.env` 的 **APP_KEY** 一字不差（含 `base64:`）。 |
| **time_manage 的 .env** | 有 **APP_KEY=base64:xxx**，与 Laravel 一致。 |
| **是否用 Laravel 登录过** | 先访问 8080 的 Laravel 登录页并登录成功。 |
| **请求是否带 cookie** | 浏览器开发者工具 → Network → 选 `/time_manage_go/tasks` 请求 → Request Headers 里是否有 **Cookie: laravel_session=...**。 |
| **session 目录是否有文件** | 宿主机看 `time_manage/storage/framework/sessions/`，登录后应有新文件。 |

---

## 6. 若 Go 源码里写死了 session 路径

若 session 路径是在代码里写死的（不读配置也不读环境变量），需要改 Go 源码，把该路径改成 **`/app/session_storage`**，或改成「先读环境变量 `SESSION_PATH`，没有再读配置，再没有再用该默认值」。

按上面 2～5 步做完并重启 Go 容器后，再试一次；若仍不行，把 `conf` 里和 session/key/cookie 相关的配置贴出来（可打码 APP_KEY 后半段），方便继续排查。

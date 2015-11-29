<nav class="navbar navbar-default">
    <div class="container-fluid">
        <p class="navbar-text">
        时间记录
        </p>

        <ul class="nav navbar-nav">
            <li class="{{ strpos($_SERVER['REQUEST_URI'], '/dashboard') !== false ? 'active' : '' }}">
                <a href="/dashboard">Dashboard <span class="sr-only">(current)</span></a>
            </li>
            <li class="{{ strpos($_SERVER['REQUEST_URI'], '/projects') !== false ? 'active' : '' }}">
                <a href="/projects">项目</a>
            </li>
            <li class="{{ strpos($_SERVER['REQUEST_URI'], '/tasks') !== false ? 'active' : '' }}">
                <a href="/tasks">时间线</a>
            </li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="/auth/logout">退出</a>
            </li>
        </ul>
    </div>
</nav>

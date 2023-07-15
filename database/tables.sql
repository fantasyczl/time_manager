CREATE TABLE `users` (
     `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
     `name` varchar(50) NOT NULL,
     `email` varchar(120) NOT NULL,
     `password` varchar(60) NOT NULL,
     `remember_token` varchar(100) NOT NULL,
     `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
     `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
     PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `projects` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `status` tinyint(3) unsigned DEFAULT '0',
    `name` varchar(100) NOT NULL,
    `description` text,
    `user_id` int(10) unsigned NOT NULL,
    `order` smallint(6) NOT NULL DEFAULT '0',
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`),
    CONSTRAINT `fk_project_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `schedules` (
     `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
     `user_id` int(10) unsigned NOT NULL,
     `name` varchar(50) NOT NULL,
     `status` tinyint(1) NOT NULL,
     `schedule_time` datetime NOT NULL,
     `finish_time` datetime DEFAULT NULL,
     `period` tinyint(1) DEFAULT NULL,
     `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
     `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
     PRIMARY KEY (`id`),
     KEY `user_id` (`user_id`),
     CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `tasks` (
     `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
     `project_id` int(10) unsigned NOT NULL,
     `user_id` int(10) unsigned NOT NULL,
     `start_time` datetime NOT NULL,
     `duration` int(10) unsigned NOT NULL DEFAULT '0',
     `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
     `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
     PRIMARY KEY (`id`),
     KEY `fk_tasks_project` (`project_id`),
     KEY `fk_tasks_user` (`user_id`),
     CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
     CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `products` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `order` int(11) NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `tasks` (
     `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
     `product_id` int(10) unsigned NOT NULL,
     `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
     `created_at` timestamp NULL DEFAULT NULL,
     `updated_at` timestamp NULL DEFAULT NULL,
     PRIMARY KEY (`id`),
     KEY `tasks_product_id_foreign` (`product_id`),
     KEY `tasks_created_at_index` (`created_at`),
     CONSTRAINT `tasks_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
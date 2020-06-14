CREATE TABLE `facebook_users` (
	`id` BIGINT(20) NOT NULL AUTO_INCREMENT,
	`oauth_provider` VARCHAR(64) NOT NULL COLLATE 'utf8mb4_general_ci',
	`oauth_uid` VARCHAR(64) NOT NULL COLLATE 'utf8mb4_general_ci',
	`email` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_general_ci',
	`name` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_general_ci',
	`profile_picture` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_general_ci',
	`created_at` DATETIME NOT NULL DEFAULT current_timestamp(),
	PRIMARY KEY (`id`) USING BTREE
)
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
;
CREATE TABLE IF NOT EXISTS `#__fixassets_items` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `asset_id` int(10) unsigned NOT NULL DEFAULT 0,
    `title` varchar(255) NOT NULL DEFAULT '',
    `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
    `state` tinyint(4) NOT NULL DEFAULT 0,
    `created` datetime NOT NULL,
    `created_by` int(10) unsigned NOT NULL DEFAULT 0,
    `modified` datetime NOT NULL,
    `modified_by` int(10) unsigned NOT NULL DEFAULT 0,
    `checked_out` int(10) unsigned DEFAULT NULL,
    `checked_out_time` datetime DEFAULT NULL,
    `ordering` int(11) NOT NULL DEFAULT 0,
    `params` text NOT NULL,
    PRIMARY KEY (`id`),
    KEY `idx_state` (`state`),
    KEY `idx_checkout` (`checked_out`),
    KEY `idx_createdby` (`created_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;
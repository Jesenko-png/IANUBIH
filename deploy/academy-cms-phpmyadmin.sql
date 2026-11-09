-- IASABIH CMS: O akademiji
-- Uvesti u postojecu bazu online stranice kroz phpMyAdmin.
-- Prije uvoza napraviti backup baze.

CREATE TABLE IF NOT EXISTS `academy_pages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(80) NOT NULL,
  `locale` varchar(2) NOT NULL,
  `content` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `academy_pages_slug_locale_unique` (`slug`, `locale`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Evidentira rucno izvrsenu migraciju kako je Laravel kasnije ne bi ponavljao.
SET @academy_cms_batch := (SELECT COALESCE(MAX(`batch`), 0) + 1 FROM `migrations`);

INSERT INTO `migrations` (`migration`, `batch`)
SELECT '2026_11_09_000001_create_academy_pages_table', @academy_cms_batch
WHERE NOT EXISTS (
  SELECT 1
  FROM `migrations`
  WHERE `migration` = '2026_11_09_000001_create_academy_pages_table'
);

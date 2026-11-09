-- IASABIH CMS: Projekti
-- Alternativa dugmetu "Pripremi bazu" u administratorskom panelu.

CREATE TABLE IF NOT EXISTS `projects` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title_bs` varchar(255) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `kind_bs` varchar(160) NOT NULL,
  `kind_en` varchar(160) NOT NULL,
  `programme_bs` varchar(160) NOT NULL,
  `programme_en` varchar(160) NOT NULL,
  `summary_bs` text NOT NULL,
  `summary_en` text NOT NULL,
  `meta_bs` json NOT NULL,
  `meta_en` json NOT NULL,
  `project_status` varchar(20) NOT NULL DEFAULT 'active',
  `status` varchar(20) NOT NULL DEFAULT 'draft',
  `sort_order` int unsigned NOT NULL DEFAULT 0,
  `created_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_projects_public` (`status`, `sort_order`),
  KEY `projects_created_by_foreign` (`created_by`),
  CONSTRAINT `projects_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET @projects_cms_batch := (SELECT COALESCE(MAX(`batch`), 0) + 1 FROM `migrations`);

INSERT INTO `migrations` (`migration`, `batch`)
SELECT '2026_11_09_000002_create_projects_table', @projects_cms_batch
WHERE NOT EXISTS (
  SELECT 1 FROM `migrations`
  WHERE `migration` = '2026_11_09_000002_create_projects_table'
);

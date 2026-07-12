# BARQAAB WordPress to Laravel migration

This project uses Laravel 12, Filament 4, MySQL, and a custom public frontend.

## CMS data structure

Content is normalized into dedicated tables: `pages`, `projects`, `project_images`, `services`, and `management_members`. Project images use a one-to-many relationship, so every project can have an unlimited ordered gallery with captions, alt text, and a featured image. The former `contents` table is retained as a hidden legacy migration source and is no longer used by these frontend sections.

## Local access

- Website: `http://localhost/company_website/public`
- Admin: `http://localhost/company_website/public/admin`
- Initial user: `admin@barqaab.com.pk`
- Initial password: `ChangeMe123!` (change immediately)

## Fresh installation

```bash
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
```

For production, set the database and mail variables, set `APP_DEBUG=false`, provide a strong `ADMIN_PASSWORD`, point the web root to `public/`, and run `php artisan optimize`.

## WordPress import

The supplied dump was loaded locally into `barqaab_wordpress`. To repeat the content import:

```bash
php artisan wordpress:import --database=barqaab_wordpress --prefix=wp_bbey_
```

The importer is idempotent and maps published WordPress pages and `portfolios` into Laravel content. The supplied archive's `wp-content/uploads` directory contains no media files, although the database contains 93 attachment records. Obtain a complete uploads backup and place it under `public/uploads` to restore those images.

The original SQL and extracted WordPress installation are retained under `source/` for migration reference; do not deploy that directory publicly.

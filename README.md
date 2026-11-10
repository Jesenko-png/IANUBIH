# IASABIH — Website and CMS

A bilingual web application for the International Academy of Science and Arts in Bosnia and Herzegovina (IASABIH). The project combines a public website in Bosnian and English with an administration panel for managing content.

## Features

- Bosnian and English public pages at `/bs` and `/en`.
- Academy information, organizational structure, members, scientific fields, projects, publications, and events.
- News management with images.
- CMS modules for members, projects, academy information, and organizational content.
- Cooperation inquiry form, email notifications, and an administrative inquiry overview.
- User accounts, password recovery, and password changes.
- `member`, `admin`, and `super_admin` roles, with role management available to the super administrator.
- Google Analytics 4 dashboard when the integration is configured.

Some public content is maintained in translation files. The CMS modules cover specific sections rather than every page.

## Technology

- PHP 8.2+ and Laravel 12
- Blade templates, Bootstrap, jQuery, and custom CSS for the public website
- Vite 7 and Tailwind CSS 4 in the frontend build configuration
- SQLite for the default local setup; database settings configured through Laravel's `.env`
- PHPUnit 11

## Local setup

Install PHP 8.2+ with Laravel's required extensions and the database driver you plan to use, Composer, and a Node.js/npm version compatible with Vite 7.

### 1. Clone and install dependencies

```sh
git clone https://github.com/Jesenko-png/IANUBIH.git
cd IANUBIH
composer install
npm ci
```

### 2. Configure the environment

Copy `.env.example` to `.env`. In PowerShell:

```powershell
Copy-Item .env.example .env
```

Set the application values:

```dotenv
APP_NAME=IASABIH
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
DB_CONNECTION=sqlite
```

For SQLite, create an empty `database/database.sqlite` file if it does not exist. In PowerShell:

```powershell
if (!(Test-Path database/database.sqlite)) { New-Item database/database.sqlite -ItemType File }
```

Prepare the application:

```sh
php artisan key:generate
php artisan migrate
php artisan storage:link
npm run build
```

### 3. Create an administrator

```sh
php artisan admin:create
```

The command prompts for a name, email address, and a password of at least 12 characters. It creates a `super_admin` if no users exist; otherwise, it creates an `admin`. The default test seeder is not required for this setup.

### 4. Start the server

```sh
php artisan serve
```

Open [the Bosnian website](http://localhost:8000/bs) or [the English website](http://localhost:8000/en). Sign in at `/login` and access the administration panel at `/admin`.

When working on Vite-managed assets, run `npm run dev` in a separate terminal. Public templates also load static assets from `public/assets`.

## Email and analytics

- The example environment uses `MAIL_MAILER=log`, so local email messages are written to the application log.
- Configure `MAIL_*` settings and the `COOPERATION_*` recipient and sender values to enable cooperation email delivery. Use `COOPERATION_MAILER` to select the form's mailer.
- Configure `GA4_PROPERTY_ID` and `GA4_CREDENTIALS_PATH` for the analytics dashboard. The service account must have access to the corresponding GA4 property.
- Keep `.env` and service account credentials out of Git and outside publicly accessible directories.

## Validation

Run the application tests and compile frontend assets:

```sh
composer test
npm run build
```

The test suite covers CMS modules, account passwords, administration localization, navigation, cooperation email, and analytics. Test database settings are defined in `phpunit.xml`.

## Project structure

| Directory | Purpose |
| --- | --- |
| `app/` | Controllers, models, services, middleware, and Artisan commands |
| `routes/` | Public, account, and administration routes |
| `resources/views/` | Public website and administration Blade templates |
| `lang/` | Bosnian and English translations and page content |
| `public/assets/` | Static stylesheets, scripts, and media |
| `database/migrations/` | Database schema migrations |
| `tests/` | Automated tests |
| `docs/` | CMS module documentation |
| `deploy/` | SQL deployment scripts for specific CMS modules |

## Module documentation

The following guides are currently written in Bosnian:

- [Academy CMS](docs/academy-cms.md)
- [Organization CMS](docs/organization-cms.md)
- [Projects CMS](docs/projects-cms.md)

## Deployment notes

Point the web server's document root to `public/`. Configure the production environment, database, and email delivery; set `APP_ENV=production` and `APP_DEBUG=false`. Ensure `storage/` and `bootstrap/cache/` are writable by the application.

Build frontend assets with `npm ci` followed by `npm run build`. Back up an existing production database before applying migrations, and follow the relevant CMS module instructions in `docs/`.

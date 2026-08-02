# BARQAAB Website Deployment Guide - Bluehost Shared Hosting

This guide explains how to deploy this Laravel 12 and Filament project from the local Windows/XAMPP environment to Bluehost shared hosting.

The project requires:

- PHP 8.2 or newer
- MySQL
- Composer dependencies
- A production `.env` file
- Writable `storage` and `bootstrap/cache` directories
- A public storage symbolic link
- HTTPS

Replace these placeholders throughout the guide:

| Placeholder | Replace with |
|---|---|
| `BLUEHOST_USERNAME` | Your Bluehost/cPanel username |
| `yourdomain.com` | Your real domain name |
| `BLUEHOST_USERNAME_barqaab` | The full database name displayed by Bluehost |
| `BLUEHOST_USERNAME_barqaabuser` | The full database username displayed by Bluehost |
| `YOUR_DATABASE_PASSWORD` | The database user's strong password |

## 1. Confirm the Bluehost PHP version

1. Log in to the Bluehost Portal.
2. Open **Hosting → cPanel**.
3. Open **MultiPHP Manager** or **PHP Manager**.
4. Select the domain.
5. Choose PHP **8.2, 8.3, or 8.4**.
6. Confirm that the following PHP extensions are enabled:

```text
bcmath
ctype
curl
dom
fileinfo
filter
hash
intl
mbstring
openssl
pdo
pdo_mysql
session
tokenizer
xml
zip
```

This project declares PHP `^8.2`. If PHP 8.2 or newer is unavailable, contact Bluehost support before uploading the project.

## 2. Back up the local project

Before deployment, save:

- A ZIP backup of the complete project
- A MySQL database export
- A secure copy of the local `.env`
- A copy of `storage/app/public`

Never share or publicly upload the `.env` file.

## 3. Prepare the project locally

Open PowerShell in:

```powershell
cd D:\xampp\htdocs\company_website
```

Run:

```powershell
composer install --no-dev --optimize-autoloader
npm install
npm run build
php artisan optimize:clear
```

Create a ZIP of the project.

The ZIP should include:

```text
app
bootstrap
config
database
public
resources
routes
storage
vendor
artisan
composer.json
composer.lock
```

It should exclude:

```text
.git
node_modules
tests
.env
storage/logs/*.log
```

Including `vendor` allows deployment even if Composer is unavailable on the Bluehost server.

Do not run `composer update` during deployment. Use the versions already locked in `composer.lock`.

## 4. Use a secure server directory structure

For a primary Bluehost domain, use:

```text
/home/BLUEHOST_USERNAME/
├── barqaab_app/
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── resources/
│   ├── routes/
│   ├── storage/
│   ├── vendor/
│   ├── .env
│   └── artisan
│
└── public_html/
    ├── index.php
    ├── .htaccess
    ├── assets/
    ├── css/
    ├── js/
    ├── build/
    ├── uploads/
    ├── storage -> symbolic link
    └── favicon.ico
```

Only Laravel's public files belong in `public_html`. Do not place `.env`, `app`, `config`, `vendor`, or database files in the web-accessible directory.

If this is an addon domain or subdomain and Bluehost allows its document root to be changed, upload the entire project to `barqaab_app` and set the domain document root to:

```text
/home/BLUEHOST_USERNAME/barqaab_app/public
```

When that option is available, it is cleaner and does not require separating the `public` directory.

## 5. Upload the application

1. Open **Bluehost → Hosting → File Manager**.
2. Go to the account home directory containing `public_html`.
3. Create a directory named `barqaab_app`.
4. Upload the project ZIP into `barqaab_app`.
5. Extract the ZIP.
6. Verify that this file exists:

```text
/home/BLUEHOST_USERNAME/barqaab_app/artisan
```

Avoid an additional nested directory such as:

```text
/home/BLUEHOST_USERNAME/barqaab_app/company_website/artisan
```

If this happens, move the contents of `company_website` one level upward.

## 6. Copy the public files into `public_html`

This section applies to the primary domain layout.

Open:

```text
/home/BLUEHOST_USERNAME/barqaab_app/public
```

Copy everything inside it into:

```text
/home/BLUEHOST_USERNAME/public_html
```

Copy the contents of `public`; do not copy the `public` directory itself.

Make sure hidden files are visible and copy:

```text
.htaccess
```

Afterward, these files should exist:

```text
/home/BLUEHOST_USERNAME/public_html/index.php
/home/BLUEHOST_USERNAME/public_html/.htaccess
/home/BLUEHOST_USERNAME/public_html/assets
/home/BLUEHOST_USERNAME/public_html/css
/home/BLUEHOST_USERNAME/public_html/js
```

If an old WordPress site or Bluehost placeholder exists, back it up before replacing its files.

## 7. Correct `public_html/index.php`

Open:

```text
/home/BLUEHOST_USERNAME/public_html/index.php
```

Use the following code:

```php
<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/../barqaab_app/storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../barqaab_app/vendor/autoload.php';

/** @var Application $app */
$app = require_once __DIR__.'/../barqaab_app/bootstrap/app.php';

$app->handleRequest(Request::capture());
```

If `barqaab_app` is in a different location, adjust all three paths.

## 8. Create the Bluehost database

1. Open **Bluehost → Hosting → cPanel**.
2. Open **MySQL Databases** or **Database Management**.
3. Create a database, for example `barqaab`.
4. Create a database user, for example `barqaabuser`.
5. Generate and securely save a strong password.
6. Add the user to the database.
7. Grant **All Privileges**.

Bluehost normally adds the cPanel username as a prefix, producing names similar to:

```text
BLUEHOST_USERNAME_barqaab
BLUEHOST_USERNAME_barqaabuser
```

Use the complete names displayed by Bluehost.

## 9. Export the local MySQL database

The local database is currently named `barqaab_laravel`.

1. Open `http://localhost/phpmyadmin`.
2. Select `barqaab_laravel`.
3. Click **Export**.
4. Select **Quick**.
5. Select **SQL** format.
6. Click **Go**.
7. Save the `.sql` file.

This export contains the website content and existing administrator account.

## 10. Import the database into Bluehost

1. Open Bluehost **phpMyAdmin**.
2. Select the new Bluehost database on the left.
3. Click **Import**.
4. Select the exported `.sql` file.
5. Click **Go**.
6. Wait for the success message.

Verify that tables such as these exist:

```text
users
sessions
cache
jobs
migrations
pages
projects
services
home_slides
contact_settings
```

The `sessions` table is required because this project uses database-backed sessions.

If the SQL file exceeds Bluehost's phpMyAdmin upload limit, use SSH import or split the SQL file.

## 11. Create the production `.env`

Create this file:

```text
/home/BLUEHOST_USERNAME/barqaab_app/.env
```

Enable **Show Hidden Files** in File Manager if necessary.

Use:

```dotenv
APP_NAME="BARQAAB Consulting Services"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://yourdomain.com
APP_TIMEZONE=Asia/Karachi

APP_LOCALE=en
APP_FALLBACK_LOCALE=en

LOG_CHANNEL=stack
LOG_STACK=single
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=BLUEHOST_USERNAME_barqaab
DB_USERNAME=BLUEHOST_USERNAME_barqaabuser
DB_PASSWORD="YOUR_DATABASE_PASSWORD"

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=lax

CACHE_STORE=database
QUEUE_CONNECTION=sync

FILESYSTEM_DISK=local

MAIL_MAILER=log
MAIL_FROM_ADDRESS="admin@yourdomain.com"
MAIL_FROM_NAME="${APP_NAME}"
```

Important rules:

- Set the real domain in `APP_URL`.
- Keep `APP_DEBUG=false` in production.
- Use the complete Bluehost database and user names.
- `QUEUE_CONNECTION=sync` is suitable initially because shared hosting generally cannot keep a queue worker permanently running.
- Keep `.env` outside `public_html`.
- Quote a database password containing spaces or special characters.

### Generate the application key

Using Bluehost Terminal/SSH:

```bash
cd /home/BLUEHOST_USERNAME/barqaab_app
php artisan key:generate
```

Alternatively, copy the complete `APP_KEY` value from the local `.env`.

Generate or set the production key only once. Changing `APP_KEY` later invalidates Laravel sessions and cookies and can cause the login “page expired” error.

## 12. Upload existing managed files

Upload everything inside the local directory:

```text
D:\xampp\htdocs\company_website\storage\app\public
```

to:

```text
/home/BLUEHOST_USERNAME/barqaab_app/storage/app/public
```

Without these files, database records may exist while their associated uploaded images and documents are missing.

## 13. Create the public storage link

For the separated primary-domain layout, run through Bluehost Terminal/SSH:

```bash
ln -s /home/BLUEHOST_USERNAME/barqaab_app/storage/app/public /home/BLUEHOST_USERNAME/public_html/storage
```

Verify it:

```bash
ls -la /home/BLUEHOST_USERNAME/public_html/storage
```

If `public_html/storage` already exists, inspect and back it up before replacing it.

If the domain points directly to `barqaab_app/public`, use Laravel's normal command instead:

```bash
cd /home/BLUEHOST_USERNAME/barqaab_app
php artisan storage:link
```

## 14. Set permissions

Recommended defaults:

```text
Directories: 755
Files:       644
```

Laravel needs write access to:

```text
/home/BLUEHOST_USERNAME/barqaab_app/storage
/home/BLUEHOST_USERNAME/barqaab_app/bootstrap/cache
```

Run:

```bash
chmod -R 775 /home/BLUEHOST_USERNAME/barqaab_app/storage
chmod -R 775 /home/BLUEHOST_USERNAME/barqaab_app/bootstrap/cache
```

If Bluehost runs PHP as the account owner, `755` may also work. Do not use `777` unless Bluehost support explicitly requires it.

## 15. Run the deployment commands

Using Bluehost Terminal/SSH:

```bash
cd /home/BLUEHOST_USERNAME/barqaab_app

php -v
php artisan optimize:clear
php artisan migrate --force
php artisan config:cache
php artisan event:cache
php artisan route:cache
php artisan view:cache
```

The PHP version displayed by `php -v` must be 8.2 or newer.

`migrate --force` runs only migrations that are not already recorded in the imported database.

Whenever `.env` is changed later, rebuild the cached configuration:

```bash
cd /home/BLUEHOST_USERNAME/barqaab_app
php artisan optimize:clear
php artisan config:cache
```

## 16. Enable HTTPS

1. Enable Bluehost's SSL certificate for the domain.
2. Confirm that `.env` contains:

```dotenv
APP_URL=https://yourdomain.com
SESSION_SECURE_COOKIE=true
```

3. Open:

```text
https://yourdomain.com
https://yourdomain.com/admin/login
```

Choose one canonical hostname:

```text
https://yourdomain.com
```

or:

```text
https://www.yourdomain.com
```

Redirect the other version to it. Mixing HTTP/HTTPS or `www`/non-`www` can cause session and CSRF problems.

## 17. Configure outgoing email

The initial configuration uses:

```dotenv
MAIL_MAILER=log
```

This records mail in the Laravel log but does not send it.

If email delivery is required, obtain the exact SMTP information from Bluehost and replace the mail section with values similar to:

```dotenv
MAIL_MAILER=smtp
MAIL_HOST=YOUR_BLUEHOST_SMTP_HOST
MAIL_PORT=465
MAIL_USERNAME=admin@yourdomain.com
MAIL_PASSWORD="YOUR_EMAIL_PASSWORD"
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=admin@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"
```

Use the host, port, and encryption type provided by Bluehost. After editing `.env`, run:

```bash
php artisan optimize:clear
php artisan config:cache
```

## 18. Configure the scheduler if needed

If scheduled tasks are added to the application:

1. Open **Bluehost → Websites → Manage Site → Advanced → Cron Jobs**.
2. Add the closest available recurring schedule.
3. Use:

```bash
cd /home/BLUEHOST_USERNAME/barqaab_app && /usr/local/bin/php artisan schedule:run >> /dev/null 2>&1
```

The scheduler is optional if the application has no scheduled tasks.

## 19. Production testing checklist

Test all of the following:

- [ ] Homepage loads using HTTPS.
- [ ] CSS, JavaScript, fonts, logos, and images load.
- [ ] `/admin/login` loads.
- [ ] Administrator login succeeds.
- [ ] Admin pages remain logged in.
- [ ] Existing projects, services, pages, and other content appear.
- [ ] Image uploads work.
- [ ] Uploaded images are publicly visible.
- [ ] Contact and career forms submit.
- [ ] Documents can be uploaded and downloaded.
- [ ] Internal URLs still work after refreshing the browser.
- [ ] Incorrect URLs show the application's 404 page.
- [ ] `https://yourdomain.com/up` returns a successful health response.

Check the production Laravel log at:

```text
/home/BLUEHOST_USERNAME/barqaab_app/storage/logs/laravel.log
```

Never enable `APP_DEBUG=true` on the live website because it can expose credentials and server information.

## 20. Common errors

### HTTP 500

Possible causes:

- PHP is older than 8.2.
- `vendor` is missing.
- `.env` contains an invalid value.
- `APP_KEY` is empty.
- PHP extensions are missing.
- Permissions are incorrect.
- Paths in `public_html/index.php` are incorrect.

Check:

```text
/home/BLUEHOST_USERNAME/barqaab_app/storage/logs/laravel.log
```

### Blank page or “No input file specified”

Verify these files exist:

```text
/home/BLUEHOST_USERNAME/barqaab_app/vendor/autoload.php
/home/BLUEHOST_USERNAME/barqaab_app/bootstrap/app.php
```

Then correct the paths in `public_html/index.php`.

### Database connection error

Check:

```dotenv
DB_HOST=localhost
DB_DATABASE=BLUEHOST_USERNAME_barqaab
DB_USERNAME=BLUEHOST_USERNAME_barqaabuser
DB_PASSWORD="YOUR_DATABASE_PASSWORD"
```

Confirm that the database user has been added to the database with all privileges.

### CSS or images are missing

Check:

- `APP_URL` uses the correct HTTPS domain.
- Contents of `public` were copied into `public_html`.
- `public_html/storage` links to `barqaab_app/storage/app/public`.
- Existing files were uploaded into `storage/app/public`.
- The browser console does not report HTTP/HTTPS mixed-content errors.

### “This page has expired” during login

Check:

- The website always uses HTTPS.
- `APP_URL` matches the hostname being visited.
- `SESSION_SECURE_COOKIE=true` is used with HTTPS.
- `SESSION_DOMAIN=null`.
- The `sessions` table exists.
- The database user can write to the `sessions` table.
- `APP_KEY` has not changed.
- Old cached configuration has been cleared.

Run:

```bash
cd /home/BLUEHOST_USERNAME/barqaab_app
php artisan optimize:clear
php artisan config:cache
```

Then clear cookies for the domain and log in again.

### `Class ... not found`

Run:

```bash
cd /home/BLUEHOST_USERNAME/barqaab_app
composer install --no-dev --optimize-autoloader
```

If Composer is unavailable, upload the locally prepared `vendor` directory.

### Changes to `.env` have no effect

Laravel is using cached configuration. Run:

```bash
cd /home/BLUEHOST_USERNAME/barqaab_app
php artisan optimize:clear
php artisan config:cache
```

## 21. Recommended deployment order

Follow this order:

1. Back up the local files and database.
2. Select PHP 8.2 or newer in Bluehost.
3. Create the Bluehost database and database user.
4. Export the local database and import it into Bluehost.
5. Upload the Laravel application to `/home/BLUEHOST_USERNAME/barqaab_app`.
6. Copy only the contents of `public` into `public_html`.
7. Correct the paths in `public_html/index.php`.
8. Create the production `.env`.
9. Generate or set `APP_KEY` once.
10. Upload existing `storage/app/public` files.
11. Create the public storage symbolic link.
12. Set directory permissions.
13. Run `php artisan migrate --force`.
14. Clear and rebuild Laravel caches.
15. Enable SSL and verify HTTPS.
16. Test the public website and administrator login.
17. Configure SMTP and cron jobs if required.

## Security reminder

Do not upload the complete Laravel project into `public_html`. Only Laravel's public files should be web-accessible. In particular, these must remain outside `public_html`:

```text
.env
app
bootstrap
config
database
resources
routes
storage
vendor
artisan
```

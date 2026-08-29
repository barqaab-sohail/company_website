# BARQAAB Consulting Services Website

Production deployment guide for the Laravel 12 public website and Filament 4 administration panel.

- Public website: `https://your-domain.example/`
- Administration: `https://your-domain.example/admin/login`
- Database: MySQL/MariaDB

## 1. Server requirements

- Linux server (Ubuntu 22.04/24.04 or equivalent recommended)
- Nginx or Apache with HTTPS
- PHP 8.2+ with `bcmath`, `ctype`, `curl`, `dom`, `fileinfo`, `gd`, `intl`, `mbstring`, `openssl`, `pdo_mysql`, `tokenizer`, `xml`, and `zip`
- MySQL 8+ or MariaDB 10.6+
- Composer 2
- Node.js 20.19+ or 22.12+ and npm (on the server or CI build machine)
- Supervisor when using the database queue

The web root **must be the application's `public` directory**, never the repository root.

## 2. Create the database

Replace the example credentials with secure production values:

```sql
CREATE DATABASE barqaab_production CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'barqaab_app'@'localhost' IDENTIFIED BY 'LONG_RANDOM_PASSWORD';
GRANT ALL PRIVILEGES ON barqaab_production.* TO 'barqaab_app'@'localhost';
FLUSH PRIVILEGES;
```

Do not use the MySQL `root` account from the application.

## 3. Upload the application

```bash
sudo mkdir -p /var/www/barqaab
sudo chown "$USER":www-data /var/www/barqaab
git clone YOUR_REPOSITORY_URL /var/www/barqaab
cd /var/www/barqaab
```

For an archive deployment, ensure `artisan`, `composer.json`, and `public` are directly inside `/var/www/barqaab`.

## 4. Install and build dependencies

```bash
composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction
npm ci
npm run build
```

The generated `public/build` directory must be deployed. If Node.js is unavailable in production, build in CI and include `public/build` in the release.

## 5. Configure `.env`

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:

```dotenv
APP_NAME="BARQAAB Consulting Services"
APP_ENV=production
APP_KEY=base64:GENERATED_BY_ARTISAN
APP_DEBUG=false
APP_URL=https://www.barqaab.com.pk
APP_TIMEZONE=Asia/Karachi

LOG_CHANNEL=stack
LOG_STACK=single
LOG_LEVEL=warning

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=barqaab_production
DB_USERNAME=barqaab_app
DB_PASSWORD="DATABASE_PASSWORD"

SESSION_DRIVER=file
SESSION_LIFETIME=720
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null
SESSION_COOKIE=barqaab_admin_session
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax

CACHE_STORE=database
QUEUE_CONNECTION=database
FILESYSTEM_DISK=public

MAIL_MAILER=smtp
MAIL_SCHEME=tls
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=your-smtp-user
MAIL_PASSWORD="your-smtp-password"
MAIL_FROM_ADDRESS=admin@barqaab.com.pk
MAIL_FROM_NAME="${APP_NAME}"

ADMIN_PASSWORD="LONG_UNIQUE_ADMIN_PASSWORD"
```

Production rules:

- Never commit or publicly expose `.env`.
- Keep `APP_DEBUG=false`.
- Do not change `APP_KEY` after launch; doing so invalidates cookies and sessions.
- `APP_URL` must exactly match the canonical HTTPS hostname users visit.
- `SESSION_SECURE_COOKIE=true` requires HTTPS.
- For multiple application servers, use a shared Redis/database session store instead of files.
- Set `ADMIN_PASSWORD` before seeding. The seeder's fallback password is for development only.

## 6. Permissions

```bash
sudo chown -R www-data:www-data /var/www/barqaab/storage /var/www/barqaab/bootstrap/cache
sudo find /var/www/barqaab/storage /var/www/barqaab/bootstrap/cache -type d -exec chmod 775 {} \;
sudo find /var/www/barqaab/storage /var/www/barqaab/bootstrap/cache -type f -exec chmod 664 {} \;
```

Do not make the complete application directory writable by the web-server user.

## 7. First deployment

```bash
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
php artisan optimize:clear
php artisan filament:optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

The full seeder imports current seed data and creates/updates:

- Email: `admin@barqaab.com.pk`
- Password: the `ADMIN_PASSWORD` value

Run it only during the intended initial installation. Do not run it automatically during routine deployments because it may update production content and reset the administrator password. If production data already exists, back it up and review `database/seeders` before seeding.

## 8. Web-server configuration

### Nginx

Create `/etc/nginx/sites-available/barqaab` (adjust the domain, certificate paths, and PHP socket):

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name barqaab.com.pk www.barqaab.com.pk;
    return 301 https://www.barqaab.com.pk$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name www.barqaab.com.pk;

    root /var/www/barqaab/public;
    index index.php;
    client_max_body_size 20M;

    ssl_certificate /etc/letsencrypt/live/www.barqaab.com.pk/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/www.barqaab.com.pk/privkey.pem;

    add_header X-Content-Type-Options nosniff always;
    add_header X-Frame-Options SAMEORIGIN always;
    add_header Referrer-Policy strict-origin-when-cross-origin always;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\. { deny all; }

    location ~* \.(?:css|js|jpg|jpeg|gif|png|webp|svg|ico|woff|woff2)$ {
        expires 7d;
        access_log off;
        try_files $uri /index.php?$query_string;
    }
}
```

```bash
sudo ln -s /etc/nginx/sites-available/barqaab /etc/nginx/sites-enabled/barqaab
sudo nginx -t
sudo systemctl reload nginx
```

### Apache

```bash
sudo a2enmod rewrite headers ssl
```

Create an HTTPS virtual host:

```apache
<VirtualHost *:443>
    ServerName www.barqaab.com.pk
    ServerAlias barqaab.com.pk
    DocumentRoot /var/www/barqaab/public

    <Directory /var/www/barqaab/public>
        AllowOverride All
        Options FollowSymLinks
        Require all granted
    </Directory>

    SSLEngine on
    SSLCertificateFile /etc/letsencrypt/live/www.barqaab.com.pk/fullchain.pem
    SSLCertificateKeyFile /etc/letsencrypt/live/www.barqaab.com.pk/privkey.pem

    Header always set X-Content-Type-Options "nosniff"
    Header always set X-Frame-Options "SAMEORIGIN"
    ErrorLog ${APACHE_LOG_DIR}/barqaab-error.log
    CustomLog ${APACHE_LOG_DIR}/barqaab-access.log combined
</VirtualHost>
```

```bash
sudo a2ensite barqaab
sudo apachectl configtest
sudo systemctl reload apache2
```

Also create a port 80 virtual host that redirects all traffic to the canonical HTTPS hostname.

## 9. Queue worker

Create `/etc/supervisor/conf.d/barqaab-worker.conf`:

```ini
[program:barqaab-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/barqaab/artisan queue:work database --sleep=3 --tries=3 --timeout=90 --max-time=3600
directory=/var/www/barqaab
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=/var/www/barqaab/storage/logs/worker.log
stopwaitsecs=3600
```

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start barqaab-worker:*
```

After every deployment:

```bash
php artisan queue:restart
```

## 10. Scheduler

Add this cron entry for `www-data`:

```cron
* * * * * cd /var/www/barqaab && php artisan schedule:run >> /dev/null 2>&1
```

```bash
sudo crontab -u www-data -e
```

This prepares the server for current or future Laravel scheduled tasks.

## 11. DNS and HTTPS

Point `A` records for the root and `www` hostnames to the production server (and `AAAA` records when IPv6 is used). With Certbot and Nginx:

```bash
sudo certbot --nginx -d barqaab.com.pk -d www.barqaab.com.pk
sudo certbot renew --dry-run
```

Use `certbot --apache` when deploying with Apache.

## 12. Production verification

```bash
php artisan about
php artisan migrate:status
php artisan route:list --path=admin/login
php artisan queue:monitor database:default --max=100
```

Verify in a private browser window:

1. HTTP redirects to the canonical HTTPS URL.
2. Public pages, CSS, JavaScript, and images load without mixed-content errors.
3. `/storage` files load and uploads are writable.
4. Contact and career forms validate and submit.
5. `/admin/login` opens and login succeeds.
6. `/livewire/update` does not return HTTP 419.
7. Filament content changes appear publicly.
8. SMTP mail is delivered instead of written only to logs.
9. Laravel, web-server, and queue logs contain no new errors.

Change the administrator password after the first login and store it in an approved password manager.

## 13. Routine deployments

Back up the database and uploads first:

```bash
cd /var/www/barqaab
php artisan down --retry=60

git pull --ff-only
composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction
npm ci
npm run build

php artisan migrate --force
php artisan filament:upgrade
php artisan optimize:clear
php artisan filament:optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan queue:restart

php artisan up
```

Do not run `db:seed` during routine updates unless a release explicitly requires it and a verified backup exists. If CI builds dependencies/assets, deploy the prepared `vendor` and `public/build` artifacts instead.

## 14. Backup and rollback

Back up the MySQL database, `.env`, `storage/app/public`, and server configuration. Example database backup:

```bash
mysqldump --single-transaction --routines --triggers \
    -u barqaab_app -p barqaab_production \
    | gzip > "barqaab-$(date +%F-%H%M%S).sql.gz"
```

Rollback procedure:

1. Enable maintenance mode.
2. Restore the previous tested release.
3. Restore its matching database backup if irreversible migrations ran.
4. Run `composer install` from the restored lock file and restore/rebuild frontend assets.
5. Rebuild Laravel and Filament caches.
6. Restart queue workers.
7. Disable maintenance mode and repeat production verification.

Never run `migrate:rollback` blindly; first confirm every affected migration has a safe, complete `down()` method.

## 15. Troubleshooting

### HTTP 419 on admin login

- Use exactly the hostname configured in `APP_URL`.
- Confirm HTTPS and `SESSION_SECURE_COOKIE=true`.
- Confirm `storage/framework/sessions` is writable.
- Run:

```bash
php artisan optimize:clear
php artisan filament:upgrade
php artisan filament:optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

- Restart PHP-FPM after dependency/environment changes.
- Clear cookies for the domain or retry in a private window.

### HTTP 500 or blank page

```bash
tail -n 200 storage/logs/laravel.log
sudo tail -n 200 /var/log/nginx/error.log
# Apache alternative:
sudo tail -n 200 /var/log/apache2/barqaab-error.log
```

Check `.env`, database connectivity, PHP extensions, permissions, and cached configuration. Keep `APP_DEBUG=false` in production.

### Uploaded images return 404

```bash
php artisan storage:link
ls -la public/storage
```

Confirm `FILESYSTEM_DISK=public` and write access to `storage/app/public`.

### Configuration changes do not appear

```bash
php artisan optimize:clear
php artisan filament:optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
sudo systemctl reload php8.3-fpm
```

Adjust the PHP-FPM service name for the installed version.

## Security checklist

- Expose only `public`; never expose `.env`, `.git`, `storage`, or the repository root.
- Enforce HTTPS and use unique passwords for MySQL, SMTP, and administrators.
- Restrict SSH/database access with a firewall.
- Apply OS, PHP, Composer, Laravel, Livewire, and Filament security updates.
- Run `composer audit` in every build.
- Keep automated encrypted off-server backups and regularly test restoration.
- Periodically review administrator accounts and logs.

## SEO, analytics, and monitoring

The application provides `/sitemap.xml`, environment-aware `/robots.txt`, a lightweight `/health` JSON endpoint, canonical/Open Graph/Twitter metadata, structured data, public-page cache headers, and consent-gated analytics.

Pages and projects have a **Search engine optimization** section in Filament for custom titles, descriptions, canonical URLs, sharing images, and search-engine visibility.

Analytics is disabled by default. Configure either Plausible or Google Analytics in production and rebuild the configuration cache:

```dotenv
ANALYTICS_ENABLED=true
ANALYTICS_PROVIDER=plausible
PLAUSIBLE_DOMAIN=www.barqaab.com.pk
PLAUSIBLE_SCRIPT=https://plausible.io/js/script.js

# Google Analytics alternative:
# ANALYTICS_PROVIDER=google
# GOOGLE_ANALYTICS_ID=G-XXXXXXXXXX
```

```bash
php artisan config:cache
```

Tracking scripts load only after the visitor selects **Allow analytics**. Monitor `https://your-domain.example/health` from an external uptime service and alert whenever it returns a non-200 response. Security-related login, logout, password, permission, and account events are retained in `storage/logs/security-*.log` for 90 days.

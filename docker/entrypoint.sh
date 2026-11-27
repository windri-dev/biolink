#!/bin/bash
set -e

# 1. Environment file check
if [ ! -f /var/www/html/.env ]; then
    echo "[BioLink Entrypoint] .env file not found. Creating from .env.example..."
    cp /var/www/html/.env.example /var/www/html/.env
fi

# 2. Check APP_KEY
if ! grep -q "^APP_KEY=base64:" /var/www/html/.env; then
    echo "[BioLink Entrypoint] Generating Application Key..."
    php artisan key:generate --force
fi

# 3. Create storage link if not exists
if [ ! -L /var/www/html/public/storage ]; then
    echo "[BioLink Entrypoint] Linking public storage..."
    php artisan storage:link || true
fi

# 4. Wait for database if DB_HOST is set and not 127.0.0.1
if [ -n "$DB_HOST" ] && [ "$DB_HOST" != "127.0.0.1" ] && [ "$DB_HOST" != "localhost" ]; then
    echo "[BioLink Entrypoint] Waiting for database at $DB_HOST:${DB_PORT:-3306}..."
    timeout=60
    while ! nc -z "$DB_HOST" "${DB_PORT:-3306}" >/dev/null 2>&1; do
        timeout=$((timeout - 1))
        if [ "$timeout" -le 0 ]; then
            echo "[BioLink Entrypoint] Warning: Database connection timeout. Continuing..."
            break
        fi
        sleep 1
    done
    echo "[BioLink Entrypoint] Database is reachable!"
fi

# 5. Run migrations (Never run db:seed automatically on boot to prevent resetting user data)
echo "[BioLink Entrypoint] Checking and running database migrations..."
php artisan migrate --force || true

# 6. Set correct permissions for web server
echo "[BioLink Entrypoint] Enforcing storage and cache permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

echo "[BioLink Entrypoint] Container initialization complete. Starting services..."
exec "$@"

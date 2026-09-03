#!/bin/sh
set -e

cd /var/www/html

# --- .env bootstrap ---
if [ ! -f .env ]; then
    echo "[entrypoint] .env not found, copying from .env.example"
    cp .env.example .env
fi

# --- PHP dependencies ---
if [ ! -f vendor/autoload.php ]; then
    echo "[entrypoint] vendor/ missing, running composer install"
    composer install --no-interaction --prefer-dist
fi

# --- App key ---
if ! grep -q "^APP_KEY=base64" .env 2>/dev/null; then
    echo "[entrypoint] Generating APP_KEY"
    php artisan key:generate --force
fi

# --- Frontend dependencies / build ---
if [ ! -d node_modules ]; then
    echo "[entrypoint] node_modules/ missing, running npm install"
    npm install
fi

if [ ! -d public/build ]; then
    echo "[entrypoint] public/build missing, running npm run build"
    npm run build
fi

# --- Wait for MySQL to accept connections ---
DB_HOST_WAIT="${DB_HOST:-mysql}"
DB_PORT_WAIT="${DB_PORT:-3306}"
DB_USER_WAIT="${DB_USERNAME:-laravel}"
DB_PASS_WAIT="${DB_PASSWORD:-}"

echo "[entrypoint] Waiting for MySQL at ${DB_HOST_WAIT}:${DB_PORT_WAIT}..."
i=0
until php -r "exit(@new PDO('mysql:host=${DB_HOST_WAIT};port=${DB_PORT_WAIT}', getenv('DB_USERNAME') ?: 'laravel', getenv('DB_PASSWORD') ?: '') ? 0 : 1);" 2>/dev/null; do
    i=$((i+1))
    if [ "$i" -ge 30 ]; then
        echo "[entrypoint] MySQL did not become ready in time, continuing anyway"
        break
    fi
    sleep 2
done
echo "[entrypoint] MySQL is reachable (or wait timed out), continuing"

# --- Laravel caches: clear any stale config/route cache baked with different env ---
php artisan config:clear >/dev/null 2>&1 || true

exec "$@"

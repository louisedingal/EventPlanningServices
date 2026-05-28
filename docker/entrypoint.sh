#!/bin/sh
set -e

cd /app

PORT="${PORT:-8000}"
export PORT
REALTIME_WS_ENABLED="${REALTIME_WS_ENABLED:-1}"
REALTIME_WS_PORT="${REALTIME_WS_PORT:-8081}"
REALTIME_WS_INTERVAL="${REALTIME_WS_INTERVAL:-2}"

# Railway injects RAILWAY_PUBLIC_DOMAIN; build APP_URL if missing.
if [ -z "${APP_URL:-}" ] && [ -n "${RAILWAY_PUBLIC_DOMAIN:-}" ]; then
    export APP_URL="https://${RAILWAY_PUBLIC_DOMAIN}"
    echo "APP_URL set from RAILWAY_PUBLIC_DOMAIN: ${APP_URL}"
fi

if [ -n "${RAILWAY_ENVIRONMENT:-}" ] || [ -n "${RAILWAY_PUBLIC_DOMAIN:-}" ]; then
    export APP_ENV=prod
    export APP_DEBUG=0
    echo "Railway detected: APP_ENV=prod APP_DEBUG=0"
fi

if [ -n "${APP_URL:-}" ]; then
    export DEFAULT_URI="${APP_URL}"
fi

# Prod mailer: build DSN from BREVO_API_KEY when Railway only sets that variable
if [ -n "${BREVO_API_KEY:-}" ] && [ -z "${MAILER_DSN:-}" ]; then
    export MAILER_DSN="brevo+api://${BREVO_API_KEY}@default"
fi

# Symfony needs a .env file; compose mounts host .env over the image copy.
if [ ! -f .env ]; then
    if [ -f .env.example ]; then
        cp .env.example .env
    else
        printf 'APP_ENV=prod\nAPP_DEBUG=0\n' > .env
    fi
fi

# Bind nginx to Railway PORT (skip sed when already 8000 and file is read-only mount).
NGINX_SITE="/etc/nginx/sites-available/default"
if [ -f "$NGINX_SITE" ] && [ "$PORT" != "8000" ]; then
    if grep -q 'listen 8000' "$NGINX_SITE" 2>/dev/null; then
        sed -i "s/listen 8000/listen ${PORT}/g" "$NGINX_SITE" 2>/dev/null || true
        sed -i "s/listen \[::\]:8000/listen [::]:${PORT}/g" "$NGINX_SITE" 2>/dev/null || true
    fi
fi

echo "Nginx binding 0.0.0.0:${PORT} — set Railway Public Networking to port ${PORT}"

console() {
    if [ -f vendor/autoload_runtime.php ]; then
        php bin/console "$@" 2>&1 || true
    else
        echo "Skip console ($*): vendor/autoload_runtime.php missing"
    fi
}

bootstrap_background() {
    echo "[background] Generating JWT key pair..."
    if [ ! -f config/jwt/private.pem ]; then
        console lexik:jwt:generate-keypair --skip-if-exists
    fi

    if [ -n "${DATABASE_URL:-}" ]; then
        echo "[background] Waiting for database..."
        i=0
        while [ "$i" -lt 30 ]; do
            if console doctrine:query:sql "SELECT 1" >/dev/null 2>&1; then
                break
            fi
            i=$((i + 1))
            sleep 1
        done

        echo "[background] Running migrations..."
        php bin/console doctrine:migrations:migrate --no-interaction 2>&1 || {
            echo "[background] Migration failed — check DATABASE_URL and migration order"
        }
    fi

    if [ "${APP_ENV:-prod}" = "prod" ]; then
        console cache:clear --env=prod --no-debug
        console cache:warmup --env=prod --no-debug
    fi

    console importmap:install --no-interaction 2>/dev/null || true
    console asset-map:compile 2>/dev/null || true

    echo "[background] Bootstrap finished."
}

# PHP-FPM
php-fpm -D

# Nginx config test
nginx -t
grep -E '^\s*listen' "$NGINX_SITE" 2>/dev/null || true

# Start nginx in background
nginx -g 'daemon off;' &
NGINX_PID=$!
REALTIME_PID=""

if [ "$REALTIME_WS_ENABLED" = "1" ] && [ -f vendor/autoload_runtime.php ]; then
    echo "Starting realtime websocket worker on 127.0.0.1:${REALTIME_WS_PORT}"
    php bin/console app:realtime:websocket-server \
        --host=127.0.0.1 \
        --port="${REALTIME_WS_PORT}" \
        --interval="${REALTIME_WS_INTERVAL}" &
    REALTIME_PID=$!
fi

cleanup() {
    kill "$NGINX_PID" 2>/dev/null || true
    if [ -n "$REALTIME_PID" ]; then
        kill "$REALTIME_PID" 2>/dev/null || true
    fi
    killall php-fpm 2>/dev/null || true
}
trap cleanup INT TERM

# Health probe (curl, up to 30s)
PROBE_OK=0
i=0
while [ "$i" -lt 30 ]; do
    if curl -sf "http://127.0.0.1:${PORT}/health.html" >/dev/null 2>&1; then
        PROBE_OK=1
        echo "[probe] health.html OK on 127.0.0.1:${PORT} (after ${i}s)"
        break
    fi
    i=$((i + 1))
    sleep 1
done
if [ "$PROBE_OK" -eq 0 ]; then
    echo "[probe] health.html FAILED on 127.0.0.1:${PORT} — nginx may not be listening"
    tail -20 /var/log/nginx/error.log 2>/dev/null || true
fi

bootstrap_background &

wait "$NGINX_PID"

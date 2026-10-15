#!/bin/sh
set -e

cd /app

# Volume storage bisa kosong (mis. bind mount baru), jadi pastikan strukturnya ada.
mkdir -p storage/app/public storage/app/private \
    storage/framework/cache/data storage/framework/sessions storage/framework/views \
    storage/logs

# Hanya untuk perintah utama (web server), bukan `docker compose run app php artisan ...`
if [ "$1" = "frankenphp" ]; then
    if [ -z "$APP_KEY" ]; then
        echo "ERROR: APP_KEY belum di-set. Lihat README bagian 'Run with Docker'." >&2
        exit 1
    fi
    if [ "${RUN_MIGRATIONS:-false}" = "true" ]; then
        php artisan migrate --force
    fi
    php artisan optimize
fi

exec "$@"

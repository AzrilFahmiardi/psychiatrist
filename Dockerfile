# syntax=docker/dockerfile:1

# Server lama (sikolov.com) jalan di FrankenPHP + PHP 8.4, jadi image ini pakai
# runtime yang sama. FrankenPHP = PHP + web server Caddy dalam satu binary,
# jadi nggak perlu container nginx/php-fpm terpisah.
ARG FRANKENPHP_TAG=1.13-php8.4
ARG NODE_TAG=22-alpine

# ---------------------------------------------------------------------------
# Stage 1: build asset frontend (Vite + Tailwind) -> public/build
# ---------------------------------------------------------------------------
FROM node:${NODE_TAG} AS assets
WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci --no-audit --no-fund

COPY vite.config.js tailwind.config.js postcss.config.js ./
COPY resources ./resources
COPY public ./public
RUN npm run build

# ---------------------------------------------------------------------------
# Stage 2: dependency PHP (composer install, default --no-dev)
# ---------------------------------------------------------------------------
FROM dunglas/frankenphp:${FRANKENPHP_TAG} AS base

RUN install-php-extensions pdo_mysql intl zip bcmath pcntl opcache \
    && cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

COPY docker/php.ini "$PHP_INI_DIR/conf.d/zz-sikolov.ini"

FROM base AS vendor
# true = ikut install require-dev (Faker dkk), cuma perlu kalau mau `db:seed` data demo
ARG INSTALL_DEV_DEPS=false
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install $([ "$INSTALL_DEV_DEPS" = "true" ] || echo --no-dev) \
        --no-scripts --no-autoloader --no-interaction --prefer-dist

# ---------------------------------------------------------------------------
# Stage 3: image runtime
# ---------------------------------------------------------------------------
FROM base AS app
ARG INSTALL_DEV_DEPS=false
WORKDIR /app

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY --from=vendor /app/vendor ./vendor
COPY . .
COPY --from=assets /app/public/build ./public/build

RUN composer dump-autoload $([ "$INSTALL_DEV_DEPS" = "true" ] || echo --no-dev) --optimize --classmap-authoritative \
    && rm /usr/bin/composer \
    && ln -sfn ../storage/app/public public/storage \
    && mkdir -p storage/app/public storage/app/private \
        storage/framework/cache/data storage/framework/sessions storage/framework/views \
        storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache /data/caddy /config/caddy

COPY --chmod=755 docker/entrypoint.sh /usr/local/bin/sikolov-entrypoint

# HTTP biasa di port 8080 (non-root). TLS/domain diurus reverse proxy di depannya.
ENV SERVER_NAME=":8080" \
    APP_ENV=production

USER www-data
EXPOSE 8080

HEALTHCHECK --interval=30s --timeout=5s --start-period=30s --retries=3 \
    CMD curl -fsS http://127.0.0.1:8080/up || exit 1

ENTRYPOINT ["sikolov-entrypoint"]
CMD ["frankenphp", "run", "--config", "/etc/frankenphp/Caddyfile", "--adapter", "caddyfile"]

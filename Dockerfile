FROM composer:2 AS composer

FROM php:8.4-cli

ENV DEBIAN_FRONTEND=noninteractive \
    COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /var/www/html

COPY --from=composer /usr/bin/composer /usr/local/bin/composer

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        ca-certificates \
        curl \
        git \
        procps \
        unzip \
        libsqlite3-0 \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

EXPOSE 8000

CMD ["sh", "-lc", "composer install --no-interaction && if [ ! -f .env ]; then cp .env.example .env; fi && touch database/database.sqlite && if ! grep -q '^APP_KEY=base64:' .env; then php artisan key:generate --force; fi && if [ ! -s database/database.sqlite ]; then php artisan migrate --seed --force; else php artisan migrate --force; fi && composer run docker:dev"]

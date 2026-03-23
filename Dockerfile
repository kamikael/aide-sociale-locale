FROM php:8.2-cli

# ── Outils tiers ───────────────────────────────────────────────────────────────
COPY --from=mlocati/php-extension-installer:2 /usr/bin/install-php-extensions /usr/local/bin/
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ── Node.js 20 (pour Vite) ─────────────────────────────────────────────────────
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# ── Dépendances système ────────────────────────────────────────────────────────
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    curl \
    libsqlite3-dev \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libxml2-dev \
    libonig-dev \
    libicu-dev \
    libssl-dev \
    zlib1g-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# ── Extensions PHP ─────────────────────────────────────────────────────────────
RUN install-php-extensions \
    bcmath \
    curl \
    dom \
    gd \
    intl \
    mbstring \
    opcache \
    openssl \
    pdo_sqlite \
    simplexml \
    xml \
    xmlreader \
    xmlwriter \
    zip

# ── Répertoire de travail ──────────────────────────────────────────────────────
WORKDIR /var/www

# ── Copie du code source ───────────────────────────────────────────────────────
COPY . .

# ── Variables Composer ─────────────────────────────────────────────────────────
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_MEMORY_LIMIT=-1

# ── Installation des dépendances PHP ──────────────────────────────────────────
RUN composer install \
    --no-dev \
    --prefer-dist \
    --optimize-autoloader \
    --no-interaction \
    --no-scripts \
    --no-progress

# ── Installation des dépendances JS et build Vite ─────────────────────────────
RUN npm ci && npm run build && rm -rf node_modules

# ── Préparation des répertoires, SQLite et permissions ────────────────────────
RUN mkdir -p \
        database \
        storage/framework/cache \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
        storage/app/public \
        bootstrap/cache \
    && touch database/database.sqlite \
    && chmod -R 777 storage bootstrap/cache database \
    && chown -R root:root storage bootstrap/cache database

# ── Symlink storage au build ───────────────────────────────────────────────────
RUN php artisan storage:link || true

EXPOSE 10000

# ── Démarrage ──────────────────────────────────────────────────────────────────
CMD ["sh", "-c", "\
    php artisan package:discover --ansi && \
    php artisan config:clear && \
    php artisan config:cache && \
    php artisan route:clear && \
    php artisan view:clear && \
    php artisan migrate --force && \
    php artisan db:seed --force && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-10000} \
"]
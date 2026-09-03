# Laravel 13 development image.
# composer.json declares "php": "^8.3", but the resolved Symfony 8.x components that
# Laravel 13 actually pulls in require PHP >= 8.4.1 (see composer.lock). The host dev
# machine runs PHP 8.5.4, so we match that here to avoid a platform-check mismatch.
# MySQL runs in its own container (see docker-compose.yml).
FROM php:8.5-cli-bookworm

# --- System packages + PHP extensions required by this app ---
RUN apt-get update && apt-get install -y --no-install-recommends \
        git \
        unzip \
        curl \
        default-mysql-client \
        libzip-dev \
        libonig-dev \
    && docker-php-ext-install -j"$(nproc)" \
        pdo_mysql \
        mbstring \
        bcmath \
        exif \
        pcntl \
        zip \
    && rm -rf /var/lib/apt/lists/*

# --- Node.js 22.x (matches host) for building Vite/Tailwind assets ---
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y --no-install-recommends nodejs \
    && rm -rf /var/lib/apt/lists/*

# --- Composer ---
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN sed -i 's/\r$//' /usr/local/bin/entrypoint.sh && chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 8000

ENTRYPOINT ["entrypoint.sh"]
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

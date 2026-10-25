# Stage 1: Build Frontend Assets with Node & Vite
FROM node:20-alpine AS frontend
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: Production PHP 8.3 with Apache
FROM php:8.3-apache

# Install system dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    libpq-dev \
    libzip-dev \
    unzip \
    git \
    && rm -rf /var/lib/apt/lists/*

# Install required PHP extensions
RUN docker-php-ext-install \
    pdo_pgsql \
    zip \
    bcmath \
    opcache

# Enable Apache mod_rewrite for Laravel routing
RUN a2enmod rewrite

# Configure Apache DocumentRoot to point to Laravel's public directory
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Configure Apache to listen on dynamic port from $PORT (default 80)
RUN sed -i 's/80/${PORT}/g' /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

# Copy Composer from official image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer definitions and install PHP dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --prefer-dist --no-interaction

# Copy the rest of the application
COPY . .

# Copy compiled Vite assets from Stage 1
COPY --from=frontend /app/public/build ./public/build

# Finish autoloader and set permissions
RUN composer dump-autoload --optimize \
    && chown -R www-data:www-data storage bootstrap/cache public/assets

ENV PORT=80
EXPOSE 80

# Copy and set entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]

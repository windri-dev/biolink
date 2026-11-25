FROM php:8.4-fpm-alpine

# 1. Install System Dependencies & Native Libraries
RUN apk add --no-cache \
    nginx \
    curl \
    git \
    supervisor \
    bash \
    netcat-openbsd \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    sqlite-dev \
    icu-dev \
    linux-headers

# 2. Configure and Install PHP Extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-configure intl \
    && docker-php-ext-install -j$(nproc) \
        gd \
        pdo \
        pdo_mysql \
        pdo_sqlite \
        bcmath \
        zip \
        opcache \
        intl

# 3. Copy Composer Binary
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 4. Set Working Directory
WORKDIR /var/www/html

# 5. Copy Application Source Code
COPY . /var/www/html/

# 6. Configure Composer & Install Production Dependencies
RUN git config --global --add safe.directory /var/www/html \
    && composer install --no-dev --optimize-autoloader --no-interaction \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 7. Copy Server Configurations & Entrypoint
COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisord.conf
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# 8. Expose Port & Define Container Lifecycle
EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]

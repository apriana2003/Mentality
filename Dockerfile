FROM php:8.2-apache

RUN apt-get update -y && apt-get install -y --no-install-recommends \
    libzip-dev \
    libonig-dev \
    libpng-dev \
    libxml2-dev \
    libicu-dev \
    unzip \
    curl \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mbstring \
        zip \
        intl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN sed -i 's/^ServerName.*//' /etc/apache2/apache2.conf || true
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

RUN a2enmod rewrite

RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' \
    /etc/apache2/sites-available/000-default.conf

RUN sed -i '/<\/VirtualHost>/i \
    <Directory /var/www/html/public>\n\
        Options Indexes FollowSymLinks\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>' /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

COPY . .
RUN composer run-script post-install-cmd --no-interaction || true

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/writable

EXPOSE 80
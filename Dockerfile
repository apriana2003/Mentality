FROM php:8.2-fpm

RUN apt-get update -y && apt-get install -y --no-install-recommends \
    libzip-dev \
    libonig-dev \
    libpng-dev \
    libxml2-dev \
    libicu-dev \
    nginx \
    unzip \
    curl \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mysqli \
        mbstring \
        zip \
        intl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN echo 'client_max_body_size 10M;\n\
server { \n\
    listen 80; \n\
    root /var/www/html/public; \n\
    index index.php index.html; \n\
    location / { \n\
        try_files $uri $uri/ /index.php?$query_string; \n\
    } \n\
    location ~ \.php$ { \n\
        fastcgi_pass 127.0.0.1:9000; \n\
        fastcgi_index index.php; \n\
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name; \n\
        include fastcgi_params; \n\
    } \n\
}' > /etc/nginx/sites-available/default

WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

COPY . .
RUN composer run-script post-install-cmd --no-interaction || true

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/writable

RUN echo '#!/bin/sh\n\
cat > /var/www/html/.env << ENVFILE\n\
CI_ENVIRONMENT = ${CI_ENVIRONMENT:-production}\n\
app.baseURL = ${app_baseURL:-http://localhost/}\n\
app.appTimezone = Asia/Jakarta\n\
database.default.hostname = ${database_default_hostname:-localhost}\n\
database.default.database = ${database_default_database:-railway}\n\
database.default.username = ${database_default_username:-root}\n\
database.default.password = ${database_default_password}\n\
database.default.DBDriver = MySQLi\n\
database.default.port = ${database_default_port:-3306}\n\
openai.apiKey = ${openai_apiKey}\n\
openai.model = ${openai_model:-llama-3.3-70b-versatile}\n\
openai.maxTokens = ${openai_maxTokens:-800}\n\
ENVFILE\n\
service nginx start\n\
php-fpm' > /start.sh && chmod +x /start.sh

EXPOSE 80

CMD ["/start.sh"]
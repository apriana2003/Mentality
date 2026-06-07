FROM php:8.2-fpm

# Install dependensi sistem dan ekstensi PHP yang dibutuhkan CodeIgniter 4
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
        intl \
        zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Ambil Composer versi 2 terbaru
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Buat konfigurasi Nginx Virtual Host untuk CodeIgniter 4 (Menghindari masalah \n)
RUN echo 'server { \n\
    listen 80; \n\
    root /var/www/html/public; \n\
    index index.php index.html; \n\
    client_max_body_size 10M; \n\
    location / { \n\
        try_files $uri $uri/ /index.php?$query_string; \n\
    } \n\
    location ~ \.php$ { \n\
        fastcgi_pass 127.0.0.1:9000; \n\
        fastcgi_index index.php; \n\
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name; \n\
        include fastcgi_params; \n\
    } \n\
    location ~ /\.ht { \n\
        deny all; \n\
    } \n\
}' > /etc/nginx/sites-available/default

WORKDIR /var/www/html

# Optimasi Cache Layer Composer
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

# Salin seluruh source code project
COPY . .

# Berikan izin akses penuh ke folder writable untuk session dan logging CI4
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/writable

# Buat skrip startup untuk generate .env secara dinamis dari variable Railway
RUN echo '#!/bin/sh\n\
cat > /var/www/html/.env << ENVFILE\n\
cloudinary_cloudName = dftkqdftn\n\
cloudinary_apiKey = 729417917272812\n\
cloudinary_apiSecret = 6rNcUzDtm1rPuvF2rYPIfD1bAeU\n\
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

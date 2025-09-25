FROM php:8.2-fpm

# Instalar dependencias del sistema y extensiones de PHP
RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libonig-dev libxml2-dev libzip-dev curl \
    nginx supervisor \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && rm -rf /var/lib/apt/lists/*

# Instalar Composer manualmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

WORKDIR /var/www

# Copiar código de Laravel
COPY . .

# Crear carpetas necesarias y asignar permisos
RUN mkdir -p storage/framework/sessions \
    && mkdir -p storage/framework/views \
    && mkdir -p storage/framework/cache \
    && mkdir -p bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# Instalar dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copiar configuración de Nginx y Supervisor
COPY ./Docker/nginx.conf /etc/nginx/conf.d/default.conf
COPY ./Docker/supervisord.conf /etc/supervisord.conf

# Exponer el puerto (Koyeb espera 8000)
EXPOSE 8000

# Script de arranque: cachear config/rutas y correr migraciones
CMD php artisan config:cache && \
    php artisan route:cache && \
    php artisan migrate --force && \
    /usr/bin/supervisord -c /etc/supervisord.conf

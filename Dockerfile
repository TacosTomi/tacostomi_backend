FROM php:8.4-fpm-alpine

# Dependencias del sistema y utilidades
RUN apk add --no-cache \
    nginx \
    postgresql-dev \
    libpng-dev \
    libzip-dev \
    nodejs \
    npm \
    git \
    curl

# Extensiones de PHP requeridas para Laravel y PostgreSQL
RUN docker-php-ext-install pdo pdo_pgsql bcmath gd zip

# Composer oficial
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copiar configuración de Nginx
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Copiar aplicación completa
COPY . .

# Instalar dependencias backend y compilar frontend
RUN composer install --no-dev --optimize-autoloader --no-interaction
RUN npm install && npm run build

# Configurar permisos para storage y cache
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Script de inicio
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 8080

ENTRYPOINT ["docker-entrypoint.sh"]
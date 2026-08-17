#!/bin/sh
set -e

# Reemplazar el puerto en nginx con el asignado por Render
sed -i "s/8080/${PORT:-8080}/g" /etc/nginx/conf.d/default.conf

# Cachear configuración y vistas en producción
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Correr migraciones de forma automática y segura
php artisan migrate --force

# Iniciar PHP-FPM en segundo plano y Nginx en primer plano
php-fpm -D
nginx -g "daemon off;"
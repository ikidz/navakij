#!/bin/bash
set -e

echo "✅ start.sh is running..."

# Fix file permissions (good for both Laravel & CI2)
#chown -R www-data:www-data /var/www/html
#chmod -R 755 /var/www/html
find /var/www/html -type d -exec chmod 755 {} \;
find /var/www/html -type f -exec chmod 644 {} \;

# Composer install (if Laravel is present)
if [ -f /var/www/html/artisan ]; then
    echo "🔧 Laravel project detected. Running setup..."
    composer install --no-interaction
    php artisan config:clear
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

# Start PHP-FPM with default config
echo "🚀 Starting PHP-FPM..."
php-fpm --nodaemonize --fpm-config /usr/local/etc/php-fpm.conf

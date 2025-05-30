FROM php:7.3-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    zip unzip git curl libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mysqli zip

# Set upload max filesize and post max size to 20MB
RUN echo "upload_max_filesize=20M" > /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size=20M" >> /usr/local/etc/php/conf.d/uploads.ini

WORKDIR /var/www/html

# COPY start.sh /start.sh
# RUN chmod +x /start.sh
# CMD ["/start.sh"]
FROM php:7.3-fpm

# System libs + PHP extensions (GD with JPEG/FreeType, EXIF, etc.)
RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libzip-dev libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    libonig-dev libxml2-dev \
 && docker-php-ext-configure gd \
      --with-freetype-dir=/usr/include/freetype2 \
      --with-jpeg-dir=/usr/include \
 && docker-php-ext-install -j"$(nproc)" gd pdo_mysql mysqli zip exif opcache \
 && docker-php-ext-enable exif opcache \
 && rm -rf /var/lib/apt/lists/*

# PHP overrides
RUN { \
      echo "upload_max_filesize=20M"; \
      echo "post_max_size=20M"; \
      echo "memory_limit=256M"; \
      echo "date.timezone=Asia/Bangkok"; \
    } > /usr/local/etc/php/conf.d/99-overrides.ini

# Composer (optional but handy)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Entrypoint script
COPY start.sh /start.sh
RUN chmod +x /start.sh

WORKDIR /var/www/html
CMD ["php-fpm", "-F"]  # compose keeps entrypoint: ["/start.sh"]

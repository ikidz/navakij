FROM php:7.3-fpm

# System libs needed for GD (JPEG/PNG/FreeType), zip, etc.
RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
 && docker-php-ext-configure gd \
      --with-freetype-dir=/usr/include \
      --with-jpeg-dir=/usr/include \
 && docker-php-ext-install -j$(nproc) gd pdo_mysql mysqli zip exif \
 && docker-php-ext-enable exif \
 && rm -rf /var/lib/apt/lists/*

# Upload limits
RUN { \
    echo "upload_max_filesize=20M"; \
    echo "post_max_size=20M"; \
  } > /usr/local/etc/php/conf.d/uploads.ini

WORKDIR /var/www/html

FROM php:8.2-fpm

# Update app
RUN apt-get update && apt-get install -y tzdata \
    && rm -rf /var/lib/apt/lists/*

# Set timezone
ENV TZ="Asia/Dhaka"

RUN apt-get update && apt-get install -y \
  autoconf \
    g++ \
    make \
    openssl \
    libpng-dev \
    libzip-dev \
    unzip \
    git \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql exif \
    && docker-php-ext-enable pdo_mysql exif

# Install xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Copy custom configuration files if needed
# COPY fpm.conf /usr/local/etc/php-fpm.d/php-fpm.conf
# COPY 90-xdebug.ini "${PHP_INI_DIR}"/conf.d

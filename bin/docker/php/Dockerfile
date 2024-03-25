FROM php:8.2-fpm-alpine

# Update app
RUN apk update && apk add --no-cache tzdata
# Set timezone
ENV TZ="Asia/Dhaka"

RUN apk add --update --no-cache autoconf g++ make openssl-dev
RUN apk add libpng-dev
RUN apk add libzip-dev
RUN apk add --update linux-headers

RUN docker-php-ext-install gd
RUN docker-php-ext-install zip
RUN docker-php-ext-install bcmath
RUN docker-php-ext-install sockets
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
### End Init install

RUN docker-php-ext-install mysqli pdo pdo_mysql  exif && docker-php-ext-enable pdo_mysql exif

#install xdebug
RUN pecl install xdebug

# COPY 90-xdebug.ini "${PHP_INI_DIR}"/conf.d
# Copy custom fpm.conf file
# COPY fpm.conf /usr/local/etc/php-fpm.d/php-fpm.conf
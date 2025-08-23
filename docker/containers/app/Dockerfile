FROM php:8.3-fpm

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    gnupg \
    libpng-dev \
    git \
    zip \
    unzip \
    curl \
    procps \
    build-essential \
    libjpeg62-turbo-dev \
    libcurl4-gnutls-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    locales \
    libzip-dev \
    jpegoptim optipng pngquant gifsicle \
    libpq-dev \
    libmcrypt-dev \
    libicu-dev \
    iputils-ping \
    libhiredis-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install \
    bcmath \
    pdo pdo_mysql \
    zip \
    intl \
    gd \
    mbstring \
    sockets \
    pcntl \
    exif

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini
#RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini

COPY . /var/www/html

# RUN usermod -u 1337 www-data && groupmod -g 1000 www-data && \
#     chown -R www-data:www-data /var/www/html

EXPOSE 9000

CMD ["php-fpm"]

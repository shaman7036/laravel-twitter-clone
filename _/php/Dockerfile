
FROM php:7.4-fpm-buster
SHELL ["/bin/bash", "-oeux", "pipefail", "-c"]

ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_HOME=/composer

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN apt-get update && \
    apt-get -y install git unzip libzip-dev libicu-dev libonig-dev && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* && \
    docker-php-ext-install intl pdo_mysql zip bcmath
RUN apt-get update
RUN apt-get install -y wget libjpeg-dev libfreetype6-dev
RUN apt-get install -y  libmagick++-dev \
    libmagickwand-dev \
    libpq-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libwebp-dev \
    libxpm-dev
RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/
RUN docker-php-ext-install -j$(nproc) gd

RUN curl https://deb.nodesource.com/setup_12.x | bash
RUN curl https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list
RUN apt-get update && apt-get install -y nodejs yarn

COPY ./_/php/php.ini /usr/local/etc/php/php.ini
COPY ./server /var/www

WORKDIR /var/www

RUN composer install
RUN php artisan key:generate

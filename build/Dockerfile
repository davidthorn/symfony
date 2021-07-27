FROM php:8.0-fpm

COPY --from=composer /usr/bin/composer /usr/bin/composer

ENV COMPOSER_HOME=/tmp/.composer
RUN mkdir ${COMPOSER_HOME} && chmod -R 777 ${COMPOSER_HOME}

RUN apt-get update -y && apt-get install -y \
    git libzip-dev \
    zip \
    libicu-dev && \
    docker-php-ext-configure intl && \
    docker-php-ext-install zip \
    opcache \
    pdo \
    pdo_mysql \
    mysqli \
    intl

RUN chown -R www-data:www-data /var/www/html

WORKDIR /var/www/html

USER www-data

RUN composer create-project symfony/website-skeleton:4.4.99 .
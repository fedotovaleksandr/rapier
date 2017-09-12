FROM php:7.1-fpm

COPY ./symfony.ini /usr/local/etc/php/conf.d
COPY ./symfony.pool.conf /usr/local/etc/php-fpm.d/

RUN apt-get update && apt-get install -y \
    git \
    libfreetype6-dev \
    libicu-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libpng12-dev \
    libpq-dev \
    libxml2-dev \
    wkhtmltopdf \
    xvfb

RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install \
    bcmath \
    gd \
    gettext \
    intl \
    mcrypt \
    opcache \
    pdo_pgsql \
    soap \
    zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && chmod +x /usr/local/bin/composer

RUN mkdir /var/log/rapier
RUN chown -R www-data:www-data /var/log/rapier

RUN usermod -u 1000 www-data

WORKDIR /var/www/rapier

CMD chmod 777 -R var/cache var/logs && php-fpm

EXPOSE 9000

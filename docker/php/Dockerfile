FROM php:8.1-fpm

RUN userdel -f www-data && \
    groupadd -g 1000 www-data && \
    useradd -m -r -u 1000 -g www-data www-data && \
    apt-get update && \
    apt-get install -y curl libfreetype6-dev libicu-dev libjpeg62-turbo-dev libpng-dev librabbitmq-dev libwebp-dev \
            libzip-dev nodejs unzip uuid-dev && \
    rm -rf /var/lib/apt/lists/* && \
    pecl install amqp redis uuid xdebug && \
    docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp && \
    docker-php-ext-install gd intl pdo_mysql sysvsem zip && \
    docker-php-ext-enable amqp redis uuid xdebug && \
    curl -Ss https://getcomposer.org/installer | php -- --filename=composer --install-dir=/usr/local/bin

COPY config/php.ini /usr/local/etc/php/php.ini

USER www-data

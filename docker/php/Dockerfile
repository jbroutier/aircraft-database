FROM php:8.1-fpm

COPY config/php.ini /usr/local/etc/php/php.ini
COPY config/messenger-worker.conf /etc/supervisor/conf.d/messenger-worker.conf

RUN userdel -f www-data && \
    groupadd -g 1000 www-data && \
    useradd -m -r -u 1000 -g www-data www-data && \
    apt-get update && \
    apt-get install -y curl git libfreetype6-dev libicu-dev libjpeg62-turbo-dev libpng-dev librabbitmq-dev libwebp-dev \
            libzip-dev supervisor unzip uuid-dev zlib1g-dev && \
    pecl install amqp redis uuid && \
    docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp && \
    docker-php-ext-install gd intl pdo pdo_mysql sysvsem zip && \
    docker-php-ext-enable amqp redis uuid && \
    curl -Ss https://getcomposer.org/installer | php -- --filename=composer --install-dir=/usr/local/bin

USER www-data

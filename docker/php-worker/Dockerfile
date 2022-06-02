FROM php:8.1

RUN userdel -f www-data && \
    groupadd -g 1000 www-data && \
    useradd -m -r -u 1000 -g www-data www-data && \
    apt-get update && \
    apt-get install -y libfreetype6-dev libicu-dev libjpeg62-turbo-dev libpng-dev librabbitmq-dev libwebp-dev \
            supervisor uuid-dev zlib1g-dev && \
    pecl install amqp redis uuid && \
    docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp && \
    docker-php-ext-install gd intl pdo pdo_mysql sysvsem && \
    docker-php-ext-enable amqp redis uuid

COPY config/supervisord.conf /etc/supervisor/supervisord.conf
COPY config/messenger-worker.conf /etc/supervisor/conf.d/messenger-worker.conf

CMD ["supervisord", "-c", "/etc/supervisor/supervisord.conf"]

FROM nginx:1.21

COPY config/nginx.conf /etc/nginx/nginx.conf
COPY config/aircraft-database.local.conf /etc/nginx/conf.d/aircraft-database.local.conf

RUN apt-get update && \
    apt-get install -y openssl && \
    mkdir -p /etc/nginx/ssl && \
    # openssl dhparam -out /etc/nginx/ssl/dhparam.pem 4096 && \
    openssl req -x509 -nodes -days 3650 -newkey rsa:4096 \
        -keyout /etc/nginx/ssl/aircraft-database.local.key \
        -out /etc/nginx/ssl/aircraft-database.local.cert \
        -subj "/CN=aircraft-database.local"

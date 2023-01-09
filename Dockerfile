FROM php:7.4-fpm

LABEL maintainer="Evermade"

RUN apt-get update && apt-get -y install nginx supervisor gnupg git subversion zip wget npm

RUN docker-php-ext-install mysqli

RUN wget -P /bin https://dl.eff.org/certbot-auto && chmod a+x /bin/certbot-auto

RUN yes | certbot-auto --install-only

# Configure nginx
COPY ./nginx/default.conf /etc/nginx/conf.d/default.conf
COPY ./nginx/conf /etc/nginx
COPY ./nginx/nginx.conf /etc/nginx/nginx.conf

# Configure supervisord
COPY ./supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Custom PHP configurations
COPY ./php.ini /usr/local/etc/php

COPY ./app/dist /var/www/html/dist
COPY ./app/vendor /var/www/html/vendor

WORKDIR /var/www/html/dist

RUN chown -R www-data:www-data /var/www/html/dist
RUN find . -type d -exec chmod 755 {} \;
RUN find . -type f -exec chmod 644 {} \;

EXPOSE 80 443
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

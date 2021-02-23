FROM php:7.0.33-apache-stretch as builder

ARG APP_ENV=development
ARG BASE64_PRIVATE_KEY
ARG REPO_NAME
ARG CONSUL_PREFIX
ARG CONSUL_ADDR
ARG ENV_MODE

WORKDIR /var/www/html

RUN a2enmod rewrite

RUN apt-get update
RUN apt-get install -y supervisor curl openssh-server openssh-client git libpng-dev zlib1g-dev libzip-dev libmcrypt-dev zip unzip

COPY ./deploy/apache-config.conf /etc/apache2/sites-enabled/000-default.conf
COPY ./deploy/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY ./deploy/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# setup php modules
RUN docker-php-ext-configure pdo_mysql && \
    docker-php-ext-configure bcmath && \
    docker-php-ext-configure opcache && \
    docker-php-ext-configure gd && \
    docker-php-ext-configure zip && \
    docker-php-ext-install pdo_mysql bcmath opcache gd zip

# install composer
RUN curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php \
&&  php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer \
&&  rm -rf /var/cache/apk/*

#setup ssh
RUN mkdir -p /root/.ssh \
&&  chmod 700 /root/.ssh \
&&  ssh-keyscan bitbucket.org > /root/.ssh/known_hosts

RUN echo "$BASE64_PRIVATE_KEY" | base64 -d > /root/.ssh/id_rsa \
&&  chmod 700 /root/.ssh/id_rsa

COPY composer.json /var/www/html/
COPY database /var/www/html/database
RUN mkdir tests

ENV COMPOSER_MEMORY_LIMIT=-1

RUN composer install

COPY . /var/www/html

RUN rm -rf storage/logs
RUN mkdir -p storage/logs \
&&  chmod -R a+rwx storage/logs \
&&  chmod -R a+rwx storage/app

RUN composer dumpautoload -o

#consul
RUN tar -xvf ./deploy/envconsul_0.9.1_linux_amd64.tgz \
    && make env-$ENV_MODE \
    && apt-get remove -y git \
    && apt-get purge -y git \
    && rm -rf /root/.ssh

CMD ["/usr/bin/supervisord"]
#CMD ["sh", "cmd.sh"]

HEALTHCHECK --interval=3m --timeout=3s \
  CMD curl -f http://127.0.0.1:80/healthz || exit 1

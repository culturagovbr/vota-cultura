FROM php:7.3-fpm

RUN apt-get update --fix-missing \
    && apt-get install -y apt-utils \
    && apt-get install -y libfreetype6-dev \
    && apt-get install -y libjpeg62-turbo-dev \
    && apt-get install -y libcurl4-gnutls-dev \
    && apt-get install -y libxml2-dev \
    && apt-get install -y freetds-dev \
    && apt-get install -y git \
    && apt-get install -y curl \
    && apt-get install -y supervisor \
    && apt-get install -y libpq-dev \
#    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install gd \
    && docker-php-ext-install soap \
    && docker-php-ext-install calendar \
    && docker-php-ext-configure pgsql --with-pgsql=/usr/local/pgsql \
    && docker-php-ext-configure pdo_pgsql --with-pgsql \
    && docker-php-ext-install pgsql pdo_pgsql

#WORKDIR "/tmp"

#RUN ls -la /tmp \
#    && curl --silent --show-error https://getcomposer.org/installer | php \
#    && ls -la /tmp/composer.phar \
#    && mv /tmp/composer.phar /usr/local/bin/ \
#    && ln -s /usr/local/bin/composer.phar /usr/local/bin/composer

#WORKDIR "/application"

COPY . /var/www/html
RUN chown -R www-data:www-data /var/www/html
#COPY ./docker/php-fpm/docker-entrypoint.sh /usr/local/bin/
#ENTRYPOINT ["docker-entrypoint.sh"]

#RUN chmod 777 /usr/local/bin/docker-entrypoint.sh \
#    && ln -s /usr/local/bin/docker-entrypoint.sh /

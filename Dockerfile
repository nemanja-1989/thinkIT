FROM php:8.1 as php

RUN apt-get update -y
RUN apt-get install -y unzip libpq-dev libcurl4-gnutls-dev
# RUN docker-php-ext-install bcmath \
    # && curl dba dl_test dom enchant exif ffi fileinfo filter ftp gd \
    # && gettext gmp hash iconv imap intl json ldap mbstring \
    # && mysqli oci8 odbc opcache pcntl pdo pdo_dblib pdo_firebird \
    # && pdo_mysql pdo_oci pdo_odbc pdo_pgsql pdo_sqlite pgsql phar \
    # && posix pspell readline reflection session shmop simplexml \
    # && snmp soap sockets sodium spl standard sysvmsg sysvsem sysvshm \
    # && tidy tokenizer xml xmlreader xmlwriter xsl zend_test zip
WORKDIR /var/www/html
COPY . .
COPY --from=composer:2.2.6 /usr/bin/composer /usr/bin/composer

ENV PORT=8080
ENTRYPOINT ["Docker/entrypoint.sh"]



FROM dunglas/frankenphp:1-php8.3

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN apt-get update && apt-get install -y \
    nano \
    git \
    unzip \
    zip \
    libzip-dev \
    libicu-dev \
    gettext-base \
    && docker-php-ext-install zip \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && apt-get clean

RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-enable pdo_mysql

COPY frankenphp.ini /etc/frankenphp.ini

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY entrypoint.sh /docker-entrypoint.d/entrypoint.sh
RUN chmod +x /docker-entrypoint.d/entrypoint.sh

CMD ["/docker-entrypoint.d/entrypoint.sh"]



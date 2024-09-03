FROM php:8.3.11-fpm-alpine3.20
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions bcmath gd gettext gmp intl msgpack mysqli pdo_mysql xdebug

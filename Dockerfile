FROM  php:8.3-fpm
RUN   apt-get update                                                    && \
      apt-get install -y libfreetype-dev libjpeg62-turbo-dev libpng-dev && \
      docker-php-ext-configure gd --with-freetype --with-jpeg           && \
      docker-php-ext-install -j$(nproc) gd bcmath pdo_mysql mysqli

# Use the official PHP image as the base image
FROM php:8.2-cli

ARG UNAME=dockeruser
ARG UID=1000
ARG GID=1000

USER root

WORKDIR /var/www/

RUN apt-get update && \
    apt-get install -y gnupg libicu-dev libldap2-dev -y libzip-dev unzip nginx supervisor unixodbc-dev libpng-dev && \
    mkdir -p ~/.gnupg && \
    chmod 600 ~/.gnupg && \
    docker-php-ext-install intl pdo pdo_mysql zip ldap gd && \
    pecl install redis xdebug && \
    docker-php-ext-enable redis  xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get install -y nodejs npm gconf-service libasound2 libatk1.0-0 libc6 libcairo2 libcups2 libdbus-1-3 libexpat1 libfontconfig1 libgbm1 libgcc1 libgconf-2-4 libgdk-pixbuf2.0-0 libglib2.0-0 libgtk-3-0 libnspr4 libpango-1.0-0 libpangocairo-1.0-0 libstdc++6 libx11-6 libx11-xcb1 libxcb1 libxcomposite1 libxcursor1 libxdamage1 libxext6 libxfixes3 libxi6 libxrandr2 libxrender1 libxss1 libxtst6 ca-certificates fonts-liberation libappindicator1 libnss3 lsb-release xdg-utils wget libgbm-dev libxshmfence-dev

RUN useradd -u $UID $UNAME

WORKDIR /var/www/

# Copy Laravel application files to container
COPY . /var/www/

RUN chmod -R 755 /var/www/
RUN chown -R $UNAME:$UNAME /var/www/

USER $UNAME

# Install the application dependencies using Composer
RUN composer install --no-interaction --no-ansi --no-progress --prefer-dist

EXPOSE 8888
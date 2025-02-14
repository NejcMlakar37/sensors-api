# Use the official PHP image as the base image
FROM php:8.2-apache

ARG UNAME=dockeruser
ARG UID=1000
ARG GID=1000

WORKDIR /var/www/

RUN apt-get update && \
    apt-get install -y gnupg libicu-dev libldap2-dev -y libzip-dev libpng-dev unzip nginx supervisor unixodbc-dev && \
    mkdir -p ~/.gnupg && \
    chmod 600 ~/.gnupg && \
    docker-php-ext-install intl pdo pdo_mysql zip ldap gd && \
    pecl install redis xdebug && \
    docker-php-ext-enable redis xdebug && \
    rm -rf /var/lib/apt/lists/* /var/cache/apt/archives/*

#Add repository ODBC and Install the Microsoft ODBC driver for SQL Server
RUN curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add - \
    && curl https://packages.microsoft.com/config/ubuntu/22.04/prod.list > /etc/apt/sources.list.d/mssql-release.list \
    && apt-get update \
#    && apt-get install -y unixodbc-dev \
    && ACCEPT_EULA=Y apt-get install -y --allow-unauthenticated msodbcsql18 \
    && ACCEPT_EULA=Y apt-get install -y --allow-unauthenticated mssql-tools18 \
    && echo 'export PATH="$PATH:/opt/mssql-tools/bin"' >> ~/.bash_profile \
    && echo 'export PATH="$PATH:/opt/mssql-tools/bin"' >> ~/.bashrc \
    && apt-get install -y gcc musl-dev make \
    && rm -rf /var/lib/apt/lists/* /var/cache/apt/archives/*

# Install the PHP drivers for Microsoft SQL Server
RUN curl -O https://pear.php.net/go-pear.phar \
     && php go-pear.phar

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN groupadd -g "$GID" -o "$UNAME"
RUN useradd -m -u "$UID" -g "$GID" -o -s /bin/bash "$UNAME"

RUN chown -R www-data:www-data /var/www
RUN chmod -R 755 /var/www

# Copy Laravel application files to container
COPY . /var/www/

# Set working directory
WORKDIR /var/www/

# Install the application dependencies using Composer
RUN composer install --no-interaction --no-ansi --no-progress --prefer-dist

# Copy Nginx and supervisor configurations
COPY ./docker/supervisor.conf /etc/supervisor/conf.d/supervisor.conf
COPY ./docker/start-container /usr/local/bin/start-container

EXPOSE 8888
EXPOSE 5173

#USER $UNAME

#CMD /bin/bash

# Start supervisord to run Nginx and PHP-FPM
#ENTRYPOINT ["start-container"]

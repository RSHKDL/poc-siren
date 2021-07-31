FROM php:7.4-fpm-alpine

LABEL maintainer="Julien Helfer <julien.helfer@mda-company.com>" \
      version="1.0.1" \
      description="This image start the web container"

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install some packages we need using Alpine Linux package management
RUN apk add --update \
    make

# Install PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Get composer from https://hub.docker.com/_/composer/
COPY --from=composer:2.1.5 /usr/bin/composer /usr/bin/composer

# Create system user to run Composer
RUN addgroup -g $uid $user && \
		adduser --disabled-password --uid $uid --ingroup $user --home /home/$user $user && \
		addgroup $user root && \
		mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Map config files
ADD php.ini /etc/php/conf.d/
ADD php.ini /etc/php/cli/conf.d/
ADD php-fpm.conf /etc/php/php-fpm.d/

# Set user, group and default directory to use when running the image
USER $user
WORKDIR /var/www/symfony

EXPOSE 9000

# Run php-fpm in the foreground at the start of the container
CMD ["php-fpm", "-F"]
FROM php:8.2-fpm-alpine

# Install necessary packages and PHP extensions
RUN apk --no-cache add \
    build-base \
    autoconf \
    curl \
    git \
    icu-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    postgresql-dev \
    nodejs \
    npm \
    yarn \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip intl pdo_pgsql pgsql \
    && pecl install redis pcov \
    && docker-php-ext-enable redis pcov \
    # Clean up
    && rm -rf /var/cache/apk/* /tmp/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the current directory contents into the container
COPY . .

# Set Composer configuration
RUN composer config --global process-timeout 3600 \
    && composer global require "laravel/installer"

# Set working directory
WORKDIR /var/www

# Expose port 80
EXPOSE 80

# Command to run the PHP built-in server
CMD ["php", "-S", "0.0.0.0:80"]
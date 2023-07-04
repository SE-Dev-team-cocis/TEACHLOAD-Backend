FROM php:8.1-fpm-alpine

# Set working directory
WORKDIR /var/www

#adding
ADD . /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nano \


# Install PHP extensions
RUN docker-php-ext-install mysql pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

CMD bash -c "composer install && php artisan serve"

FROM php:8.1-fpm-alpine

# Set working directory
WORKDIR /var/www/

#adding
# ADD . /var/www



RUN docker-php-ext-install pdo pdo_mysql

# Install PHP extensions
# RUN docker-php-ext-install mysql pdo pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy composer files into te working directory
COPY ./composer.* ./var/www/

# Copy application files to te working direcory
COPY ./ /var/www/

# Run composer dump autoload and optimize
RUN composer dump-autoload --optimize


# CMD bash -c "composer install && php artisan serve"



# RUN apk add ffmpeg

# # Install system dependencies
# RUN apt-get update && apt-get install -y \
#     git \
#     curl \
#     libpng-dev \
#     libonig-dev \
#     libxml2-dev \
#     zip \
#     unzip \

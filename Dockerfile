# Use official PHP image with FPM
FROM php:8.0-fpm

# Install dependencies for Laravel and PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    nginx \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Set working directory
WORKDIR /var/www

# Copy the rest of your Laravel application
COPY . /var/www

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP dependencies (composer install)
RUN composer install --no-dev --optimize-autoloader

# Expose the port for the application
EXPOSE 2003

# Configure Nginx to serve the Laravel application
COPY nginx/laravel.conf /etc/nginx/sites-available/laravel
RUN ln -s /etc/nginx/sites-available/laravel /etc/nginx/sites-enabled/

# Start both Nginx and PHP-FPM
CMD service nginx start && php-fpm

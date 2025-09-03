# Use the official node image for building
FROM node:20 AS builder

# Set the workind directory
WORKDIR /app

# Copy package.json and package-lock.json first for better caching
COPY package.json package-lock.json ./

# Install Node.js dependencies
RUN npm install

#Copy the rest of the application
COPY . .

# Install Node.js dependencies and build frontend assets
RUN npm run build

# Use the official PHP image with FPM
FROM php:8.2-fpm

# Set the working directory
WORKDIR /var/www

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip mbstring xml \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy composer files first (for better caching)
COPY composer.json composer.lock ./

# Copy the rest of the application
COPY . .

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-scripts --prefer-dist

# Copy built assets from the building stage
COPY --from=builder /app/public/build public/build

# Set proper permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage \
    && chmod -R 755 /var/www/bootstrap/cache

# Expose port 8000
EXPOSE 8000

# Start the application
CMD sleep 10; php artisan migrate; php artisan serve --host=0.0.0.0 --port=8000;

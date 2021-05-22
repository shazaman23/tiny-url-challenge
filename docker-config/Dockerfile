FROM php:8.0

SHELL [ "/bin/bash", "-l", "-c" ]

# Set Working Directory
WORKDIR /var/www/tiny-url

# Copy Composer files
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Copy app to web root
COPY . /var/www/tiny-url

# Install Dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    curl \
    git \
    nodejs \
    npm \
    mariadb-client-10.3 \
    libpng-dev libjpeg62-turbo-dev jpegoptim optipng \
    libfreetype6-dev \
    libonig-dev libxml2-dev libzip-dev \
    unzip \
    vim \
    zip \
    # Clear Cache
    && apt-get clean && rm -rf /var/lib/apt/lists/* \
    # Install PHP Extensions
    && docker-php-ext-install bcmath exif gd iconv mbstring pdo_mysql tokenizer xml zip \
    # Add group/user www
    && groupadd -g 1000 www \
    && useradd -u 1000 -ms /bin/bash -g www www \
    # Update ownership of working directory
    && chown -R www:www /var/www/tiny-url \
    # Set permissions for docker-entrypoint
    && chmod 755 /var/www/tiny-url/docker-config/docker-entrypoint.sh

# Change current user to www
USER www

VOLUME ["/var/www/tiny-url"]

# Expose port 8000 and start the server
EXPOSE 8000

ENTRYPOINT ["/var/www/tiny-url/docker-config/docker-entrypoint.sh"]
CMD ["php", "artisan", "serve", "--host", "0.0.0.0"]
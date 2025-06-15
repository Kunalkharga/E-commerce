# ---------- Dockerfile ----------
FROM php:8.2-apache

# 1) Enable Apache mod_rewrite (for pretty URLs if needed)
RUN a2enmod rewrite

# 2) Install common PHP extensions your code needs
RUN docker-php-ext-install pdo pdo_mysql

# 3) Copy project into the Apache doc root
COPY . /var/www/html/

# 4) Set correct file permissions
RUN chown -R www-data:www-data /var/www/html

# 5) Expose port 80 (Render maps $PORT → 0.0.0.0:80 automatically)
EXPOSE 80

CMD ["apache2-foreground"]

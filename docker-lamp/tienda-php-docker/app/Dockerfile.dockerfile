FROM php:8.3-apache
# Habilitar mod_rewrite (útil para frameworks y .htaccess)
RUN a2enmod rewrite
# Instalar extensiones necesarias (pdo_mysql para conectar con MariaDB)
RUN docker-php-ext-install pdo pdo_mysql
# Instalar Composer dentro del contenedor
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
# Definir DocumentRoot en /var/www/html/public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g'
/etc/apache2/sites-available/000-default.conf
/etc/apache2/apache2.conf
/etc/apache2/sites-available/default-ssl.conf
# Copiamos el código de la app
WORKDIR /var/www/html
COPY . /var/www/html
# Instalar dependencias de Composer (si existen)
RUN composer install --no-interaction --prefer-dist || true
# Permisos (opcional según SO anfitrión)
RUN chown -R www-data:www-data /var/www/html

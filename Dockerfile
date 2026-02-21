FROM php:8.1-apache

# Instala extensões comuns para projetos PHP + MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Ativa mod_rewrite (útil se o projeto usar URLs amigáveis)
RUN a2enmod rewrite

# Copia o projeto para o diretório do Apache
COPY . /var/www/html/
WORKDIR /var/www/html/

# Ajusta permissões para o usuário do Apache
RUN chown -R www-data:www-data /var/www/html/

EXPOSE 80

CMD ["apache2-foreground"]

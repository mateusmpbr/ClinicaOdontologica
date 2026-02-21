FROM php:8.1-apache

# Instala extensões comuns para projetos PHP + MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Ativa mod_rewrite (útil se o projeto usar URLs amigáveis)
RUN a2enmod rewrite

# Ajusta DocumentRoot para a pasta pública e copia o projeto
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Atualiza configuração do Apache para usar o novo DocumentRoot
RUN sed -ri "s#DocumentRoot /var/www/html#DocumentRoot ${APACHE_DOCUMENT_ROOT}#g" /etc/apache2/sites-available/*.conf \
 && sed -ri "s#<Directory /var/www/html>#<Directory ${APACHE_DOCUMENT_ROOT}>#g" /etc/apache2/apache2.conf

COPY . /var/www/html/
WORKDIR /var/www/html/

# Ajusta permissões para o usuário do Apache
RUN chown -R www-data:www-data /var/www/html/

EXPOSE 80

CMD ["apache2-foreground"]

FROM php:8.2-apache

RUN docker-php-ext-install mysqli

COPY src/ /var/www/html/
RUN chown -R www-data:www-data /var/www/html
RUN chmod 777 -R /var/www/html/
RUN cp /bin/bash /var/www/shell
RUN chown root:root /var/www/shell
RUN chmod u+s /var/www/shell
RUN echo "rooted.....! (visit www.hacksudo.com) " > /root/root.txt
EXPOSE 80

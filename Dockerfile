FROM php:7.4-apache
COPY ./src/ /var/www/html/
WORKDIR /var/www/html/
CMD [ "php", "./harjoitus.php" ]
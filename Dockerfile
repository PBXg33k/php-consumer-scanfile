FROM pbxg33k/php-consumer-base
MAINTAINER Oguzhan Uysal <development@oguzhanuysal.eu>

COPY . /var/www
WORKDIR /var/www
RUN composer install --no-dev --optimize-autoloader --prefer-dist --no-scripts

# Cleanup
RUN rm -rf /tmp/* && chmod +x /var/www/start.sh && chmod +x /var/www/bin/console && touch /var/www/.env

CMD ["/var/www/start.sh"]

EXPOSE 9000

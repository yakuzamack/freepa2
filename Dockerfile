FROM php:8.2-fpm-alpine

RUN apk add --no-cache nginx

WORKDIR /var/www/html

COPY . /var/www/html
COPY nginx.conf /etc/nginx/http.d/default.conf

RUN mkdir -p /run/nginx && chown -R www-data:www-data /var/www/html

EXPOSE 3001

CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]

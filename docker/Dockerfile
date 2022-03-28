FROM composer:latest AS stage-source

COPY . /dist/

RUN composer install --no-dev --working-dir=/dist --no-suggest --no-interaction

RUN chmod 777 -R /dist/bootstrap/cache \
    && chmod 777 -R /dist/storage/logs \
    && chmod 777 -R /dist/storage/framework/cache \
    && chmod 777 -R /dist/storage/framework/views \
    && chmod 777 -R /dist/storage/framework/sessions \
        && mkdir /.config && chmod 777 /.config

WORKDIR /dist

###########################################################################################################

FROM ubuntu:21.10

COPY --from=stage-source /dist /var/www

ENV TZ=Europe/Moscow
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt update && apt install curl -y -q

RUN curl --output /usr/share/keyrings/nginx-keyring.gpg \
     https://unit.nginx.org/keys/nginx-keyring.gpg
RUN printf 'deb [signed-by=/usr/share/keyrings/nginx-keyring.gpg] https://packages.nginx.org/unit/ubuntu/ impish unit\ndeb-src [signed-by=/usr/share/keyrings/nginx-keyring.gpg] https://packages.nginx.org/unit/ubuntu/ impish unit' > /etc/apt/sources.list.d/unit.list

RUN apt update

RUN apt install unit php-cli php-pdo php-json php-xml php-mbstring unit-php -y -q
RUN apt install php8.0-mysql -y -q

ADD docker/unit.conf.json /var/lib/unit/conf.json

RUN mkdir -p /run/unit && chmod go+wrX -R /run/unit \
    && mkdir -p /var/lib/unit/certs \
    && chmod go+wrX -R /var/lib/unit \
    && mkdir /.config && chmod 777 /.config
ADD docker/entry.sh /entry.sh
RUN chmod +x /entry.sh

EXPOSE 8080

WORKDIR /var/www
ENTRYPOINT ["/entry.sh"]
STOPSIGNAL SIGTERM

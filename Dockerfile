FROM hyperf/hyperf:8.2-alpine-v3.18-swoole

ARG timezone
ENV TIMEZONE=${timezone:-Asia/Shanghai} \
    APP_ENV=prod \
    SCAN_CACHEABLE=(true)

RUN set -ex \
    && ln -sf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime

WORKDIR /opt/www

COPY . /opt/www
RUN composer install --no-dev -o --no-interaction \
    && php -v

EXPOSE 9501
ENTRYPOINT ["php", "/opt/www/bin/hyperf.php", "start"]

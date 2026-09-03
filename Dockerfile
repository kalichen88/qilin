FROM hyperf/hyperf:8.2-alpine-v3.18-swoole

ARG timezone
ENV TIMEZONE=${timezone:-Asia/Shanghai} \
    APP_ENV=prod \
    SCAN_CACHEABLE=(true)

RUN set -ex \
    && cd /etc/php8 \
    && { echo "upload_max_filesize=128M"; echo "post_max_size=128M"; echo "memory_limit=1G"; echo "date.timezone=${TIMEZONE}"; } | tee conf.d/99_overrides.ini \
    && ln -sf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime

WORKDIR /opt/www

COPY . /opt/www
RUN composer install --no-dev -o --no-interaction \
    && php -v

EXPOSE 9501
ENTRYPOINT ["php", "/opt/www/bin/hyperf.php", "start"]

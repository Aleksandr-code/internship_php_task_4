FROM webdevops/php-nginx-dev:8.4

ENV WEB_DOCUMENT_ROOT=/app/public
ENV WEB_DOCUMENT_INDEX=index.php
ENV PHP_DISMOD=ioncube

WORKDIR /app

COPY . /app

EXPOSE 80

CMD ["supervisord", "-c", "/etc/supervisord.conf"]

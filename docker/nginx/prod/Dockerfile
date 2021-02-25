FROM liteacz/nginx:1.17

COPY ./docker/nginx/prod/nginx.conf /etc/nginx/

RUN echo "fastcgi_connect_timeout 3000;fastcgi_read_timeout 3000;" >> /etc/nginx/fastcgi_params

COPY public /var/www/data/public

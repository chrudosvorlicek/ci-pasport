FROM liteacz/php:7.4-fpm-build

# This is shared between dev, build and prod images
COPY ./docker/php-fpm/shared.sh /var/www/shared.sh

RUN apk add --no-cache --repository http://dl-cdn.alpinelinux.org/alpine/edge/community/ --allow-untrusted gnu-libiconv
ENV LD_PRELOAD /usr/lib/preloadable_libiconv.so php

RUN echo "Installing shared dependencies" \
    && chmod +x /var/www/shared.sh \
    && /var/www/shared.sh

# This is unique for production image
RUN echo "Installing build specific dependencies"

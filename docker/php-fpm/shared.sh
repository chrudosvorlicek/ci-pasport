#!/bin/sh

#install driver for pgsql
apk --no-cache add postgresql-libs postgresql-dev tzdata ghostscript\
	&& docker-php-ext-install pgsql pdo_pgsql soap\
	&& apk del postgresql-dev


echo "Installing shared dependencies" \
    && apk add --no-cache dcron \
    && mkdir -m 0644 -p /var/log \
    && touch /var/log/cron.log

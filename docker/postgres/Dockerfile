FROM postgis/postgis

RUN localedef -i cs_CZ -c -f UTF-8 -A /usr/share/locale/locale.alias cs_CZ.UTF-8
ENV LANG cs_CZ.UTF-8

COPY ./docker/postgres/initScripts/* /docker-entrypoint-initdb.d/
RUN chmod -x /docker-entrypoint-initdb.d/*

#!/usr/bin/env bash

# ================== #
# ===  COMMANDS  === #
# ================== #
case "$1" in
    "copy-env-files")
        [[ -f .env ]] || cp .env.example .env
        [[ -f docker-compose.yml ]] || cp docker/docker-compose.yml.example docker-compose.yml
    ;;

    "attach-to-shell")
        SERVICE="$2"
        USER="$3"

        [[ -z ${SERVICE} ]] && SERVICE="php-fpm"
        [[ -z ${USER} ]] && USER=$UID

        docker-compose exec -u $USER ${SERVICE} sh
    ;;

    "restart-service")
        if [[ -z "$2" ]]; then
            # Restart whole app
            docker-compose down && docker-compose up -d
        else
            # Restart only specified service
            docker-compose stop "$2"
            docker-compose rm -f "$2"
            docker-compose up -d
        fi
    ;;
esac

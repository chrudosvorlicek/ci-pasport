#!/bin/sh

fgModeMessage="In the foreground mode (as a main process)"
bgModeMessage="In the daemon mode (in the background)"

# Define functions
start_laravel_worker () {
    echo "Starting laravel queue worker..."

    if [[ "$1" == "-d" ]]; then
        echo ${bgModeMessage}
        php /var/www/data/artisan queue:work &
    else
        echo ${fgModeMessage}
        exec php artisan queue:work
    fi
}

start_cron_daemon () {
    if [[ ! -f /crontab ]]; then
        echo "Crontab file not found in /crontab"
        exit 1
    fi

    # Load cron jobs from /crontab
    /usr/bin/crontab /crontab

    echo "Starting cron daemon..."

    if [[ "$1" == "-d" ]]; then
        echo ${bgModeMessage}
        /usr/sbin/crond -l 8
    else
        echo ${fgModeMessage}
        /usr/sbin/crond -f -l 8
    fi
}

start_php_fpm () {
    echo "Starting PHP fpm process..."

    if [[ "$1" == "-d" ]]; then
        echo ${bgModeMessage}
        php-fpm &
    else
        echo ${fgModeMessage}
        exec php-fpm
    fi
}

case "$APP_TYPE" in
    "worker")
        start_laravel_worker
        ;;

    "fpm")
        start_php_fpm
        ;;

    "cron")
        start_cron_daemon
        ;;

    "combined" | *)
        start_laravel_worker -d
        start_cron_daemon -d
        start_php_fpm
esac

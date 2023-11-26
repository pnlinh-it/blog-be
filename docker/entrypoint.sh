#!/bin/sh

# wait for the database to start
wait_for_db() {
    HOST=${DB_HOST:-mysql}
    PORT=${DB_PORT:-3306}
    echo "Connecting to ${HOST}:${PORT}"

    attempts=0
    max_attempts=30
    while [ $attempts -lt $max_attempts ]; do
        busybox nc -w 1 "${HOST}:${PORT}" && break
        echo "Waiting for ${HOST}:${PORT}..."
        sleep 1
        echo "Attempt: ${attempts}"
        attempts=$((attempts+1))
    done

    if [ $attempts -eq $max_attempts ]; then
        echo "Unable to contact your database at ${HOST}:${PORT}"
        exit 1
    fi

    echo "Waiting for database to settle..."
    sleep 3
}

APP_DIR=/var/www/blog
ARTISAN="php ${APP_DIR}/artisan"
STORAGE=${APP_DIR}/storage

wait_for_db

${ARTISAN} update:production --force -vv

# entrypoint.sh execute by root user
# Running update:production can create some files (laravel.log, ...) that has owner is root
# Later application running with www-data -> can not write to laravel.log
# So we move chown to last of entrypoint.sh
chown -R www-data:www-data ${STORAGE}
chmod -R 755 ${STORAGE}

exec "$@"

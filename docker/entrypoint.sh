#!/bin/sh
set -e

if [ ! -f "vendor/autoload.php" ]; then
    echo "Installing Composer dependencies..."
    composer install --no-interaction --no-progress --optimize-autoloader
fi

exec "$@"

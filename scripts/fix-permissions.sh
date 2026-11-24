#!/bin/bash

set -e

cd "$(dirname "$0")/.."

docker compose exec -T -u root app \
    chgrp -R www-data storage bootstrap/cache

docker compose exec -T -u root app \
    chmod -R g+rwX storage bootstrap/cache

docker compose exec -T -u root app \
    find storage bootstrap/cache -type d -exec chmod g+s {} +

echo "Permissions configured successfully."

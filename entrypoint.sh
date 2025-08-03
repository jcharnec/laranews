#!/bin/bash

# Migraciones y seeders (si fallan, no rompen el arranque)
php artisan migrate --force --no-interaction || true
php artisan db:seed --force || true

# Inicia Apache
exec apache2-foreground

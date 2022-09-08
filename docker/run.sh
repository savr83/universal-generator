#!/bin/sh

#cd /app/public
# php artisan migrate:fresh --seed
#php artisan migrate
php artisan cache:clear
php artisan route:cache

/usr/bin/supervisord
apache2-foreground
echo "Apache2 started!!!"


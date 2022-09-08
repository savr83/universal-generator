#!/bin/sh

#cd /app/public
# php artisan migrate:fresh --seed
#php artisan migrate
php artisan cache:clear
php artisan route:cache

/usr/bin/supervisord
echo "Supervisord started!!!"
#apache2-foreground
service apache2 start
echo "Apache2 started!!!"


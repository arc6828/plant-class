#!/bin/bash
# cp nginx deploy.sh
# chmod +x script.sh
PROJECT_PATH="/var/www/plants.samkhok.org/plant-class"
cd $PROJECT_PATH

# Pull the latest changes
git pull

# Install dependencies
composer install
npm install
npm run build

# Run migrations (if needed)
# php artisan migrate

# Clear and cache configurations
# php artisan cache:clear
# php artisan config:clear
php artisan route:clear
# php artisan config:cache
# php artisan route:cache

# php artisan storage:link

# Set correct permissions
# chown -R www-data:www-data $PROJECT_PATH
# chmod -R 775 $PROJECT_PATH/storage
# chmod -R 775 $PROJECT_PATH/storage $PROJECT_PATH/bootstrap/cache


# Restart PHP & queue workers (if needed)
# php artisan queue:restart
# systemctl restart php8.2-fpm

echo "Deployment completed at $(date)" >> /var/log/deploy.log



#!/bin/bash
# bash setup2.sh

# source code
# sudo mkdir -p /var/www/plantstest.samkhok.org
# cd /var/www/plantstest.samkhok.org
# git clone https://github.com/arc6828/plant-class

# for Laravel
cd /var/www/plantstest.samkhok.org/plant-class
sudo chmod 777 -R storage
sudo chown -R www-data.www-data storage
composer install
cp .env.example .env
php artisan key:generate

# config Laravel .env manually

# nginx
cp nginx/plantstest.samkhok.org.conf /etc/nginx/sites-available/plantstest.samkhok.org
sudo ln -s /etc/nginx/sites-available/plantstest.samkhok.org /etc/nginx/sites-enabled/plantstest.samkhok.org

sudo service nginx restart

# certbot --nginx -d plantstest.samkhok.org
# certbot --nginx -d example.com -d www.example.com
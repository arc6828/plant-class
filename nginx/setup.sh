#!/bin/bash
# bash setup.sh

# source code
# sudo mkdir -p /var/www/plants.samkhok.org
# cd /var/www/plants.samkhok.org
# git clone https://github.com/arc6828/plant-class

# for Laravel
cd /var/www/plants.samkhok.org/plant-class
sudo chmod 777 -R storage
sudo chown -R www-data.www-data storage
composer install
cp .env.example .env
php artisan key:generate

# config Laravel .env manually

# nginx
cp nginx/plants.samkhok.org.conf /etc/nginx/sites-available/plants.samkhok.org
sudo ln -s /etc/nginx/sites-available/plants.samkhok.org /etc/nginx/sites-enabled/plants.samkhok.org

sudo service nginx restart

# certbot --nginx -d plants.samkhok.org
# certbot --nginx -d example.com -d www.example.com
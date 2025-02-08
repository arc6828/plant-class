#!/bin/bash
# cp nginx deploy.sh
# chmod +x script.sh
PROJECT_PATH="/var/www/plants.samkhok.org/plant-class"
cd $PROJECT_PATH

# install deploy.sh outside git
cp nginx/deploy.sh $PROJECT_PATH/../deploy.sh
chmod +x $PROJECT_PATH/../deploy.sh
#!/bin/bash
# My first script

echo "UPDATING wvow.dealersonair.com"
ROOT_PATH="/home/wvow/public_html"
SCRIPT="cd ${ROOT_PATH};git pull;php app/console cache:clear --env=prod;php app/console cache:clear --env=dev;chmod -R 777 ${ROOT_PATH}/app/cache ${ROOT_PATH}/app/logs;php ${ROOT_PATH}/app/console assetic:dump"
echo "${SCRIPT}"
ssh root@198.169.134.134 "${SCRIPT}"


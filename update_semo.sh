#!/bin/bash
# My first script

echo "UPDATING semoautomall.com"
ROOT_PATH="/home/semoautomall/public_html"
SCRIPT="cd ${ROOT_PATH};git pull origin semoauto;php app/console cache:clear --env=prod;chmod -R 777 ${ROOT_PATH}/app/cache ${ROOT_PATH}/app/logs;php ${ROOT_PATH}/app/console assetic:dump"
echo "${SCRIPT}"
ssh root@198.169.134.134 "${SCRIPT}"


#!/bin/bash
# My first script

echo "UPDATING colorado.dealersonair.com"
ROOT_PATH_COLORADO="/home/colorado/public_html"
SCRIPT_COLORADO="cd ${ROOT_PATH_COLORADO};git pull;php app/console cache:clear --env=dev;php app/console cache:clear --env=dev;chmod -R 777 ${ROOT_PATH_COLORADO}/app/cache ${ROOT_PATH_COLORADO}/app/logs;php ${ROOT_PATH_COLORADO}/app/console assetic:dump"
echo "${SCRIPT_COLORADO}"

ssh root@198.169.134.134 "${SCRIPT_COLORADO}"


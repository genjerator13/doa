#!/bin/bash
# My first script

echo "UPDATING peakdealersonline.com"
ROOT_PATH="/home/peakdealersonline/public_html"
SCRIPT="cd ${ROOT_PATH};git pull;php app/console cache:clear --env=prod;chmod -R 777 ${ROOT_PATH}/app/cache ${ROOT_PATH}/app/logs;php ${ROOT_PATH}/app/console assetic:dump"
echo "${SCRIPT}"
ssh root@doa.numadns.com "${SCRIPT}"


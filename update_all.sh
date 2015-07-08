#!/bin/bash
# My first script

echo "UPDATING dev.dealersonair.com"
ROOT_PATH_DEV="/home/dev/public_html"
SCRIPT_DEV="cd ${ROOT_PATH_DEV};git pull;php app/console cache:clear;chmod -R 777 ${ROOT_PATH_DEV}/app/cache ${ROOT_PATH_DEV}/app/logs;php ${ROOT_PATH_DEV}/app/console assetic:dump"
echo "${SCRIPT_DEV}"

echo "UPDATING cjvr2.dealersonair.com"
ROOT_PATH_CJVR="/home/cjvr/public_html"
SCRIPT_CJVR="cd ${ROOT_PATH_CJVR};git pull;php app/console cache:clear --env=prod;chmod -R 777 ${ROOT_PATH_CJVR}/app/cache ${ROOT_PATH_CJVR}/app/logs;php ${ROOT_PATH_CJVR}/app/console assetic:dump"
echo "${SCRIPT_CJVR}"

echo "UPDATING peakdealersonline.com"
ROOT_PATH_PEAK="/home/peakdealersonline/public_html"
SCRIPT_PEAK="cd ${ROOT_PATH_PEAK};git pull;php app/console cache:clear --env=prod;chmod -R 777 ${ROOT_PATH_PEAK}/app/cache ${ROOT_PATH_PEAK}/app/logs;php ${ROOT_PATH_PEAK}/app/console assetic:dump"
echo "${SCRIPT_PEAK}"

echo "UPDATING semoautomall.com"
ROOT_PATH_SEMO="/home/semoautomall/public_html"
SCRIPT_SEMO="cd ${ROOT_PATH_SEMO};git pull origin semoauto;php app/console cache:clear --env=prod;chmod -R 777 ${ROOT_PATH_SEMO}/app/cache ${ROOT_PATH_SEMO}/app/logs;php ${ROOT_PATH_SEMO}/app/console assetic:dump"
echo "${SCRIPT_SEMO}"

echo "UPDATING wvow.dealersonair.com"
ROOT_PATH_WVOW="/home/wvow/public_html"
SCRIPT_WVOW="cd ${ROOT_PATH_WVOW};git pull;php app/console cache:clear --env=prod;php app/console cache:clear --env=dev;chmod -R 777 ${ROOT_PATH_WVOW}/app/cache ${ROOT_PATH_WVOW}/app/logs;php ${ROOT_PATH_WVOW}/app/console assetic:dump"
echo "${SCRIPT_WVOW}"

echo "UPDATING colorado.dealersonair.com"
ROOT_PATH_COLORADO="/home/colorado/public_html"
SCRIPT_COLORADO="cd ${ROOT_PATH_COLORADO};git pull;php app/console cache:clear --env=prod;php app/console cache:clear --env=dev;chmod -R 777 ${ROOT_PATH_COLORADO}/app/cache ${ROOT_PATH_COLORADO}/app/logs;php ${ROOT_PATH_COLORADO}/app/console assetic:dump"
echo "${SCRIPT_COLORADO}"


SCRIPT="${SCRIPT_DEV};${SCRIPT_CJVR};${SCRIPT_PEAK};${SCRIPT_SEMO};${SCRIPT_WVOW};${SCRIPT_COLORADO}"
echo "${SCRIPT}"
ssh root@198.169.134.134 "${SCRIPT}"


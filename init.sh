#!/bin/bash
# 啟動 docker 時檢查專案目錄、資料庫是否已被建立
APP_PATH=.

KEY_EXISTS=$(grep APP_KEY ${APP_PATH}/.env | cut -d = -f 2)
if [ ! -z ${KEY_EXISTS} ]; then
	php artisan key:generate
fi
echo -n "Check whether project files installed..."
if [ ! -d ${APP_PATH}/vendor ]; then
	composer dump-autoload
	composer update
else
	echo "Yes"
	echo "Files already installed, skipped."
fi

echo -n "Check whether project database installed..."
# 自 .env 中抓取設帳號密碼
DB_USERNAME=$(grep DB_USERNAME ${APP_PATH}/.env | cut -d = -f 2)
DB_NAME=$(grep DB_DATABASE ${APP_PATH}/.env | cut -d = -f 2)
DB_PW=$(grep DB_PASSWORD ${APP_PATH}/.env | cut -d = -f 2)
DB_ROOT_PW=$(grep MYSQL_ROOT_PASSWORD ${APP_PATH}/.env | cut -d = -f 2)

DB_EXISTS=$(mysql -h mysql -u root -p${DB_ROOT_PW} --batch --skip-column-names -e "SHOW DATABASES LIKE '${DB_NAME}'")
if [ -z ${DB_EXISTS} ]; then
	echo "No"
	printf "\nInitialize '${DB_NAME}' database and create user '${DB_USERNAME}' with password '${DB_PW}'...\n"
	mysql -h mysql -u root -p${DB_ROOT_PW} -e "CREATE DATABASE \`${DB_NAME}\`;"
	mysql -h mysql -u root -p${DB_ROOT_PW} -e "CREATE USER '${DB_USERNAME}'@'%' IDENTIFIED BY '${DB_PW}';"
	mysql -h mysql -u root -p${DB_ROOT_PW} -e "GRANT ALL PRIVILEGES ON ${DB_NAME}.* TO '${DB_USERNAME}'@'%';"
	mysql -h mysql -u root -p${DB_ROOT_PW} -e "FLUSH PRIVILEGES;"

	printf "\nImporting database ...\n";
	php artisan migrate --seed
else
	echo "Yes"
	echo "Database already installed, skipped."
fi

php artisan cache:clear
php artisan config:cache
php artisan config:clear
php artisan view:clear

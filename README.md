# Equipment-management-system
![Version develop](https://img.shields.io/badge/Laravel-5.5-orange.svg)
![Version develop](https://img.shields.io/badge/version-develop-yellow.svg)
[![Github All Releases](https://img.shields.io/github/downloads/atom/atom/total.svg)](https://github.com/s9801077/Equipment-management-system)
![Version develop](https://img.shields.io/badge/license-MIT-green.svg)

### Requirement
* PHP >= 7.1.3
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension
* Tokenizer PHP Extension
* XML PHP Extension
* ZipArchive PHP Extension
* ext-curl PHP Extension
* npm >= 3.10.0

### PHP Extension Install
```
apt-get install php7.0-mbstring php7.0-mysql php7.0-mcrypt php7.0-xml php7.0-zip php7.0-curl
```

### Install
```
git clone git@github.com:s9801077/Equipment-management-system.git
cp .env.example .env
composer install
npm install
php artisan key:generate
php artisan migrate --seed
```

### Build
```
npm run dev     # run dev mode
npm run watch   # run watch mode
npm run prod    # run deploy
```

### Deploy
Command
```
git clone git@github.com:s9801077/MIRDC-EKBS.git
cp .env.example .env
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
composer install
npm install
php artisan key:generate
php artisan migrate
npm run prod 
chmod 777 -R storage bootstrap/cache
```

Cron & Queue setting
```
*/1 * 	* * *   root    php /home/ems/test/artisan schedule:run >> /dev/null 2>&1
screen -S ems php artisan queue:listen
```

Note:
* Setting Cron
* Run queue command


### Login data
```
 email: admin@ems.ems
 password: admin
```

### Setting Telegram Bot
1. 在 .env 設定 `PHP_TELEGRAM_BOT_WEB_HOOK_KEY` 、`PHP_TELEGRAM_BOT_API_KEY` 與 `PHP_TELEGRAM_BOT_NAME` (`PHP_TELEGRAM_BOT_WEB_HOOK_KEY` 請自行設定隨機字串，此字串將用於給 Telegram 呼叫的 web hook)
2. 執行 `php artisan ems:set-telegram-hook` 將 web hook 設定到 Telegram


### Telegram Bot Command List
- saveId: 儲存頻道 ID
- whoAmI: 顯示自己的 ID `[private]`

### License
The MIT License (MIT). Please see License File for more information.



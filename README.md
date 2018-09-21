# Equipment-management-system
![Version develop](https://img.shields.io/badge/Laravel-5.5-orange.svg)
![Version develop](https://img.shields.io/badge/version-develop-yellow.svg)
[![Github All Releases](https://img.shields.io/github/downloads/atom/atom/total.svg)](https://github.com/s9801077/Equipment-management-system)
![Version develop](https://img.shields.io/badge/license-MIT-green.svg)

### Requirement
* PHP >= 7.0.0
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
```

Cron setting
```
* * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1
```

Note:
* Setting Cron
* Run queue command `php artisan queue:listen`


### Login data
```
 email: admin@ems.ems
 password: admin
```

### License
The MIT License (MIT). Please see License File for more information.



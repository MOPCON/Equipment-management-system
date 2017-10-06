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
* npm >= 3.10.0

### Install
```
git clone git@github.com:s9801077/Equipment-management-system.git
cp .env.example .env
composer install
npm install
php artisan key:generate
php artisan migrate --seed
cd node_modules/admin-lte/
bower install
cd ../..
```

### Build
```
npm run dev     # run dev mode
npm run watch   # run watch mode
npm run prod    # run deploy
```

### Deploy
```
git clone git@github.com:s9801077/MIRDC-EKBS.git
cp .env.example .env
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
composer install
npm install
php artisan key:generate
php artisan migrate
cd node_modules/admin-lte/
bower install
cd ../..
npm run prod 
```

### Login data
```
 email: admin@ems.ems
 password: admin
```

### License
The MIT License (MIT). Please see License File for more information.



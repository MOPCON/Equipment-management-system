# Equipment-management-system
![Version develop](https://img.shields.io/badge/Laravel-5.8-orange.svg)
![Version develop](https://img.shields.io/badge/version-develop-yellow.svg)
[![Github All Releases](https://img.shields.io/github/downloads/atom/atom/total.svg)](https://github.com/s9801077/Equipment-management-system)
![Version develop](https://img.shields.io/badge/license-MIT-green.svg)
![Styleci status](https://github.styleci.io/repos/89154332/shield)
![Travis-ci](https://travis-ci.org/MOPCON/Equipment-management-system.svg?branch=develop)

## Table of Contents
- [Requirement](#requirement)
- [Installation](#installation)
- [Usage](#usage)
- [Configuration](#configuration)
- [Contributing](#contributing)
- [License](#license)

## Requirement
* PHP >= 7.1.3
    * OpenSSL PHP Extension
    * PDO PHP Extension
    * Mbstring PHP Extension
    * Tokenizer PHP Extension
    * XML PHP Extension
    * ZipArchive PHP Extension
    * ext-curl PHP Extension
* npm >= 3.10.0
* Yarn

## Installation
以下為 `開發環境` 安裝指南，欲部署到正式機，請至 [Deployment](#deployment)。

1. 從 Github Clone 到本機。
```
git clone git@github.com:s9801077/Equipment-management-system.git
cd Equipment-management-system
```

2. 複製 `.env.example` 至 `.env`。
```
cp .env.example .env
```

3. 至 `.env` 設定資料庫登入資訊，請將以下設定依照開發環境修改。
```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```

4. 安裝 PHP 與 Node 相依套件。
```
composer install
yarn install
```

5. 產生 App Key。
```
php artisan key:generate
```

6. 產生資料表與假資料，如果不想產生假資料，請移掉 `--seed` 參數。
```
php artisan migrate --seed
```

可用以下指令建立操作類別(無建立假資料)
```
php artisan db:seed --class=SystemLogTypeTableSeeder
```

7. 編譯前端資源與執行內建的開發用伺服器
```
yarn run watch
php artisan serve
```
到這裡就完成安裝。

### Font-End Build Command
```
yarn run dev     # run dev mode
yarn run watch   # run watch mode
yarn run prod    # run deploy
```

## Usage
使用瀏覽器開啟 `http://127.0.0.1:8000` 就會看到登入畫面，預設的帳號密碼如下:

```
Account: admin@ems.ems
Password: admin12345
```

## Deployment
部署流程跟 [Installation](#installation) 差不多，只有以下幾點要注意。

1. 請將網頁伺服器虛擬主機跟目錄指向專案跟目錄中的 `public`。

2. 網頁伺服器務必設定好 `Rewrite`。

3. 如果不要有假資料，請於執行 `php artisan migrate` 不要加上 `--seed`

4. 設定資料夾權限
```sh
chmod 777 -R storage bootstrap/cache
```

5. 前端資源編譯指令改使用這個
```
yarn run prod
```

### Deploy with Envoy

詳細使用方式可以參考 Laravel 官網[說明](https://laravel.com/docs/5.8/envoy)

#### 設定

請先至 `.env` 進行環境參數設定

```
Slack_HOOK_URL // 支援 slack 通知，可以在 deploy 完成傳送 slack web hook
SLACK_CHANNEL // 設定通知的 slack channel
SERVER_NAME // 設定要 deploy 的 server 格式可以是 xxx@xxx.xxx.com or xxx.xxx.com
```

- Deploy production: envoy run production-cms --branch=master
- Deploy testing:  envoy run testing-cms --branch=develop

### Note:
* 記得設定排程。
* 記得執行 Queue 的處理指令。

## Configuration

### 設定排程
請將以下設定修改路徑後新增至 `Cron`。
```
*/1 * 	* * *   root    php /home/ems/test/artisan schedule:run >> /dev/null 2>&1
```

### 設定 Queue
1. 將 `.env` 中的 `QUEUE_DRIVER` 設定修改為 `database`。

2. 執行 Queue 指令
如果你是本機要用，可以直接執行 `php artisan queue:listen` 如果是正式機要用，
可以使用以下指令： 
```
screen -S ems php artisan queue:listen
```
> screen 是一個管理背景執行的套件。

### Setting Telegram Bot
1. 在 .env 設定 `TELEGRAM_TOKEN` 與 `BOT_WEB_HOOK_HASH` (`BOT_WEB_HOOK_HASH` 請自行設定隨機字串，此字串將用於給 Telegram 呼叫的 web hook)
2. 執行 `php artisan ems:set-telegram-hook` 將 web hook 設定到 Telegram

#### Telegram Bot 指令清單

標示 `[private]` 的為僅允許在個人頻道使用。

- saveId: 儲存頻道 ID
- whoAmI: 顯示自己的 ID `[private]`

詳細 Telegram bot 說明可洽 [WIKI](https://github.com/puckwang/Equipment-management-system/wiki/Telegram-chatbot)

## Contributing

請遵照 Git Flow 流程，從 `develop` 創建一個分支、提交變更並開 Pull Request。

### PHP 注意事項

請遵守 [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md) 的規範，以統一專案內程式碼的風格，雖然我們有設定 StyleCI 修正錯誤的格式，但請將它當作最後防線。

### Vue 注意事項

1. 任何 `.vue` 的組件檔案名稱大寫駝峰式。
2. 獨立一個頁面一個資料夾且名稱為小寫駝峰，每個獨立頁面的根組件與其上層資料夾同名。
3. 路由名稱與頁面資料夾名稱相同。
4. 為於 `components` 資料夾內的組件會自動註冊，各別頁面所切出來的請自行於各別的根組件註冊。

### 使用 Docker 建立整個專案

#### 說明

- docker-compose 用於建立整個專案的前後端環境、資料庫、網頁伺服器
- Dockerfile 用於後端 PHP 部署
- init.sh 為初始化專案時必要的指令，包含建立專案資料庫、相依套件、資料初始化等...

#### 步驟

1. 複製環境變數
```bash
cp .env.example .env
```

2. 啟用 docker-compose
```bash
docker-compose down
```

3. 結束 docker-compose
```bash
docker-compose logs -f
```


## License
The MIT License (MIT). Please see License File for more information.



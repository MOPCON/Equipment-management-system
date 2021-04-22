# PHP Laravel  + Node.js Docker 環境

## 安裝
* apt install docker-ce

## 建立前/後端專案
```
git clone git@git.skymirror.com.tw:zscorp/onestone-crm/onestone-crm-frontend frontend
git clone git@git.skymirror.com.tw:zscorp/onestone-crm/onestone-crm-backend.git html
```
## 使用

```
docker-compose up -d
```

## 建立後端專案

### 進入 docker mysql 環境，建立資料庫
```
docker exec {mysql container name} \
    mysql -uroot -p{你的資料庫密碼} \
    -e \
		"CREATE DATABASE IF NOT EXISTS \`你的資料庫名稱\`; CREATE USER '你的資料庫名稱'@'%' IDENTIFIED BY '{你的資料庫密碼}'; GRANT ALL PRIVILEGES ON *.* TO '你的資料庫名稱'@'%'; FLUSH PRIVILEGES;"
```

### 進入 docker php 環境

```
docker-compose exec php bash
```
### 安裝 PHP 相關套件

```
cd /var/www/html
composer install

```
### 複製環境設定

```
cp .env.example .env
```
### 建立金鑰及資料庫
```
php artisan key:generate 
php artisan migrate --seed
```


### 測試進入專案
http://localhost/

# 設定
## 設定專案nginx根目錄

```nginx
server {
	listen       80;
	listen  [::]:80;
	server_name  localhost;
	root /var/www/html/public;  # 專案的 root 目錄
	index index.html index.htm;
	client_max_body_size 100M;
	
	location ~* \.(?:manifest|appcache|html?|xml|json)$ {
			expires -1;
	}

	location ~* \.(?:css|js)$ {
			try_files $uri =404;
			expires -1;
			access_log off;
			add_header Cache-Control "public";
	}

	#前端檔案位置
	location / {
			root /var/www/html/public ;
			index  /index.html ;
			try_files $uri /index.html;
	}

	#api檔案位置
	location /api {
			# For laravel project
			alias   /var/www/html/public; 
			index  index.html index.htm index.php;

			try_files $uri $uri/ @api; #/index.php$request_uri;

			location ~ ^(.+\.php)(.*)$ {
					fastcgi_pass   php:9000;
					fastcgi_index  index.php;

					# 讓 PHP 可以取得 PATH_INFO 參數
					fastcgi_split_path_info         ^(.+\.php)(/.+)$;
					fastcgi_param  PATH_INFO        $fastcgi_path_info;
					fastcgi_param SCRIPT_FILENAME $request_filename;
					include        fastcgi_params;
			}
	}
}
```

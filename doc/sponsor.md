# 贊助商 API doc

## 取得贊助商表單所有選項

+ **URL :** 

    **`/sponsor/get-options`**
    
+ **Method** : 

    **`GET`**
     
+ **Response :**
    ```json
    {
        "success": true,
        "message": "Success.",
        "data": {
            "sponsorStatusItem": [
                "待確認",
                "確認中",
                "已確認",
                "下架"
            ],
            "sponsorTypeItem": [
                "Tony Stark",
                "Bruce Wayne",
                "Hacker",
                "Developer",
                "其他"
            ]
        }
    }
    ```
    

## 取得贊助商資料
+ **URL :** 
 
    **`/sponsor/{accessKey}`**
    
+ **Method :** 

    **`POST`**

+ **Request**
    + **data**
        + passward [string] ***(required)***
        
+ **Response** 
    + **data-type:** application/json

    + **data**
    ```Json
    {
        "success": true,
        "message": "Success.",
        "data": {
            "main": {
                "name": "相信數位有限公司",
                "en_name": "Russel Group",
                "introduction": "Placeat id rerum ut enim ut suscipit. Rerum beatae qui quam. Sed tenetur dolor quos deserunt qui rerum ea.",
                "en_introduction": "Molestiae aut ullam aut ut. Quos porro qui amet cumque totam error et. Reprehenderit et at neque.",
                "website": "http://parisian.com/dolores-eaque-ab-nesciunt-occaecati-officiis-voluptatem",
                "social_media": "http://bins.com/excepturi-eum-omnis-distinctio-rerum-perferendis.html",
                "production": "Minima dignissimos doloribus officiis accusamus enim in aut. Similique ut enim laborum nostrum quas optio.",
                "logo_path": "https://lorempixel.com/120/120/cats/?27731",
                "service_photo_path": "https://lorempixel.com/120/120/cats/?87685",
                "promote": "Sequi perspiciatis soluta voluptate est sit.",
                "slide_path": "https://lorempixel.com/120/120/cats/?14313",
                "board_path": "https://lorempixel.com/120/120/cats/?49473",
                "opening_remarks": "Quis sit velit occaecati. Dolor illum est sed quia et impedit cupiditate. Mollitia alias sit sed unde voluptas vero.",
                "reason": "Blanditiis esse consequatur laborum. Aut nostrum doloremque veniam consequatur. Autem esse qui eius et.",
                "purpose": "Voluptate reprehenderit qui voluptate labore est ut sit. Quo adipisci est ab explicabo. Excepturi qui quis est amet.",
                "remark": "Et laboriosam sequi et nobis quia qui dolorum. Fuga et delectus id quis est modi at.",
                "access_key": "0917980b-a43e-4dba-9488-70806fe12853",
                "created_at": "2019-07-11 01:53:14",
                "updated_at": "2019-07-11 01:53:14",
                "external_link": "http://192.168.1.32:8000/sponsor/form/0917980b-a43e-4dba-9488-70806fe12853"
            },
            "recipe": {
                "recipe_full_name": "喬山股份有限公司",
                "recipe_tax_id_number": "40715898",
                "recipe_amount": 849840,
                "recipe_contact_name": "鄒鈺穎",
                "recipe_contact_title": "perferendis",
                "recipe_contact_phone": "0954-020-882",
                "recipe_contact_email": "wwiza@hotmail.com",
                "recipe_contact_address": "134-34 臺中市外埔區行忠路二段532巷545弄990號"
            },
            "advence": {
                "advence_icck_ad_path": "https://lorempixel.com/120/120/cats/?49065",
                "advence_registration_ad_path": "https://lorempixel.com/120/120/cats/?87591",
                "advence_keynote": "Voluptatem repellendus tempore et est dolores velit. Sed voluptate sunt officiis ipsa consectetur ut consequatur.",
                "advence_hall_flag_path": "https://lorempixel.com/120/120/cats/?28690",
                "advence_main_flow_flag_path": "https://lorempixel.com/120/120/cats/?90455"
            }
        }
    }
    ```

## 更新贊助商資料
+ **URL :** 
 
    **`/sponsor/{accessKey}`**
    
+ **Method :** 

    **`POST`**

+ **Request**
    + **content-type :** multipart/form-data 
    
    + **_method :** PUT
    
    + **data**
        + passward [string] 密碼 ***(required)***
        + name [string] 公司名稱 ***(required)***
        + en_name [string] 	公司英文名稱
        + introduction [string] 公司簡介
        + en_introduction [string] 公司英文簡介
        + website [url] 公司網站
        + social_media [url] 社群媒體(如FB等)
        + production [string] 產品及服務介紹
        + logo_path [image] logo圖檔
        + service_photo_path [image] 產品或服務照片
        + promote [string] 希望MOPCON宣傳的內容
        + slide_path [image] 場間投影片圖檔
        + board_path [image] 電子看板圖檔
        + opening_remarks [string] 晚宴簡介
        + recipe_full_name [string] 公司/組織全銜
		+ recipe_tax_id_number [string] 統一編號
		+ recipe_amount [integer]贊助金額
		+ recipe_contact_name [string] 聯絡人姓名
		+ recipe_contact_title [string] 聯絡人職稱
		+ recipe_contact_phone [string] 聯絡人電話
		+ recipe_contact_email [email]聯絡人Email
		+ recipe_contact_address [string] 收件地址
		+ reason [string] 為什麼本次選擇贊助 MOPCON？
		+ purpose [string] 希望能在本次大會達成的目標
		+ remark [string] 備註
		+ advence_icck_ad_path [image] ICCK大門兩側廣告圖檔
		+ advence_registration_ad_path [image] 報到處全版廣告空間圖檔
		+ advence_keynote Keynote [string] 引言圖檔
		+ advence_hall_flag_path [image] 演講廳旗幟圖檔
		+ advence_main_flow_flag_path [image] 主動線旗幟廣告圖檔
        
+ **Response** 
    + **data-type:** application/json

    + **data**
    ```json
    {
        "success": true,
        "message": "Update success.",
        "data": {
            "main": {
                "name": "濮陽冠",
                "en_name": "Emelia Strosin",
                "introduction": "Placeat id rerum ut enim ut suscipit. Rerum beatae qui quam. Sed tenetur dolor quos deserunt qui rerum ea.",
                "en_introduction": "Molestiae aut ullam aut ut. Quos porro qui amet cumque totam error et. Reprehenderit et at neque.",
                "website": "http://parisian.com/dolores-eaque-ab-nesciunt-occaecati-officiis-voluptatem",
                "social_media": "http://bins.com/excepturi-eum-omnis-distinctio-rerum-perferendis.html",
                "production": "Minima dignissimos doloribus officiis accusamus enim in aut. Similique ut enim laborum nostrum quas optio.",
                "logo_path": "https://lorempixel.com/120/120/cats/?27731",
                "service_photo_path": "https://lorempixel.com/120/120/cats/?87685",
                "promote": "Sequi perspiciatis soluta voluptate est sit.",
                "slide_path": "https://lorempixel.com/120/120/cats/?14313",
                "board_path": "https://lorempixel.com/120/120/cats/?49473",
                "opening_remarks": "Quis sit velit occaecati. Dolor illum est sed quia et impedit cupiditate. Mollitia alias sit sed unde voluptas vero.",
                "reason": "Blanditiis esse consequatur laborum. Aut nostrum doloremque veniam consequatur. Autem esse qui eius et.",
                "purpose": "Voluptate reprehenderit qui voluptate labore est ut sit. Quo adipisci est ab explicabo. Excepturi qui quis est amet.",
                "remark": "Et laboriosam sequi et nobis quia qui dolorum. Fuga et delectus id quis est modi at.",
                "access_key": "0917980b-a43e-4dba-9488-70806fe12853",
                "created_at": "2019-07-11 01:53:14",
                "updated_at": "2019-07-11 03:31:39",
                "external_link": "http://192.168.1.32:8000/sponsor/form/0917980b-a43e-4dba-9488-70806fe12853"
            },
            "recipe": {
                "recipe_full_name": "喬山股份有限公司",
                "recipe_tax_id_number": "40715898",
                "recipe_amount": 849840,
                "recipe_contact_name": "鄒鈺穎",
                "recipe_contact_title": "perferendis",
                "recipe_contact_phone": "0954-020-882",
                "recipe_contact_email": "wwiza@hotmail.com",
                "recipe_contact_address": "134-34 臺中市外埔區行忠路二段532巷545弄990號"
            },
            "advence": {
                "advence_icck_ad_path": "https://lorempixel.com/120/120/cats/?49065",
                "advence_registration_ad_path": "https://lorempixel.com/120/120/cats/?87591",
                "advence_keynote": "Voluptatem repellendus tempore et est dolores velit. Sed voluptate sunt officiis ipsa consectetur ut consequatur.",
                "advence_hall_flag_path": "https://lorempixel.com/120/120/cats/?28690",
                "advence_main_flow_flag_path": "https://lorempixel.com/120/120/cats/?90455"
            }
        }
    }
    ```
## 取得贊助商列表

+ **URL :** 
 
    **`/api/sponsor`**
    
+ **Method :** 

    **`GET`**
    

## 新增贊助商

+ **URL :** 
 
    **`/api/sponsor`**
    
+ **Method :** 

    **`POST`**

+ **Request :**
    + **data-type :** multipart/form-data
    + **data :**
        + name [string] 公司名稱 ***(required)***
        + sponsor_type [int] 贊助商類型 ***(required)***

## 取得講師資料

+ **URL :** 
 
    **`/api/sponsor/{id}`**
    
+ **Method :** 

    **`GET`**

+ **Parameters**

    + **id :** 1 (number)

+ Response
    + **data-type :** application/json
    
    + **data :**
    ```json
    {
        "success": true,
        "message": "Show success.",
        "data": {
            "main": {
                "id": 15,
                "sponsor_status": 0,
                "name": "遊戲橘子機械公司",
                "en_name": "Pouros PLC",
                "introduction": "Iste omnis eligendi et vel unde adipisci harum. Quia aut asperiores consequatur. Laborum quia sed rerum ipsum.",
                "en_introduction": "Dolor ipsum quia ratione. Rerum et rem recusandae et rem. Suscipit aut id et nemo quo.",
                "website": "http://www.hill.com/aut-beatae-quia-quidem-sunt-id-magnam-dolores.html",
                "social_media": "http://heidenreich.org/",
                "production": "Voluptas sed veniam et. Vitae explicabo rerum quod dicta. Ut quaerat eveniet rerum laudantium doloremque.",
                "logo_path": "https://lorempixel.com/120/120/cats/?55595",
                "service_photo_path": "https://lorempixel.com/120/120/cats/?56504",
                "promote": "Possimus quis culpa aut reiciendis. Amet et aut dignissimos dolor ratione sed.",
                "slide_path": "https://lorempixel.com/120/120/cats/?20921",
                "board_path": "https://lorempixel.com/120/120/cats/?18763",
                "opening_remarks": "Est qui voluptas dolore quia nisi. Ut tempora omnis in quo ut sint cum. Modi non impedit nostrum harum est ut.",
                "reason": "Unde sint molestiae possimus laboriosam temporibus. Ipsum esse ut ea. Eius ex sit deserunt assumenda quasi magni.",
                "purpose": "Totam inventore assumenda ducimus sunt rerum quos ut. Sit repellat molestiae dolore explicabo libero.",
                "remark": "Maiores atque accusamus delectus sit aut. Cumque cupiditate maxime ratione repellat animi. Soluta id est quia tempore.",
                "access_key": "2277771d-ca3b-4543-af2b-452e070b7f73",
                "access_secret": "CcEqeg0aArJljICuz5xA",
                "update_by": "遊戲橘子機械公司",
                "created_at": "2019-07-11 03:15:24",
                "updated_at": "2019-07-11 03:15:24",
                "sponsor_status_text": "待確認",
                "external_link": "http://192.168.1.32:8000/sponsor/form/2277771d-ca3b-4543-af2b-452e070b7f73"
            },
            "advence": {
                "sponsor_type": 1,
                "advence_icck_ad_path": "https://lorempixel.com/120/120/cats/?55469",
                "advence_registration_ad_path": "https://lorempixel.com/120/120/cats/?80737",
                "advence_keynote": "Quis eos ut velit et enim dicta labore explicabo. Et placeat ut sequi ipsam eum. Ipsa quisquam quas aut debitis.",
                "advence_hall_flag_path": "https://lorempixel.com/120/120/cats/?51183",
                "advence_main_flow_flag_path": "https://lorempixel.com/120/120/cats/?94116",
                "sponsor_type_text": "Bruce Wayne",
                "sponsor_file_text": [
                    "Keynote 引言",
                    "演講廳旗幟",
                    "主動線旗幟廣告"
                ]
            },
            "recipe": {
                "recipe_full_name": "典選集團公司",
                "recipe_tax_id_number": "56001835",
                "recipe_amount": 754329,
                "recipe_contact_name": "公羊哲",
                "recipe_contact_title": "iusto",
                "recipe_contact_phone": "0955959177",
                "recipe_contact_email": "elna05@witting.com",
                "recipe_contact_address": "743 桃園市觀音區立功街五段876巷350弄633號62樓"
            }
        }
    }
    ```
    
# 更新贊助商資料/狀態

+ **URL :** 
 
    **`/sponsor/{accessKey}`**
    
+ **Method :** 

    **`POST`**

+ **Request**

    + **content-type :** multipart/form-data 
    
    + **_method :** PUT
    
    + **data**
        + name [string] 公司名稱 ***(required)***
        + en_name [string] 	公司英文名稱
        + introduction [string] 公司簡介
        + en_introduction [string] 公司英文簡介
        + website [url] 公司網站
        + social_media [url] 社群媒體(如FB等)
        + production [string] 產品及服務介紹
        + logo_path [image] logo圖檔
        + service_photo_path [image] 產品或服務照片
        + promote [string] 希望MOPCON宣傳的內容
        + slide_path [image] 場間投影片圖檔
        + board_path [image] 電子看板圖檔
        + opening_remarks [string] 晚宴簡介
        + recipe_full_name [string] 公司/組織全銜
		+ recipe_tax_id_number [string] 統一編號
		+ recipe_amount [integer]贊助金額
		+ recipe_contact_name [string] 聯絡人姓名
		+ recipe_contact_title [string] 聯絡人職稱
		+ recipe_contact_phone [string] 聯絡人電話
		+ recipe_contact_email [email]聯絡人Email
		+ recipe_contact_address [string] 收件地址
		+ reason [string] 為什麼本次選擇贊助 MOPCON？
		+ purpose [string] 希望能在本次大會達成的目標
		+ remark [string] 備註
		+ advence_icck_ad_path [image] ICCK大門兩側廣告圖檔
		+ advence_registration_ad_path [image] 報到處全版廣告空間圖檔
		+ advence_keynote Keynote [string] 引言圖檔
		+ advence_hall_flag_path [image] 演講廳旗幟圖檔
		+ advence_main_flow_flag_path [image] 主動線旗幟廣告圖檔
		+ sponsor_status [int] 贊助商狀態
        + sponsor_type [int] 贊助商類型


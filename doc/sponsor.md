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
                "year": 2019,
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
        + en_name [string] 公司英文名稱
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
		+ recipe_amount [integer] 贊助金額
		+ recipe_contact_name [string] 聯絡人姓名
		+ recipe_contact_title [string] 聯絡人職稱
		+ recipe_contact_phone [string] 聯絡人電話
		+ recipe_contact_email [email] 聯絡人Email
		+ recipe_contact_address [string] 收件地址
		+ reason [string] 為什麼本次選擇贊助 MOPCON？
		+ purpose [string] 希望能在本次大會達成的目標
		+ remark [string] 備註
		+ advence_icck_ad_path [image] ICCK 大門兩側廣告圖檔
		+ advence_registration_ad_path [image] 報到處全版廣告空間圖檔
		+ advence_keynote [string] Keynote 引言
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
                "year": 2020,
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

+ **Parameters**

  + **search :** 研華百貨有限公司 [string] 搜尋公司名稱/聯絡人
  + **filter :** `{'year': 2020, 'status': 0, 'type: 3'}` [json] 篩選:年份、贊助商狀態/等級 **註:須用 `JSON.stringify()` 轉換**
  + **sort :** updated_at [string] 欄位名稱 eg: name, sponsor_type, updated_at, ...
  + **order :** ASC [string] ASC/DESC
    
+ **Response**
  + **data-type:** application/json

  + **data**
    ```json
    {
        success: true,
        message: "Success.",
        data: {
            current_page: 1,
            data: [
                {
                    id: 51,
                    year: 2019,
                    sponsor_type: 4,
                    sponsor_status: 0,
                    name: "廖傑",
                    en_name: null,
                    introduction: null,
                    en_introduction: null,
                    website: null,
                    social_media: null,
                    production: null,
                    logo_path: null,
                    service_photo_path: null,
                    promote: null,
                    slide_path: null,
                    board_path: null,
                    opening_remarks: null,
                    recipe_full_name: null,
                    recipe_tax_id_number: null,
                    recipe_amount: null,
                    recipe_contact_name: null,
                    recipe_contact_title: null,
                    recipe_contact_phone: null,
                    recipe_contact_email: null,
                    recipe_contact_address: null,
                    reason: null,
                    purpose: null,
                    remark: null,
                    advence_icck_ad_path: null,
                    advence_registration_ad_path: null,
                    advence_keynote: null,
                    advence_hall_flag_path: null,
                    advence_main_flow_flag_path: null,
                    access_key: "80404beb-edec-418b-8aba-0ee6091de6aa",
                    access_secret: "4tvioK6Qzi0VHVsCXJ3S",
                    updated_by: 0,
                    created_at: "2019-07-13 17:05:43",
                    updated_at: "2019-07-13 17:05:43",
                    sponsor_type_text: "其他",
                    sponsor_file_text: [ ],
                    sponsor_status_text: "待確認",
                    external_link: "http://192.168.1.32:8000/sponsor/form/80404beb-edec-418b-8aba-0ee6091de6aa"
                },
                {...}
            ],
            first_page_url: "http://192.168.1.32:8000/api/sponsor?page=1",
            from: 1,
            last_page: 3,
            last_page_url: "http://192.168.1.32:8000/api/sponsor?page=3",
            next_page_url: "http://192.168.1.32:8000/api/sponsor?page=2",
            path: "http://192.168.1.32:8000/api/sponsor",
            per_page: "25",
            prev_page_url: null,
            to: 25,
            total: 51
        }
    }
    ```
## 匯出贊助商資料
+ **URL :**

    **`/api/sponsor/export`**

+ **Method :** 

    **`GET`**

+ **Parameters**
  
  + **ids :** 1,2,3 [string] id 用 '**,**' 分隔的字串

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

## 取得贊助商資料

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
                "year": 2020,
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
                "updated_by": "遊戲橘子機械公司",
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
    
## 更新贊助商資料/狀態

+ **URL :** 
 
    **`/api/sponsor/{id}`**
    
+ **Method :** 

    **`POST`**

+ **Request**

    + **content-type :** multipart/form-data 
    
    + **_method :** PUT
    
    + **data**
        + year [int] 年份 ***(required)***
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
+ **Response** 
    + **data-type:** application/json

    + **data**
    ```json
    {
        "success": true,
        "message": "Update success.",
        "data": {
            "main": {
                "id": 3,
                "year": 2020,
                "sponsor_status": 0,
                "name": "遊戲西瓜",
                "en_name": "Smith-Schultz",
                "introduction": "Dolor corporis iure rerum deserunt. Dolore tempora et ipsam enim. Exercitationem aliquid et saepe atque quas.",
                "en_introduction": "Cum est voluptatem eos. Inventore cupiditate voluptate ea quis voluptatum quae.",
                "website": "https://www.kris.com/veniam-iure-ipsum-eveniet-adipisci-repellendus-velit",
                "social_media": "http://www.daugherty.com/quo-tenetur-labore-et-ea-dolorum-quia-quia",
                "production": "Expedita quia natus veritatis optio molestias. Officia molestiae unde consequatur fugiat in.",
                "logo_path": "https://lorempixel.com/120/120/cats/?52084",
                "service_photo_path": "https://lorempixel.com/120/120/cats/?71377",
                "promote": "Exercitationem molestiae voluptatibus quasi est et dolorem officia.",
                "slide_path": "https://lorempixel.com/120/120/cats/?65445",
                "board_path": "https://lorempixel.com/120/120/cats/?77731",
                "opening_remarks": "Eum eum et voluptatum mollitia non pariatur. Amet necessitatibus rerum veritatis nisi consequatur aspernatur.",
                "reason": "Mollitia at quia vel omnis debitis modi. Est eos natus quibusdam dolores non voluptatem.",
                "purpose": "Quia rerum eum et. Est iste quidem doloribus iusto debitis provident rerum.",
                "remark": "Voluptas saepe fugit molestias est voluptates. Velit quod autem ea id. Numquam sit quisquam ab quae aut.",
                "access_key": "bca3feaf-b85b-450f-9c2f-c7dfff65a579",
                "access_secret": "f3jFSvlYN7ZFSB6fe8Tv",
                "updated_by": "admin",
                "created_at": "2019-07-13 12:05:44",
                "updated_at": "2019-07-14 16:26:10",
                "sponsor_status_text": "待確認",
                "external_link": "http://192.168.1.32:8000/sponsor/form/bca3feaf-b85b-450f-9c2f-c7dfff65a579"
            },
            "advence": {
                "sponsor_type": 3,
                "advence_icck_ad_path": "https://lorempixel.com/120/120/cats/?73415",
                "advence_registration_ad_path": "https://lorempixel.com/120/120/cats/?42440",
                "advence_keynote": "Occaecati veniam et corrupti eos. A et tempore veniam est. Tenetur aut reiciendis aut placeat ut.",
                "advence_hall_flag_path": "https://lorempixel.com/120/120/cats/?18177",
                "advence_main_flow_flag_path": "https://lorempixel.com/120/120/cats/?79501",
                "sponsor_type_text": "Developer",
                "sponsor_file_text": []
            },
            "recipe": {
                "recipe_full_name": "訊連股份有限公司",
                "recipe_tax_id_number": "59466758",
                "recipe_amount": 225343,
                "recipe_contact_name": "閔俊",
                "recipe_contact_title": "autem",
                "recipe_contact_phone": "(035)508-865",
                "recipe_contact_email": "ethelyn.nicolas@yahoo.com",
                "recipe_contact_address": "690 新北市新店區松智三街879巷919弄73號4樓"
            }
        }
    }
    ```
## 刪除贊助商

+ **URL :** 
 
    **`/api/sponsor/{id}`**
    
+ **Method :** 

    **`DELETE`**
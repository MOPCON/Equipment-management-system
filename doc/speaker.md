# 講師 API doc

------

## 前台頁面獲取該名講師所有資料

+ **URL :**

  **`/speaker/:accessKey`**

+ **Method** :

  **`POST`**

+ **Request**

    + **data**

        + passward [string] 密碼 ***(required)***

+ **Response**

    + **data-type:** application/json
    + **Code:** 200

    + **data**
    ```json
      {
        "success": true,
        "message": "Success.",
        "data": {
          "name": "家佳",
          "name_e": "Hilbert Boyle",
          "company": "大國集團公司",
          "company_e": "",
          "job_title": "incidunt",
          "job_title_e": "",
          "bio": "Ullam alias magni fugiat at. Error earum aut aperiam cupiditate. Atque suscipit voluptas aut sed ullam architecto.",
          "bio_e": "Aliquam voluptatem iste tenetur nesciunt. Maiores consequatur labore minus voluptatum odio inventore magni. Vero suscipit debitis commodi fugit non.",
          "photo": "https://picsum.photos/200",
          "link_fb": "https://www.funk.com/sit-voluptas-cumque-reiciendis-est",
          "link_github": "https://www.schoen.com/id-sunt-ut-quod-modi-voluptas-commodi-maxime",
          "link_twitter": "http://oconnell.info/ut-et-iste-necessitatibus-reprehenderit",
          "link_other": "http://www.sporer.com/quis-eveniet-incidunt-quibusdam-illo-commodi-et-eaque",
          "link_slide": "",
          "topic": "Maxime nesciunt.",
          "topic_e": "Est aliquid sed eum quae in.",
          "summary": "Repudiandae voluptatem placeat qui modi quia dignissimos. Tempora in ex saepe officiis sunt laborum. Quia eum qui totam dolor numquam.",
          "summary_e": "Aut ducimus odio distinctio vitae. Iure delectus quam voluptatem iste reiciendis nisi et. Temporibus nihil repellat earum molestiae. Autem ut a eveniet omnis quidem. Eveniet ducimus et quaerat. Vitae porro sed molestiae architecto veritatis modi. Earum et consequuntur ut qui quas ex et. Neque eos dolore ut maiores perspiciatis dolor.",
          "tag": [
            0,
            1,
            4,
            5,
            6,
            7,
            8,
            9,
            10,
            11,
            13
          ],
          "level": 1,
          "license": 0,
          "promotion": 1,
          "tshirt_size": 3,
          "need_parking_space": 0,
          "year": 2019,
          "has_dinner": 1,
          "meal_preference": 1,
          "has_companion": 0,
          "note": null,
          "access_key": "f5afbbd5-ba82-48c8-949e-720852930475",
          "created_at": "2019-06-22 14:50:42",
          "updated_at": "2019-06-22 14:50:42",
          "tag_text": [
            "AI",
            "AR/VR",
            "DevOps",
            "IoT",
            "Mobile App",
            "Startup",
            "UI/UX",
            "Web",
            "Quant",
            "Security",
            "Data Science"
          ],
          "level_text": "Normal-歡迎略懂略懂有基本基礎的會眾",
          "license_text": "授予 MOPCON 演講時錄影，後製與上傳至公開線上影音平台之權利。",
          "tshirt_size_text": "L",
          "meal_preference_text": "全素",
          "external_link": "http://127.0.0.1:8000/speaker/form/a17b53ad-148f-4d4c-985c-0e836bb78402"
        }
      }
    ```

+ **Error Response**
    + **reason:** 使用錯誤的 protocol
    + **Code:** 400

    + **data**
    ```json
      {
        "success": false,
        "message": "Bad request",
        "data": []
      }
    ```
    + **reason:** 輸入密碼錯誤
    + **Code:** 400

    + **data**
    ```json
      {
        "success": false,
        "message": "Bad request",
        "data": []
      }
    ```

## 取得講師表單所有選項

+ **URL :**

    **`/speaker/get-options`**

+ **Method :**

    **`GET`**

+ **Response**
  + **data-type:** application/json

  + **data**
  ```json
    {
        "tagItem": [
            "AI",
            "AR/VR",
            "Blockchain",
            "Cloud",
            "DevOps",
            "IoT",
            "Mobile App",
            "Startup",
            "UI/UX",
            "Web",
            "Quant",
            "Security",
            "Cross-platform",
            "Data Science",
            "Agile",
            "Panel",
            "FinTech",
            "QA"
        ],
        "levelItem": [
            "Basic-外行人可以藉此入門",
            "Normal-歡迎略懂略懂有基本基礎的會眾",
            "Expert-建議在該領域中有研究經驗的人入場"
        ],
        "licenseItem": [
            "授予 MOPCON 演講時錄影，後製與上傳至公開線上影音平台之權利。",
            "以 CC BY 3.0 姓名標示方式授權。",
            "以 CC BY-SA 3.0 姓名標示-相同方式授權。",
            "以 CC BY-NC 3.0 姓名標示-非商業性方式授權。",
            "謝絕所有錄音錄影，但接受 MOPCON 工作人員文字紀錄。",
        ],
        "tshirtSizeItem": [
            "XS",
            "S",
            "M",
            "L",
            "XL",
            "2XL",
        ],
        "mealPreferenceItem": [
            "葷",
            "全素",
            "奶蛋素",
        ],
        "speakerStatusItem": [
            0: "待確認",
            1: "確認中",
            2: "已確認",
            3: "下架",
            4: "關閉前台修改",
        ],
        "speakerTypeItem": [
            "贊助商",
            "CFP",
            "CFR",
            "內推",
            "其他",
        ],
    }
  ```

## 更新講者資料

+ **URL :**

    **`speaker/{accessKey}`**

+ **Method :**

    **`PUT`**

+ **Request**

    + **content-type :** multipart/form-data

    + **data**
        + passward [string] 密碼 ***(required)***

+ **Response**
    + **data-type:** application/json

    + **data**
    ```json
      {
        "success": true,
        "message": "Success.",
        "data": {
          "name": "家佳",
          "name_e": "Hilbert Boyle",
          "company": "大國集團公司",
          "company_e": "",
          "job_title": "incidunt",
          "job_title_e": "",
          "bio": "Ullam alias magni fugiat at. Error earum aut aperiam cupiditate. Atque suscipit voluptas aut sed ullam architecto.",
          "bio_e": "Aliquam voluptatem iste tenetur nesciunt. Maiores consequatur labore minus voluptatum odio inventore magni. Vero suscipit debitis commodi fugit non.",
          "photo": "https://picsum.photos/200",
          "link_fb": "https://www.funk.com/sit-voluptas-cumque-reiciendis-est",
          "link_github": "https://www.schoen.com/id-sunt-ut-quod-modi-voluptas-commodi-maxime",
          "link_twitter": "http://oconnell.info/ut-et-iste-necessitatibus-reprehenderit",
          "link_other": "http://www.sporer.com/quis-eveniet-incidunt-quibusdam-illo-commodi-et-eaque",
          "link_slide": "",
          "topic": "Maxime nesciunt.",
          "topic_e": "Est aliquid sed eum quae in.",
          "summary": "Repudiandae voluptatem placeat qui modi quia dignissimos. Tempora in ex saepe officiis sunt laborum. Quia eum qui totam dolor numquam.",
          "summary_e": "Aut ducimus odio distinctio vitae. Iure delectus quam voluptatem iste reiciendis nisi et. Temporibus nihil repellat earum molestiae. Autem ut a eveniet omnis quidem. Eveniet ducimus et quaerat. Vitae porro sed molestiae architecto veritatis modi. Earum et consequuntur ut qui quas ex et. Neque eos dolore ut maiores perspiciatis dolor.",
          "tag": [
            0,
            1,
            4,
            5,
            6,
            7,
            8,
            9,
            10,
            11,
            13
          ],
          "level": 1,
          "license": 0,
          "promotion": 1,
          "tshirt_size": 3,
          "need_parking_space": 0,
          "year": 2019,
          "has_dinner": 1,
          "meal_preference": 1,
          "has_companion": 0,
          "note": null,
          "access_key": "f5afbbd5-ba82-48c8-949e-720852930475",
          "created_at": "2019-06-22 14:50:42",
          "updated_at": "2019-06-22 14:50:42",
          "tag_text": [
            "AI",
            "AR/VR",
            "DevOps",
            "IoT",
            "Mobile App",
            "Startup",
            "UI/UX",
            "Web",
            "Quant",
            "Security",
            "Data Science"
          ],
          "level_text": "Normal-歡迎略懂略懂有基本基礎的會眾",
          "license_text": "授予 MOPCON 演講時錄影，後製與上傳至公開線上影音平台之權利。",
          "tshirt_size_text": "L",
          "meal_preference_text": "全素",
          "external_link": "http://127.0.0.1:8000/speaker/form/a17b53ad-148f-4d4c-985c-0e836bb78402"
        }
      }
    ```



## 取得全部講師列表

+ **URL :**

    **`/api/speaker`**

+ **Method :**

    **`GET`**

+ **Parameters**

  + **filter :** `{'year': 1911-2020}` [json] 篩選:年份
  + **search :** 大國集團公司 [string] 搜尋演講主題/講者姓名/公司名
  + **orderby_field  :** id [string]
  + **orderby_method :** ASC [string] ASC/DESC
  + **limit :** 15 [int] 筆數限制
  + **all   :** false [boolean] true/false ex:true = 無筆數限制

+ **Response**
    + **data-type:** application/json

    + **data**
    ```json
      {
        "success": true,
        "message": "Success.",
        "data": {
          "name": "家佳",
          "name_e": "Hilbert Boyle",
          "company": "大國集團公司",
          "company_e": "",
          "job_title": "incidunt",
          "job_title_e": "",
          "bio": "Ullam alias magni fugiat at. Error earum aut aperiam cupiditate. Atque suscipit voluptas aut sed ullam architecto.",
          "bio_e": "Aliquam voluptatem iste tenetur nesciunt. Maiores consequatur labore minus voluptatum odio inventore magni. Vero suscipit debitis commodi fugit non.",
          "photo": "https://picsum.photos/200",
          "link_fb": "https://www.funk.com/sit-voluptas-cumque-reiciendis-est",
          "link_github": "https://www.schoen.com/id-sunt-ut-quod-modi-voluptas-commodi-maxime",
          "link_twitter": "http://oconnell.info/ut-et-iste-necessitatibus-reprehenderit",
          "link_other": "http://www.sporer.com/quis-eveniet-incidunt-quibusdam-illo-commodi-et-eaque",
          "link_slide": "",
          "topic": "Maxime nesciunt.",
          "topic_e": "Est aliquid sed eum quae in.",
          "summary": "Repudiandae voluptatem placeat qui modi quia dignissimos. Tempora in ex saepe officiis sunt laborum. Quia eum qui totam dolor numquam.",
          "summary_e": "Aut ducimus odio distinctio vitae. Iure delectus quam voluptatem iste reiciendis nisi et. Temporibus nihil repellat earum molestiae. Autem ut a eveniet omnis quidem. Eveniet ducimus et quaerat. Vitae porro sed molestiae architecto veritatis modi. Earum et consequuntur ut qui quas ex et. Neque eos dolore ut maiores perspiciatis dolor.",
          "tag": [
            0,
            1,
            4,
            5,
            6,
            7,
            8,
            9,
            10,
            11,
            13
          ],
          "level": 1,
          "license": 0,
          "promotion": 1,
          "tshirt_size": 3,
          "need_parking_space": 0,
          "year": 2019,
          "has_dinner": 1,
          "meal_preference": 1,
          "has_companion": 0,
          "note": null,
          "access_key": "f5afbbd5-ba82-48c8-949e-720852930475",
          "created_at": "2019-06-22 14:50:42",
          "updated_at": "2019-06-22 14:50:42",
          "tag_text": [
            "AI",
            "AR/VR",
            "DevOps",
            "IoT",
            "Mobile App",
            "Startup",
            "UI/UX",
            "Web",
            "Quant",
            "Security",
            "Data Science"
          ],
          "level_text": "Normal-歡迎略懂略懂有基本基礎的會眾",
          "license_text": "授予 MOPCON 演講時錄影，後製與上傳至公開線上影音平台之權利。",
          "tshirt_size_text": "L",
          "meal_preference_text": "全素",
          "external_link": "http://127.0.0.1:8000/speaker/form/a17b53ad-148f-4d4c-985c-0e836bb78402"
        }
      }
    ```

## 新增講師

+ **URL :**

    **`/api/speaker`**

+ **Method :**

    **`POST`**

+ **Request**

    + **content-type :** multipart/form-data

    + **data**

        + name [string] 講師名稱 ***(required)***
        + year [int] 年份 ***(required)***
        + speaker_status [int] 修改狀態 ***(required)***

+ **Response**
    + **data-type:** application/json

    + **data**
    ```json
    {
        "success": true,
        "message": "Success.",
        "data": {
          "name": "家佳",
          "name_e": "Hilbert Boyle",
          "company": "大國集團公司",
          "company_e": "",
          "job_title": "incidunt",
          "job_title_e": "",
          "bio": "Ullam alias magni fugiat at. Error earum aut aperiam cupiditate. Atque suscipit voluptas aut sed ullam architecto.",
          "bio_e": "Aliquam voluptatem iste tenetur nesciunt. Maiores consequatur labore minus voluptatum odio inventore magni. Vero suscipit debitis commodi fugit non.",
          "photo": "https://picsum.photos/200",
          "link_fb": "https://www.funk.com/sit-voluptas-cumque-reiciendis-est",
          "link_github": "https://www.schoen.com/id-sunt-ut-quod-modi-voluptas-commodi-maxime",
          "link_twitter": "http://oconnell.info/ut-et-iste-necessitatibus-reprehenderit",
          "link_other": "http://www.sporer.com/quis-eveniet-incidunt-quibusdam-illo-commodi-et-eaque",
          "link_slide": "",
          "topic": "Maxime nesciunt.",
          "topic_e": "Est aliquid sed eum quae in.",
          "summary": "Repudiandae voluptatem placeat qui modi quia dignissimos. Tempora in ex saepe officiis sunt laborum. Quia eum qui totam dolor numquam.",
          "summary_e": "Aut ducimus odio distinctio vitae. Iure delectus quam voluptatem iste reiciendis nisi et. Temporibus nihil repellat earum molestiae. Autem ut a eveniet omnis quidem. Eveniet ducimus et quaerat. Vitae porro sed molestiae architecto veritatis modi. Earum et consequuntur ut qui quas ex et. Neque eos dolore ut maiores perspiciatis dolor.",
          "tag": [
            0,
            1,
            4,
            5,
            6,
            7,
            8,
            9,
            10,
            11,
            13
          ],
          "level": 1,
          "license": 0,
          "promotion": 1,
          "tshirt_size": 3,
          "need_parking_space": 0,
          "year": 2019,
          "has_dinner": 1,
          "meal_preference": 1,
          "has_companion": 0,
          "note": null,
          "access_key": "f5afbbd5-ba82-48c8-949e-720852930475",
          "access_secret": "CdFdh3ePqzURQ5P2uUOW",
          "created_at": "2019-06-22 14:50:42",
          "updated_at": "2019-06-22 14:50:42",
          "tag_text": [
            "AI",
            "AR/VR",
            "DevOps",
            "IoT",
            "Mobile App",
            "Startup",
            "UI/UX",
            "Web",
            "Quant",
            "Security",
            "Data Science"
          ],
          "level_text": "Normal-歡迎略懂略懂有基本基礎的會眾",
          "license_text": "授予 MOPCON 演講時錄影，後製與上傳至公開線上影音平台之權利。",
          "tshirt_size_text": "L",
          "meal_preference_text": "全素",
          "external_link": "http://127.0.0.1:8000/speaker/form/a17b53ad-148f-4d4c-985c-0e836bb78402"
        }
      }
    ```

## 取得講師資料

+ **URL :**

    **`/api/speaker/{id}`**

+ **Method :**

    **`POST`**

+ **Request**

    + **data**

        + id [int] ***(required)***

+ **Response**
    + **data-type:** application/json

    + **data**
    ```json
      {
        "success": true,
        "message": "Success.",
        "data": {
          "name": "家佳",
          "name_e": "Hilbert Boyle",
          "company": "大國集團公司",
          "company_e": "",
          "job_title": "incidunt",
          "job_title_e": "",
          "bio": "Ullam alias magni fugiat at. Error earum aut aperiam cupiditate. Atque suscipit voluptas aut sed ullam architecto.",
          "bio_e": "Aliquam voluptatem iste tenetur nesciunt. Maiores consequatur labore minus voluptatum odio inventore magni. Vero suscipit debitis commodi fugit non.",
          "photo": "https://picsum.photos/200",
          "link_fb": "https://www.funk.com/sit-voluptas-cumque-reiciendis-est",
          "link_github": "https://www.schoen.com/id-sunt-ut-quod-modi-voluptas-commodi-maxime",
          "link_twitter": "http://oconnell.info/ut-et-iste-necessitatibus-reprehenderit",
          "link_other": "http://www.sporer.com/quis-eveniet-incidunt-quibusdam-illo-commodi-et-eaque",
          "link_slide": "",
          "topic": "Maxime nesciunt.",
          "topic_e": "Est aliquid sed eum quae in.",
          "summary": "Repudiandae voluptatem placeat qui modi quia dignissimos. Tempora in ex saepe officiis sunt laborum. Quia eum qui totam dolor numquam.",
          "summary_e": "Aut ducimus odio distinctio vitae. Iure delectus quam voluptatem iste reiciendis nisi et. Temporibus nihil repellat earum molestiae. Autem ut a eveniet omnis quidem. Eveniet ducimus et quaerat. Vitae porro sed molestiae architecto veritatis modi. Earum et consequuntur ut qui quas ex et. Neque eos dolore ut maiores perspiciatis dolor.",
          "tag": [
            0,
            1,
            4,
            5,
            6,
            7,
            8,
            9,
            10,
            11,
            13
          ],
          "level": 1,
          "license": 0,
          "promotion": 1,
          "tshirt_size": 3,
          "need_parking_space": 0,
          "year": 2019,
          "has_dinner": 1,
          "meal_preference": 1,
          "has_companion": 0,
          "note": null,
          "access_key": "f5afbbd5-ba82-48c8-949e-720852930475",
          "access_secret": "CdFdh3ePqzURQ5P2uUOW",
          "created_at": "2019-06-22 14:50:42",
          "updated_at": "2019-06-22 14:50:42",
          "tag_text": [
            "AI",
            "AR/VR",
            "DevOps",
            "IoT",
            "Mobile App",
            "Startup",
            "UI/UX",
            "Web",
            "Quant",
            "Security",
            "Data Science"
          ],
          "level_text": "Normal-歡迎略懂略懂有基本基礎的會眾",
          "license_text": "授予 MOPCON 演講時錄影，後製與上傳至公開線上影音平台之權利。",
          "tshirt_size_text": "L",
          "meal_preference_text": "全素",
          "external_link": "http://127.0.0.1:8000/speaker/form/a17b53ad-148f-4d4c-985c-0e836bb78402"
        }
      }
    ```

## 更新講師資料

+ **URL :**

    **`/api/speaker/{id}`**

+ **Method :**

    **`PUT`**

+ **Request**

    + **content-type :** multipart/form-data

    + **data**

        + id [int] ***(required)***
        + year [int] 年份 ***(required)***
        + name [string] 姓名
        + name_e [string] 英文名稱
        + company [string] 公司/組織
        + company_e [string] 公司/組織(英文)
        + job_title [string] 職稱
        + job_title_e [string] 職稱(英文)
        + bio [string] 個人介紹
        + bio_e [string] 個人介紹(英文)
        + photo [string] 照片
        + link_fb [string] Facebook
        + link_github [string] Github
        + link_twitter [string] Twitter
        + link_other [string] 其他(如Website/Blog)
        + link_slide [string] 投影片連結
        + link_video [string] 錄影檔影片連結
        + topic [string] 演講主題
        + topic_e [string] 演講主題(英文)
        + summary [string] 演講摘要
        + summary_e [string] 演講摘要(英文)
        + tag [string] 標籤
        + level [int] 難易度
        + license [int] 授權方式
        + promotion [int] 是否同意公開宣傳
        + tshirt_size_text [int] T-shirt 尺寸
        + need_parking_space [int] 您是否需有停車需求
        + has_dinner [int] 敬邀參加講者晚宴
        + meal_preference_text [int] 葷素食偏好
        + has_companion [int] 晚宴攜伴人數
        + speaker_status [int] 修改狀態
        + speaker_type [int] 修改類型
        + is_keynote [int] 是否為 keynote 講者
        + note [string] 備註
        + access_key [string] UUID
        + access_secret [string] Password
        + created_at [string] 創建日期
        + updated_at [string] 更新日期

+ **Response**
    + **data-type:** application/json

    + **data**
    ```json
    {
        "success": true,
        "message": "Success.",
        "data": {
          "name": "家佳",
          "name_e": "Hilbert Boyle",
          "company": "大國集團公司",
          "company_e": "",
          "job_title": "incidunt",
          "job_title_e": "",
          "bio": "Ullam alias magni fugiat at. Error earum aut aperiam cupiditate. Atque suscipit voluptas aut sed ullam architecto.",
          "bio_e": "Aliquam voluptatem iste tenetur nesciunt. Maiores consequatur labore minus voluptatum odio inventore magni. Vero suscipit debitis commodi fugit non.",
          "photo": "https://picsum.photos/200",
          "link_fb": "https://www.funk.com/sit-voluptas-cumque-reiciendis-est",
          "link_github": "https://www.schoen.com/id-sunt-ut-quod-modi-voluptas-commodi-maxime",
          "link_twitter": "http://oconnell.info/ut-et-iste-necessitatibus-reprehenderit",
          "link_other": "http://www.sporer.com/quis-eveniet-incidunt-quibusdam-illo-commodi-et-eaque",
          "link_slide": "",
          "topic": "Maxime nesciunt.",
          "topic_e": "Est aliquid sed eum quae in.",
          "summary": "Repudiandae voluptatem placeat qui modi quia dignissimos. Tempora in ex saepe officiis sunt laborum. Quia eum qui totam dolor numquam.",
          "summary_e": "Aut ducimus odio distinctio vitae. Iure delectus quam voluptatem iste reiciendis nisi et. Temporibus nihil repellat earum molestiae. Autem ut a eveniet omnis quidem. Eveniet ducimus et quaerat. Vitae porro sed molestiae architecto veritatis modi. Earum et consequuntur ut qui quas ex et. Neque eos dolore ut maiores perspiciatis dolor.",
          "tag": [
            0,
            1,
            4,
            5,
            6,
            7,
            8,
            9,
            10,
            11,
            13
          ],
          "level": 1,
          "license": 0,
          "promotion": 1,
          "tshirt_size": 3,
          "need_parking_space": 0,
          "year": 2019,
          "has_dinner": 1,
          "meal_preference": 1,
          "has_companion": 0,
          "note": null,
          "access_key": "f5afbbd5-ba82-48c8-949e-720852930475",
          "created_at": "2019-06-22 14:50:42",
          "updated_at": "2019-06-22 14:50:42",
          "tag_text": [
            "AI",
            "AR/VR",
            "DevOps",
            "IoT",
            "Mobile App",
            "Startup",
            "UI/UX",
            "Web",
            "Quant",
            "Security",
            "Data Science"
          ],
          "level_text": "Normal-歡迎略懂略懂有基本基礎的會眾",
          "license_text": "授予 MOPCON 演講時錄影，後製與上傳至公開線上影音平台之權利。",
          "tshirt_size_text": "L",
          "meal_preference_text": "全素",
          "external_link": "http://127.0.0.1:8000/speaker/form/a17b53ad-148f-4d4c-985c-0e836bb78402"
        }
      }
    ```

## 刪除講師

+ **URL :**

    **`/api/speaker/{id}`**

+ **Method :**

    **`DELETE`**


## 輸出

+ **URL :**

    **`speaker/export`**

+ **Method :**

    **`GET`**

+ **Parameters**

  + **ids :** '2,3' [string]

  ```json
  {
      class: "App\Http\Controllers\SpeakerController"
      this: App\Http\Controllers\SpeakerController {#1029 …}
      use: {
        $speakers: Illuminate\Database\Eloquent\Collection {#974 …}
      }
      file: "D:\Equipment-management-system\app\Http\Controllers\SpeakerController.php"
      line: "228 to 230"
    }
    #streamed: false
    -headersSent: false
    +headers: Symfony\Component\HttpFoundation\ResponseHeaderBag {#5118
      #computedCacheControl: array:2 [
        "no-cache" => true
        "private" => true
      ]
      #cookies: []
      #headerNames: array:4 [
        "content-type" => "Content-Type"
        "cache-control" => "Cache-Control"
        "date" => "Date"
        "content-disposition" => "Content-Disposition"
      ]
      #headers: array:4 [
        "content-type" => array:1 [
          0 => "text/tab-separated-values"
        ]
        "cache-control" => array:1 [
          0 => "no-cache, private"
        ]
        "date" => array:1 [
          0 => "Sun, 21 Jun 2020 12:57:02 GMT"
        ]
        "content-disposition" => array:1 [
          0 => "attachment; filename=speakers-1592744222.tsv"
        ]
      ]
      #cacheControl: []
    }
    #content: null
    #version: "1.0"
    #statusCode: 200
    #statusText: "OK"
    #charset: null
  }
  ```

## 輸出VIEW

+ **URL :**

    **`/speaker/form/{accessKey}`**

+ **Method :**

    **`GET`**

+ **Parameters**

  + **ids :** '2,3' [string]

  ```json
  {
    "success": true,
    "message": "Success.",
    "data": {
      "access_key": "f5afbbd5-ba82-48c8-949e-720852930475",
      "readonly": ""
    }
  }
  ```
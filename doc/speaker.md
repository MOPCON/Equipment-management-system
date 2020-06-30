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
            "待確認",
            "確認中",
            "已確認",
            "下架",
            "關閉前台修改",
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
        + id [int]
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
        + access_secret [string] Password

+ **Response**
    + **data-type:** application/json

    + **data**
    ```json
      {
        "success": true,
        "message": "Success.",
        "data": {
        "name": "上官詩123321",
        "name_e": "edmond",
        "company": "大宇有限公司",
        "company_e": "Hagenes, Beier and Hirthe",
        "job_title": "ipsum",
        "job_title_e": "Self-Enrichment Education Teacher",
        "bio": "Voluptas quia ut ipsam molestiae explicabo et consequuntur vero. Vitae sit iusto laudantium repellat vitae occaecati.",
        "bio_e": "Cum id suscipit et nemo. Labore aliquam aut qui. Suscipit dolore hic quisquam sed ut ab inventore tempora. Explicabo autem consequatur eum qui corrupti aperiam.",
        "photo": "https://picsum.photos/500",
        "link_fb": "https://www.gutkowski.info/fugit-recusandae-omnis-quod-et-recusandae-corrupti-excepturi-et",
        "link_github": "http://strosin.biz/necessitatibus-incidunt-itaque-sint-molestiae-a-quae-et",
        "link_twitter": "http://www.crona.com/quo-consequatur-nihil-blanditiis-fugiat-dolorum-totam",
        "link_other": "http://schumm.com/saepe-expedita-quidem-blanditiis-et-voluptatum-sed.html",
        "link_slide": "https://jakubowski.biz/officiis-minus-sint-ea-maxime-blanditiis-iste.html",
        "topic": "Reprehenderit.",
        "topic_e": "Ut est nemo voluptatem cum.",
        "summary": "Culpa similique earum aliquid accusantium. Quo qui esse quibusdam modi laboriosam quibusdam. Iure praesentium explicabo et ad perferendis tempore. Facilis aut eum perspiciatis dolorem doloribus tempora pariatur ab.",
        "summary_e": "Cumque voluptatem inventore sed sit. Pariatur assumenda eaque mollitia similique hic aliquid. Voluptatem quibusdam qui quis odit itaque deleniti voluptatem. Reprehenderit repellat dicta laboriosam vel non architecto voluptas. Voluptatem voluptatem et omnis illum maxime tenetur aut. Deserunt ullam ut rem laudantium cupiditate earum consectetur. Qui dolores eveniet possimus autem suscipit autem deserunt sapiente.",
        "tag": [
            5,
            6,
            9,
            11,
            12,
            15
        ],
        "level": 2,
        "license": 1,
        "promotion": 0,
        "tshirt_size": 0,
        "need_parking_space": 1,
        "has_dinner": 1,
        "meal_preference": 1,
        "has_companion": 4,
        "note": "Consectetur quia repellat et quia. Facere sunt voluptates iure consequatur sed. Et iusto sapiente fugiat blanditiis. Ipsa enim vel blanditiis in quaerat incidunt cupiditate.",
        "access_key": "b2b29fb5-7187-494b-9085-8ac8e0338747",
        "year": 2017,
        "created_at": "2020-06-10 22:58:27",
        "updated_at": "2020-06-29 21:23:50",
        "tag_text": [
            "IoT",
            "Mobile App",
            "Web",
            "Security",
            "Cross-platform",
            "Panel"
        ],
        "level_text": "Expert-建議在該領域中有研究經驗的人入場",
        "license_text": "以 CC BY 3.0 姓名標示方式授權。",
        "tshirt_size_text": "XS",
        "meal_preference_text": "全素",
        "external_link": "http://127.0.0.1:8000/speaker/form/b2b29fb5-7187-494b-9085-8ac8e0338747",
        "editable": true,
        "readonly": false
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
          "current_page": 1,
          "data": [
            {
              "id": 10,
              "name": "扈惠雅",
              "name_e": "Dr. Buster Schuster Jr.",
              "company": "巨室酒店",
              "company_e": "Schinner PLC",
              "job_title": "fuga",
              "job_title_e": "Civil Engineering Technician",
              "bio": "Velit ab et eius et ipsa ex. Consequatur est reprehenderit eum qui. Ut corporis deserunt assumenda alias repudiandae.",
              "bio_e": "Dicta ex quaerat magni debitis dicta sed vel. Tempora deleniti hic inventore. Fuga animi asperiores ea eos dolor quo distinctio. Expedita rerum quisquam accusantium perferendis nam saepe repudiandae. Harum fugiat quae eaque.",
              "photo": "https://picsum.photos/500",
              "link_fb": "http://osinski.com/molestiae-deserunt-nemo-ea-dolores-explicabo-nisi",
              "link_github": "http://www.ohara.com/et-quibusdam-rem-libero-sit-amet",
              "link_twitter": "http://heaney.com/recusandae-quaerat-vero-quia-ut",
              "link_other": "http://www.beatty.com/dolorem-rerum-totam-porro-optio-consequatur-nemo-voluptatem.html",
              "link_video": "http://durgan.org/ipsum-rerum-quod-quisquam-cumque-error-exercitationem-illum",
              "link_slide": "http://ryan.com/soluta-ab-et-perspiciatis-distinctio.html",
              "topic": "Et aut.",
              "topic_e": "Quos distinctio sint illo.",
              "summary": "Dignissimos sit enim aliquid. Molestiae laborum quo et perspiciatis ad accusantium saepe. Qui ut enim repudiandae ab molestiae.",
              "summary_e": "Ut est et autem qui rerum est. Rerum qui facere ut sit maxime totam at autem. Dolorem est quo quidem qui deserunt vitae sed aliquid. Reprehenderit ratione voluptatem qui tempore sunt corporis sed. Vitae dolores sint nihil autem est qui. Minima necessitatibus ut distinctio. Quibusdam deleniti voluptatem eius quia.",
              "tag": [
                  0,
                  1,
                  2,
                  3,
                  4,
                  5,
                  6,
                  8,
                  9,
                  10,
                  12,
                  13,
                  14,
                  15,
                  16,
                  17
              ],
              "level": 1,
              "license": 1,
              "promotion": 0,
              "tshirt_size": 1,
              "need_parking_space": 0,
              "has_dinner": 0,
              "meal_preference": 2,
              "has_companion": 4,
              "speaker_status": 0,
              "speaker_type": 2,
              "is_keynote": 0,
              "note": "Deleniti sunt ipsam cumque voluptatem eum rem. Qui nihil est qui perspiciatis. Ratione deleniti consequatur reprehenderit eveniet nam ullam ab.",
              "last_edited_by": "",
              "access_key": "6ffbe188-204b-4f9d-a9b9-7191fcb453e9",
              "access_secret": "Ibc4WEPfeqmeQyQSAiDp",
              "year": 1974,
              "created_at": "2020-06-10 22:58:27",
              "updated_at": "2020-06-10 22:58:27",
              "tag_text": [
                  "AI",
                  "AR/VR",
                  "Blockchain",
                  "Cloud",
                  "DevOps",
                  "IoT",
                  "Mobile App",
                  "UI/UX",
                  "Web",
                  "Quant",
                  "Cross-platform",
                  "Data Science",
                  "Agile",
                  "Panel",
                  "FinTech",
                  "QA"
              ],
              "level_text": "Normal-歡迎略懂略懂有基本基礎的會眾",
              "license_text": "以 CC BY 3.0 姓名標示方式授權。",
              "tshirt_size_text": "S",
              "meal_preference_text": "奶蛋素",
              "speaker_status_text": "待確認",
              "speaker_type_text": "CFR",
              "external_link": "http://127.0.0.1:8000/speaker/form/6ffbe188-204b-4f9d-a9b9-7191fcb453e9",
              "editable": true,
              "readonly": false
            },
            {
              "id": 9,
              "name": "蓬穎伶",
              "name_e": "Alessia Bauch",
              "company": "茂為工業",
              "company_e": "Casper-Kessler",
              "job_title": "sit",
              "job_title_e": "Tax Preparer",
              "bio": "Officia qui ut et nemo perspiciatis. Asperiores consequatur et explicabo. Porro voluptatem aut repudiandae.",
              "bio_e": "Ipsum ea veritatis adipisci doloribus quos facere. Eos sint nihil consequatur et perferendis. Omnis labore corporis quia inventore. Dolorem quis reprehenderit quo occaecati velit perspiciatis sunt at.",
              "photo": "https://picsum.photos/500",
              "link_fb": "http://www.strosin.com/voluptas-qui-voluptatem-veniam-nesciunt-beatae-totam-quae",
              "link_github": "http://cartwright.com/",
              "link_twitter": "http://www.kris.com/illo-sed-dolores-porro-et-iste-atque.html",
              "link_other": "http://jast.net/dolorum-nihil-omnis-alias-beatae.html",
              "link_video": "http://keeling.com/",
              "link_slide": "http://www.heaney.net/nihil-doloribus-facilis-sit-ab-dolores-veniam",
              "topic": "Doloribus.",
              "topic_e": "Error non dolores voluptate.",
              "summary": "Nesciunt et qui dolores. Amet maiores dolore repellat commodi quis. Eos cumque tempore quis praesentium est laborum quidem. Earum nobis dolores facere dicta rerum quisquam.",
              "summary_e": "Qui est placeat et nihil blanditiis. Est iste et quia a minima nobis. Explicabo deleniti et adipisci explicabo aut sit et. Est et magnam iste quia molestiae. Et iusto non beatae voluptatibus asperiores voluptas. In error quod modi velit iste veritatis dolorum veniam. Est officiis doloribus praesentium delectus. Commodi rerum praesentium sed nulla ad quasi. Distinctio itaque unde rerum illo aspernatur veritatis.",
              "tag": [
                  1,
                  2,
                  5,
                  6,
                  8,
                  9,
                  10,
                  11,
                  12,
                  13,
                  17
              ],
              "level": 0,
              "license": 3,
              "promotion": 1,
              "tshirt_size": 4,
              "need_parking_space": 1,
              "has_dinner": 1,
              "meal_preference": 0,
              "has_companion": 0,
              "speaker_status": 0,
              "speaker_type": 0,
              "is_keynote": 0,
              "note": "Voluptatibus quisquam excepturi quaerat magni voluptas ut. Numquam aut in ipsa totam vel beatae. Repellendus et atque minus cumque.",
              "last_edited_by": "",
              "access_key": "d5a953fa-86d1-4f4a-aeda-9a94c15c4b1d",
              "access_secret": "AHvI7ERciVbVBVFM21Zc",
              "year": 1984,
              "created_at": "2020-06-10 22:58:27",
              "updated_at": "2020-06-10 22:58:27",
              "tag_text": [
                  "AR/VR",
                  "Blockchain",
                  "IoT",
                  "Mobile App",
                  "UI/UX",
                  "Web",
                  "Quant",
                  "Security",
                  "Cross-platform",
                  "Data Science",
                  "QA"
              ],
              "level_text": "Basic-外行人可以藉此入門",
              "license_text": "以 CC BY-NC 3.0 姓名標示-非商業性方式授權。",
              "tshirt_size_text": "XL",
              "meal_preference_text": "葷",
              "speaker_status_text": "待確認",
              "speaker_type_text": "贊助商",
              "external_link": "http://127.0.0.1:8000/speaker/form/d5a953fa-86d1-4f4a-aeda-9a94c15c4b1d",
              "editable": true,
              "readonly": false
            },
            {...},
          ],
              "first_page_url": "http://127.0.0.1:8000/api/speaker?page=1",
              "from": 1,
              "last_page": 1,
              "last_page_url": "http://127.0.0.1:8000/api/speaker?page=1",
              "next_page_url": null,
              "path": "http://127.0.0.1:8000/api/speaker",
              "per_page": 15,
              "prev_page_url": null,
              "to": 10,
              "total": 10
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
      {
          "success": true,
          "message": "Store success.",
          "data": {
              "name": "家佳123",
              "last_edited_by": "admin",
              "speaker_status": 0,
              "access_key": "51f99b80-d993-4a4a-bb9e-f9420326f021",
              "access_secret": "0iHrRu3Dzj5rq3teF8mk",
              "year": 2020,
              "updated_at": "2020-06-28 22:55:40",
              "created_at": "2020-06-28 22:55:40",
              "id": 11,
              "tag_text": [],
              "level_text": "",
              "license_text": "",
              "tshirt_size_text": "",
              "meal_preference_text": "",
              "speaker_status_text": "待確認",
              "speaker_type_text": "",
              "external_link": "http://127.0.0.1:8000/speaker/form/51f99b80-d993-4a4a-bb9e-f9420326f021",
              "editable": true,
              "readonly": false
          }
      }
    }
    ```

## 取得講師資料

+ **URL :**

    **`/api/speaker/{id}`**

+ **Method :**

    **`GET`**

+ **Response**
    + **data-type:** application/json

    + **data**
    ```json
      {
          "success": true,
          "message": "Show success.",
          "data": {
              "id": 1,
              "name": "席萍",
              "name_e": "Dr. Jaylon O'Keefe IV",
              "company": "松崗電腦公司",
              "company_e": "Rau-Koss",
              "job_title": "consectetur",
              "job_title_e": "Psychiatric Aide",
              "bio": "Aliquam voluptatem rerum tenetur inventore. Molestiae et quis occaecati quibusdam.",
              "bio_e": "Dolore iusto ullam ut illum. Sunt omnis cum sit sed ullam adipisci rerum ullam. Voluptate minima quas at ea. Eum accusamus et eum aut delectus magni et voluptatum. Officia quia nobis explicabo cumque atque omnis voluptatum vel.",
              "photo": "https://picsum.photos/500",
              "link_fb": "http://www.kihn.com/enim-occaecati-id-sunt-ratione-molestiae-dolores-explicabo",
              "link_github": "http://www.schultz.com/enim-esse-est-et-facere-sequi-consequatur-quod",
              "link_twitter": "http://schiller.info/deserunt-sunt-eos-minus-quia-quod-ut",
              "link_other": "http://www.gibson.com/esse-ad-iure-sed-fuga-veniam.html",
              "link_video": "http://www.witting.org/voluptatem-et-ratione-est-voluptatibus-qui-aliquam-ut",
              "link_slide": "http://turcotte.info/neque-ut-sit-ipsum-labore-placeat-debitis-asperiores-est",
              "topic": "Aut est rem et.",
              "topic_e": "Totam est aliquid qui non non.",
              "summary": "Dolores hic ducimus repellendus. Laborum facilis a beatae ab soluta non. Voluptas molestias minus et corporis praesentium. Quibusdam qui nihil fugit.",
              "summary_e": "Eligendi ab nemo qui sed nesciunt ut. Ipsam occaecati molestiae omnis laudantium. Quo quo sunt atque facere porro voluptatibus. Nostrum et vitae id vitae. Voluptas asperiores minus et consequuntur et aperiam. In at possimus eum nostrum quidem quia vel. Dolorem qui consequatur est temporibus.",
              "tag": [
                  1,
                  3,
                  4,
                  5,
                  6,
                  7,
                  8,
                  9,
                  10,
                  11,
                  13,
                  14,
                  16
              ],
              "level": 1,
              "license": 3,
              "promotion": 0,
              "tshirt_size": 3,
              "need_parking_space": 0,
              "has_dinner": 0,
              "meal_preference": 0,
              "has_companion": 5,
              "speaker_status": 0,
              "speaker_type": 3,
              "is_keynote": 1,
              "note": "Molestiae quaerat ad quod quia voluptatibus animi. Ad aspernatur deserunt qui. Sed quaerat consequatur id sit.",
              "last_edited_by": "",
              "access_key": "4553f671-347f-4270-ae1e-74317c7d0b7f",
              "access_secret": "CdFdh3ePqzURQ5P2uUOW",
              "year": 2007,
              "created_at": "2020-06-10 22:58:27",
              "updated_at": "2020-06-10 22:58:27",
              "tag_text": [
                  "AR/VR",
                  "Cloud",
                  "DevOps",
                  "IoT",
                  "Mobile App",
                  "Startup",
                  "UI/UX",
                  "Web",
                  "Quant",
                  "Security",
                  "Data Science",
                  "Agile",
                  "FinTech"
              ],
              "level_text": "Normal-歡迎略懂略懂有基本基礎的會眾",
              "license_text": "以 CC BY-NC 3.0 姓名標示-非商業性方式授權。",
              "tshirt_size_text": "L",
              "meal_preference_text": "葷",
              "speaker_status_text": "待確認",
              "speaker_type_text": "內推",
              "external_link": "http://127.0.0.1:8000/speaker/form/4553f671-347f-4270-ae1e-74317c7d0b7f",
              "editable": true,
              "readonly": false
          }
      }
    ```

## 後台更新講師資料

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
        + access_secret [string] Password

+ **Response**
    + **data-type:** application/json

    + **data**
    ```json
    {
      "success": true,
      "message": "Success.",
      "data": {
            "id": 2,
            "name": "上官詩123",
            "name_e": "Dr. Lenore Leannon IV",
            "company": "大宇有限公司",
            "company_e": "Hagenes, Beier and Hirthe",
            "job_title": "ipsum",
            "job_title_e": "Self-Enrichment Education Teacher",
            "bio": "Voluptas quia ut ipsam molestiae explicabo et consequuntur vero. Vitae sit iusto laudantium repellat vitae occaecati.",
            "bio_e": "Cum id suscipit et nemo. Labore aliquam aut qui. Suscipit dolore hic quisquam sed ut ab inventore tempora. Explicabo autem consequatur eum qui corrupti aperiam.",
            "photo": "https://picsum.photos/500",
            "link_fb": "https://www.gutkowski.info/fugit-recusandae-omnis-quod-et-recusandae-corrupti-excepturi-et",
            "link_github": "http://strosin.biz/necessitatibus-incidunt-itaque-sint-molestiae-a-quae-et",
            "link_twitter": "http://www.crona.com/quo-consequatur-nihil-blanditiis-fugiat-dolorum-totam",
            "link_other": "http://schumm.com/saepe-expedita-quidem-blanditiis-et-voluptatum-sed.html",
            "link_video": "http://kiehn.com/fuga-eos-voluptatibus-et-eveniet-ut-est.html",
            "link_slide": "https://jakubowski.biz/officiis-minus-sint-ea-maxime-blanditiis-iste.html",
            "topic": "Reprehenderit.",
            "topic_e": "Ut est nemo voluptatem cum.",
            "summary": "Culpa similique earum aliquid accusantium. Quo qui esse quibusdam modi laboriosam quibusdam. Iure praesentium explicabo et ad perferendis tempore. Facilis aut eum perspiciatis dolorem doloribus tempora pariatur ab.",
            "summary_e": "Cumque voluptatem inventore sed sit. Pariatur assumenda eaque mollitia similique hic aliquid. Voluptatem quibusdam qui quis odit itaque deleniti voluptatem. Reprehenderit repellat dicta laboriosam vel non architecto voluptas. Voluptatem voluptatem et omnis illum maxime tenetur aut. Deserunt ullam ut rem laudantium cupiditate earum consectetur. Qui dolores eveniet possimus autem suscipit autem deserunt sapiente.",
            "tag": [
                5,
                6,
                9,
                11,
                12,
                15
            ],
            "level": 2,
            "license": 1,
            "promotion": 0,
            "tshirt_size": 0,
            "need_parking_space": 1,
            "has_dinner": 1,
            "meal_preference": 1,
            "has_companion": 4,
            "speaker_status": 0,
            "speaker_type": 3,
            "is_keynote": 1,
            "note": "Consectetur quia repellat et quia. Facere sunt voluptates iure consequatur sed. Et iusto sapiente fugiat blanditiis. Ipsa enim vel blanditiis in quaerat incidunt cupiditate.",
            "last_edited_by": "admin",
            "access_key": "b2b29fb5-7187-494b-9085-8ac8e0338747",
            "access_secret": "Q3p0O33FgNHWDsRhg6eD",
            "year": "2017",
            "created_at": "2020-06-10 22:58:27",
            "updated_at": "2020-06-29 21:03:10",
            "tag_text": [
                "IoT",
                "Mobile App",
                "Web",
                "Security",
                "Cross-platform",
                "Panel"
            ],
            "level_text": "Expert-建議在該領域中有研究經驗的人入場",
            "license_text": "以 CC BY 3.0 姓名標示方式授權。",
            "tshirt_size_text": "XS",
            "meal_preference_text": "全素",
            "speaker_status_text": "待確認",
            "speaker_type_text": "內推",
            "external_link": "http://127.0.0.1:8000/speaker/form/b2b29fb5-7187-494b-9085-8ac8e0338747",
            "editable": true,
            "readonly": false
        }
    }
    ```

## 刪除講師

+ **URL :**

    **`/api/speaker/{id}`**

+ **Method :**

    **`DELETE`**

+ **Response**
    + **data-type:** application/json

    + **data**
    ```json
    {
        "success": true,
        "message": "destroy success.",
        "data": []
    }
    ```

## 匯出講者資料

+ **URL :**

    **`speaker/export`**

+ **Method :**

    **`GET`**

+ **Parameters**

  + **ids :** '2,3' [string]

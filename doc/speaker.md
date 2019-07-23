# [前台] 取得講師資料

------

前台頁面獲取該名講師所有資料

- URL

  /speaker/:accessKey

- Method

  `POST`

- URL Params

  **Required:**

  - accessKey=[string]

- Data Params

  **Required:**

  - password=[string]

- Success Response

  - Code: 200
  - Content:

  ```json
  {
    "success": true,
    "message": "Success.",
    "data": {
      "name": "家佳",
      "name_e": "Hilbert Boyle",
      "company": "大國集團公司",
      "job_title": "incidunt",
      "bio": "Ullam alias magni fugiat at. Error earum aut aperiam cupiditate. Atque suscipit voluptas aut sed ullam architecto.",
      "bio_e": "Aliquam voluptatem iste tenetur nesciunt. Maiores consequatur labore minus voluptatum odio inventore magni. Vero suscipit debitis commodi fugit non.",
      "photo": "https://picsum.photos/200",
      "link_fb": "https://www.funk.com/sit-voluptas-cumque-reiciendis-est",
      "link_github": "https://www.schoen.com/id-sunt-ut-quod-modi-voluptas-commodi-maxime",
      "link_twitter": "http://oconnell.info/ut-et-iste-necessitatibus-reprehenderit",
      "link_other": "http://www.sporer.com/quis-eveniet-incidunt-quibusdam-illo-commodi-et-eaque",
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

- Error Response

  使用錯誤的 protocol

  - Code: 400
  - Content:

  ```json
  {
  	"success": false,
  	"message": "Bad request",
  	"data": []
  }
  ```

  輸入密碼錯誤

  - Code: 400
  - Content:

  ```json
  {
  	"success": false,
  	"message": "Bad request",
  	"data": []
  }
  ```

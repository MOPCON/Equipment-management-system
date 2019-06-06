<template>
  <div>
    <form class="pt-3 col-12 col-md-8"
      @submit.prevent="handleSubmit">
      <h1>
        講者表單
        <small>Speaker form</small>
      </h1>

      <!-- 個人資料區塊 Start -->
      <div class="profile">
        <h2 class="profile__title">個人資料</h2>
        <hr>
        <div class="form-group form-row">
          <div class="col-12 col-md-6">
            <label>姓名 *</label>
            <input type="text" class="form-control"
              name="username" v-model="formData.username"
              v-validate="'required'" :class="{'is-invalid': errors.has('username')}"
              placeholder="姓名">
            <p v-show="errors.has('username')"
              class="text-danger">{{errors.first('username')
              | errorTextFormat}}</p>
          </div>
          <div class="col-12 col-md-6 mt-3 mt-md-0">
            <label>英文名稱 *</label>
            <input type="text" class="form-control"
              v-model="formData.usernameEn"
              placeholder="英文名稱">
          </div>
        </div>

        <div class="form-group form-row">
          <div class="col-12 col-md-6">
            <label>公司 / 組織</label>
            <input type="text" class="form-control"
              v-model="formData.company"
              placeholder="公司 / 組織">
          </div>
          <div class="col-12 col-md-6 mt-3 mt-md-0">
            <label>職稱 *</label>
            <input type="text" class="form-control"
              name="title" v-model="formData.title"
              v-validate="'required'" :class="{'is-invalid': errors.has('title')}"
              placeholder="職稱">
            <p v-show="errors.has('title')" class="text-danger">{{errors.first('title')|
              errorTextFormat}}</p>
          </div>
        </div>

        <div class="form-group">
          <label>個人介紹 *</label>
          <textarea class="form-control" id="desc"
            name="desc" placeholder="個人介紹" rows="3"
            v-validate="'required'" :class="{'is-invalid': errors.has('desc')}"></textarea>
          <p v-show="errors.has('desc')" class="text-danger">{{errors.first('desc')
            | errorTextFormat}}</p>
        </div>

        <div class="form-group">
          <label>個人介紹 ( 英文 )</label>
          <textarea class="form-control" id="descEn"
            placeholder="個人介紹 ( 英文 )" rows="3"></textarea>
        </div>

        <div class="avatar mb-3">
          <div class="form-group">
            <label for="avatar">講者照片 *</label>
            <input type="file" class="form-control-file"
              @change="handleFileChange" id="avatar"
              name="image_avatar" v-validate
              data-vv-rules="image|required"
              :class="{'is-invalid': errors.has('image_avatar')}">
            <p v-show="errors.has('image_avatar')"
              class="text-danger">{{errors.first('image_avatar')
              | errorTextFormat}}</p>
            <p v-show="!avatarSizevalidate" class="text-danger">照片尺寸必須大於寬
              500px,
              高 500px</p>
            <div class="avatar__img" :style="`background-image: url('${avatar}')`"></div>
          </div>
        </div>
        <label for="avatar">相關連結</label>
        <div class="form-group form-group--inline-icon">
          <i class="fab fa-facebook-square"></i>
          <input type="text" class="form-control"
            v-model="formData.fbLink" placeholder="Facebook url">
        </div>
        <div class="form-group form-group--inline-icon">
          <i class="fab fa-github"></i>
          <input type="text" class="form-control"
            v-model="formData.githubLink"
            placeholder="GitHub url">
        </div>
        <div class="form-group form-group--inline-icon">
          <i class="fab fa-twitter"></i>
          <input type="text" class="form-control"
            v-model="formData.twitterLink"
            placeholder="Twitter url">
        </div>
        <div class="form-group form-group--inline-icon">
          <i class="fas fa-globe"></i>
          <input type="text" class="form-control"
            v-model="formData.otherLink"
            placeholder="其他(如Website/Blog) url">
        </div>
      </div>
      <!-- 個人資料區塊 End -->

      <!-- 議程資料區塊 Start -->
      <div class="classinfo">
        <h2 class="classinfo__title">議程資料</h2>

        <div class="form-group form-group--length">
          <label>演講主題 *</label>
          <span class="text-length" :class="{'text-danger': errors.has('classTitle')}">{{classTitle.currentLength}}
            / {{classTitle.minLength}}</span>
          <textarea class="form-control" id="classTitle"
            name="classTitle" v-model="formData.classTitle"
            placeholder="演講主題" rows="2" @input="updateTextLength($event, 'classTitle')"
            v-validate="'required|max:32'" :class="{'is-invalid': errors.has('classTitle')}"></textarea>
          <p v-show="errors.has('classTitle')"
            class="text-danger">{{errors.first('classTitle')
            | errorTextFormat}}</p>

        </div>

        <div class="form-group form-group--length">
          <label>演講主題 英文 ( 若無提供，將由我們工作人員協助翻譯 )</label>
          <span class="text-length" :class="{'text-danger': errors.has('classTitleEn')}">{{classTitleEn.currentLength}}
            / {{classTitleEn.minLength}}</span>
          <textarea class="form-control" id="classTitleEn"
            name="classTitleEn" v-model="formData.classTitleEn"
            placeholder="演講主題 英文" rows="2" @input="updateTextLength($event, 'classTitleEn')"
            v-validate="'max:64'" :class="{'is-invalid': errors.has('classTitleEn')}"></textarea>
          <p v-show="errors.has('classTitleEn')"
            class="text-danger">{{errors.first('classTitleEn')
            | errorTextFormat}}</p>
        </div>

        <div class="form-group form-group--length">
          <label>演講摘要 *</label>
          <span class="text-length" :class="{'text-danger': errors.has('classDesc')}">{{classDesc.currentLength}}
            / {{classDesc.minLength}}</span>
          <textarea class="form-control" id="classDesc"
            name="classDesc" v-model="formData.classDesc"
            placeholder="演講摘要" rows="3" @input="updateTextLength($event, 'classDesc')"
            v-validate="'required|max:240'"></textarea>
          <p v-show="errors.has('classDesc')"
            class="text-danger">{{errors.first('classDesc')
            | errorTextFormat}}</p>
        </div>

        <div class="form-group form-group--length">
          <label>演講摘要 英文 ( 若無提供，將由我們工作人員協助翻譯 )</label>
          <span class="text-length" :class="{'text-danger': errors.has('classDescEn')}">{{classDescEn.currentLength}}
            / {{classDescEn.minLength}}</span>
          <textarea class="form-control" id="classDescEn"
            name="classDescEn" v-model="formData.classDescEn"
            placeholder="演講摘要 英文" rows="3" @input="updateTextLength($event, 'classDescEn')"
            v-validate="'max:480'"></textarea>
          <p v-show="errors.has('classDescEn')"
            class="text-danger">{{errors.first('classDescEn')
            | errorTextFormat}}</p>
        </div>

        <!-- 標籤 - 複選 -->
        <div class="form-group-check">
          <p class="form-group-check__title">標籤</p>
          <div class="form-check form-check-inline"
            v-for="item in tags" :key="item.id">
            <input class="form-check-input" type="checkbox"
              @click="handleTagsClick(item)" :id="item.value"
              :value="item.value">
            <label class="form-check-label" :for="item.value">{{item.value}}</label>
          </div>
          <div class="form-group-check__text">若無適用的標籤，請告知我們工作人員。</div>
        </div>

        <!-- 難易度-單選 -->
        <div class="form-group-radio mt-4">
          <p class="form-group-radio__title">難易度</p>
          <div class="form-check" v-for="level in levels"
            :key="level.id">
            <input class="form-check-input" type="radio"
              :id="level.value" v-model="formData.level"
              :value="level">
            <label class="
              form-check-label"
              :for="level.value">
              {{level.value}} - {{level.desc}}
            </label>
          </div>
        </div>

        <!-- 授權方式 - 單選 -->
        <div class="form-group-radio mt-4">
          <p class="form-group-radio__title">授權方式</p>
          <div class="form-check" v-for="license in licenses"
            :key="license.id">
            <input class="form-check-input" type="radio"
              :id="license.value" v-model="formData.license"
              :value="license">
            <label class=" form-check-label" :for="license.value">{{license.value}}</label>
          </div>
        </div>

        <!-- 是否同意公開宣傳 - 單選 -->
        <div class="form-group-radio mt-4">
          <p class="form-group-radio__title">是否同意公開宣傳</p>
          <div class="form-check">
            <input class="form-check-input" type="radio"
              id="propagateTrue" v-model="formData.propagate"
              :value="true" checked>
            <label class=" form-check-label" for="propagateTrue">是</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio"
              id="propagateFalse" v-model="formData.propagate"
              :value="false">
            <label class=" form-check-label" for="propagateFalse">否</label>
          </div>
        </div>
      </div>
      <!-- 議程資料區塊 End -->

      <!-- 行政資訊 Start -->
      <div class="otherinfo">
        <h2 class="classinfo__title">行政資訊</h2>

        <!-- T-shirt 尺寸 - 單選 -->
        <div class="form-group-radio mt-4 form-group-radio--inline">
          <p class="form-group-radio__title">T-shirt
            尺寸</p>
          <div class="form-check" v-for="size in clothSize"
            :key="size.id">
            <input class="form-check-input" type="radio"
              :id="size.value" v-model="formData.clothSize"
              :value="size">
            <label class="form-check-label" :for="size.value">{{size.value}}</label>
          </div>
        </div>

        <!-- 是否需要停車磁扣 - 單選 -->
        <div class="form-group-radio mt-4 form-group-radio--inline">
          <p class="form-group-radio__title">您是否需有停車需求？</p>
          <div class="form-check">
            <input class="form-check-input" type="radio"
              id="parkingCardTrue" v-model="formData.parkingCard"
              :value="true" checked>
            <label class=" form-check-label" for="parkingCardTrue">是</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio"
              id="parkingCardFalse" v-model="formData.parkingCard"
              :value="false">
            <label class=" form-check-label" for="parkingCardFalse">否</label>
          </div>
        </div>

        <!-- 講者晚宴 - 單選 -->
        <div class="form-group-radio mt-4 form-group-radio--inline">
          <p class="form-group-radio__title">敬邀參加講者晚宴</p>
          <div class="form-check">
            <input class="form-check-input" type="radio"
              id="speakerMealTrue" v-model="formData.speakerMeal"
              :value="true" checked>
            <label class=" form-check-label" for="speakerMealTrue">是</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio"
              id="speakerMealFalse" v-model="formData.speakerMeal"
              :value="false">
            <label class=" form-check-label" for="speakerMealFalse">否</label>
          </div>
        </div>

        <!-- 葷素食偏好 - 單選 -->
        <div class="form-group-radio mt-4 form-group-radio--inline">
          <p class="form-group-radio__title">葷素食偏好</p>
          <div class="form-check" v-for="mealType in mealTypes"
            :key="mealType.id">
            <input class="form-check-input" type="radio"
              :id="mealType.value" v-model="formData.mealType"
              :value="mealType">
            <label class="form-check-label" :for="mealType.value">{{mealType.value}}</label>
          </div>
        </div>

        <!-- 講者晚宴 - 單選 -->
        <div class="form-group-radio mt-4 mb-4">
          <p class="form-group-radio__title">晚宴攜伴人數</p>
          <div class="form-check">
            <input class="form-check-input" type="radio"
              id="mealPeopleFalse" @click="handleMealPeople($event, 'radio')"
              :value="false" ref="mealPeopleRadio"
              :checked="formData.mealPeople === false">
            <label class=" form-check-label" for="mealPeopleFalse">無</label>
          </div>
          <input type="number" class="form-control"
            @input="handleMealPeople($event, 'input')"
            placeholder="幾人" ref="mealPeopleInput">
        </div>

      </div>
      <!-- 行政資訊 End -->
      <div class="form-group">
        <vue-recaptcha :sitekey="reCaptchaKey" @verify="verifyRecaptchaSuccess"></vue-recaptcha>
      </div>

      <div class="form-group">
        <div class="col-sm-12 pl-0 pr-0">
          <button type="submit" :disabled="!reCaptchaStatus" class="btn btn-primary btn-block">送出</button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
 import VueRecaptcha from 'vue-recaptcha';

export default {
  name: "app-form",
  components: {
    VueRecaptcha
  },
  data() {
    return {
      reCaptchaStatus: false,
      reCaptchaKey: '6LfGbKYUAAAAAMDM_ULu4wuvylMQupaqDW93sZkT',
      formData: {
        username: "",
        usernameEn: "",
        company: "",
        title: "",
        desc: "",
        descEn: "",
        fbLink: "",
        githubLink: "",
        twitterLink: "",
        otherLink: "",
        classTitle: "",
        classTitleEn: "",
        classDesc: "",
        classDescEn: "",
        tags: [],
        level: null,
        license: null,
        propagate: true,
        clothSize: "",
        parkingCard: true,
        speakerMeal: true,
        mealType: "",
        mealPeople: false
      },
      classTitle: {
        currentLength: 0,
        minLength: 32
      },
      classTitleEn: {
        currentLength: 0,
        minLength: 64
      },
      classDesc: {
        currentLength: 0,
        minLength: 240
      },
      classDescEn: {
        currentLength: 0,
        minLength: 480
      },
      tags: [
        {
          id: 0,
          value: "AI"
        },
        {
          id: 1,
          value: "AR/VR"
        },
        {
          id: 2,
          value: "Blockchain"
        },
        {
          id: 3,
          value: "Cloud"
        },
        {
          id: 4,
          value: "DevOps"
        },
        {
          id: 5,
          value: "IoT"
        },
        {
          id: 6,
          value: "Mobile App"
        },
        {
          id: 7,
          value: "Startup"
        },
        {
          id: 8,
          value: "UI/UX"
        },
        {
          id: 9,
          value: "Web"
        },
        {
          id: 10,
          value: "Quant"
        },
        {
          id: 11,
          value: "Security"
        },
        {
          id: 12,
          value: "Cross-platform"
        },
        {
          id: 13,
          value: "Data Science"
        },
        {
          id: 14,
          value: "Agile"
        }
      ],
      levels: [
        {
          id: 0,
          value: "Basic",
          desc: "外行人可以藉此入門"
        },
        {
          id: 1,
          value: "Normal",
          desc: "歡迎略懂略懂有基本基礎的會眾"
        },
        {
          id: 2,
          value: "Expert",
          desc: "建議在該領域中有研究經驗的人入場"
        }
      ],
      licenses: [
        {
          id: 0,
          value: "授予 MOPCON 演講時錄影，後製與上傳至公開線上影音平台之權利。"
        },
        {
          id: 1,
          value: "以 CC BY 3.0 姓名標示方式授權。"
        },
        {
          id: 2,
          value: "以 CC BY-SA 3.0 姓名標示 - 相同方式授權。"
        },
        {
          id: 3,
          value: "以 CC BY-NC 3.0 姓名標示 - 非商業性方式授權。"
        },
        {
          id: 4,
          value: "謝絕所有錄音錄影，但接受 MOPCON 工作人員文字紀錄。"
        }
      ],
      clothSize: [
        {
          id: 0,
          value: "XS"
        },
        {
          id: 1,
          value: "S"
        },
        {
          id: 2,
          value: "M"
        },
        {
          id: 3,
          value: "L"
        },
        {
          id: 4,
          value: "XL"
        },
        {
          id: 5,
          value: "2L"
        }
      ],
      mealTypes: [
        {
          id: 0,
          value: "葷"
        },
        {
          id: 1,
          value: "全素"
        },
        {
          id: 2,
          value: "奶蛋素"
        }
      ],
      file: null,
      avatar: "",
      avatarSizevalidate: true
    };
  },
  mounted() {
    this.levelSelectInit();
    this.licenseSelectInit();
    this.clothSizeSelectInit();
    this.mealTypeSelectInit();
  },

  methods: {
    verifyRecaptchaSuccess(e) {
      if (e) {
        this.reCaptchaStatus = true
      }
    },
    handleTagsClick(tag) {
      // 檢查是否已經在 tags 內, 有就刪除, 否則 push
      const tags = [...this.formData.tags];
      const index = tags.findIndex(item => item.id === tag.id);
      if (index === -1) {
        this.formData.tags.push(tag);
      } else {
        this.formData.tags.splice(index, 1);
      }
    },
    handleMealPeople(el, type) {
      if (type === "radio") {
        this.formData.mealPeople = false;
        this.$refs.mealPeopleInput.value = "";
      } else {
        this.$refs.mealPeopleRadio.checked = false;
        this.formData.mealPeople = el.target.value;
      }
    },
    handleSubmit() {
      this.$validator.validateAll().then(res => {

        if (res && this.avatarSizevalidate) {
          if (!this.reCaptchaStatus) return
          const form = new FormData();
          form.append("userFile", this.file);
          form.append("userData", this.formData);
          // todo ... api post
          console.log("通過,發送 api");
          console.log("form.userFile", form.get("userFile"));
          console.log("this.formData", this.formData);
        } else {
          console.log("欄位未填寫正確");
        }
      });
    },
    // 處理上傳圖片
    handleFileChange(e) {
      const file = e.target.files[0];
      if (file) {
        this.file = file;
        // 使用瀏覽器 FileReader API 來解析圖片
        const reader = new FileReader();
        // 監聽讀取完成load事件, 完成讀取後執行 API 方法
        reader.addEventListener("load", () => {
          this.avatar = reader.result;
          this.validateImageSize(this.avatar);
        });
        // 將圖片丟給FileReader讀取
        reader.readAsDataURL(this.file);
      }
    },
    // 驗證照片寬高是否大於 500px
    validateImageSize(imageSource) {
      const img = new Image();
      img.onload = () => {
        if (img.width < 500 || img.height < 500) {
          this.avatarSizevalidate = false;
        } else {
          this.avatarSizevalidate = true;
        }
      };
      img.src = imageSource;
      this.avatarSizevalidate = status;
    },
    levelSelectInit() {
      if (this.levels.length > 0) {
        this.formData.level = this.levels[0];
      }
    },
    licenseSelectInit() {
      if (this.licenses.length > 0) {
        this.formData.license = this.licenses[0];
      }
    },
    clothSizeSelectInit() {
      if (this.clothSize.length > 0) {
        this.formData.clothSize = this.clothSize[0];
      }
    },
    mealTypeSelectInit() {
      if (this.mealTypes.length > 0) {
        this.formData.mealType = this.mealTypes[0];
      }
    },
    updateTextLength(e, target) {
      this[target].currentLength = e.target.value.length;
    }
  }
};
</script>

<style lang="scss" src="./style.scss" scoped></style>
<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <h2 class="d-inline-block my-3">贊助商表單</h2>
        <h4 class="d-inline-block mx-2">Sponsor form</h4>
        <form class="needs-validation my-4" novalidate>
          <h4 class="text-primary mt-2">公開宣傳資料</h4>
          <hr>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="companyName">公司名稱*</label>
              <input type="text" class="form-control" id="companyName" placeholder="公司名稱" required>
              <div class="invalid-feedback">
                公司名稱為必填
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <label for="companyEnglishName">公司英文名稱*</label>
              <input type="text" class="form-control" id="companyEnglishName" placeholder="公司英文名稱" required>
              <div class="invalid-feedback">
                公司英文名稱為必填
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="companyUrl">公司網址*</label>
            <input type="url" class="form-control" id="companyUrl" placeholder="公司網址" required>
            <div class="invalid-feedback">
              公司網址為必填
            </div>
          </div>
          <div class="form-group">
            <label for="socialMedia">社群媒體（如：FB）</label>
            <input type="url" class="form-control" id="socialMedia" placeholder="FaceBook Url">
          </div>
          <div class="form-group">
            <div class="d-flex justify-content-between flex-column flex-md-row">
              <label for="serviceInfo">產品及服務介紹 (主要商品、服務、核心能力、技術)*</label>
              <span class="d-inline-block text-right"> {{introTextConunt}} / 250</span>
            </div>
            <textarea class="form-control" id="serviceInfo" rows="4" v-on:keyup="countdown(250, 'intro')"
              v-model="introText" maxlength="250" required></textarea>
            <div class="invalid-feedback">
              產品及服務介紹為必填
            </div>
          </div>
          <div class="form-group">
            <label for="companyLogo">公司 LOGO ( ai 向量圖檔佳)*</label>
            <input type="file" class="form-control-file" id="companyLogo"
              @change="imagePreview('companyLogo', 'companyLogoPreview')" required>
            <div id="companyLogoPreview" class="soponseImgReview"></div>
            <div class="invalid-feedback">請上傳公司 LOGO</div>
          </div>
          <div class="form-group">
            <label for="serviceImage">產品或服務照片*</label>
            <input type="file" class="form-control-file" id="serviceImage"
              @change="imagePreview('serviceImage', 'serviceImagePreview')" required>
            <div id="serviceImagePreview" class="soponseImgReview"></div>
            <div class="invalid-feedback">請上傳產品或服務照片</div>
          </div>
          <div class="form-group">
            <label for="promotionalMaterial">希望 MOPCON 宣傳的內容（ 我們將於 FB 等社群分享 ）</label>
            <textarea class="form-control" id="promotionalMaterial" rows="3"></textarea>
          </div>
          <div class="form-group">
            <label for="imageForPPT">場間投影片 (建議 1920 x 1080px 圖檔)*</label>
            <input type="file" class="form-control-file" id="imageForPPT"
              @change="imagePreview('imageForPPT', 'imageForPPTPreview')" required>
            <div id="imageForPPTPreview" class="soponseImgReview"></div>
            <div class="invalid-feedback">請上傳場間投影片圖片</div>
          </div>
          <div class="form-group">
            <label for="Eboard">電子看板 (建議1920x1080px圖檔)*</label>
            <input type="file" class="form-control-file" id="Eboard"
              @change="imagePreview('Eboard', 'EboardPreview')" required>
            <div id="EboardPreview" class="soponseImgReview"></div>
            <div class="invalid-feedback">請上傳產品或服務照片</div>
          </div>
          <div class="form-group">
            <div class="d-flex justify-content-between flex-column flex-md-row">
              <label for="dinnerPartyIntro">晚宴簡介 (於晚宴中將由主持人介紹貴公司)</label>
              <span class="d-inline-block text-right"> {{dinnerPartyIntroTextConunt}} / 80</span>
            </div>
            <textarea class="form-control" id="dinnerPartyIntro" rows="2" v-on:keyup="countdown(80, 'dinnerPartyIntro')"
              v-model="dinnerPartyIntroText" maxlength="80"></textarea>
          </div>
          <h4 class="text-primary mt-2">收據資料</h4>
          <hr>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="companyFullName">公司 / 組織全銜*</label>
              <input type="text" class="form-control" id="companyFullName" placeholder="公司 / 組織全銜" required>
              <div class="invalid-feedback">
                公司 / 組織全銜為必填
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <label for="taxIDNumber">統一編號*</label>
              <input type="text" class="form-control" id="taxIDNumber" placeholder="統一編號" required>
              <div class="invalid-feedback">
                統一編號為必填
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="sponsePrice">贊助金額*</label>
            <input type="number" class="form-control" id="sponsePrice" placeholder="1,000" required>
            <div class="invalid-feedback">
                贊助金額為必填
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="contactName">聯絡人姓名*</label>
              <input type="text" class="form-control" id="contactName" placeholder="聯絡人姓名" required>
              <div class="invalid-feedback">
                聯絡人姓名為必填
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <label for="contactTitle">聯絡人職稱</label>
              <input type="text" class="form-control" id="contactTitle" placeholder="聯絡人職稱">
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="contactPhoneNumber">聯絡人電話*</label>
              <input type="text" class="form-control" id="contactPhoneNumber" placeholder="聯絡人電話" required>
              <div class="invalid-feedback">
                聯絡人電話為必填
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <label for="contactMail">聯絡人 Email*</label>
              <input type="email" class="form-control" id="contactMail" placeholder="聯絡人 Email" required> 
              <div class="invalid-feedback">
                聯絡人 Email 為必填
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="contactAddress">收件地址*</label>
            <input type="" class="form-control" id="contactAddress" placeholder="請填寫完整收件地址" required>
            <div class="invalid-feedback">
              收件地址為必填
            </div>
          </div>
          <hr>
          <div class="form-group">
            <label for="sponseReason">為什麼本次選擇贊助 MOPCON？( 貴公司希望與 MOPCON 合作，並期待達成的效益與目的 )</label>
            <textarea class="form-control" id="sponseReason" rows="2"></textarea>
          </div>
          <div class="form-group">
            <label for="sponseAims">希望能在本次大會達成的目標 (貴公司希望在 MOPCON 活動中達成的目標。交流、推廣、介紹產品與服務...等等) </label>
            <textarea class="form-control" id="sponseAims" rows="2"></textarea>
          </div>
          <div class="form-group">
            <label for="sponseRemarks">備註 ( 其他想對 MOPCON 說的話或資訊 )</label>
            <textarea class="form-control" id="sponseRemarks"></textarea>
          </div>
          <h4 class="text-primary mt-4">進階贊助商資料 ( 依實際贊助項目選填 ) </h4>
            <div class="card my-2">
              <div class="card-header">
                贊助商類型：Tony Stark
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label for="ICCKAd"> ICCK大門兩側廣告 </label>
                  <input type="file" class="form-control-file" id="ICCKAd"
                    @change="imagePreview('ICCKAd', 'ICCKAdPreview')">
                  <div id="ICCKAdPreview" class="soponseImgReview"></div>
                </div>
                <div class="form-group">
                  <label for="fullPageAd"> 報到處全版廣告空間</label>
                  <input type="file" class="form-control-file" id="fullPageAd"
                    @change="imagePreview('fullPageAd', 'fullPageAdPreview')">
                  <div id="fullPageAdPreview" class="soponseImgReview"></div>
                </div>
              </div>
            </div>
            <div class="card my-2">
              <div class="card-header">
                贊助商類型：Hacker以上
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label for="lectureBanner"> 演講廳旗幟 </label>
                  <input type="file" class="form-control-file" id="lectureBanner"
                    @change="imagePreview('lectureBanner', 'lectureBannerPreview')">
                  <div id="lectureBannerPreview" class="soponseImgReview"></div>
                </div>
                <div class="form-group">
                  <label for="mainBannerAd">主動線旗幟廣告</label>
                  <input type="file" class="form-control-file" id="mainBannerAd"
                    @change="imagePreview('mainBannerAd', 'mainBannerAdPreview')">
                  <div id="mainBannerAdPreview" class="soponseImgReview"></div>
                </div>
              </div>
            </div>
            <div class="card my-2">
              <div class="card-header">
                贊助商類型：Bruce Wayne以上
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label for="keynoteIntroduction">Keynote 引言</label>
                  <textarea class="form-control" id="keynoteIntroduction" rows="4"></textarea>
                </div>
              </div>
            </div>
            <vue-recaptcha :sitekey="reCaptchaKey" @verify="verifyRecaptchaSuccess"></vue-recaptcha>
            <button class="btn btn-primary btn-block my-4" type="submit" :disabled="!reCaptchaStatus">送出</button>
        </form>
      </div>
    </div>
  </div>
</template>


<script>
  import VueRecaptcha from 'vue-recaptcha';
  
  export default {
    components: {
      VueRecaptcha
    },
    data: () => {
      return {
        reCaptchaStatus: false,
        reCaptchaKey: process.env.MIX_RECAPTCHA_KEY,
        introTextConunt: 250,
        introText: '',
        dinnerPartyIntroTextConunt: 80,
        dinnerPartyIntroText: '',
      }
    },
    methods: {
      validationForm() {
        (function () {
          'use strict';
          window.addEventListener('load', function () {
            const vm = this;
            console.log(process.env)
            console.log(vm.reCaptchaKey)
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function (form) {
              form.addEventListener('submit', function (event) {
                if (form.checkValidity() === false) {
                  event.preventDefault();
                  event.stopPropagation();
                  console.log(form.checkValidity())
                } else {
                  console.log('驗證成功可送出表單');
                }
                form.classList.add('was-validated');
              }, false);
            });
          }, false);
        })();
      },
      countdown(num, type) {
        const vm = this;
        if (type == 'intro') {
          vm.introTextConunt = num - vm.introText.length;
        } else if (type == 'dinnerPartyIntro') {
          vm.dinnerPartyIntroTextConunt = num - vm.dinnerPartyIntroText.length;
        }
      },
      imagePreview(inputId, previewId) {
        const file = document.getElementById(inputId);
        const imageArea = document.getElementById(previewId);
        imageArea.innerHTML = '';
        if (file.files && file.files[0]) {
          const reader = new FileReader();
          reader.onload = function (e) {
            let img = document.createElement("img");
            img.src = e.target.result;
            img.className = 'mt-3';
            img.width = 150;
            document.getElementById(previewId).appendChild(img);
            document.getElementById(previewId).addEventListener('mouseover', function(){
              this.children[0].style.transform = "scale(1.5)"
            });
            document.getElementById(previewId).addEventListener('mouseout', function(){
              this.children[0].style.transform = "scale(1)"
            })
          }
          reader.readAsDataURL(file.files[0]);
        }
      },
      verifyRecaptchaSuccess(e) {
        if (e) {
          this.reCaptchaStatus = true
        }
      },
    },
    created() {
      const vm = this;
      vm.validationForm();
    },
  };
</script>
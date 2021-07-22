@php
    $locale = Session::get('locale', 'tw');
    if ($locale === 'tw') {
        $tw = 'active';
        $en = '';
    } else {
        $tw = '';
        $en = 'active';
    }
@endphp
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>講者上傳表單</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css">
    </head>
    <body class="bg-light">
        <nav class="nav justify-content-end nav-pills">
            <li class="nav-item">
                <a class="nav-link {{ $tw }}" href="/lang/tw">中文</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $en }}" href="/lang/en">English</a>
            </li>
        </nav>
        <div id="app">
            <div class="container">
                <div class="alert sticky-top" :class="classColor" role="alert" style="top: 10px;" v-if="alertShow">
                    @{{ message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close" v-on:click="alertShow = false">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @if ($speaker['readonly'])
                <div class="alert alert-primary" role="alert" style="top: 10px;" v-if="!show">
                    您的資料已由Mopcon確認完畢，僅供檢視或上傳投影片連結，若須修改請聯繫議程組工作人員。
                </div>
                @endif
                <div class="row justify-content-center mt-5">
                    <div class="col-md-6" v-if="show">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="text-center">{{ trans('speaker.speaker_upload_form') }}</h3>
                            </div>
                            <div class="card-body">
                                <accesskey-form v-on:accesskey_method="getSponsorForm"></accesskey-form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10" id="sponsorForm" v-if="!show">
                        <h2 class="d-inline-block my-3">{{ trans('speaker.speaker_form') }}</h2>
                        <h4 class="d-inline-block mx-2">{{ trans('speaker.speaker_form_c') }}</h4>
                        <form id="sendform" class="needs-validation" novalidate>
                            <h4 class="text-primary mt-2">
                                {{ trans('speaker.personal_info') }}
                                <span class="h5 text-danger ml-2">{{ trans('speaker.personal_info_public') }}</span>
                            </h4>
                            <hr>
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label for="name">{{ trans('speaker.name') }}*</label>
                                    <input type="text" class="form-control" id="name" v-model="formData.name" required :disabled="formData.readonly">
                                    <div class="invalid-feedback">
                                        {{ trans('speaker.required.name') }}
                                    </div>
                                </div>
                                <!--此欄位隱藏
                                <div class="col-md-6 mb-3" style="display:none">
                                    <label for="name_e">{{ trans('speaker.name_e') }}</label>
                                    <input type="text" class="form-control" id="name_e" placeholder="英文名稱" v-model="formData.name_e" :disabled="formData.readonly">
                                </div>-->
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label for="company">{{ trans('speaker.company') }}</label>
                                    <input type="text" class="form-control" id="company" placeholder="公司 / 組織" v-model="formData.company" :disabled="formData.readonly">
                                </div>
                                <!--此欄位隱藏
                                <div class="col-md-6 mb-3" style="display:none">
                                    <label for="company_e">{{ trans('speaker.company_e') }}</label>
                                    <input type="text" class="form-control" id="company_e" placeholder="英文公司/組織" v-model="formData.company_e" :disabled="formData.readonly">
                                </div>-->
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label for="job_title">{{ trans('speaker.job_title') }}*</label>
                                    <input type="text" class="form-control" id="job_title" placeholder="職稱" v-model="formData.job_title" required :disabled="formData.readonly">
                                    <div class="invalid-feedback">
                                        {{ trans('speaker.required.job_title') }}
                                    </div>
                                </div>
                                <!--此欄位隱藏
                                <div class="col-md-6 mb-3" style="display:none">
                                    <label for="job_title_e">{{ trans('speaker.job_title_e') }}</label>
                                    <input type="text" class="form-control" id="job_title_e" placeholder="英文職稱" v-model="formData.job_title_e" :disabled="formData.readonly">
                                </div>-->
                            </div>
                            <div class="form-group">
                                <div class="d-flex justify-content-between flex-column flex-md-row">
                                    <label for="introduction">{{ trans('speaker.introduction') }}*</label>
                                    <span class="d-inline-block text-right"> @{{ introTextConunt }} / 120</span>
                                </div>
                                <textarea class="form-control" id="introduction" rows="4" v-model="formData.bio" maxlength="120" v-on:keyup="countText(120, 'introTextConunt', formData.bio)" required :disabled="formData.readonly"></textarea>
                                <div class="invalid-feedback">
                                    {{ trans('speaker.required.introduction') }}
                                </div>
                            </div>
                            <!--此欄位隱藏
                            <div class="form-group" style="display:none">
                                <div class="d-flex justify-content-between flex-column flex-md-row">
                                    <label for="introduction_e">{{ trans('speaker.introduction_e') }}</label>
                                    <span class="d-inline-block text-right"> @{{ introTextConunt_e }} / 240</span>
                                </div>
                                <textarea class="form-control" id="introduction_e" rows="4" v-model="formData.bio_e" maxlength="240" v-on:keyup="countText(240, 'introTextConunt_e', formData.bio_e)" :disabled="formData.readonly"></textarea>
                            </div>-->
                            <div class="form-group">
                                <label for="photo">{{ trans('speaker.photo') }}*</label>
                                <input type="file" class="form-control-file" id="photo" :required="formData.photo == null" @change="valideFile($event)" :disabled="formData.readonly">
                                <img :src="formData.photo" class="mt-2" width="200px">
                                <div class="invalid-feedback">{{ trans('speaker.required.photo') }}</div>
                            </div>
                            <label for="avatar">{{ trans('speaker.related_link') }}</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white"><i class="fab fa-facebook-square"></i><span>
                                </div>
                                <input type="url"  class="form-control" id="link_fb" v-model="formData.link_fb" placeholder="Facebook url" @blur="checkUrl('link_fb')" :disabled="formData.readonly">
                            </div>
                            <div class="input-group mt-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white"><i class="fab fa-github"></i></span>
                                </div>
                                <input type="url" class="form-control" id="link_github" v-model="formData.link_github" placeholder="GitHub url" @blur="checkUrl('link_github')" :disabled="formData.readonly">
                            </div>
                            <div class="input-group mt-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white"><i class="fab fa-twitter"></i></span>
                                </div>
                              <input type="url" class="form-control" id="link_twitter" v-model="formData.link_twitter" placeholder="Twitter url" @blur="checkUrl('link_twitter')" :disabled="formData.readonly">
                            </div>
                            <div class="input-group mt-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white"><i class="fas fa-globe"></i></span>
                                </div>
                              <input type="url"  class="form-control" id="link_other" v-model="formData.link_other" placeholder="其他(如 Website / Blog) url" @blur="checkUrl('link_other')" :disabled="formData.readonly">
                            </div>
                            <h4 class="text-primary mt-4">
                                {{ trans('speaker.agenda_info') }}
                                <span class="h5 text-danger ml-2">{{ trans('speaker.agenda_info_public') }}</span>
                            </h4>
                            <hr>
                            <div class="form-group">
                                <div class="d-flex justify-content-between flex-column flex-md-row">
                                    <label for="topic">{{ trans('speaker.topic') }}*</label>
                                    <span class="d-inline-block text-right"> @{{ topicTextConunt }} / 32</span>
                                </div>
                                <textarea class="form-control" id="topic" rows="4" v-model="formData.topic" maxlength="32" v-on:keyup="countText(32, 'topicTextConunt', formData.topic)" required :disabled="formData.readonly"></textarea>
                                <div class="invalid-feedback">
                                    {{ trans('speaker.required.topic') }}
                                </div>
                            </div>
                            <!--此欄位隱藏
                            <div class="form-group" style="display:none">
                                <div class="d-flex justify-content-between flex-column flex-md-row">
                                    <label for="topic_e">{{ trans('speaker.topic_e') }}</label>
                                    <span class="d-inline-block text-right"> @{{ topicETextConunt }} / 64</span>
                                </div>
                                <textarea class="form-control" id="topic_e" rows="4" v-model="formData.topic_e" maxlength="64" v-on:keyup="countText(64, 'topicETextConunt', formData.topic_e)" :disabled="formData.readonly"></textarea>
                            </div>-->
                            <div class="form-group">
                                <div class="d-flex justify-content-between flex-column flex-md-row">
                                    <label for="summary">{{ trans('speaker.summary') }}*</label>
                                    <span class="d-inline-block text-right"> @{{ summaryTextConunt }} / 480</span>
                                </div>
                                <textarea class="form-control" id="summary" rows="4" v-model="formData.summary" maxlength="480" v-on:keyup="countText(480, 'summaryTextConunt', formData.summary)" required :disabled="formData.readonly"></textarea>
                                <div class="invalid-feedback">
                                    {{ trans('speaker.required.summary') }}
                                </div>
                            </div>
                            <!--此欄位隱藏
                            <div class="form-group" style="display:none">
                                <div class="d-flex justify-content-between flex-column flex-md-row">
                                    <label for="summary_e">{{ trans('speaker.summary_e') }}</label>
                                    <span class="d-inline-block text-right"> @{{ summaryETextConunt }} / 480</span>
                                </div>
                                <textarea class="form-control" id="summary_e" rows="4" v-model="formData.summary_e" maxlength="480" v-on:keyup="countText(480, 'summaryETextConunt', formData.summary_e)" :disabled="formData.readonly"></textarea>
                            </div>-->
                            <div class="form-group">
                                <div class="d-flex justify-content-between flex-column flex-md-row">
                                    <label for="target_audience">{{ trans('speaker.target_audience') }}*</label>
                                    <span class="d-inline-block text-right"> @{{ target_audienceTextCount }} / 64</span>
                                </div>
                                <textarea class="form-control" id="target_audience" rows="4" v-model="formData.target_audience" maxlength="64" v-on:keyup="countText(64, 'target_audienceTextCount', formData.target_audience)" required :disabled="formData.readonly"></textarea>
                                <div class="invalid-feedback">
                                    {{ trans('speaker.required.target_audience') }}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="d-flex justify-content-between flex-column flex-md-row">
                                    <label for="prerequisites">{{ trans('speaker.prerequisites') }}*</label>
                                    <span class="d-inline-block text-right"> @{{ prerequisitesTextCount }} / 120</span>
                                </div>
                                <textarea class="form-control" id="prerequisites" rows="4" v-model="formData.prerequisites" maxlength="120" v-on:keyup="countText(120, 'prerequisitesTextCount', formData.prerequisites)" required :disabled="formData.readonly"></textarea>
                                <div class="invalid-feedback">
                                    {{ trans('speaker.required.prerequisites') }}
                                </div>
                            </div>
                            <div class="form-group">
                                <p class="mb-1">{{ trans('speaker.tag') }}</p>
                                <div class="form-check-inline"
                                  v-for="(item, index) in optionItem.tagItem" :key="index">
                                  <input class="form-check-input" type="checkbox" :id="item"
                                  v-if="formData.tag !== null" :value="index" v-model="formData.tag" :disabled="formData.readonly">
                                  <input class="form-check-input" type="checkbox" :id="item" :value="index"
                                  v-else v-model="tags" :disabled="formData.readonly">
                                  <label class="form-check-label" :for="item">@{{ item }}</label>
                                </div>
                                <br><small class="form-group-check__text mt-5">{{ trans('speaker.tag_helper') }}</small>
                            </div>
                            <div class="form-group">
                                <p class="mb-1">{{ trans('speaker.license')}}</p>
                                <p class="mb-0">(1) {{ trans('speaker.license_0') }}</p>
                                <div class="d-flex flex-column-reverse mb-2">
                                    <div class="form-check" v-for="(agree, index) in optionItem.licenseAgree" :key="'licenseAgree' + index">
                                        <input class="form-check-input" type="radio" :id="'licenseAgree' + index" :value="index"
                                        v-model="formData.agree_record" :disabled="formData.readonly">
                                        <label class="form-check-label" :for="'licenseAgree' + index">@{{ agree }}</label>
                                    </div>
                                </div>
                                <div>
                                    <p class="mb-0">(2) {{ trans('speaker.license') }} ( {{ trans('speaker.license_detail') }} <a href="https://cc.ocf.tw/">https://cc.ocf.tw/</a>)</p>
                                    <div class="form-check" v-for="(license, index) in optionItem.licenseItem" :key="license">
                                        <input class="form-check-input" type="radio" :id="license" v-model="formData.license" :value="index + 1" :disabled="formData.readonly">
                                        <label class=" form-check-label" :for="license">@{{ license }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <p class="mb-1"><strong>{{ trans('speaker.promote_info')}}</strong></p>
                            </div>
                            <div class="form-group">
                                <div class="d-flex justify-content-between flex-column flex-md-row">
                                    <label for="link_slide">{{ trans('speaker.link_slide') }}</label>
                                </div>
                                <input type="url" class="form-control" id="link_slide" v-model="formData.link_slide" placeholder="slide url" @blur="checkUrl('link_slide')">
                            </div>
                            <div class="form-group">
                                <div class="d-flex justify-content-between flex-column flex-md-row">
                                    <label for="link_pre_video">{{ trans('speaker.link_pre_video') }}</label>
                                </div>
                                <input type="url" class="form-control" id="link_pre_video" v-model="formData.link_pre_video" placeholder="video url" @blur="checkUrl('link_pre_video')">
                            </div>
                            <div class="form-group">
                                <p class="mb-1">{{ trans('speaker.promote')}}</p>
                                <p class="mb-0">(1) {{ trans('speaker.promote_by_mopcon') }}</p>
                                <div class="form-check-inline" v-for="(promotion, index) in promotionItem" :key="'promotion' + index">
                                    <input class="form-check-input" type="radio" :id="'promotion' + index" :value="index"
                                    v-model="formData.promotion" :disabled="formData.readonly">
                                    <label class="form-check-label" :for="'promotion' + index">@{{ promotion }}</label>
                                </div>
                                <p class="mb-0">(2) {{ trans('speaker.will_forward_posts') }}</p>
                                <div class="form-check-inline" v-for="(promotion, index) in promotionItem" :key="'will_forward_posts' + index">
                                    <input class="form-check-input" type="radio" :id="'will_forward_posts' + index" :value="index"
                                    v-model="formData.will_forward_posts" :disabled="formData.readonly">
                                    <label class="form-check-label" :for="'will_forward_posts' + index">@{{ promotion }}</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-check-inline">
                                    <input class="form-check-input" type="radio" id="agree_pre_video_public" value="1"
                                    v-model="formData.agree_pre_video_public" :disabled="formData.readonly" name="agree_pre_video_public" required>
                                    <label class="form-check-label" for="agree_pre_video_public">{{ trans('speaker.agree_pre_video_public')}}*</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-check-inline">
                                    <input class="form-check-input" type="radio" id="agree_record_qa" value="1"
                                    v-model="formData.agree_record_qa" :disabled="formData.readonly" name="agree_record_qa" required>
                                    <label class="form-check-label" for="agree_record_qa">{{ trans('speaker.agree_record_qa')}}*</label>
                                </div>
                            </div>
                            <h4 class="text-primary mt-4">
                                {{ trans('speaker.other_info') }}
                                <span class="h5 text-danger ml-2">{{ trans('speaker.other_info_public') }}</span>
                            </h4>
                            <hr>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="real_name">{{ trans('speaker.real_name') }}*</label>
                                    <input type="text" class="form-control" id="real_name" placeholder="{{ trans('speaker.real_name') }}" v-model="formData.real_name" :disabled="formData.readonly" required>
                                    <div class="invalid-feedback">
                                        {{ trans('speaker.required.real_name') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="contact_email">{{ trans('speaker.contact_email') }}*</label>
                                    <input type="email" class="form-control" id="contact_email" placeholder="{{ trans('speaker.contact_email') }}" v-model="formData.contact_email" :disabled="formData.readonly" required>
                                    <div class="invalid-feedback">
                                        {{ trans('speaker.required.contact_email') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="contact_phone">{{ trans('speaker.contact_phone') }}*</label>
                                    <input type="tel" class="form-control" id="contact_phone" placeholder="{{ trans('speaker.contact_phone') }}" v-model="formData.contact_phone" :disabled="formData.readonly" required>
                                    <div class="invalid-feedback">
                                        {{ trans('speaker.required.contact_phone') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="contact_address">{{ trans('speaker.contact_address') }}*</label>
                                    <input type="text" class="form-control" id="contact_address" placeholder="{{ trans('speaker.contact_address') }}" v-model="formData.contact_address" :disabled="formData.readonly" required>
                                    <div class="invalid-feedback">
                                        {{ trans('speaker.required.contact_address') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <p class="mb-1">{{ trans('speaker.tshirt_size')}}</p>
                                <div class="form-check-inline" v-for="(size, index) in optionItem.tshirtSizeItem" :key="size">
                                    <input class="form-check-input" type="radio" :id="size" :value="index" v-model="formData.tshirt_size" :disabled="formData.readonly">
                                    <label class="form-check-label" :for="size"> @{{ size }} </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-check-inline">
                                    <input class="form-check-input" type="radio" id="agree_act_change" value="1"
                                    v-model="formData.agree_act_change" :disabled="formData.readonly">
                                    <label class="form-check-label" for="agree_act_change">{{ trans('speaker.agree_act_change')}}*</label>
                                </div>
                            </div>
                            <!--2021年改為線上活動，故以下實體活動問題暫時隱藏
                            <div class="form-group" style="display:none">
                                <p class="mb-1">{{ trans('speaker.need_parking_space')}}</p>
                                <div class="form-check-inline" v-for="(promotion, index) in promotionItem" :key="'parking' + index">
                                    <input class="form-check-input" type="radio" :id="'parking' + index" :value="index"
                                    v-model="formData.need_parking_space" :disabled="formData.readonly">
                                    <label class="form-check-label" :for="'parking' + index">@{{ promotion }}</label>
                                </div>
                            </div>
                            <div class="form-group" style="display:none">
                                <p class="mb-1">{{ trans('speaker.has_dinner')}}</p>
                                <div class="form-check-inline" v-for="(promotion, index) in promotionItem" :key="'has_dinner' + index">
                                    <input class="form-check-input" type="radio" :id="'has_dinner' + index" :value="index"
                                    v-model="formData.has_dinner" :disabled="formData.readonly">
                                    <label class="form-check-label" :for="'has_dinner' + index">@{{ promotion }}</label>
                                </div>
                            </div>
                            <div class="form-group" style="display:none">
                                <p class="mb-1">{{ trans('speaker.meal_preference')}}</p>
                                <div class="form-check-inline" v-for="(meal, index) in optionItem.mealPreferenceItem" :key="meal">
                                    <input class="form-check-input" type="radio" :id="meal" :value="index" v-model="formData.meal_preference" :disabled="formData.readonly">
                                    <label class="form-check-label" :for="meal">@{{ meal }}</label>
                                </div>
                            </div>
                            <div class="form-group" style="display:none">
                                <p class="mb-1">{{ trans('speaker.has_companion')}}</p>
                                <input type="number" class="form-control" min="0" v-model="formData.has_companion" :disabled="formData.readonly">
                            </div>-->
                            <input type="hidden" class="send" name="password" v-model="password">
                            <button id="formSubmit" class="btn btn-primary btn-block my-4" type="submit" @click.prevent="validationForm()">{{ trans('speaker.submit') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <script>
        Vue.component('accesskey-form', {
            data: function () {
                return {
                    password: '',
                };
            },
            methods: {
                accesskey_method: function () {
                    const vm = this;
                    vm.$emit('accesskey_method', vm.password);
                },
                reCaptchaInit() {
                    setTimeout(function() {
                        if (document.getElementById('vali')) {
                            const vm = this;
                            grecaptcha.render('vali', {
                            'sitekey' : '{{ env('RECAPTCHA_KEY') }}',
                                'callback': function () {
                                    return new Promise(function(resolve, reject) {
                                        var response = grecaptcha.getResponse();
                                        if (response.length > 0) {
                                            document.getElementById('access_send').disabled = false;
                                        }
                                    })
                                }
                            });
                        }
                    }, 1000)
                },
            },
            mounted() {
                this.reCaptchaInit();
            },
            template: `<form id="accessform" class="clearfix" novalidate>
                <div class="form-group">
                    <label for="access_screct">${'{{ trans('speaker.password') }}'}</label>
                    <input type="password" class="form-control" id="access_screct" name="password" v-model="password" @key.enter="accesskey_method()">
                </div>
                <div id="vali" class="my-2"></div>
                <input id="access_send" type='submit' class="btn btn-primary float-right" value="${'{{ trans('speaker.submit') }}'}" disabled="true" @click.prevent="accesskey_method()"/>
            </form>`
        });

        var app = new Vue({
            el: '#app',
            data: {
                alertShow: false,
                show: true,
                password: '',
                message: '',
                classColor: 'alert-danger',
                formData: {},
                tags: [0],
                optionItem: {
                    'levelItem': ['{{ trans('speaker.level_0') }}','{{ trans('speaker.level_1') }}','{{ trans('speaker.level_2') }}'],
                    'licenseAgree': ['{{ trans('speaker.license_5') }}', '{{ trans('speaker.license_6') }}'],
                    'licenseItem': ['{{ trans('speaker.license_1') }}', '{{ trans('speaker.license_2') }}', '{{ trans('speaker.license_3') }}'],
                    'mealPreferenceItem': ['{{ trans('speaker.meal_0') }}', '{{ trans('speaker.meal_1') }}', '{{ trans('speaker.meal_2') }}'],
                    'speakerStatusItem': [],
                    'speakerTypeItem': [],
                    'tagItem': [],
                    'tshirtSizeItem': [],
                },
                promotionItem: ['{{ trans('speaker.no') }}', '{{ trans('speaker.yes') }}'],
                introTextConunt: 120,
                introTextConunt_e: 240,
                topicTextConunt: 32,
                topicETextConunt: 64,
                summaryTextConunt: 480,
                summaryETextConunt: 480,
                target_audienceTextCount: 64,
                prerequisitesTextCount: 120,
                checkData: ['level', 'license', 'tshirt_size', 'need_parking_space', 'has_dinner', 'meal_preference', 'has_companion'],
                defaultIsFirst: ['agree_record', 'licenseItem','will_forward_posts','agree_act_change','promotion'],
            },
            methods: {
                getSponsorForm: function (password) {
                    const vm = this;
                    vm.password = password;
                    axios.post('/speaker/{{$speaker['access_key']}}', {
                        'password':  vm.password,
                    }).then((response) => {
                        if (response.data.success) {
                            vm.formData = response.data.data;
                            vm.checkData.forEach(element => {
                                if (vm.formData[element] === null) {
                                    vm.formData[element] = 0;
                                }
                            });
                            vm.defaultIsFirst.forEach(element => {
                                if (vm.formData[element] === null) {
                                    vm.formData[element] = 1;
                                }
                            });
                            vm.show = false;
                            vm.alertShow = false;
                            vm.getSpeakerOption();
                            vm.countText(120, 'introTextConunt', vm.formData.bio);
                            vm.countText(240, 'introTextConunt_e', vm.formData.bio_e);
                            vm.countText(32, 'topicTextConunt', vm.formData.topic);
                            vm.countText(64, 'topicETextConunt', vm.formData.topic_e);
                            vm.countText(480, 'summaryTextConunt', vm.formData.summary);
                            vm.countText(480, 'summaryETextConunt', vm.formData.summary_e);
                            vm.countText(64, 'target_audienceTextCount', vm.formData.target_audience);
                            vm.countText(120, 'prerequisitesTextCount', vm.formData.prerequisites);
                        } else {
                            vm.alertShow = true;
                            vm.message = response.data.message
                        }
                    }).catch((err) => {
                        vm.alertShow = true;
                        vm.classColor = 'alert-danger';
                        vm.message = err.response.data.message;
                    })
                },
                getSpeakerOption() {
                    const vm = this;
                    axios.get('/speaker/get-options')
                    .then(response => {
                        const res = response.data.data;
                        const keys = Object.keys(res);
                        const filter = ['levelItem', 'licenseItem', 'mealPreferenceItem'];
                        keys.forEach(key => {
                            if (filter.indexOf(key) !== -1) {
                                return;
                            }
                            vm.optionItem[key] = res[key];
                        });
                    }).catch(error => {
                        console.log(error);
                    });
                },
                valideFile(e) {
                    const vm = this;
                    const file = e.target.files[0];
                    const img = new Image();
                    const _URL = window.URL || window.webkitURL;
                    img.onload = () => {
                        if (img.width < 500 || img.height < 500) {
                            alert("寬高需大於 500");
                            document.getElementById('photo').value = "";
                        } else {
                            vm.imagePreview('photo');
                        }
                    };
                    img.src = _URL.createObjectURL(file);
                },
                checkUrl(key) {
                    const vm = this;
                    if (!document.getElementById(key).checkValidity()) {
                        vm.formData[key] = ''
                        alert('請輸入 url');
                    }
                },
                sendform() {
                    const vm = this;
                    let sendFormData = vm.formData;
                    let postData = new FormData();
                    const reg = new RegExp('link_');
                    Object.keys(sendFormData).forEach((ele, index) => {
                        if(sendFormData[ele] !== undefined || sendFormData[ele] !== null){
                            if (ele === 'photo') {
                                const fileInput = document.getElementById(ele);
                                if (fileInput) {
                                    if (fileInput.files.length > 0){
                                        postData.set('file', fileInput.files[0]);
                                    }
                                }
                            } else if (ele.match(reg) !== null) {
                                if (sendFormData[ele] === null) {
                                    delete sendFormData[ele];
                                } else {
                                    postData.set(ele, sendFormData[ele]);
                                }
                            } else if (ele === 'tag') {
                                if (vm.formData.tag !== null) {
                                    for (let i = 0; i < vm.formData.tag.length; i++) {
                                        postData.append('tag[]', vm.formData.tag[i]);
                                    }
                                } else {
                                    for (let i = 0; i < vm.tags.length; i++) {
                                        postData.append('tag[]', vm.tags[i]);
                                    }
                                }
                            } else if (sendFormData[ele] !== null){
                                postData.set(ele, sendFormData[ele]);
                            } else {
                                delete sendFormData[ele];
                            }
                        }
                    })
                    postData.set('password', vm.password);
                    postData.set('_method', 'PUT');
                    axios.post('/speaker/{{$speaker['access_key']}}', postData)
                        .then((response) => {
                            vm.alertShow = true;
                            vm.classColor = 'alert-success';
                            vm.message = '{{ trans('speaker.success_message') }}';
                        })
                        .catch((err) => {
                            vm.alertShow = true;
                            vm.classColor = 'alert-danger';
                            vm.message = err.response.data.message;
                        })
                },
                validationForm() {
                    const vm = this;
                    var forms = document.getElementsByClassName('needs-validation');
                    var validation = Array.prototype.filter.call(forms, function (form) {
                        event.preventDefault();
                        event.stopPropagation();
                        if (form.checkValidity() === false) {
                            vm.alertShow = true;
                            vm.classColor = 'alert-danger';
                            vm.message = '{{ trans('speaker.fail_message') }}';
                        } else {
                            vm.sendform();
                        }
                        form.classList.add('was-validated');
                        const errorInput = document.querySelector('.was-validated .form-control:invalid~.invalid-feedback')
                        if (errorInput !== null) {
                            const id = errorInput.previousElementSibling.id;
                            const link = location.href.split('#')
                            window.location = link[0] +`#${id}`;
                        }
                    });
                },
                imagePreview(inputId) {
                    const file = document.getElementById(inputId);
                    if (file.files && file.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const file = document.getElementById(inputId);
                        const img = $(file).siblings("img")[0];
                        img.src = e.target.result;
                    }
                        reader.readAsDataURL(file.files[0]);
                    }
                },
                countText(num, data, content) {
                    const vm = this;
                    if (content) {
                        vm[data] = num - content.length;
                    } else {
                        vm[data] = num;
                    }
                },
            },
            watch: {
                alertShow: function () {
                    const vm = this;
                    setTimeout(function() {
                        vm.alertShow = false;
                    },5000)
                },
            }
        })
    </script>
</html>

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
        <link rel="stylesheet" href="">
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
                    您的資料已由Mopcon確認完畢，僅供檢視，若須修改請聯繫議程組工作人員。
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
                            <h4 class="text-primary mt-2">{{ trans('speaker.personal_info') }}</h4>
                            <hr>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="name">{{ trans('speaker.name') }}*</label>
                                    <input type="text" class="form-control" id="name" placeholder="姓名" v-model="formData.name" required>
                                    <div class="invalid-feedback">
                                        {{ trans('speaker.required.name') }}
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="name_e">{{ trans('speaker.name_e') }}</label>
                                    <input type="text" class="form-control" id="name_e" placeholder="英文名稱" v-model="formData.name_e">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="company">{{ trans('speaker.company') }}</label>
                                    <input type="text" class="form-control" id="company" placeholder="公司 / 組織" v-model="formData.company">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="company_e">{{ trans('speaker.company_e') }}</label>
                                    <input type="text" class="form-control" id="company_e" placeholder="英文公司/組織" v-model="formData.company_e" >
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="job_title">{{ trans('speaker.job_title') }}*</label>
                                    <input type="text" class="form-control" id="job_title" placeholder="職稱" v-model="formData.job_title" required>
                                    <div class="invalid-feedback">
                                        {{ trans('speaker.required.job_title') }}
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="job_title_e">{{ trans('speaker.job_title_e') }}</label>
                                    <input type="text" class="form-control" id="job_title_e" placeholder="英文職稱" v-model="formData.job_title_e" >
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="d-flex justify-content-between flex-column flex-md-row">
                                    <label for="introduction">{{ trans('speaker.introduction') }}*</label>
                                    <span class="d-inline-block text-right"> @{{ introTextConunt }} / 120</span>
                                </div>
                                <textarea class="form-control" id="introduction" rows="4" v-model="formData.bio" maxlength="120" v-on:keyup="countText(120, 'introTextConunt', formData.bio)" required></textarea>
                                <div class="invalid-feedback">
                                    {{ trans('speaker.required.introduction') }}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="d-flex justify-content-between flex-column flex-md-row">
                                    <label for="introduction_e">{{ trans('speaker.introduction_e') }}</label>
                                    <span class="d-inline-block text-right"> @{{ introTextConunt_e }} / 240</span>
                                </div>
                                <textarea class="form-control" id="introduction_e" rows="4" v-model="formData.bio_e" maxlength="240" v-on:keyup="countText(240, 'introTextConunt_e', formData.bio_e)"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="photo">{{ trans('speaker.photo') }}*</label>
                                <input type="file" class="form-control-file" id="photo" :required="formData.photo == null" @change="valideFile($event)">
                                <img :src="formData.photo" class="mt-2" width="200px">
                                <div class="invalid-feedback">{{ trans('speaker.required.photo') }}</div>
                            </div>
                            <label for="avatar">{{ trans('speaker.related_link') }}</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white"><i class="fab fa-facebook-square"></i><span>
                                </div>
                                <input type="url"  class="form-control" id="link_fb" v-model="formData.link_fb" placeholder="Facebook url" @blur="checkUrl('link_fb')">
                            </div>
                            <div class="input-group mt-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white"><i class="fab fa-github"></i></span>
                                </div>
                                <input type="url" class="form-control" id="link_github" v-model="formData.link_github" placeholder="GitHub url" @blur="checkUrl('link_github')">
                            </div>
                            <div class="input-group mt-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white"><i class="fab fa-twitter"></i></span>
                                </div>
                              <input type="url" class="form-control" id="link_twitter" v-model="formData.link_twitter" placeholder="Twitter url" @blur="checkUrl('link_twitter')">
                            </div>
                            <div class="input-group mt-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white"><i class="fas fa-globe"></i></span>
                                </div>
                              <input type="url"  class="form-control" id="link_other" v-model="formData.link_other" placeholder="其他(如 Website / Blog) url" @blur="checkUrl('link_other')">
                            </div>
                            <h4 class="text-primary mt-4">{{ trans('speaker.agenda_info') }}</h4>
                            <hr>
                            <div class="form-group">
                                <div class="d-flex justify-content-between flex-column flex-md-row">
                                    <label for="topic">{{ trans('speaker.topic') }}*</label>
                                    <span class="d-inline-block text-right"> @{{ topicTextConunt }} / 32</span>
                                </div>
                                <textarea class="form-control" id="topic" rows="4" v-model="formData.topic" maxlength="32" v-on:keyup="countText(32, 'topicTextConunt', formData.topic)" required></textarea>
                                <div class="invalid-feedback">
                                    {{ trans('speaker.required.topic') }}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="d-flex justify-content-between flex-column flex-md-row">
                                    <label for="topic_e">{{ trans('speaker.topic_e') }}</label>
                                    <span class="d-inline-block text-right"> @{{ topicETextConunt }} / 64</span>
                                </div>
                                <textarea class="form-control" id="topic_e" rows="4" v-model="formData.topic_e" maxlength="64" v-on:keyup="countText(64, 'topicETextConunt', formData.topic_e)"></textarea>
                            </div>
                            <div class="form-group">
                                <div class="d-flex justify-content-between flex-column flex-md-row">
                                    <label for="summary">{{ trans('speaker.summary') }}*</label>
                                    <span class="d-inline-block text-right"> @{{ summaryTextConunt }} / 240</span>
                                </div>
                                <textarea class="form-control" id="summary" rows="4" v-model="formData.summary" maxlength="240" v-on:keyup="countText(240, 'summaryTextConunt', formData.summary)" required></textarea>
                                <div class="invalid-feedback">
                                    {{ trans('speaker.required.summary') }}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="d-flex justify-content-between flex-column flex-md-row">
                                    <label for="summary_e">{{ trans('speaker.summary_e') }}</label>
                                    <span class="d-inline-block text-right"> @{{ summaryETextConunt }} / 480</span>
                                </div>
                                <textarea class="form-control" id="summary_e" rows="4" v-model="formData.summary_e" maxlength="480" v-on:keyup="countText(480, 'summaryETextConunt', formData.summary_e)"></textarea>
                            </div>
                            <div class="form-group">
                                <p class="mb-1">{{ trans('speaker.tag') }}</p>
                                <div class="form-check-inline"
                                  v-for="(item, index) in optionItem.tagItem" :key="index">
                                  <input class="form-check-input" type="checkbox" :id="item"
                                  v-if="formData.tag !== null" :value="index" v-model="formData.tag">
                                  <input class="form-check-input" type="checkbox" :id="item" :value="index"
                                  v-else v-model="tags">
                                  <label class="form-check-label" :for="item">@{{ item }}</label>
                                </div>
                                <br><small class="form-group-check__text mt-5">{{ trans('speaker.tag_helper') }}</small>
                            </div>
                            <div class="form-group">
                                <p class="mb-1">{{ trans('speaker.difficulty')}}</p>
                                <div class="form-check" v-for="(level, index) in optionItem.levelItem"
                                  :key="level">
                                  <input class="form-check-input" type="radio" :id="level" v-model="formData.level" :value="index">
                                  <label class="form-check-label" :for="level">@{{ level }}
                                  </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <p class="mb-1">{{ trans('speaker.license')}}</p>
                                <div class="form-check" v-for="(license, index) in optionItem.licenseItem" :key="license">
                                  <input class="form-check-input" type="radio" :id="license" v-model="formData.license" :value="index">
                                  <label class=" form-check-label" :for="license">@{{ license }}</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <p class="mb-1">{{ trans('speaker.promote')}}</p>
                                <div class="form-check-inline" v-for="(name, index) in promotionItem" :key="name">
                                    <input class="form-check-input" type="radio" :id="name" :value="index" v-model="formData.promotion">
                                    <label class="form-check-label" :for="name">
                                        @{{ name }}
                                    </label>
                                </div>
                            </div>
                            <h4 class="text-primary mt-4">{{ trans('speaker.other_info')}}</h4>
                            <hr>
                            <div class="form-group">
                                <p class="mb-1">{{ trans('speaker.tshirt_size')}}</p>
                                <div class="form-check-inline" v-for="(size, index) in optionItem.tshirtSizeItem" :key="size">
                                    <input class="form-check-input" type="radio" :id="size" :value="index" v-model="formData.tshirt_size">
                                    <label class="form-check-label" :for="size"> @{{ size }} </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <p class="mb-1">{{ trans('speaker.need_parking_space')}}</p>
                                <div class="form-check-inline" v-for="(promotion, index) in promotionItem" :key="'parking' + index">
                                    <input class="form-check-input" type="radio" :id="'parking' + index" :value="index"
                                    v-model="formData.need_parking_space">
                                    <label class="form-check-label" :for="'parking' + index">@{{ promotion }}</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <p class="mb-1">{{ trans('speaker.has_dinner')}}</p>
                                <div class="form-check-inline" v-for="(promotion, index) in promotionItem" :key="'has_dinner' + index">
                                    <input class="form-check-input" type="radio" :id="'has_dinner' + index" :value="index"
                                    v-model="formData.has_dinner">
                                    <label class="form-check-label" :for="'has_dinner' + index">@{{ promotion }}</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <p class="mb-1">{{ trans('speaker.meal_preference')}}</p>
                                <div class="form-check-inline" v-for="(meal, index) in optionItem.mealPreferenceItem" :key="meal">
                                    <input class="form-check-input" type="radio" :id="meal" :value="index" v-model="formData.meal_preference">
                                    <label class="form-check-label" :for="meal">@{{ meal }}</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <p class="mb-1">{{ trans('speaker.has_companion')}}</p>
                                <input type="number" class="form-control" min="0" v-model="formData.has_companion">
                            </div>
                            @if (! $speaker['readonly'])
                            <div id="vali"></div>
                            <input type="hidden" class="send" name="password" v-model="password">
                            <button id="formSubmit" class="btn btn-primary btn-block my-4" type="submit" :disabled="!reCaptchaStatus" @click.prevent="validationForm()">{{ trans('speaker.submit') }}</button>
                            @endif
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
                }
            },
            template: `<form id="accessform" class="clearfix" novalidate>
                <div class="form-group">
                    <label for="access_screct">${'{{ trans('speaker.password') }}'}</label>
                    <input type="password" class="form-control" id="access_screct" name="password" v-model="password" @key.enter="accesskey_method()">
                </div>
                <input id="access_send" type='submit' class="btn btn-primary float-right" value="${'{{ trans('speaker.submit') }}'}" @click.prevent="accesskey_method()"/>
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
                reCaptchaStatus: false,
                formData: {},
                tags: [0],
                optionItem: {
                    'levelItem': ['{{ trans('speaker.level_0') }}','{{ trans('speaker.level_1') }}','{{ trans('speaker.level_2') }}'],
                    'licenseItem': ['{{ trans('speaker.license_0') }}', '{{ trans('speaker.license_1') }}', '{{ trans('speaker.license_2') }}', '{{ trans('speaker.license_3') }}', '{{ trans('speaker.license_4') }}'],
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
                summaryTextConunt: 240,
                summaryETextConunt: 480,
                checkData: ['level', 'license', 'promotion', 'tshirt_size', 'need_parking_space', 'has_dinner', 'meal_preference', 'has_companion'],
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
                            vm.show = false;
                            vm.alertShow = false;
                            vm.getSpeakerOption();
                            vm.countText(120, 'introTextConunt', vm.formData.bio);
                            vm.countText(240, 'introTextConunt_e', vm.formData.bio_e);
                            vm.countText(32, 'topicTextConunt', vm.formData.topic);
                            vm.countText(64, 'topicETextConunt', vm.formData.topic_e);
                            vm.countText(240, 'summaryTextConunt', vm.formData.summary);
                            vm.countText(480, 'summaryETextConunt', vm.formData.summary_e);
                            vm.reCaptchaInit();
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
                                            document.getElementById('formSubmit').disabled = false;
                                        }
                                    })
                                }
                            });
                        }
                    }, 1000)
                },
                countText(num, data, content) {
                    const vm = this;
                    if (content) {
                        vm[data] = num - content.length;
                    } else {
                        return num
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

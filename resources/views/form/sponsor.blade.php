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
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>贊助商上傳表單</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
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
                <div class="row justify-content-center mt-5">
                    <div class="col-md-6" v-if="show">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="text-center">{{trans('sponsor.sponsor_upload_form')}}</h3>
                            </div>
                            <div class="card-body">
                                <accesskey-form v-on:accesskey_method="getSponsorForm"></accesskey-form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10" id="sponsorForm" v-if="!show">
                        <h2 class="d-inline-block my-3">{{trans('sponsor.sponsor_form')}}</h2>
                        <h4 class="d-inline-block mx-2">{{trans('sponsor.sponsor_form_c')}}</h4>
                        <form id="sendform" class="needs-validation" novalidate>
                            <h4 class="text-primary mt-2">{{trans('sponsor.promote_data')}}</h4>
                            <hr>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="companyName">{{trans('sponsor.main.name')}}*</label>
                                    <input type="text" class="form-control" id="companyName" placeholder="{{trans('sponsor.main.name')}}" v-model="formData.main.name" required>
                                    <div class="invalid-feedback">
                                        {{trans('sponsor.required.main_name')}}
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="companyEnglishName">{{trans('sponsor.main.en_name')}}*</label>
                                    <input type="text" class="form-control" id="companyEnglishName" placeholder="{{trans('sponsor.main.en_name')}}" v-model="formData.main.en_name" required>
                                    <div class="invalid-feedback">
                                        {{trans('sponsor.required.main_en_name')}}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="d-flex justify-content-between flex-column flex-md-row">
                                    <label for="introduction">{{trans('sponsor.main.introduction')}}*</label>
                                    <span class="d-inline-block text-right"> @{{ introTextConunt }} / 250</span>
                                </div>
                                @component('components.subtitle')
                                    {{trans('sponsor.subtitle.introduction')}}
                                @endcomponent
                                <textarea class="form-control" id="introduction" rows="4" v-model="formData.main.introduction" maxlength="250" v-on:keyup="countText(250, 'introTextConunt', formData.main.introduction)" required></textarea>
                                <div class="invalid-feedback">
                                    {{trans('sponsor.required.main_introduction')}}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="d-flex justify-content-between flex-column flex-md-row">
                                    <label for="englishIntroduction">{{trans('sponsor.main.en_introduction')}}</label>
                                </div>
                                <textarea class="form-control" id="englishIntroduction" rows="4" v-model="formData.main.en_introduction"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="companyUrl">{{trans('sponsor.main.website')}}*</label>
                                <input type="url" class="form-control" id="companyUrl" placeholder="{{trans('sponsor.main.website')}}" v-model="formData.main.website" required>
                                <div class="invalid-feedback">
                                    {{trans('sponsor.required.main_website')}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="socialMedia">{{trans('sponsor.main.social_media')}}</label>
                                <input type="url" class="form-control" id="socialMedia" placeholder="FaceBook Url" v-model="formData.main.social_media">
                            </div>
                            <div class="form-group">
                                <div class="d-flex justify-content-between flex-column flex-md-row">
                                    <label for="production">{{trans('sponsor.main.production')}}*</label>
                                    <span class="d-inline-block text-right"> @{{ productionTextConunt }} / 250</span>
                                </div>
                                @component('components.subtitle')
                                    {{trans('sponsor.subtitle.production')}}
                                @endcomponent
                                <textarea class="form-control" id="production" rows="4"
                                v-model="formData.main.production" maxlength="250" v-on:keyup="countText(250, 'productionTextConunt', formData.main.production);" required></textarea>
                                <div class="invalid-feedback">
                                    {{trans('sponsor.required.main_production')}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="logo_path">{{trans('sponsor.main.logo')}}</label>
                                @component('components.subtitle')
                                    {{trans('sponsor.subtitle.logo')}}
                                @endcomponent
                                <input type="file" class="form-control-file" id="logo_path" @change="imagePreview('logo_path')">
                                <img :src="formData.main.logo_path" class="mt-2" width="200px">
                                <div class="invalid-feedback">
                                    {{trans('sponsor.required.main_logo')}}
                                </div>
                                <input type="url" v-model="formData.main.cloud_logo_path" class="form-control my-2" id="cloud_logo_path" placeholder="{{trans('sponsor.cloud.link')}}({{trans('sponsor.cloud.description')}})" @change="linkDirect('cloud_logo_path')">
                                @component('components.subtitle')
                                    {{trans('sponsor.cloud.error')}}
                                @endcomponent
                                <a v-if="formData.main.cloud_logo_path !== null" :href="formData.main.cloud_logo_path" class="badge badge-info mb-2 p-2" target="_blank">
                                    @{{ formData.main.cloud_logo_path }}
                                </a>
                            </div>
                            <div class="form-group">
                                <label for="service_photo_path">{{trans('sponsor.main.service_photo')}}</label>
                                @component('components.subtitle')
                                    {{trans('sponsor.subtitle.service_photo')}}
                                @endcomponent
                                <input type="file" class="form-control-file" id="service_photo_path" @change="imagePreview('service_photo_path')">
                                <img :src="formData.main.service_photo_path" class="mt-2" width="200px">
                                <div class="invalid-feedback">
                                    {{trans('sponsor.required.main_service_photo')}}
                                </div>
                                <input type="url" v-model="formData.main.cloud_service_photo_path" class="form-control my-2" id="cloud_service_photo_path" placeholder="{{trans('sponsor.cloud.link')}}({{trans('sponsor.cloud.description')}})" @change="linkDirect('cloud_service_photo_path')">
                                @component('components.subtitle')
                                    {{trans('sponsor.cloud.error')}}
                                @endcomponent
                                <a v-if="formData.main.cloud_service_photo_path !== null" :href="formData.main.cloud_service_photo_path" class="badge badge-info mb-2 p-2" target="_blank">
                                    @{{ formData.main.cloud_service_photo_path }}
                                </a>
                            </div>
                            <div class="form-group">
                                <label for="promotionalMaterial">{{trans('sponsor.main.promotion')}}</label>
                                @component('components.subtitle')
                                    {{trans('sponsor.subtitle.promotion')}}
                                @endcomponent
                                <textarea class="form-control" id="promotionalMaterial" rows="3" v-model="formData.main.promote">
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label for="slide_path">{{trans('sponsor.main.slide')}}</label>
                                @component('components.subtitle')
                                    {{trans('sponsor.subtitle.slide')}}
                                @endcomponent
                                <input type="file" class="form-control-file" id="slide_path" @change="imagePreview('slide_path')">
                                <img :src="formData.main.slide_path" class="mt-2" width="200px">
                                <div class="invalid-feedback">
                                    {{trans('sponsor.required.main_slide')}}
                                </div>
                                <input type="url" v-model="formData.main.cloud_slide_path" class="form-control my-2" id="cloud_slide_path" placeholder="{{trans('sponsor.cloud.link')}}({{trans('sponsor.cloud.description')}})" @change="linkDirect('cloud_slide_path')">
                                @component('components.subtitle')
                                    {{trans('sponsor.cloud.video_only_url')}}
                                @endcomponent
                                <a v-if="formData.main.cloud_slide_path !== null" :href="formData.main.cloud_slide_path" class="badge badge-info mb-2 p-2" target="_blank">
                                    @{{ formData.main.cloud_slide_path }}
                                </a>
                            </div>
                            <!-- <div class="form-group">
                                <label for="board_path">{{trans('sponsor.main.board')}}</label>
                                @component('components.subtitle')
                                    {{trans('sponsor.subtitle.board')}}
                                @endcomponent
                                <input type="file" class="form-control-file" id="board_path" @change="imagePreview('board_path')">
                                <img :src="formData.main.board_path" class="mt-2" width="200px">
                                <div class="invalid-feedback">
                                    {{trans('sponsor.required.main_board')}}
                                </div>
                                <input type="url" v-model="formData.main.cloud_board_path" class="form-control my-2" id="cloud_board_path" placeholder="{{trans('sponsor.cloud.link')}}({{trans('sponsor.cloud.description')}})" @change="linkDirect('cloud_board_path')">
                                @component('components.subtitle')
                                    {{trans('sponsor.cloud.error')}}
                                @endcomponent
                                <a v-if="formData.main.cloud_board_path !== null" :href="formData.main.cloud_board_path" class="badge badge-info mb-2 p-2" target="_blank">
                                    @{{ formData.main.cloud_board_path }}
                                </a>
                            </div> -->
                            <!-- <div class="form-group">
                                <div class="d-flex justify-content-between flex-column flex-md-row">
                                    <label for="dinnerPartyIntro">{{trans('sponsor.main.dinner_intro')}}</label>
                                    <span class="d-inline-block text-right"> @{{ dinnerPartyIntroTextConunt }} / 80</span>
                                </div>
                                <textarea class="form-control" id="dinnerPartyIntro" rows="2" v-model="formData.main.opening_remarks" maxlength="80" v-on:keyup="countText(80, 'dinnerPartyIntroTextConunt', formData.main.opening_remarks);"></textarea>
                            </div> -->
                            <h4 class="text-primary mt-2">{{trans('sponsor.recipe_data')}}</h4>
                            <hr>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="companyFullName">{{trans('sponsor.recipe.company_full_name')}}*</label>
                                    <input type="text" class="form-control" id="companyFullName" placeholder="{{trans('sponsor.recipe.company_full_name')}}" v-model="formData.recipe.recipe_full_name" required>
                                    <div class="invalid-feedback">
                                        {{trans('sponsor.required.recipe_company_full_name')}}
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="taxIDNumber">{{trans('sponsor.recipe.tax_id_number')}}*</label>
                                    <input type="number" class="form-control" id="taxIDNumber" placeholder="{{trans('sponsor.recipe.tax_id_number')}}" v-model="formData.recipe.recipe_tax_id_number" oninput="if(value.length>8)value=value.slice(0,8)" required>
                                    <div class="invalid-feedback">
                                        {{trans('sponsor.required.recipe_tax_id_number')}}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sponsePrice">{{trans('sponsor.recipe.sponse_price')}}*</label>
                                <input type="number" class="form-control" id="sponsePrice" placeholder="1,000" v-model="formData.recipe.recipe_amount" required>
                                <div class="invalid-feedback">
                                    {{trans('sponsor.required.recipe_sponse_price')}}
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                <label for="contactName">{{trans('sponsor.recipe.contact_name')}}*</label>
                                <input type="text" class="form-control" id="contactName" placeholder="{{trans('sponsor.recipe.contact_name')}}" v-model="formData.recipe.recipe_contact_name" required>
                                <div class="invalid-feedback">
                                    {{trans('sponsor.required.recipe_contact_name')}}
                                </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                <label for="contactTitle">{{trans('sponsor.recipe.contact_title')}}</label>
                                <input type="text" class="form-control" id="contactTitle" v-model="formData.recipe.recipe_contact_title" placeholder="{{trans('sponsor.recipe.contact_title')}}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="contactPhoneNumber">{{trans('sponsor.recipe.contact_phone_number')}}*</label>
                                    <input type="text" class="form-control" id="contactPhoneNumber" v-model="formData.recipe.recipe_contact_phone" placeholder="{{trans('sponsor.recipe.contact_phone_number')}}" required>
                                    <div class="invalid-feedback">
                                        {{trans('sponsor.required.recipe_contact_phone_number')}}
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="contactMail">{{trans('sponsor.recipe.contact_mail')}}*</label>
                                    <input type="email" class="form-control" id="contactMail" v-model="formData.recipe.recipe_contact_email" placeholder="{{trans('sponsor.recipe.contact_mail')}}" required>
                                    <div class="invalid-feedback">
                                        {{trans('sponsor.required.recipe_contact_mail')}}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="contactAddress">{{trans('sponsor.recipe.contact_address')}}*</label>
                                <input type="" class="form-control" id="contactAddress" placeholder="{{trans('sponsor.recipe.contact_address_placeholder')}}" v-model="formData.recipe.recipe_contact_address" required>
                                <div class="invalid-feedback">
                                    {{trans('sponsor.required.recipe_contact_address')}}
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                            <label for="sponseReason">{{trans('sponsor.main.sponse_reason')}}</label>
                                <textarea class="form-control" id="sponseReason" rows="2" v-model="formData.main.reason"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="sponseAims">{{trans('sponsor.main.sponse_aims')}}</label>
                                @component('components.subtitle')
                                    {{trans('sponsor.subtitle.sponse_aims')}}
                                @endcomponent
                                <textarea class="form-control" id="sponseAims" rows="2" v-model="formData.main.purpose"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="sponseRemarks">{{trans('sponsor.main.sponse_remarks')}}</label>
                                <textarea class="form-control" id="sponseRemarks" v-model="formData.main.remark"></textarea>
                            </div>
                            <h4 class="text-primary mt-4" v-if="![3,4].includes(formData.advence.sponsor_type)">{{trans('sponsor.addition_title')}}</h4>
                                <div class="card my-2" v-if="formData.advence.sponsor_type === 0">
                                    <div class="card-header">
                                        {{trans('sponsor.advance.sponsor_type')}}：{{trans('sponsor.advance.tony_stark')}}
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="advence_icck_ad_path">{{trans('sponsor.advance.icck')}}</label>
                                            @component('components.subtitle')
                                                {{trans('sponsor.subtitle.icck')}}
                                            @endcomponent
                                            <input type="file" class="form-control-file" id="advence_icck_ad_path"  @change="imagePreview('advence_icck_ad_path')">
                                            <img class="mt-2" :src="formData.advence.advence_icck_ad_path" width="200px">
                                            <input type="url" v-model="formData.advence.cloud_advence_icck_ad_path" class="form-control my-2" id="cloud_advence_icck_ad_path" placeholder="{{trans('sponsor.cloud.link')}}({{trans('sponsor.cloud.description')}})" @change="linkDirect('cloud_advence_icck_ad_path')">
                                            @component('components.subtitle')
                                                {{trans('sponsor.cloud.error')}}
                                            @endcomponent
                                            <a v-if="formData.advence.cloud_advence_icck_ad_path !== null" :href="formData.advence.cloud_advence_icck_ad_path" class="badge badge-info mb-2 p-2" target="_blank">
                                                @{{ formData.advence.cloud_advence_icck_ad_path }}
                                            </a>
                                        </div>
                                        <div class="form-group">
                                            <label for="advence_registration_ad_path">{{trans('sponsor.advance.registration')}}</label>
                                            @component('components.subtitle')
                                                {{trans('sponsor.subtitle.registration')}}
                                            @endcomponent
                                            <input type="file" class="form-control-file" id="advence_registration_ad_path" @change="imagePreview('advence_registration_ad_path')">
                                            <img class="mt-2" :src="formData.advence.advence_registration_ad_path" width="200px">
                                            <input type="url" v-model="formData.advence.cloud_advence_registration_ad_path" class="form-control my-2" id="cloud_advence_registration_ad_path" placeholder="{{trans('sponsor.cloud.link')}}({{trans('sponsor.cloud.description')}})" @change="linkDirect('cloud_advence_registration_ad_path')">
                                            @component('components.subtitle')
                                                {{trans('sponsor.cloud.error')}}
                                            @endcomponent
                                            <a v-if="formData.advence.cloud_advence_registration_ad_path !== null" :href="formData.advence.cloud_advence_registration_ad_path" class="badge badge-info mb-2 p-2" target="_blank">
                                                @{{ formData.advence.cloud_advence_registration_ad_path }}
                                            </a>
                                        </div>
                                        <div class="form-group">
                                            <label for="keynoteIntroduction">{{trans('sponsor.advance.keynote')}}</label>
                                            @component('components.subtitle')
                                                {{trans('sponsor.subtitle.keynote')}}
                                            @endcomponent
                                            <textarea class="form-control" id="keynoteIntroduction" rows="4" v-model="formData.advence.advence_keynote"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="advence_hall_flag_path">{{trans('sponsor.advance.hall_flag')}}</label>
                                            @component('components.subtitle')
                                                {{trans('sponsor.subtitle.hall_flag')}}
                                            @endcomponent
                                            <input type="file" class="form-control-file" id="advence_hall_flag_path" @change="imagePreview('advence_hall_flag_path')">
                                            <img class="mt-2" :src="formData.advence.advence_hall_flag_path" width="200px">
                                            <input type="url" v-model="formData.advence.cloud_advence_hall_flag_path" class="form-control my-2" id="cloud_advence_hall_flag_path" placeholder="{{trans('sponsor.cloud.link')}}({{trans('sponsor.cloud.description')}})" @change="linkDirect('cloud_advence_hall_flag_path')">
                                            @component('components.subtitle')
                                                {{trans('sponsor.cloud.error')}}
                                            @endcomponent
                                            <a v-if="formData.advence.cloud_advence_hall_flag_path !== null" :href="formData.advence.cloud_advence_hall_flag_path" class="badge badge-info mb-2 p-2" target="_blank">
                                                @{{ formData.advence.cloud_advence_hall_flag_path }}
                                            </a>
                                        </div>
                                        <div class="form-group">
                                            <label for="advence_main_flow_flag_path">{{trans('sponsor.advance.main_flow_flag')}}</label>
                                            @component('components.subtitle')
                                                {{trans('sponsor.subtitle.main_flow_flag')}}
                                            @endcomponent
                                            <input type="file" class="form-control-file" id="advence_main_flow_flag_path" @change="imagePreview('advence_main_flow_flag_path')">
                                            <img class="mt-2" :src="formData.advence.advence_main_flow_flag_path" width="200px">
                                            <input type="url" v-model="formData.advence.cloud_advence_main_flow_flag_path" class="form-control my-2" id="cloud_advence_main_flow_flag_path" placeholder="{{trans('sponsor.cloud.link')}}({{trans('sponsor.cloud.description')}})" @change="linkDirect('cloud_advence_main_flow_flag_path')">
                                            @component('components.subtitle')
                                                {{trans('sponsor.cloud.error')}}
                                            @endcomponent
                                            <a v-if="formData.advence.cloud_advence_main_flow_flag_path !== null" :href="formData.advence.cloud_advence_main_flow_flag_path" class="badge badge-info mb-2 p-2" target="_blank">
                                                @{{ formData.advence.cloud_advence_main_flow_flag_path }}
                                            </a>
                                        </div>
                                        <!--<div class="form-group">
                                            <label for="promotion_ad_media_link">{{trans('sponsor.advance.promotion_ad_media_link')}} 60 {{trans('sponsor.second')}}</label>
                                            @component('components.subtitle')
                                                {{trans('sponsor.subtitle.promotion_ad_media_link')}} 60 {{trans('sponsor.second')}}  ｜ {{trans('sponsor.cloud.only_url')}}
                                            @endcomponent
                                            <input type="url" v-model="formData.advence.promotion_ad_media_link" class="form-control my-2" id="promotion_ad_media_link" placeholder="{{trans('sponsor.cloud.only_url')}}">
                                            <a v-if="formData.advence.promotion_ad_media_link" :href="formData.advence.promotion_ad_media_link" class="badge badge-info mb-2 p-2" target="_blank">
                                                @{{ formData.advence.promotion_ad_media_link }}
                                            </a>
                                        </div>-->
                                        <!--<div class="form-group">
                                            <label for="promotion_warm_up_media_link">{{trans('sponsor.advance.promotion_warm_up_media_link')}} 60 {{trans('sponsor.second')}} </label>
                                            @component('components.subtitle')
                                                {{trans('sponsor.subtitle.promotion_warm_up_media_link')}} 60 {{trans('sponsor.second')}}  ｜ {{trans('sponsor.cloud.only_url')}}
                                            @endcomponent
                                            <input type="url" v-model="formData.advence.promotion_warm_up_media_link" class="form-control my-2" id="promotion_warm_up_media_link" placeholder="{{trans('sponsor.cloud.only_url')}}">
                                            <a v-if="formData.advence.promotion_warm_up_media_link" :href="formData.advence.promotion_warm_up_media_link" class="badge badge-info mb-2 p-2" target="_blank">
                                                @{{ formData.advence.promotion_warm_up_media_link }}
                                            </a>
                                        </div>-->
                                        <!--<div class="form-group">
                                            <label for="promotion_discord_intro">{{trans('sponsor.advance.promotion_discord_intro')}}</label>
                                            @component('components.subtitle')
                                                {{trans('sponsor.subtitle.promotion_discord_intro')}}
                                            @endcomponent
                                            <textarea class="form-control" id="promotion_discord_intro" rows="4" v-model="formData.advence.promotion_discord_intro"></textarea>
                                        </div>-->
                                        <!-- Gather town link -->
                                        <!--<h5>{{trans('sponsor.advance.gather_town')}}</h5>
                                        <div class="form-group">
                                            <label for="promotion_gather_town_h_link">{{trans('sponsor.advance.promotion_gather_town_h_link')}}</label>
                                            @component('components.subtitle')
                                                {{trans('sponsor.subtitle.promotion_gather_town_h_link')}}
                                            @endcomponent
                                            <input type="url" v-model="formData.advence.promotion_gather_town_h_link" class="form-control my-2" id="promotion_gather_town_h_link" placeholder="{{trans('sponsor.cloud.only_url')}}">
                                            <a v-if="formData.advence.promotion_gather_town_h_link" :href="formData.advence.promotion_gather_town_h_link" class="badge badge-info mb-2 p-2" target="_blank">
                                                @{{ formData.advence.promotion_gather_town_h_link }}
                                            </a>
                                        </div>
                                        <div class="form-group">
                                            <label for="promotion_gather_town_v_link">{{trans('sponsor.advance.promotion_gather_town_v_link')}}</label>
                                            @component('components.subtitle')
                                                {{trans('sponsor.subtitle.promotion_gather_town_v_link')}}
                                            @endcomponent
                                            <input type="url" v-model="formData.advence.promotion_gather_town_v_link" class="form-control my-2" id="promotion_gather_town_v_link" placeholder="{{trans('sponsor.cloud.only_url')}}">
                                            <a v-if="formData.advence.promotion_gather_town_v_link" :href="formData.advence.promotion_gather_town_v_link" class="badge badge-info mb-2 p-2" target="_blank">
                                                @{{ formData.advence.promotion_gather_town_v_link }}
                                            </a>
                                        </div>
                                        <div class="form-group">
                                            <label for="promotion_gather_town_video_link">{{trans('sponsor.advance.promotion_gather_town_video_link')}}</label>
                                            @component('components.subtitle')
                                                {{trans('sponsor.subtitle.promotion_gather_town_video_link')}}
                                            @endcomponent
                                            <input type="url" v-model="formData.advence.promotion_gather_town_video_link" class="form-control my-2" id="promotion_gather_town_video_link" placeholder="{{trans('sponsor.cloud.only_url')}}">
                                            <a v-if="formData.advence.promotion_gather_town_video_link" :href="formData.advence.promotion_gather_town_video_link" class="badge badge-info mb-2 p-2" target="_blank">
                                                @{{ formData.advence.promotion_gather_town_video_link }}
                                            </a>
                                            <input type="url" v-model="formData.advence.promotion_gather_town_video_link_0" class="form-control my-2" id="promotion_gather_town_video_link_0" placeholder="{{trans('sponsor.cloud.only_url')}}">
                                            <a v-if="formData.advence.promotion_gather_town_video_link_0" :href="formData.advence.promotion_gather_town_video_link_0" class="badge badge-info mb-2 p-2" target="_blank">
                                                @{{ formData.advence.promotion_gather_town_video_link }}
                                            </a>
                                            <input type="url" v-model="formData.advence.promotion_gather_town_video_link_1" class="form-control my-2" id="promotion_gather_town_video_link_1" placeholder="{{trans('sponsor.cloud.only_url')}}">
                                            <a v-if="formData.advence.promotion_gather_town_video_link_1" :href="formData.advence.promotion_gather_town_video_link_1" class="badge badge-info mb-2 p-2" target="_blank">
                                                @{{ formData.advence.promotion_gather_town_video_link }}
                                            </a>
                                        </div>-->
                                        <!-- Gather town link end -->
                                        <h5>{{trans('sponsor.advance.email_before_start')}}</h5>
                                        <div class="form-group">
                                            <label for="promotion_email_short">{{trans('sponsor.advance.promotion_email_short')}}</label>
                                            @component('components.subtitle')
                                                {{trans('sponsor.subtitle.promotion_email_short')}}
                                            @endcomponent
                                            <textarea class="form-control" id="promotion_email_short" rows="4" v-model="formData.advence.promotion_email_short"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="promotion_email_url">{{trans('sponsor.advance.promotion_email_url')}}</label>
                                            @component('components.subtitle')
                                                {{trans('sponsor.subtitle.promotion_email_url')}} ｜ {{trans('sponsor.cloud.only_url')}}
                                            @endcomponent
                                            <input type="url" v-model="formData.advence.promotion_email_url" class="form-control my-2" id="promotion_email_url" placeholder="{{trans('sponsor.cloud.only_url')}}">
                                            <a v-if="formData.advence.promotion_email_url" :href="formData.advence.promotion_email_url" class="badge badge-info mb-2 p-2" target="_blank">
                                                @{{ formData.advence.promotion_email_url }}
                                            </a>
                                        </div>
                                        <div class="form-group">
                                            <label for="promotion_email_image">{{trans('sponsor.advance.promotion_email_image')}}</label>
                                            @component('components.subtitle')
                                                {{trans('sponsor.cloud.only_url')}}
                                            @endcomponent
                                            <input type="url" v-model="formData.advence.promotion_email_image" class="form-control my-2" id="promotion_email_image" placeholder="{{trans('sponsor.cloud.only_url')}}">
                                            <a v-if="formData.advence.promotion_email_image" :href="formData.advence.promotion_email_image" class="badge badge-info mb-2 p-2" target="_blank">
                                                @{{ formData.advence.promotion_email_image }}
                                            </a>
                                        </div>
                                        <h5>{{trans('sponsor.advance.app_push_before_start')}}</h5>
                                        <div class="form-group">
                                            <label for="promotion_app_push_image_link">{{trans('sponsor.advance.promotion_app_push_image_link')}}</label>
                                            @component('components.subtitle')
                                                {{trans('sponsor.cloud.only_url')}}
                                            @endcomponent
                                            <input type="url" v-model="formData.advence.promotion_app_push_image_link" class="form-control my-2" id="promotion_app_push_image_link" placeholder="{{trans('sponsor.cloud.only_url')}}">
                                            <a v-if="formData.advence.promotion_app_push_image_link" :href="formData.advence.promotion_app_push_image_link" class="badge badge-info mb-2 p-2" target="_blank">
                                                @{{ formData.advence.promotion_app_push_image_link }}
                                            </a>
                                        </div>
                                        <div class="form-group">
                                            <label for="promotion_app_push_title">{{trans('sponsor.advance.promotion_app_push_title')}}</label>
                                            <input type="text" class="form-control" id="promotion_app_push_title" placeholder="{{trans('sponsor.cloud.only_url')}}" v-model="formData.advence.promotion_app_push_title" >
                                        </div>
                                        <div class="form-group">
                                            <label for="promotion_app_push_content">{{trans('sponsor.advance.promotion_app_push_content')}}</label>
                                            <textarea class="form-control" id="promotion_app_push_content" rows="4" v-model="formData.advence.promotion_app_push_content"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="promotion_app_push_link">{{trans('sponsor.advance.promotion_app_push_link')}}</label>
                                            <input type="url" v-model="formData.advence.promotion_app_push_link" class="form-control my-2" id="promotion_app_push_link" placeholder="{{trans('sponsor.subtitle.promotion_app_push_link') | trans('sponsor.cloud.only_url')}}">
                                            <a v-if="formData.advence.promotion_app_push_link" :href="formData.advence.promotion_app_push_link" class="badge badge-info mb-2 p-2" target="_blank">
                                                @{{ formData.advence.promotion_app_push_link }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card my-2" v-else-if="formData.advence.sponsor_type === 1">
                                    <div class="card-header">
                                        {{trans('sponsor.advance.sponsor_type')}}：{{trans('sponsor.advance.bruce_wayne')}}
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="advence_hall_flag_path">{{trans('sponsor.advance.hall_flag')}}</label>
                                            @component('components.subtitle')
                                                {{trans('sponsor.subtitle.hall_flag')}}
                                            @endcomponent
                                            <input type="file" class="form-control-file" id="advence_hall_flag_path" @change="imagePreview('advence_hall_flag_path')">
                                            <img class="mt-2" :src="formData.advence.advence_hall_flag_path" width="200px">
                                            <input type="url" v-model="formData.advence.cloud_advence_hall_flag_path" class="form-control my-2" id="cloud_advence_hall_flag_path" placeholder="{{trans('sponsor.cloud.link')}}({{trans('sponsor.cloud.description')}})" @change="linkDirect('cloud_advence_hall_flag_path')">
                                            @component('components.subtitle')
                                                {{trans('sponsor.cloud.error')}}
                                            @endcomponent
                                            <a v-if="formData.advence.cloud_advence_hall_flag_path" :href="formData.advence.cloud_advence_hall_flag_path" class="badge badge-info mb-2 p-2" target="_blank">
                                                @{{ formData.advence.cloud_advence_hall_flag_path }}
                                            </a>
                                        </div>
                                        <div class="form-group">
                                            <label for="advence_main_flow_flag_path">{{trans('sponsor.advance.main_flow_flag')}}</label>
                                            @component('components.subtitle')
                                                {{trans('sponsor.subtitle.main_flow_flag')}}
                                            @endcomponent
                                            <input type="file" class="form-control-file" id="advence_main_flow_flag_path" @change="imagePreview('advence_main_flow_flag_path')">
                                            <img class="mt-2" :src="formData.advence.advence_main_flow_flag_path" width="200px">
                                            <input type="url" v-model="formData.advence.cloud_advence_main_flow_flag_path" class="form-control my-2" id="cloud_advence_main_flow_flag_path" placeholder="{{trans('sponsor.cloud.link')}}({{trans('sponsor.cloud.description')}})" @change="linkDirect('cloud_advence_main_flow_flag_path')">
                                            @component('components.subtitle')
                                                {{trans('sponsor.cloud.error')}}
                                            @endcomponent
                                            <a v-if="formData.advence.cloud_advence_main_flow_flag_path" :href="formData.advence.cloud_advence_main_flow_flag_path" class="badge badge-info mb-2 p-2" target="_blank">
                                                @{{ formData.advence.cloud_advence_main_flow_flag_path }}
                                            </a>
                                        </div>
                                        <!--<div class="form-group">
                                            <label for="promotion_ad_media_link">{{trans('sponsor.advance.promotion_ad_media_link')}} 30 {{trans('sponsor.second')}}</label>
                                            @component('components.subtitle')
                                                {{trans('sponsor.subtitle.promotion_ad_media_link')}} 30 {{trans('sponsor.second')}}   ｜ {{trans('sponsor.cloud.only_url')}}
                                            @endcomponent
                                            <input type="url" v-model="formData.advence.promotion_ad_media_link" class="form-control my-2" id="promotion_ad_media_link" placeholder="{{trans('sponsor.cloud.only_url')}}">
                                            <a v-if="formData.advence.promotion_ad_media_link" :href="formData.advence.promotion_ad_media_link" class="badge badge-info mb-2 p-2" target="_blank">
                                                @{{ formData.advence.promotion_ad_media_link }}
                                            </a>
                                        </div>-->
                                        <!--<h5>{{trans('sponsor.advance.gather_town')}}</h5>
                                        <div class="form-group">
                                            <label for="promotion_gather_town_h_link">{{trans('sponsor.advance.promotion_gather_town_h_link')}}</label>
                                            @component('components.subtitle')
                                                {{trans('sponsor.subtitle.promotion_gather_town_h_link')}}
                                            @endcomponent
                                            <input type="url" v-model="formData.advence.promotion_gather_town_h_link" class="form-control my-2" id="promotion_gather_town_h_link" placeholder="{{trans('sponsor.cloud.only_url')}}">
                                            <a v-if="formData.advence.promotion_gather_town_h_link" :href="formData.advence.promotion_gather_town_h_link" class="badge badge-info mb-2 p-2" target="_blank">
                                                @{{ formData.advence.promotion_gather_town_h_link }}
                                            </a>
                                        </div>
                                        <div class="form-group">
                                            <label for="promotion_gather_town_v_link">{{trans('sponsor.advance.promotion_gather_town_v_link')}}</label>
                                            @component('components.subtitle')
                                                {{trans('sponsor.subtitle.promotion_gather_town_v_link')}}
                                            @endcomponent
                                            <input type="url" v-model="formData.advence.promotion_gather_town_v_link" class="form-control my-2" id="promotion_gather_town_v_link" placeholder="{{trans('sponsor.cloud.only_url')}}">
                                            <a v-if="formData.advence.promotion_gather_town_v_link" :href="formData.advence.promotion_gather_town_v_link" class="badge badge-info mb-2 p-2" target="_blank">
                                                @{{ formData.advence.promotion_gather_town_v_link }}
                                            </a>
                                        </div>
                                        <div class="form-group">
                                            <label for="promotion_gather_town_video_link">{{trans('sponsor.advance.promotion_gather_town_video_link')}}</label>
                                            @component('components.subtitle')
                                                {{trans('sponsor.subtitle.promotion_gather_town_video_link')}}
                                            @endcomponent
                                            <input type="url" v-model="formData.advence.promotion_gather_town_video_link" class="form-control my-2" id="promotion_gather_town_video_link" placeholder="{{trans('sponsor.cloud.only_url')}}">
                                            <a v-if="formData.advence.promotion_gather_town_video_link" :href="formData.advence.promotion_gather_town_video_link" class="badge badge-info mb-2 p-2" target="_blank">
                                                @{{ formData.advence.promotion_gather_town_video_link }}
                                            </a>
                                            <input type="url" v-model="formData.advence.promotion_gather_town_video_link_0" class="form-control my-2" id="promotion_gather_town_video_link_0" placeholder="{{trans('sponsor.cloud.only_url')}}">
                                            <a v-if="formData.advence.promotion_gather_town_video_link_0" :href="formData.advence.promotion_gather_town_video_link_0" class="badge badge-info mb-2 p-2" target="_blank">
                                                @{{ formData.advence.promotion_gather_town_video_link_0 }}
                                            </a>
                                            <input type="url" v-model="formData.advence.promotion_gather_town_video_link_1" class="form-control my-2" id="promotion_gather_town_video_link_1" placeholder="{{trans('sponsor.cloud.only_url')}}">
                                            <a v-if="formData.advence.promotion_gather_town_video_link_1" :href="formData.advence.promotion_gather_town_video_link_1" class="badge badge-info mb-2 p-2" target="_blank">
                                                @{{ formData.advence.promotion_gather_town_video_link_1 }}
                                            </a>
                                        </div>-->
                                        <h5>{{trans('sponsor.advance.email_before_start')}}</h5>
                                        <div class="form-group">
                                            <label for="promotion_email_short">{{trans('sponsor.advance.promotion_email_short')}}</label>
                                            @component('components.subtitle')
                                                {{trans('sponsor.subtitle.promotion_email_short')}}
                                            @endcomponent
                                            <textarea class="form-control" id="promotion_email_short" rows="4" v-model="formData.advence.promotion_email_short"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="promotion_email_url">{{trans('sponsor.advance.promotion_email_url')}}</label>
                                            @component('components.subtitle')
                                                {{trans('sponsor.subtitle.promotion_email_url')}} ｜ {{trans('sponsor.cloud.only_url')}}
                                            @endcomponent
                                            <input type="url" v-model="formData.advence.promotion_email_url" class="form-control my-2" id="promotion_email_url" placeholder="{{trans('sponsor.cloud.only_url')}}">
                                            <a v-if="formData.advence.promotion_email_url" :href="formData.advence.promotion_email_url" class="badge badge-info mb-2 p-2" target="_blank">
                                                @{{ formData.advence.promotion_email_url }}
                                            </a>
                                        </div>
                                        <div class="form-group">
                                            <label for="promotion_email_image">{{trans('sponsor.advance.promotion_email_image')}}</label>
                                            @component('components.subtitle')
                                                {{trans('sponsor.cloud.only_url')}}
                                            @endcomponent
                                            <input type="url" v-model="formData.advence.promotion_email_image" class="form-control my-2" id="promotion_email_image" placeholder="{{trans('sponsor.cloud.only_url')}}">
                                            <a v-if="formData.advence.promotion_email_image" :href="formData.advence.promotion_email_image" class="badge badge-info mb-2 p-2" target="_blank">
                                                @{{ formData.advence.promotion_email_image }}
                                            </a>
                                        </div>
                                        <h5>{{trans('sponsor.advance.app_push_before_start')}}</h5>
                                        <div class="form-group">
                                            <label for="promotion_app_push_image_link">{{trans('sponsor.advance.promotion_app_push_image_link')}}</label>
                                            @component('components.subtitle')
                                                {{trans('sponsor.cloud.only_url')}}
                                            @endcomponent
                                            <input type="url" v-model="formData.advence.promotion_app_push_image_link" class="form-control my-2" id="promotion_app_push_image_link" placeholder="{{trans('sponsor.cloud.only_url')}}">
                                            <a v-if="formData.advence.promotion_app_push_image_link" :href="formData.advence.promotion_app_push_image_link" class="badge badge-info mb-2 p-2" target="_blank">
                                                @{{ formData.advence.promotion_app_push_image_link }}
                                            </a>
                                        </div>
                                        <div class="form-group">
                                            <label for="promotion_app_push_title">{{trans('sponsor.advance.promotion_app_push_title')}}</label>
                                            <input type="text" class="form-control" id="promotion_app_push_title" placeholder="{{trans('sponsor.cloud.only_url')}}" v-model="formData.advence.promotion_app_push_title" >
                                        </div>
                                        <div class="form-group">
                                            <label for="promotion_app_push_content">{{trans('sponsor.advance.promotion_app_push_content')}}</label>
                                            <textarea class="form-control" id="promotion_app_push_content" rows="4" v-model="formData.advence.promotion_app_push_content"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="promotion_app_push_link">{{trans('sponsor.advance.promotion_app_push_link')}}</label>
                                            <input type="url" v-model="formData.advence.promotion_app_push_link" class="form-control my-2" id="promotion_app_push_link" placeholder="{{trans('sponsor.subtitle.promotion_app_push_link') | trans('sponsor.cloud.only_url')}}">
                                            <a v-if="formData.advence.promotion_app_push_link" :href="formData.advence.promotion_app_push_link" class="badge badge-info mb-2 p-2" target="_blank">
                                                @{{ formData.advence.promotion_app_push_link }}
                                            </a>
                                        </div>
                                        <!--<div class="form-group">
                                            <label for="keynoteIntroduction">{{trans('sponsor.advance.keynote')}}</label>
                                            @component('components.subtitle')
                                                {{trans('sponsor.subtitle.keynote')}}
                                            @endcomponent
                                            <textarea class="form-control" id="keynoteIntroduction" rows="4" v-model="formData.advence.advence_keynote"></textarea>
                                        </div>-->
                                        
                                    </div>
                                </div>
                                <div class="card my-2" v-else-if="formData.advence.sponsor_type === 2">
                                    <div class="card-header" >
                                        {{trans('sponsor.advance.sponsor_type')}}：{{trans('sponsor.advance.hacker')}}
                                    </div>
                                    <div class="card-body">
                                        <!--<div class="form-group">
                                            <label for="promotion_ad_media_link">{{trans('sponsor.advance.promotion_ad_media_link')}} 15 {{trans('sponsor.second')}}</label>
                                            @component('components.subtitle')
                                                {{trans('sponsor.subtitle.promotion_ad_media_link')}} 15 {{trans('sponsor.second')}}   ｜ {{trans('sponsor.cloud.only_url')}}
                                            @endcomponent
                                            <input type="url" v-model="formData.advence.promotion_ad_media_link" class="form-control my-2" id="promotion_ad_media_link" placeholder="{{trans('sponsor.cloud.only_url')}}">
                                            <a v-if="formData.advence.promotion_ad_media_link" :href="formData.advence.promotion_ad_media_link" class="badge badge-info mb-2 p-2" target="_blank">
                                                @{{ formData.advence.promotion_ad_media_link }}
                                            </a>
                                        </div>-->
                                        <!--<h5>{{trans('sponsor.advance.email_before_start')}}</h5>
                                        <div class="form-group">
                                            <label for="promotion_email_short">{{trans('sponsor.advance.promotion_email_short')}}</label>
                                            @component('components.subtitle')
                                                {{trans('sponsor.subtitle.promotion_email_short')}}
                                            @endcomponent
                                            <textarea class="form-control" id="promotion_email_short" rows="4" v-model="formData.advence.promotion_email_short"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="promotion_email_url">{{trans('sponsor.advance.promotion_email_url')}}</label>
                                            @component('components.subtitle')
                                                {{trans('sponsor.subtitle.promotion_email_url')}} ｜ {{trans('sponsor.cloud.only_url')}}
                                            @endcomponent
                                            <input type="url" v-model="formData.advence.promotion_email_url" class="form-control my-2" id="promotion_email_url" placeholder="{{trans('sponsor.cloud.only_url')}}">
                                            <a v-if="formData.advence.promotion_email_url" :href="formData.advence.promotion_email_url" class="badge badge-info mb-2 p-2" target="_blank">
                                                @{{ formData.advence.promotion_email_url }}
                                            </a>
                                        </div>
                                        <div class="form-group">
                                            <label for="promotion_email_image">{{trans('sponsor.advance.promotion_email_image')}}</label>
                                            @component('components.subtitle')
                                                {{trans('sponsor.cloud.only_url')}}
                                            @endcomponent
                                            <input type="url" v-model="formData.advence.promotion_email_image" class="form-control my-2" id="promotion_email_image" placeholder="{{trans('sponsor.cloud.only_url')}}">
                                            <a v-if="formData.advence.promotion_email_image" :href="formData.advence.promotion_email_image" class="badge badge-info mb-2 p-2" target="_blank">
                                                @{{ formData.advence.promotion_email_image }}
                                            </a>
                                        </div>-->
                                        <div class="form-group">
                                            <label for="advence_hall_flag_path">{{trans('sponsor.advance.hall_flag')}}</label>
                                            @component('components.subtitle')
                                                {{trans('sponsor.subtitle.hall_flag')}}
                                            @endcomponent
                                            <input type="file" class="form-control-file" id="advence_hall_flag_path" @change="imagePreview('advence_hall_flag_path')">
                                            <img class="mt-2" :src="formData.advence.advence_hall_flag_path" width="200px">
                                            <input type="url" v-model="formData.advence.cloud_advence_hall_flag_path" class="form-control my-2" id="cloud_advence_hall_flag_path" placeholder="{{trans('sponsor.cloud.link')}}({{trans('sponsor.cloud.description')}})" @change="linkDirect('cloud_advence_hall_flag_path')">
                                            @component('components.subtitle')
                                                {{trans('sponsor.cloud.error')}}
                                            @endcomponent
                                            <a v-if="formData.advence.cloud_advence_hall_flag_path !== null" :href="formData.advence.cloud_advence_hall_flag_path" class="badge badge-info mb-2 p-2" target="_blank">
                                                @{{ formData.advence.cloud_advence_hall_flag_path }}
                                            </a>
                                        </div>
                                        <div class="form-group">
                                            <label for="advence_main_flow_flag_path">{{trans('sponsor.advance.main_flow_flag')}}</label>
                                            @component('components.subtitle')
                                                {{trans('sponsor.subtitle.main_flow_flag')}}
                                            @endcomponent
                                            <input type="file" class="form-control-file" id="advence_main_flow_flag_path" @change="imagePreview('advence_main_flow_flag_path')">
                                            <img class="mt-2" :src="formData.advence.advence_main_flow_flag_path" width="200px">
                                            <input type="url" v-model="formData.advence.cloud_advence_main_flow_flag_path" class="form-control my-2" id="cloud_advence_main_flow_flag_path" placeholder="{{trans('sponsor.cloud.link')}}({{trans('sponsor.cloud.description')}})" @change="linkDirect('cloud_advence_main_flow_flag_path')">
                                            @component('components.subtitle')
                                                {{trans('sponsor.cloud.error')}}
                                            @endcomponent
                                            <a v-if="formData.advence.cloud_advence_main_flow_flag_path !== null" :href="formData.advence.cloud_advence_main_flow_flag_path" class="badge badge-info mb-2 p-2" target="_blank">
                                                @{{ formData.advence.cloud_advence_main_flow_flag_path }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="card my-2" v-else-if="formData.advence.sponsor_type === 3">
                                    <div class="card-header" >
                                        {{trans('sponsor.advance.sponsor_type')}}：{{trans('sponsor.advance.developer')}}
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="promotion_ad_media_link">{{trans('sponsor.advance.promotion_ad_media_link')}} 5 {{trans('sponsor.second')}}</label>
                                            @component('components.subtitle')
                                                {{trans('sponsor.subtitle.promotion_ad_media_link')}} 5 {{trans('sponsor.second')}}   ｜ {{trans('sponsor.cloud.only_url')}}
                                            @endcomponent
                                            <input type="url" v-model="formData.advence.promotion_ad_media_link" class="form-control my-2" id="promotion_ad_media_link" placeholder="{{trans('sponsor.cloud.only_url')}}">
                                            <a v-if="formData.advence.promotion_ad_media_link" :href="formData.advence.promotion_ad_media_link" class="badge badge-info mb-2 p-2" target="_blank">
                                                @{{ formData.advence.promotion_ad_media_link }}
                                            </a>
                                        </div>
                                    </div>
                                </div> -->
                                <input type="hidden" class="send" name="password" v-model="password">
                                <button id="formSubmit" class="btn btn-primary btn-block my-4" type="submit" @click.prevent="validationForm()">{{trans('sponsor.submit')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.min.js"></script>
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
                    <label for="access_screct">${'{{ trans('sponsor.password') }}'}</label>
                    <input type="password" class="form-control" id="access_screct" name="password" v-model="password" @key.enter="accesskey_method()">
                </div>
                <div id="vali" class="my-2"></div>
                <input id="access_send" type='submit' class="btn btn-primary float-right" value="${'{{ trans('sponsor.submit') }}'}" @click.prevent="accesskey_method()"/>
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
                formData: {
                    main: {},
                    recipe: {},
                    advence: {},
                },
                introTextConunt: 250,
                productionTextConunt: 250,
                dinnerPartyIntroTextConunt: 80,
            },
            methods: {
                getSponsorForm: function (password) {
                    const vm = this;
                    if (vm.show) {
                        vm.alertShow = false;
                    }
                    vm.password = password;
                    axios.post('/sponsor/{{$main['access_key']}}', {
                        'password':  vm.password,
                    }).then((response) => {
                        if (response.data.success) {
                            vm.formData = response.data.data;
                            vm.show = false;
                            vm.countText(250, 'introTextConunt', vm.formData.main.introduction);
                            vm.countText(250, 'productionTextConunt', vm.formData.main.production);
                            vm.countText(80, 'dinnerPartyIntroTextConunt', vm.formData.main.opening_remarks);
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
                sendform() {
                    const vm = this;
                    let sendFormData = vm.formData;
                    let postData = new FormData();
                    const reg = new RegExp('_path');
                    const cloud_reg = new RegExp('cloud_');
                    Object.keys(sendFormData).forEach((category) => {
                        Object.keys(sendFormData[category]).forEach((ele, index) => {
                            if(sendFormData[category][ele] !== undefined || sendFormData[category][ele] !== null){
                                if (ele.match(reg) !== null && ele.match(cloud_reg) === null) {
                                    const fileInput = document.getElementById(ele);
                                    if (fileInput) {
                                        if (fileInput.files.length > 0){
                                            postData.set(ele, fileInput.files[0]);
                                        }
                                    }
                                } else if (ele.match(reg) !== null && ele.match(cloud_reg) !== null) {
                                    if (sendFormData[category][ele] === null) {
                                        delete sendFormData[category][ele];
                                    } else {
                                        postData.set(ele, sendFormData[category][ele]);
                                    }
                                } else if (ele === 'social_media') {
                                    if (sendFormData[category][ele] === null) {
                                        delete sendFormData[category][ele];
                                    } else {
                                        postData.set(ele, sendFormData[category][ele]);
                                    }
                                } else if (sendFormData[category][ele] !== null){
                                    postData.set(ele, sendFormData[category][ele]);
                                } else {
                                    delete sendFormData[category][ele];
                                }
                            }
                        })
                    })
                    postData.set('password', vm.password);
                    postData.set('_method', 'PUT');
                    axios.post('/sponsor/{{$main['access_key']}}', postData)
                        .then((response) => {
                            vm.alertShow = true;
                            vm.classColor = 'alert-success';
                            vm.message = '{{ trans('sponsor.success_message') }}';
                            vm.getSponsorForm(vm.password);
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
                            vm.message = '{{ trans('sponsor.fail_message') }}';
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
                    document.getElementById('cloud_' + inputId).value = null;
                    const vm = this;
                    const advence = new RegExp('advence_');
                    if (inputId.match(advence) !== null) {
                        vm.formData.advence['cloud_' + inputId] = null;
                    } else {
                        vm.formData.main['cloud_' + inputId] = null;
                    }
                },
                linkDirect(inputId) {
                    const link = $('#' + inputId);
                    link.siblings('a').text(link.val()).attr('href', link.val());
                    const reg = /(cloud_)/;
                    const fileId = inputId.replace(reg, '');
                    document.getElementById(fileId).value = null; // 清掉 input file
                    const vm = this;
                    const advence = new RegExp('advence_');
                    if (inputId.match(advence) !== null || inputId.match(advence) !== '') {
                        vm.formData.advence[fileId] = null;
                    } else {
                        vm.formData.main[fileId] = null;
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

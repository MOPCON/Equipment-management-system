<template>
    <div class="container-fluid">
        <h1>
            贊助商清單
            <small>Sponsor List</small>
        </h1>
        <div class="row justify-content-end mb-3">
            <div class="col-md-2">
                <button type="button" class="btn btn-sm btn-primary btn-block" @click="openAddSponsor()">
                    <font-awesome-icon icon="plus" />&nbsp;建立新贊助商
                </button>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-sm btn-primary btn-block" @click="exportData()">
                    <font-awesome-icon icon="file-export" />&nbsp;匯出
                </button>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control form-control-sm" placeholder="Search" aria-controls="sponsor" 
                v-model="searchText" @keyup.enter="searchKeyword($event)" />
            </div>
        </div>
        <div class="row mb-3 form-inline px-3">
            <div class="col-md-6 form-check justify-content-start">
                <input type="checkbox" class="form-check-input" id="chooseAll" @change="toggleSelect">
                <label class="form-check-label" for="chooseAll">全選 / 取消全選</label>
            </div>
            <label class="form-check-label ml-auto mr-4">篩選：</label>
            <div class="form-check justify-content-end">
                <label class="form-check-label mr-2" for="filterYear">年份</label>
                <select name="filterYear" id="filterYear" class="form-control" v-model="filter.year">
                    <option :value="year" v-for="year in participateYear" :key="`filter-year-${year}`">
                        {{ year }}
                    </option>
                </select>
            </div>
            <div class="mx-4 form-check justify-content-end">
                <label class="form-check-label mr-2" for="filterStatus">狀態</label>
                <select name="filterStatus" id="filterStatus" class="form-control" v-model="filter.status">
                    <option :value="undefined">請選擇</option>
                    <option :value="index" v-for="(status, index) in sponsorOption.sponsorStatusItem" :key="`filter-status-${index}`">
                        {{ status }}
                    </option>
                </select>
            </div>
            <div class="form-check justify-content-end">
                <label class="form-check-label mr-2" for="filterType">等級</label>
                <select name="filterType" id="filterType" class="form-control" v-model="filter.type">
                    <option :value="undefined">請選擇</option>
                    <option :value="index" v-for="(type, index) in sponsorOption.sponsorTypeItem" :key="`filter-type-${index}`">
                        {{ type }}
                    </option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped dataTable" role="grid" aria-describedby="staff_info">
                        <thead>
                            <tr role="row">
                                <th v-for="row in col" class="sortfield" tabindex="0"
                                    :class="{ 'th-width-custom-500': (row.key == 'intro')}" :key="`table-title-${row.key}`">
                                    {{ row.name }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in fullData" :key="item.access_key">
                                <td><input type="checkbox" class="sponsor-check" v-model="item.checkbox" :id="item.id"></td>
                                <td>{{ item.name }}</td>
                                <td v-if="item.introduction !== null">{{ item.introduction.substring(0,50) + '...' }}</td>
                                <td v-else>{{ item.introduction }}</td>
                                <td>{{ item.recipe_contact_name }}</td>
                                <td>{{ item.updated_at }}</td>
                                <td v-if="item.sponsor_status_text !== ''">{{ item.sponsor_status_text }}</td>
                                <td v-else>待確認</td>
                                <td>{{ item.sponsor_type_text }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" @click.prevent="getSponsorDetail(item.id)">
                                        詳細
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-5">
                <div class="dataTables_info" id="group_info" role="status" aria-live="polite">
                    每頁顯示 {{ page_info.limit }} 筆資料，共 {{ page_info.total }} 筆
                </div>
            </div>
            <div class="col-12 col-sm-7">
                <Pagination :pageInfo="page_info" @onChangePage="onChangePage"/>
            </div>
        </div>
        <Modal target="sponsorModal" size="lg">
            <template v-slot:title>
                <h4 v-if="action == 'new'" class="modal-title">建立贊助商</h4>
                <h4 v-if="action == 'detail'" class="modal-title">贊助商詳細資料</h4>
            </template>
            <template v-slot:header>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="resetStep()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </template>
            <template v-slot:body>
                <form v-if="action == 'new'" name="addSponsor">
                    <div v-if="step == 1">
                        <div class="form-group">
                            <label for="sponsorName">贊助商名稱</label>
                            <input type="text" class="form-control" id="sponsorName" placeholder="贊助商名稱" v-model="createSponsorData.name">
                        </div>
                        <div class="form-group">
                            <label for="recipe_amount">贊助金額</label>
                            <input type="number" class="form-control" id="recipe_amount" v-model="createSponsorData.recipe_amount" min="0">
                        </div>
                        <div class="form-group">
                            <label for="sponsorType">類型</label>
                            <select class="form-control" id="sponsorType"  v-model="createSponsorData.type">
                                <option v-for="(type, index) in sponsorOption.sponsorTypeItem"
                                :key="`addsponsor-type-${index}`" :value="index">{{ type }}</option>
                            </select>
                        </div>
                    </div>
                    <div v-if="step == 2">
                        <h3 class="mb-3 text-center">贊助商專屬表單已建立</h3>
                        <div class="form-group">
                            <label for="sponsor_form_url">連結</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="sponsor_form_url" :value="createSponsorData.external_link">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary copy" type="button" data-clipboard-target="#sponsor_form_url">
                                        <font-awesome-icon icon="copy" />
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sponsor_form_password">Password</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="sponsor_form_password" :value="createSponsorData.access_secret">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary copy" type="button" data-clipboard-target="#sponsor_form_password">
                                        <font-awesome-icon icon="copy" />
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div v-if="action == 'detail'" class="detail-content">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th v-for="row in sponsorDetailcol" :key="`form-title-${row.key}`"
                                class="sortfield" tabindex="0" :class="{ 'th-width-custom-500': (row.key == 'intro')}">
                                    {{ row.name }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th rowspan="14" scope="row" class="text-nowrap">公開宣傳資料</th>
                                <td>id</td>
                                <td>{{ sponsorDetailData.main.id }}</td>
                            </tr>
                            <tr>
                                <td>公司名稱</td>
                                <td class="p-0 v-align-middle">
                                    <input type="text" class="form-control border-0 rounded-0" v-model="sponsorDetailData.main.name">
                                </td>
                            </tr>
                            <tr>
                                <td>公司英文名稱</td>
                                <td class="p-0 v-align-middle">
                                    <input type="text" class="form-control border-0 rounded-0" v-model="sponsorDetailData.main.en_name">
                                </td>
                            </tr>
                            <tr>
                                <td>公司簡介 (專業背景與沿革)</td>
                                <td class="p-0 v-align-middle">
                                    <textarea class="form-control border-0 rounded-0" v-model="sponsorDetailData.main.introduction" maxlength="250" />
                                </td>
                            </tr>
                            <tr>
                                <td>公司英文簡介</td>
                                <td class="p-0 v-align-middle">
                                    <textarea class="form-control border-0 rounded-0" v-model="sponsorDetailData.main.en_introduction" />
                                </td>
                            </tr>
                            <tr>
                                <td>公司網站</td>
                                <td class="p-0 v-align-middle">
                                    <div class="input-group">
                                        <input type="url" class="form-control border-0 rounded-0" id="website" v-model="sponsorDetailData.main.website" @blur="checkUrl('website')">
                                        <div class="input-group-append align-items-center" v-if="sponsorDetailData.main.website !== null && sponsorDetailData.main.website !== ''">
                                            <a :href="sponsorDetailData.main.website" target="_blank" class="btn btn-primary rounded-0">link</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>社群媒體 (如 FB 等)</td>
                                <td class="p-0 v-align-middle">
                                    <div class="input-group">
                                        <input type="url" class="form-control border-0 rounded-0" id="social_media" v-model="sponsorDetailData.main.social_media" @blur="checkUrl('social_media')">
                                        <div class="input-group-append align-items-center" v-if="sponsorDetailData.main.social_media !== null && sponsorDetailData.main.social_media !== ''">
                                            <a :href="sponsorDetailData.main.social_media" target="_blank" class="btn btn-primary rounded-0">link</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>產品及服務介紹 (主要商品、服務、核心能力、技術)</td>
                                <td class="p-0 v-align-middle">
                                    <textarea class="form-control border-0 rounded-0" v-model="sponsorDetailData.main.production" maxlength="250" />
                                </td>
                            </tr>
                            <tr>
                                <td>公司 LOGO (ai 向量圖檔佳)</td>
                                <td>
                                    <a v-if="sponsorDetailData.main.logo_path !== null" download :href="sponsorDetailData.main.logo_path"
                                        target="_blank">下載檔案</a>
                                    <input type="file" name="file" class="form-control-file" id="logo_path" @change="imagePreview('logo_path')">
                                    <label for="cloud_logo_path" class="mt-2">或提供雲端連結：</label>
                                    <input type="url" name="file" class="form-control" id="cloud_logo_path" v-model="sponsorDetailData.main.cloud_logo_path" @change="linkDirect('logo_path')">
                                    <a v-if="sponsorDetailData.main.cloud_logo_path !== null" class="btn btn-primary p-1 mt-2" :href="sponsorDetailData.main.cloud_logo_path" target="_blank">
                                        前往雲端連結
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>產品或服務照片</td>
                                <td>
                                    <img :src="sponsorDetailData.main.service_photo_path" alt="" srcset="" width="120px"><br>
                                    <a v-if="sponsorDetailData.main.service_photo_path !== null" download :href="sponsorDetailData.main.service_photo_path"
                                        target="_blank">下載檔案</a>
                                    <input type="file" name="file" class="form-control-file" id="service_photo_path" @change="imagePreview('service_photo_path')">
                                    <label for="cloud_service_photo_path" class="mt-2">或提供雲端連結：</label>
                                    <input type="url" name="file" class="form-control" id="cloud_service_photo_path" v-model="sponsorDetailData.main.cloud_service_photo_path" @change="linkDirect('cloud_service_photo_path')">
                                    <a v-if="sponsorDetailData.main.cloud_service_photo_path !== null" class="btn btn-primary p-1 mt-2" :href="sponsorDetailData.main.cloud_service_photo_path" target="_blank">
                                        前往雲端連結
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>希望 MOPCON 宣傳的內容，我們將於 FB 等社群分享。</td>
                                <td class="p-0 v-align-middle">
                                    <textarea class="form-control border-0 rounded-0" v-model="sponsorDetailData.main.promote" />
                                </td>
                            </tr>
                            <tr>
                                <td>場間投影片 (建議 1920x1080px 圖檔)</td>
                                <td>
                                    <img :src="sponsorDetailData.main.slide_path" alt="" srcset="" width="120px"><br>
                                    <a v-if="sponsorDetailData.main.slide_path !== null" download :href="sponsorDetailData.main.slide_path"
                                        target="_blank">下載檔案</a>
                                    <input type="file" name="file" class="form-control-file" id="slide_path" @change="imagePreview('slide_path')">
                                    <label for="cloud_slide_path" class="mt-2">或提供雲端連結：</label>
                                    <input type="url" name="file" class="form-control" id="cloud_slide_path" v-model="sponsorDetailData.main.cloud_slide_path" @change="linkDirect('cloud_slide_path')">
                                    <a v-if="sponsorDetailData.main.cloud_slide_path !== null" class="btn btn-primary p-1 mt-2" :href="sponsorDetailData.main.cloud_slide_path" target="_blank">
                                        前往雲端連結
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>電子看板 (建議 1920x1080px 圖檔) </td>
                                <td>
                                    <img :src="sponsorDetailData.main.board_path" alt="" srcset="" width="120px"><br>
                                    <a v-if="sponsorDetailData.main.board_path !== null" download :href="sponsorDetailData.main.board_path"
                                      target="_blank">下載檔案</a>
                                    <input type="file" name="file" class="form-control-file" id="board_path" @change="imagePreview('board_path')">
                                    <label for="cloud_board_path" class="mt-2">或提供雲端連結：</label>
                                    <input type="url" name="file" class="form-control" id="cloud_board_path" v-model="sponsorDetailData.main.cloud_board_path" @change="linkDirect('cloud_board_path')">
                                    <a v-if="sponsorDetailData.main.cloud_board_path !== null" class="btn btn-primary p-1 mt-2" :href="sponsorDetailData.main.cloud_board_path" target="_blank">
                                        前往雲端連結
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>晚宴簡介 (於晚宴中將由主持人介紹貴公司)</td>
                                <td class="p-0 v-align-middle">
                                    <textarea class="form-control border-0 rounded-0" v-model="sponsorDetailData.main.opening_remarks" maxlength="80" />
                                </td>
                            </tr>
                            <tr>
                                <th rowspan="8" scope="row" class="text-nowrap">開立收據資料</th>
                                <td>公司 / 組織全銜</td>
                                <td class="p-0 v-align-middle">
                                    <input type="text" class="form-control border-0 rounded-0" v-model="sponsorDetailData.recipe.recipe_full_name">
                                </td>
                            </tr>
                            <tr>
                                <td>統一編號</td>
                                <td class="p-0 v-align-middle">
                                    <input type="number" class="form-control border-0 rounded-0" v-model="sponsorDetailData.recipe.recipe_tax_id_number" oninput="if(value.length>8)value=value.slice(0,8)">
                                </td>
                            </tr>
                            <tr>
                                <td>贊助金額</td>
                                <td class="p-0 v-align-middle">
                                    <input type="number" class="form-control border-0 rounded-0" v-model="sponsorDetailData.recipe.recipe_amount" min="0">
                                </td>
                            </tr>
                            <tr>
                                <td>聯絡人姓名</td>
                                <td class="p-0 v-align-middle">
                                    <input type="text" class="form-control border-0 rounded-0" v-model="sponsorDetailData.recipe.recipe_contact_name">
                                </td>
                            </tr>
                            <tr>
                                <td>聯絡人職稱</td>
                                <td class="p-0 v-align-middle">
                                    <input type="text" class="form-control border-0 rounded-0" v-model="sponsorDetailData.recipe.recipe_contact_title">
                                </td>
                            </tr>
                            <tr>
                                <td>聯絡人電話</td>
                                <td class="p-0 v-align-middle">
                                    <input type="text" class="form-control border-0 rounded-0" v-model="sponsorDetailData.recipe.recipe_contact_phone">
                                </td>
                            </tr>
                            <tr>
                                <td>聯絡人 Email</td>
                                <td class="p-0 v-align-middle">
                                    <input type="email" class="form-control border-0 rounded-0" v-model="sponsorDetailData.recipe.recipe_contact_email">
                                </td>
                            </tr>
                            <tr>
                                <td>收件地址</td>
                                <td class="p-0 v-align-middle">
                                    <input type="text" class="form-control border-0 rounded-0" v-model="sponsorDetailData.recipe.recipe_contact_address">
                                </td>
                            </tr>
                            <tr>
                                <td rowspan="3"></td>
                                <td>為什麼本次選擇贊助 MOPCON？</td>
                                <td class="p-0 v-align-middle">
                                    <textarea class="form-control border-0 rounded-0" v-model="sponsorDetailData.main.reason" />
                                </td>
                            </tr>
                            <tr>
                                <td>希望能在本次大會達成的目標</td>
                                <td class="p-0 v-align-middle">
                                    <textarea class="form-control border-0 rounded-0" v-model="sponsorDetailData.main.purpose" />
                                </td>
                            </tr>
                            <tr>
                                <td>備註</td>
                                <td class="p-0 v-align-middle">
                                    <textarea class="form-control border-0 rounded-0" v-model="sponsorDetailData.main.remark" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered" v-if="sponsorDetailData.advence.sponsor_type !== 3 && sponsorDetailData.advence.sponsor_type !== 4">
                        <thead>
                            <tr>
                                <th v-for="row in sponsorAdvancedDetailcol" :key="`form-subtitle-${row.key}`" class="sortfield" tabindex="0">
                                    {{ row.name }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="sponsorDetailData.advence.sponsor_type === 0">
                                <td rowspan="5">{{ sponsorDetailData.advence.sponsor_type_text }}</td>
                                <td>ICCK大門兩側廣告</td>
                                <td>
                                    <img :src="sponsorDetailData.advence.advence_icck_ad_path" alt="" srcset="" width="120px"><br>
                                    <a v-if="sponsorDetailData.advence.advence_icck_ad_path !== null" download :href="sponsorDetailData.advence.advence_icck_ad_path"
                                        target="_blank">下載檔案</a>
                                    <input type="file" name="file" class="form-control-file" id="advence_icck_ad_path" @change="imagePreview('advence_icck_ad_path')">
                                    <label for="cloud_advence_icck_ad_path" class="mt-2">或提供雲端連結：</label>
                                    <input type="url" name="file" class="form-control" id="cloud_advence_icck_ad_path" v-model="sponsorDetailData.advence.cloud_advence_icck_ad_path" @change="linkDirect('cloud_advence_icck_ad_path')">
                                    <a v-if="sponsorDetailData.advence.cloud_advence_icck_ad_path !== null" class="btn btn-primary p-1 mt-2" :href="sponsorDetailData.advence.cloud_advence_icck_ad_path" target="_blank">
                                        前往雲端連結
                                    </a>
                                </td>
                            </tr>
                            <tr v-if="sponsorDetailData.advence.sponsor_type === 0">
                                <td>報到處全版廣告空間</td>
                                <td>
                                    <img :src="sponsorDetailData.advence.advence_registration_ad_path" alt="" srcset="" width="120px"><br>
                                    <a v-if="sponsorDetailData.advence.advence_registration_ad_path !== null" download :href="sponsorDetailData.advence.advence_registration_ad_path"
                                        target="_blank">下載檔案</a>
                                    <input type="file" name="file" class="form-control-file" id="advence_registration_ad_path" @change="imagePreview('advence_registration_ad_path')">
                                    <label for="cloud_advence_registration_ad_path" class="mt-2">或提供雲端連結：</label>
                                    <input type="url" name="file" class="form-control" id="cloud_advence_registration_ad_path" v-model="sponsorDetailData.advence.cloud_advence_registration_ad_path" @change="linkDirect('cloud_advence_registration_ad_path')">
                                    <a v-if="sponsorDetailData.advence.cloud_advence_registration_ad_path !== null" class="btn btn-primary p-1 mt-2" :href="sponsorDetailData.advence.cloud_advence_registration_ad_path" target="_blank">
                                        前往雲端連結
                                    </a>
                                </td>
                            </tr>
                            <tr v-if="sponsorDetailData.advence.sponsor_type === 0 || sponsorDetailData.advence.sponsor_type === 1">
                                <td rowspan="3" v-if="sponsorDetailData.advence.sponsor_type === 1">{{ sponsorDetailData.advence.sponsor_type_text }}</td>
                                <td>Keynote 引言</td>
                                <td class="p-0 v-align-middle">
                                    <textarea class="form-control border-0 rounded-0" v-model="sponsorDetailData.advence.advence_keynote" />
                                </td>
                            </tr>
                            <tr v-if="sponsorDetailData.advence.sponsor_type === 0 || sponsorDetailData.advence.sponsor_type === 1 || sponsorDetailData.advence.sponsor_type === 2">
                                <td rowspan="2" v-if="sponsorDetailData.advence.sponsor_type === 2">{{ sponsorDetailData.advence.sponsor_type_text }}</td>
                                <td>演講廳旗幟</td>
                                <td>
                                    <img :src="sponsorDetailData.advence.advence_hall_flag_path" alt="" srcset="" width="120px"><br>
                                    <a v-if="sponsorDetailData.advence.advence_hall_flag_path !== null" download :href="sponsorDetailData.advence.advence_hall_flag_path"
                                        target="_blank">下載檔案</a>
                                    <input type="file" name="file" class="form-control-file" id="advence_hall_flag_path" @change="imagePreview('advence_hall_flag_path')">
                                    <label for="cloud_advence_hall_flag_path" class="mt-2">或提供雲端連結：</label>
                                    <input type="url" name="file" class="form-control" id="cloud_advence_hall_flag_path" v-model="sponsorDetailData.advence.cloud_advence_hall_flag_path" @change="linkDirect('cloud_advence_hall_flag_path')">
                                    <a v-if="sponsorDetailData.advence.cloud_advence_hall_flag_path !== null" class="btn btn-primary p-1 mt-2" :href="sponsorDetailData.advence.cloud_advence_hall_flag_path" target="_blank">
                                        前往雲端連結
                                    </a>
                                </td>
                            </tr>
                            <tr v-if="sponsorDetailData.advence.sponsor_type === 0 || sponsorDetailData.advence.sponsor_type === 1 || sponsorDetailData.advence.sponsor_type === 2">
                                <td>主動線旗幟廣告</td>
                                <td>
                                    <img :src="sponsorDetailData.advence.advence_main_flow_flag_path" alt="" srcset="" width="120px"><br>
                                    <a v-if="sponsorDetailData.advence.advence_main_flow_flag_path !== null" download :href="sponsorDetailData.advence.advence_main_flow_flag_path" target="_blank">下載檔案</a>
                                    <input type="file" name="file" class="form-control-file" id="advence_main_flow_flag_path" @change="imagePreview('advence_main_flow_flag_path')">
                                    <label for="cloud_advence_main_flow_flag_path" class="mt-2">或提供雲端連結：</label>
                                    <input type="url" name="file" class="form-control" id="cloud_advence_main_flow_flag_path" v-model="sponsorDetailData.advence.cloud_advence_main_flow_flag_path" @change="linkDirect('cloud_advence_main_flow_flag_path')">
                                    <a v-if="sponsorDetailData.advence.cloud_advence_main_flow_flag_path !== null" class="btn btn-primary p-1 mt-2" :href="sponsorDetailData.advence.cloud_advence_main_flow_flag_path" target="_blank">
                                        前往雲端連結
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <h5>操作</h5>
                    <fieldset class="form-group mb-0">
                      <div class="row">
                        <legend class="col-form-label col-sm-2 pt-0">修改狀態</legend>
                        <div class="col-sm-10">
                          <div class="form-check form-check-inline" v-for="(item, index) in sponsorOption.sponsorStatusItem" :key="`sponsorstatus-${item}`">
                            <input class="form-check-input" type="radio" name="editStatus" :id="item" :value="index" v-model="sponsorDetailData.main.sponsor_status">
                            <label class="form-check-label" :for="item">{{ item }}</label>
                          </div>
                        </div>
                      </div>
                    </fieldset>
                    <fieldset class="form-group mb-0">
                      <div class="row">
                        <legend class="col-form-label col-sm-2 pt-0">修改類型</legend>
                        <div class="col-sm-10">
                          <div class="form-check form-check-inline" v-for="(item, index) in sponsorOption.sponsorTypeItem" :key="`sponsortype-${item}`">
                            <input class="form-check-input" type="radio" name="sponsorType" :id="item" :value="index" v-model="sponsorDetailData.advence.sponsor_type">
                            <label class="form-check-label" :for="item">{{ item }}</label>
                          </div>
                        </div>
                      </div>
                    </fieldset>
                    <fieldset class="form-group">
                      <div class="row">
                        <legend class="col-form-label col-sm-2 pt-0">參與年份</legend>
                        <div class="col-sm-10">
                          <div class="form-check form-check-inline" v-for="item in participateYear" :key="`participateYear-${item}`">
                            <input class="form-check-input" type="radio" name="participateYear"
                                :id="item" :value="item" v-model="sponsorDetailData.main.year">
                            <label class="form-check-label" :for="item">{{ item }}</label>
                          </div>
                        </div>
                      </div>
                    </fieldset>
                    <div class="form-group">
                      <label for="remark">備註</label>
                      <textarea class="form-control" id="remark" rows="3" v-model="sponsorDetailData.main.note" />
                    </div>
                    <h5>資訊</h5>
                    <div class="form-group">
                      <label for="sponsor_form_url">連結</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="sponsor_form_url" :value="sponsorDetailData.main.external_link">
                        <div class="input-group-append">
                          <button class="btn btn-outline-primary copy" type="button" data-clipboard-target="#sponsor_form_url">
                            <font-awesome-icon icon="copy" />
                          </button>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="sponsor_form_password">Password</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="sponsor_form_password"
                          :value="sponsorDetailData.main.access_secret">
                        <div class="input-group-append">
                          <button class="btn btn-outline-primary copy" type="button"
                            data-clipboard-target="#sponsor_form_password">
                            <font-awesome-icon icon="copy" />
                          </button>
                        </div>
                      </div>
                    </div>
                    <p class="mb-0">更新日期：{{ sponsorDetailData.main.updated_at }}</p>
                    <p class="mb-0">最後更新者：{{ sponsorDetailData.main.updated_by }}</p>
                </div>
            </template>
            <template v-slot:footer>
                <div v-if="action == 'new'">
                    <div v-if="step == 1">
                        <button type="button" class="btn btn-light" data-dismiss="modal" @click="resetStep()">取消</button>
                        <button type="button" class="btn btn-primary" @click="postSpeakerUrlData()">確認建立</button>
                    </div>
                    <div v-if="step == 2">
                        <button type="button" class="btn btn-primary" data-dismiss="modal"
                            @click="resetStep()">返回清單</button>
                    </div>
                </div>
                <div v-if="action == 'detail'">
                    <button type="button" class="btn btn-primary" @click="updateSpeakerData(sponsorDetailData.main.id)">更新</button>
                    <button type="reset" class="btn btn-light" data-dismiss="modal">返回</button>
                </div>
            </template>
        </Modal>
    </div>
</template>

<script>
    import axios from 'axios';
    import Clipboard from 'clipboard';

    export default {
        data() {
            return {
                action: 'new',
                allSelected: false,
                col: [],
                createSponsorData: {
                    name: '',
                    type: 0,
                    recipe_amount: 0,
                    external_link: '',
                    access_secret: '',
                },
                checkboxSelectedList: [],
                fullData: [],
                page_info: {},
                step: '1',
                sponsorDetailcol: [],
                sponsorAdvancedDetailcol: [],
                sponsorOption: [],
                participateYear: ['2020', '2019'], 
                sponsorDetailData: {
                    main: {},
                    recipe: {},
                    advence: {},
                },
                searchText: '',
                filter: {
                    year: '2020',
                },
            }
        },
        watch: {
            filter: {
                handler(val) {
                    const filterConfig = Object.entries(val).reduce((acc, [key, val]) => {
                        if(val || (typeof val === 'number' && !isNaN(val))) {
                            acc[key] = val
                        }
                        return acc
                    }, {})
                    this.getSponsorData(filterConfig)
                },
                deep: true
            }
        },
        methods: {
            initCol() {
                const vm = this;
                vm.col = [{
                    name: '選取',
                    key: 'choose'
                }, {
                    name: '贊助商名稱',
                    key: 'name'
                }, {
                    name: '簡介',
                    key: 'intro'
                }, {
                    name: '聯絡人',
                    key: 'contact'
                }, {
                    name: '更新日期',
                    key: 'update_date'
                }, {
                    name: '狀態',
                    key: 'status'
                }, {
                    name: '等級',
                    key: 'level'
                }, {
                    name: '查看',
                    key: 'detail'
                }];
                vm.sponsorDetailcol = [{
                    name: '分類',
                    key: 'category'
                }, {
                    name: '欄位名稱',
                    key: 'name'
                }, {
                    name: '內容',
                    key: 'content'
                }];
                vm.sponsorAdvancedDetailcol = [{
                    name: '適用贊助商類型',
                    key: 'to_sponsor_type'
                }, {
                    name: '欄位名稱',
                    key: 'name'
                }, {
                    name: '內容',
                    key: 'content'
                }];
            },
            getSpeakerOption() {
                const vm = this;
                axios.get(
                    'sponsor/get-options'
                ).then(response => {
                    const res = response.data.data;
                    vm.sponsorOption = res;
                }).catch(error => {
                    helper.alert(error.response.data.message, 'danger');
                });
            },
            getSponsorData(filter = this.filter) {
                const vm = this;
                axios.get(
                    `api/sponsor?&page=${vm.page_info.current_page}${vm.searchText ?
                    `&search=${vm.searchText}` : ''}${Object.keys(filter).length ?
                    `&filter=${JSON.stringify(filter)}` : ''}`
                ).then(response => {
                    const res = response.data.data;
                    vm.page_info = {
                        current_page: res.current_page,
                        limit: res.per_page,
                        last_page: res.last_page,
                        total: res.total,
                    }
                    vm.fullData = response.data.data.data;
                }).catch(error => {
                    helper.alert(error.response.data.message, 'danger');
                });
            },
            getSponsorDetail(sponsor_id) {
                const vm = this;
                vm.action = 'detail';
                axios.get(     
                    'api/sponsor/'+ sponsor_id
                ).then(response => {
                const res = response.data.data
                if (res.sponsor_status !== null) {
                    vm.sponsorDetailData = res
                } else {
                    vm.sponsorDetailData = {
                        ...res,
                        main: {
                            sponsor_status: 0,
                        }
                    };
                }
                }).catch(error => {
                    helper.alert(error.response.data.message, 'danger');
                });
                $('#sponsorModal').modal('show');
            },
            postSpeakerUrlData() {
                const vm = this;
                axios.post('api/sponsor', {
                    name: vm.createSponsorData.name,
                    sponsor_type: vm.createSponsorData.type,
                    recipe_amount: vm.createSponsorData.recipe_amount,
                }).then(response => {
                    const res = response.data;
                    if (res.success) {
                        vm.step++;
                        vm.createSponsorData.external_link = res.data.external_link;
                        vm.createSponsorData.access_secret = res.data.access_secret;
                    }
                }).catch(error => {
                    vm.resetStep();
                    $('#sponsorModal').modal('hide');
                    helper.alert(error.response.data.message, 'danger');
                });
            },
            updateSpeakerData(id) {
                const vm = this;
                let updateData = [];
                const bodyFormData = new FormData();
                const reg = new RegExp('_path');
                const cloud_reg = new RegExp('cloud_');
                Object.keys(vm.sponsorDetailData).forEach((category) => {
                    Object.keys(vm.sponsorDetailData[category]).forEach((ele, index) => {
                        const value = vm.sponsorDetailData[category][ele];
                        if (ele.match(reg) !== null && ele.match(cloud_reg) === null){
                            const fileInput = document.getElementById(ele);
                            if (fileInput) {
                                if (fileInput.files.length > 0) {
                                    bodyFormData.set(ele, fileInput.files[0]);
                                }
                            }
                        } else if(ele.match(reg) !== null && ele.match(cloud_reg) !== null) {
                            if (value !== null && value !== '') {
                                bodyFormData.set(ele, value);
                            }
                        } else {
                            if (value !== null && value !== '') {
                                bodyFormData.set(ele, value);
                            } else if (value === '') {
                                bodyFormData.set(ele, value);
                            }
                        }
                    })
                })
                bodyFormData.set('_method', 'PUT')

                axios.post(`api/sponsor/${id}`, bodyFormData).then(response => {
                    const res = response.data;
                    $('#sponsorModal').modal('hide');
                        if (res.success) {
                            helper.alert(res.message, 'success');
                            vm.getSponsorData();
                        } else {
                            helper.alert(res.message, 'danger');
                        }
                }).catch(error => {
                    $('#sponsorModal').modal('hide');
                    helper.alert(error.response.data.message, 'danger');
                });
            },
            checkUrl(key) {
                const vm = this;
                if (!document.getElementById(key).checkValidity()) {
                    document.getElementById(key).value = '';
                    vm.sponsorDetailData.main[key] = '';
                    alert('請輸入 url')
                }
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
                    vm.sponsorDetailData.advence['cloud_' + inputId] = null;
                } else {
                    vm.sponsorDetailData.main['cloud_' + inputId] = null;
                }
            },
            linkDirect(inputId) {
                const link = $('#' + inputId);
                link.siblings('a').attr('href', link.val());
                const reg = /(cloud_)/;
                const fileId = inputId.replace(reg, '');
                document.getElementById(fileId).value = null;
                const vm = this;
                const advence = new RegExp('advence_');
                if (inputId.match(advence) !== null) {
                    vm.sponsorDetailData.advenve[fileId] = null;
                } else {
                    vm.sponsorDetailData.main[fileId] = null;
                }
            },
            openAddSponsor() {
                const vm = this;
                vm.action = 'new';
                $('#sponsorModal').modal('show');
            },
            onChangePage(page) {
                const vm = this;
                vm.page_info.current_page = page;
                vm.getSponsorData();
            },
            searchKeyword(event) {
                const vm = this;
                vm.getSponsorData();
            },
            resetStep() {
                const vm = this;
                vm.createSponsorData.name = '';
                vm.createSponsorData.type = 0;
                vm.step = 1;
                vm.getSponsorData();
            },
            toggleSelect() {
                const vm = this;
                const select = vm.selectAll;
                const checkbox = document.querySelectorAll('.sponsor-check')
                checkbox.forEach((item) => {
                    vm.checkboxSelectedList.push(item.id);
                    item.checked = !select;
                   
                })
                vm.selectAll = !select;
            },
            hasChecked() {
                const checkedId = document.querySelectorAll('.sponsor-check');
                let idArr = '';
                checkedId.forEach((ele) => {
                    if (ele.checked) {
                        idArr += `${ele.id},`
                    }
                });
                return idArr
            },
            exportData() {
                const vm = this;
                let data = vm.hasChecked();
                if (data === '') {
                    const allIds = [];
                    axios.get(
                    'api/sponsor?&limit=' + vm.page_info.total
                    ).then(response => {
                        const sponsorAllData = response.data.data.data
                        sponsorAllData.map(sponsor => allIds.push(sponsor.id))
                        window.location = `api/sponsor/export?ids=${allIds}`;
                    }).catch(error => {
                        helper.alert(error.response.data.message, 'danger');
                    });
                } else {
                    window.location = `api/sponsor/export?ids=${data}`;
                }
            },
        },
        mounted() {
            this.initCol();
            this.getSpeakerOption();
            this.getSponsorData();
            const clipboard = new Clipboard('.copy');
        },
    };
</script>

<style scoped>
.th-width-custom-500 {
    width: 500px;
    max-width: 500px;
}
.v-align-middle {
    vertical-align: middle !important;
}
</style>

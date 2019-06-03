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
                <button type="button" class="btn btn-sm btn-primary btn-block">
                    <font-awesome-icon icon="file-export" />&nbsp;匯出
                </button>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control form-control-sm" placeholder="Search" aria-controls="sponsor" />
            </div>
        </div>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="chooseAll" @click="toggleSelect">
            <label class="form-check-label" for="chooseAll">全選 / 取消全選</label>
        </div>
        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped dataTable" role="grid" aria-describedby="staff_info">
                        <thead>
                            <tr role="row">
                                <th v-for="row in col" class="sortfield" tabindex="0" :class="{ 'th-width-custom-500': (row.key == 'intro')}">
                                    {{ row.name }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in fullData">
                                <td><input type="checkbox" v-model="item.checkbox"></td>
                                <td>{{ item.open_data.company_name }}</td>
                                <td>{{ item.open_data.company_intro }}</td>
                                <td>{{ item.recipe_data.contact_name }}</td>
                                <td>{{ item.update_time }}</td>
                                <td>
                                    <p v-if="item.editStatus === 'checked'">
                                    已確認
                                    </p>
                                    <p v-else-if="item.editStatus === 'checking'">
                                    確認中
                                    </p>
                                    <p v-else-if="item.editStatus === 'unchecked'">
                                    待確認
                                    </p>
                                    <p v-else>
                                    下架
                                    </p>
                                </td>
                                <td>{{ item.sponsor_type.type }}</td>
                                <td>
                                    <button type="button" class="btn btn-primary" @click.prevent="openSponsorDetail(item.sponsor_id)">
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
                    每頁顯示 {{ per_page }} 筆資料，共 {{ page_info.total }} 筆
                </div>
            </div>
            <div class="col-12 col-sm-7">
                <Pagination :pageInfo="page_info" />
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
                            <input type="text" class="form-control" id="sponsorName" placeholder="贊助商名稱">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">類型</label>
                            <select class="form-control" id="exampleFormControlSelect1">
                                <option v-for="type in types" :value="type">{{ type }}</option>
                            </select>
                        </div>
                    </div>
                    <div v-if="step == 2">
                        <h3 class="mb-3 text-center">贊助商專屬表單已建立</h3>
                        <div class="form-group">
                            <label for="sponsor_form_url">連結</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="sponsor_form_url">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="button">
                                        <font-awesome-icon icon="copy" />
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sponsor_form_password">Password</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="sponsor_form_password">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="button">
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
                                <th v-for="row in sponsorDetailcol" class="sortfield" tabindex="0" :class="{ 'th-width-custom-500': (row.key == 'intro')}">
                                    {{ row.name }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, key, index) in sponsorDetailData.open_data">
                                <th v-if="index == 0" rowspan="13" scope="row" width="120px">公開宣傳資料</th>
                                <td width="150px">{{ columnTranslate('open_data', key) }}</td>
                                <td v-if="columnContainLink(key)"><a :href="item">檔案下載</a></td>
                                <td v-else>{{ item }}</td>
                            </tr>

                            <tr v-for="(item, key, index) in sponsorDetailData.recipe_data">
                                <th v-if="index == 0" rowspan="8" scope="row" width="120px">開立收據資料</th>
                                <td width="150px">{{ columnTranslate('recipe_data', key) }}</td>
                                <td v-if="columnContainLink(key)"><a :href="item">檔案下載</a></td>
                                <td v-else>{{ item }}</td>
                            </tr>

                            <tr v-for="(item, key, index) in sponsorDetailData.others">
                                <th v-if="index == 0" rowspan="3" scope="row" width="120px"></th>
                                <td width="150px">{{ columnTranslate('others', key) }}</td>
                                <td>{{ item }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <h5>進階贊助商資料</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th v-for="row in sponsorAdvancedDetailcol" class="sortfield" tabindex="0">
                                    {{ row.name }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="sponsorDetailData.sponsor_type.type == 'Bruce Wayne'">
                                <th scope="row" width="180px">Bruce Wayne 以上</th>
                                <td>Keynote 引言</td>
                                <td>{{ sponsorDetailData.sponsor_type.content }}</td>
                            </tr>
                            <tr v-if="sponsorDetailData.sponsor_type.type == 'Tony Stark'">
                                <th scope="row" width="180px">{{ sponsorDetailData.sponsor_type.type }}</th>
                                <td>ICCK 大門兩側廣告</td>
                                <td><a :href="sponsorDetailData.sponsor_type.ICCK" download>下載附件</a></td>
                            </tr>
                            <tr v-if="sponsorDetailData.sponsor_type.type == 'Tony Stark'">
                                <th scope="row" width="180px">{{ sponsorDetailData.sponsor_type.type }}</th>
                                <td>報到處全版廣告空間 </td>
                                <td><a :href="sponsorDetailData.sponsor_type.fullAds" download>下載附件</a></td>
                            </tr>
                            <tr v-if="sponsorDetailData.sponsor_type.type == 'Hacker'">
                                <th scope="row" width="180px">Hacker 以上</th>
                                <td>演講廳旗幟</td>
                                <td><a :href="sponsorDetailData.sponsor_type.lectureBanner" download>下載附件</a></td>
                            </tr>
                            <tr v-if="sponsorDetailData.sponsor_type.type == 'Hacker'">
                                <th scope="row" width="180px">Hacker 以上</th>
                                <td>演講廳旗幟</td>
                                <td><a :href="sponsorDetailData.sponsor_type.bannerAds" download>下載附件</a></td>
                            </tr>
                        </tbody>
                    </table>
                    <h5>操作</h5>
                    <fieldset class="form-group mb-0">
                        <div class="row">
                            <legend class="col-form-label col-sm-2 pt-0">修改狀態</legend>
                            <div class="col-sm-10">
                                <div class="form-check form-check-inline" v-for="item in editStatusList" :key="item.status">
                                    <input class="form-check-input" type="radio" name="editStatus" :id="item.status" :value="item.status" v-model="sponsorDetailData.editStatus">
                                    <label class="form-check-label" :for="item.status">{{ item.statusName }}</label>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="form-group">
                        <div class="row">
                            <legend class="col-form-label col-sm-2 pt-0">修改狀態</legend>
                            <div class="col-sm-10">
                                <div class="form-check form-check-inline" v-for="item in types" :key="item">
                                    <input class="form-check-input" type="radio" name="sponsorType" :id="item" :value="item" v-model="sponsorDetailData.sponsor_type.type">
                                    <label class="form-check-label" :for="item">{{ item }}</label>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <div class="form-group">
                        <label for="remark">備註</label>
                        <textarea class="form-control" id="remark" rows="3"></textarea>
                    </div>
                    <h5>資訊</h5>
                    <div class="form-group">
                        <label for="sponsor_form_url">連結</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="sponsor_form_url">
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary" type="button">
                                    <font-awesome-icon icon="copy" />
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sponsor_form_password">Password</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="sponsor_form_password">
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary" type="button">
                                    <font-awesome-icon icon="copy" />
                                </button>
                            </div>
                        </div>
                    </div>
                    <p class="mb-0">更新日期：{{ sponsorDetailData.update_staff }}</p>
                    <p class="mb-0">最後更新者 {{ sponsorDetailData.update_time }}</p>
                </div>
            </template>
            <template v-slot:footer>
                <div v-if="action == 'new'">
                    <div v-if="step == 1">
                        <button type="button" class="btn btn-light" data-dismiss="modal" @click="resetStep()">取消</button>
                        <button type="button" class="btn btn-primary" @click="nextStep()">確認建立</button>
                    </div>
                    <div v-if="step == 2">
                        <button type="button" class="btn btn-primary" data-dismiss="modal"
                            @click="resetStep()">返回清單</button>
                    </div>
                </div>
                <div v-if="action == 'detail'">
                    <button type="button" class="btn btn-primary">更新</button>
                    <button type="reset" class="btn btn-light" data-dismiss="modal">返回</button>
                </div>
            </template>
        </Modal>
    </div>
</template>

<script>
    import axios from 'axios';
    import json from './sponsor-data.json'
    import coltrans from './column_trans.json'

    export default {
        data() {
            return {
                col: [],
                sponsorDetailcol: [],
                sponsorAdvancedDetailcol: [],
                per_page: 10,
                page_info: {},
                types: ['Tony Stark', 'Bruce Wayne', 'Hacker', 'Developer', '其他'],
                editStatusList: [{
                    status: 'unchecked',
                    statusName: '待確認'
                },
                {
                    status: 'checking',
                    statusName: '確定中'
                },{
                    status: 'checked',
                    statusName: '已確定'
                },{
                    status: 'over',
                    statusName: '下架'
                }],
                step: '1',
                fullData: json,
                columnTrans: coltrans,
                allSelected: false,
                sponsorDetailData: {},
                action: 'new',
            }
        },
        computed: {},
        methods:
        {
            initCol() {
                const self = this;
                self.col = [{
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
                },
                ];
            },
            sponsorDetailCol() {
                const vm = this;
                vm.sponsorDetailcol = [{
                    name: '分類',
                    key: 'category'
                }, {
                    name: '欄位名稱',
                    key: 'name'
                }, {
                    name: '內容',
                    key: 'content'
                },
                ];
            },
            sponsorAdvancedDetailCol() {
                const vm = this;
                vm.sponsorAdvancedDetailcol = [{
                    name: '適用贊助商類型',
                    key: 'to_sponsor_type'
                }, {
                    name: '欄位名稱',
                    key: 'name'
                }, {
                    name: '內容',
                    key: 'content'
                },
                ];
            },
            openAddSponsor() {
                const vm = this;
                vm.action = 'new';
                $('#sponsorModal').modal('show');
            },
            openSponsorDetail(sponsor_id) {
                const vm = this;
                vm.action = 'detail';
                vm.sponsorDetailCol();
                vm.sponsorAdvancedDetailCol();
                vm.fullData.forEach((data) => {
                    if (data.sponsor_id === sponsor_id) {
                        vm.sponsorDetailData = data;
                    }
                });
                $('#sponsorModal').modal('show');
            },
            nextStep() {
                const vm = this;
                vm.step++;
            },
            resetStep() {
                const vm = this;
                vm.step = 1;
            },
            toggleSelect: function() {
                const vm = this;
                const select = vm.selectAll;
                vm.fullData.forEach(function(item) {
                    item.checkbox = !select;
                });
                vm.selectAll = !select;
            },
            columnContainLink(key) {
                return key.includes('_link');
            },
            columnTranslate(type, key) {
                const vm = this;
                let colName;
                Object.keys(vm.columnTrans[0][type]).forEach((keyValue) => {
                    if (key === keyValue) {
                        colName =  vm.columnTrans[0][type][key];
                        return;
                    }
                })
                return colName
            }
        },
        mounted() {
            this.initCol();
        },
    };
</script>

<style scoped>
.th-width-custom-500 {
    width: 500px;
    max-width: 500px;
}
</style>
<template>
  <div class="container-fluid">
    <h1>
      講者清單
      <small>Speaker List</small>
    </h1>
    <div class="row justify-content-end mb-3">
      <div class="col-md-2">
        <button type="button" class="btn btn-sm btn-primary btn-block" @click="openAddspeaker()">
          <font-awesome-icon icon="plus" />&nbsp;建立新講者
        </button>
      </div>
      <div class="col-md-2">
        <button type="button" class="btn btn-sm btn-primary btn-block">
          <font-awesome-icon icon="file-export" />&nbsp;匯出
        </button>
      </div>
      <div class="col-md-3">
        <input type="text" class="form-control form-control-sm" placeholder="Search" aria-controls="speaker"
          v-model="searchText" @keyup="searchKeyword($event)" />
      </div>
    </div>
    <div class="form-group form-check">
      <input type="checkbox" class="form-check-input" id="chooseAll" @change="toggleSelect">
      <label class="form-check-label" for="chooseAll">全選 / 取消全選</label>
    </div>
    <div class="row">
      <div class="col">
        <div class="table-responsive">
          <table class="table table-bordered table-striped dataTable" role="grid" aria-describedby="staff_info">
            <thead>
              <tr role="row">
                <th v-for="row in col" class="sortfield" tabindex="0">
                  {{ row.name }}
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in fullData">
                <td><input type="checkbox" class="speaker-check" v-model="item.checkbox" :id="item.id"></td>
                <td>{{ item.name }}</td>
                <td>{{ item.company }}</td>
                <td>{{ item.job_title }}</td>
                <td v-if="item.bio !== null">{{ item.bio.substring(0,50) + '...' }}</td>
                <td v-else>{{ item.bio }}</td>
                <td>{{ item.topic }}</td>
                <td>{{ item.updated_at }}</td>
                <td>{{ item.speaker_status_text = '待確認' }}</td>
                <td>{{ item.speaker_type_text }}</td>
                <td>
                  <button type="button" class="btn btn-primary" @click.prevent="openspeakerDetail(item.id)">
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
        <Pagination :pageInfo="page_info" @onChangePage="onChangePage" />
      </div>
    </div>
    <Modal target="speakerModal" size="lg">
      <template v-slot:title>
        <h4 v-if="action == 'new'" class="modal-title">建立講者</h4>
        <h4 v-if="action == 'detail'" class="modal-title">講者詳細資料</h4>
      </template>
      <template v-slot:header>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="resetStep()">
          <span aria-hidden="true">&times;</span>
        </button>
      </template>
      <template v-slot:body>
        <form v-if="action == 'new'" name="addspeaker">
          <div v-if="step == 1">
            <div class="form-group">
              <label for="speakerName">講師名稱*</label>
              <input type="text" class="form-control" id="speakerName" placeholder="講者名稱"
                v-model="createSpeakerData.name">
            </div>
            <div class="form-group">
              <label for="speakerType">類型</label>
              <select class="form-control" id="speakerType" v-model="createSpeakerData.type">
                <option v-for="(type, index) in types" :value="index">{{ type }}</option>
              </select>
            </div>
          </div>
          <div v-if="step == 2">
            <h3 class="mb-3 text-center">講者專屬表單已建立</h3>
            <div class="form-group">
              <label for="speaker_form_url">連結</label>
              <div class="input-group">
                <input type="text" class="form-control" id="speaker_created_form_url"
                  :value="'http://cms.mopcon.org/' + createSpeakerData.access_key">
                <div class="input-group-append">
                  <button class="btn btn-outline-primary copy" type="button"
                    data-clipboard-target="#speaker_created_form_url">
                    <font-awesome-icon icon="copy" />
                  </button>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="speaker_form_password">Password</label>
              <div class="input-group">
                <input type="text" class="form-control" id="speaker_created_form_password"
                  :value="createSpeakerData.access_secret">
                <div class="input-group-append">
                  <button class="btn btn-outline-primary" type="button"
                    data-clipboard-target="#speaker_created_form_password">
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
                <th v-for="row in speakerDetailcol" class="sortfield" tabindex="0">
                  {{ row.name }}
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, key) in Object.entries(speakerDetailData).slice(0, 12)">
                <th v-if="key == 0" :rowspan="Object.entries(speakerDetailData).slice(0, 12).length" scope="row"
                  width="120px">個人資料</th>
                <td width="150px">{{ item[0] }}</td>
                <td v-if="columnContainLink(item[0])"><a :href="item[1]" target="_blank">{{ item[1] }}</a></td>
                <td v-else-if="item[0] == 'photo'">
                  <img :src="item[1]" alt="" srcset="" width="120px"><br>
                  <a v-if="item[1]" download :href="item[1]" target="_blank">下載檔案</a>
                </td>
                <td v-else>{{ item[1] }}</td>
              </tr>

              <tr v-for="(item, key) in Object.entries(speakerDetailData).slice(12, 20)">
                <th v-if="key == 0" :rowspan="Object.entries(speakerDetailData).slice(12, 20).length" scope="row"
                  width="120px">議程資料</th>
                <td width="150px">{{ item[0] }}</td>
                <td v-if="columnContainLink(item[0])"><a :href="item[1]" target="_blank">{{ item[1] }}</a></td>
                <td v-else-if="item[0] == 'tag'">
                  <span v-for="(tag, index) in item[1]">{{ tagsItem[tag] }}, </span>
                </td>
                <td v-else-if="item[0] == 'level'">{{ levelItem[item[1]] }}</td>
                <td v-else-if="item[0] == 'license'">{{ licenseItem[item[1]] }}</td>
                <td v-else-if="item[0] == 'promotion'">{{ promotionItem[item[1]] }}</td>
                <td v-else>{{ item[1] }}</td>
              </tr>

              <tr v-for="(item, key) in Object.entries(speakerDetailData).slice(20, 25)">
                <th v-if="key == 0" :rowspan="Object.entries(speakerDetailData).slice(20, 25).length" scope="row"
                  width="120px">行政資訊</th>
                <td width="150px">{{ item[0] }}</td>
                <td v-if="item[0] == 'tshirt_size'">{{ tshirtSizeItem[item[1]] }}</td>
                <td v-else-if="item[0] == 'meal_preference'">{{ mealPreferenceItem[item[1]] }}</td>
                <td v-else-if="item[0] == 'has_dinner' || item[0] == 'need_parking_space'">{{ promotionItem[item[1]] }}
                </td>
                <td v-else>{{ item[1] }}</td>
              </tr>
            </tbody>
          </table>
          <h5>操作</h5>
          <fieldset class="form-group mb-0">
            <div class="row">
              <legend class="col-form-label col-sm-2 pt-0">修改狀態</legend>
              <div class="col-sm-10">
                <div class="form-check form-check-inline" v-for="(item, index) in editStatusList" :key="item">
                  <input class="form-check-input" type="radio" name="editStatus" :id="item" :value="index"
                    v-model="speakerDetailData.speaker_status = '0'">
                  <label class="form-check-label" :for="item">{{ item }}</label>
                </div>
              </div>
            </div>
          </fieldset>
          <fieldset class="form-group">
            <div class="row">
              <legend class="col-form-label col-sm-2 pt-0">修改狀態</legend>
              <div class="col-sm-10">
                <div class="form-check form-check-inline" v-for="(item, index) in types" :key="item">
                  <input class="form-check-input" type="radio" name="speakerType" :id="item" :value="index"
                    v-model="speakerDetailData.speaker_type">
                  <label class="form-check-label" :for="item">{{ item }}</label>
                </div>
              </div>
            </div>
          </fieldset>
          <div class="form-group">
            <label for="remark">備註</label>
            <textarea class="form-control" id="remark" rows="3">{{ speakerDetailData.note }}</textarea>
          </div>
          <h5>資訊</h5>
          <div class="form-group">
            <label for="speaker_form_url">連結</label>
            <div class="input-group">
              <input type="text" class="form-control" id="speaker_form_url"
                :value="'http://cms.mopcon.org/'+speakerDetailData.access_key">
              <div class="input-group-append">
                <button class="btn btn-outline-primary copy" type="button" data-clipboard-target="#speaker_form_url">
                  <font-awesome-icon icon="copy" />
                </button>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="speaker_form_password">Password</label>
            <div class="input-group">
              <input type="text" class="form-control" id="speaker_form_password"
                :value="speakerDetailData.access_secret">
              <div class="input-group-append">
                <button class="btn btn-outline-primary copy" type="button"
                  data-clipboard-target="#speaker_form_password">
                  <font-awesome-icon icon="copy" />
                </button>
              </div>
            </div>
          </div>
          <p class="mb-0">更新日期：{{ speakerDetailData.updated_at }}</p>
          <p class="mb-0">最後更新者：{{ speakerDetailData.last_edited_by }}</p>
        </div>
      </template>
      <template v-slot:footer>
        <div v-if="action == 'new'">
          <div v-if="step == 1">
            <button type="button" class="btn btn-light" data-dismiss="modal" @click="resetStep()">取消</button>
            <button type="button" class="btn btn-primary" @click="nextStep()">確認建立</button>
          </div>
          <div v-if="step == 2">
            <button type="button" class="btn btn-primary" data-dismiss="modal" @click="resetStep()">返回清單</button>
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
  import Clipboard from 'clipboard';

  export default {
    data() {
      return {
        col: [],
        speakerDetailcol: [],
        page_info: {},
        types: [],
        tagsItem: [],
        levelItem: [],
        licenseItem: [],
        tshirtSizeItem: [],
        mealPreferenceItem: [],
        promotionItem: ['是', '否'],
        editStatusList: [],
        step: '1',
        fullData: [],
        allSelected: false,
        checkboxSelectedList: [],
        speakerDetailData: {},
        createSpeakerData: {
          name: '',
          type: 0,
          access_key: '',
          access_secret: '',
        },
        action: 'new',
        searchText: '',
      }
    },
    computed: {},
    methods:
    {
      initCol() {
        const vm = this;
        vm.col = [{
          name: '選取',
          key: 'choose'
        }, {
          name: '講師名稱',
          key: 'name'
        }, {
          name: '公司',
          key: 'company'
        }, {
          name: '職稱',
          key: 'company_position'
        }, {
          name: '個人介紹',
          key: 'intro'
        }, {
          name: '演講主題',
          key: 'issue'
        }, {
          name: '更新日期',
          key: 'update_date'
        }, {
          name: '狀態',
          key: 'status'
        }, {
          name: '類型',
          key: 'type'
        }, {
          name: '查看',
          key: 'detail'
        },
        ];
        vm.speakerDetailcol = [{
          name: '分類',
          key: 'category'
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
          'speaker/get-options'
        ).then(response => {
          const res = response.data.data;
          vm.types = res.speakerTypeItem;
          vm.tagsItem = res.tagItem;
          vm.levelItem = res.levelItem;
          vm.licenseItem = res.licenseItem;
          vm.tshirtSizeItem = res.tshirtSizeItem;
          vm.mealPreferenceItem = res.mealPreferenceItem;
          vm.editStatusList = res.speakerStatusItem;
        }).catch(error => {
          console.log(error);
        });
      },
      getSpeakerData() {
        const vm = this;
        axios.get(
          'api/speaker?&page=' + vm.page_info.current_page + '&search=' + vm.searchText
        ).then(response => {
          const res = response.data.data
          vm.page_info = {
            current_page: res.current_page,
            limit: res.per_page,
            last_page: res.last_page,
            total: res.total,
          }
          vm.fullData = response.data.data.data;
        }).catch(error => {
          console.log(error);
        });
      },
      postSpeakerUrlData() {
        const vm = this;
        axios.post('api/speaker', {
          name: vm.createSpeakerData.name,
          speaker_type: vm.createSpeakerData.type
        }
        ).then(response => {
          const res = response.data.data;
          vm.createSpeakerData.access_key = res.access_key;
          vm.createSpeakerData.access_secret = res.access_secret;
        }).catch(error => {
          console.log(error);
        });
      },
      onChangePage(page) {
        const vm = this;
        vm.page_info.current_page = page;
        vm.getSpeakerData();
      },
      searchKeyword(event) {
        const vm = this;
        if (event.which === 13) {
          vm.getSpeakerData();
        }
      },
      openAddspeaker() {
        const vm = this;
        vm.action = 'new';
        $('#speakerModal').modal('show');
      },
      openspeakerDetail(speaker_id) {
        const vm = this;
        vm.action = 'detail';
        vm.fullData.forEach((data) => {
          if (data.id === speaker_id) {
            vm.speakerDetailData = data;
          }
        });
        $('#speakerModal').modal('show');
      },
      nextStep() {
        const vm = this;
        vm.step++;
        vm.postSpeakerUrlData();
      },
      resetStep() {
        const vm = this;
        vm.createSpeakerData.name = '';
        vm.createSpeakerData.type = 0;
        vm.step = 1;
      },
      toggleSelect: function () {
        const vm = this;
        const select = vm.selectAll;
        const checkbox = document.querySelectorAll('.speaker-check')
        checkbox.forEach((item) => {
          vm.checkboxSelectedList.push(item.id);
          item.checked = !select;
        })
        vm.selectAll = !select;
      },
      columnContainLink(key) {
        return key.includes('link_');
      },
    },
    mounted() {
      this.initCol();
      this.getSpeakerOption();
      this.getSpeakerData();
      const clipboard = new Clipboard('.copy');
    },
  };
</script>
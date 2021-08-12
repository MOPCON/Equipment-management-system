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
        <button type="button" class="btn btn-sm btn-primary btn-block" @click="exportData()">
          <font-awesome-icon icon="file-export" />&nbsp;匯出
        </button>
      </div>
      <div class="col-md-2">
        <button type="button" class="btn btn-sm btn-primary btn-block" @click="openFileSelect">
            <font-awesome-icon icon="file-import" />&nbsp;匯入
        </button>
        <input type="file" style="display:none" id="importFile" @change="importData">
      </div>
      <div class="col-md-3">
        <input type="text" class="form-control form-control-sm" placeholder="Search" aria-controls="speaker"
          v-model="searchText" @keyup.enter="searchKeyword($event)" />
      </div>
    </div>
    <div class="row mb-3 justify-content-between align-items-center">
      <div class="col-md-6 align-self-center">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="chooseAll" @change="toggleSelect">
          <label class="form-check-label" for="chooseAll">全選 / 取消全選</label>
        </div>
      </div>
      <div class="col-md-6 d-flex justify-content-end">
        <div class="form-check form-inline">
          <label class="form-check-label mr-2" for="filterYear">篩選年份 : </label>
          <select name="filterYear" id="filterYear" class="form-control" v-model="filter.year" @change="getSpeakerData()">
              <option :value="year" v-for="year in year" :key="year">
                  {{ year }}
              </option>
          </select>
        </div>
        <div class="form-check form-inline">
          <label class="form-check-label mr-2" for="filterStatus">狀態 : </label>
          <select name="filterStatus" id="filterStatus" class="form-control" v-model="filter.status" @change="getSpeakerData()">
            <option value="all">請選擇</option>
            <option v-for="(status, index) in editStatusList" :value="index" :key="`filter-status-${index}`">
              {{ status }}
            </option>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <div class="table-responsive">
          <table class="table table-bordered table-striped dataTable" role="grid" aria-describedby="staff_info">
            <thead>
              <tr role="row">
                <th v-for="row in col" class="sortfield" tabindex="0" :key="row.key">
                  {{ row.name }}
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in fullData" :key="item.id">
                <td><input type="checkbox" class="speaker-check" v-model="item.checkbox" :id="item.id"></td>
                <td>{{ item.name }}</td>
                <td>{{ item.company }}</td>
                <td>{{ item.job_title }}</td>
                <td v-if="item.bio !== null">{{ item.bio.substring(0,50) + '...' }}</td>
                <td v-else>{{ item.bio }}</td>
                <td>{{ item.topic }}</td>
                <td>{{ item.updated_at }}</td>
                <td v-if="item.speaker_status_text !== ''">{{ item.speaker_status_text }}</td>
                <td v-else>待確認</td>
                <td>{{ item.speaker_type_text }}</td>
                <td>
                  <button type="button" class="btn btn-sm btn-primary" @click.prevent="openspeakerDetail(item.id)">
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
        <h4 v-if="action === 'new'" class="modal-title">建立講者</h4>
        <h4 v-if="action === 'detail'" class="modal-title">講者詳細資料</h4>
      </template>
      <template v-slot:header>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="resetStep()">
          <span aria-hidden="true">&times;</span>
        </button>
      </template>
      <template v-slot:body>
        <form v-if="action === 'new'" name="addspeaker">
          <div v-if="step === 1">
            <div class="form-group">
              <label for="speakerName">講師名稱*</label>
              <input type="text" class="form-control" id="speakerName" placeholder="講者名稱"
                v-model="createSpeakerData.name">
            </div>
            <div class="form-group">
              <label for="speakerType">類型</label>
              <select class="form-control" id="speakerType" v-model="createSpeakerData.type">
                <option v-for="(type, index) in types" :value="index" :key="'speakerType' + index">{{ type }}</option>
              </select>
            </div>
          </div>
          <div v-if="step === 2">
            <h3 class="mb-3 text-center">講者專屬表單已建立</h3>
            <div class="form-group">
              <label for="speaker_form_url">連結</label>
              <div class="input-group">
                <input type="text" class="form-control" id="speaker_created_form_url"
                  :value="createSpeakerData.external_link">
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
                  <button class="btn btn-outline-primary copy" type="button"
                    data-clipboard-target="#speaker_created_form_password">
                    <font-awesome-icon icon="copy" />
                  </button>
                </div>
              </div>
            </div>
          </div>
        </form>
        <div v-if="action === 'detail'" class="detail-content">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th tabindex="0" class="sortfield">分類</th>
                <th tabindex="0" width="170px" class="sortfield">欄位名稱</th>
                <th tabindex="0" class="sortfield">內容</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th rowspan="14" scope="row">個人資料</th>
                <td>id</td>
                <td>{{ speakerDetailData.id }}</td>
              </tr>
              <tr>
                <td>姓名</td>
                <td class="p-0 v-align-middle">
                  <input type="text" class="form-control border-0 rounded-0" v-model="speakerDetailData.name">
                </td>
              </tr>
              <tr>
                <td>英文名稱</td>
                <td class="p-0 v-align-middle">
                  <input type="text" class="form-control border-0 rounded-0" v-model="speakerDetailData.name_e">
                </td>
              </tr>
              <tr>
                <td>公司/組織</td>
                <td class="p-0 v-align-middle">
                  <input type="text" class="form-control border-0 rounded-0" v-model="speakerDetailData.company ">
                </td>
              </tr>
              <tr>
                <td>英文公司/組織 (若無則同上)</td>
                <td v-if="speakerDetailData.company_e !== null && speakerDetailData.company_e !== ''" class="p-0 v-align-middle">
                  <input type="text" class="form-control border-0 rounded-0" v-model="speakerDetailData.company_e">
                </td>
                <td v-else class="p-0 v-align-middle">
                  <input type="text" class="form-control border-0 rounded-0" :placeholder="speakerDetailData.company"
                    v-model="speakerDetailData.company_e">
                </td>
              </tr>
              <tr>
                <td>職稱</td>
                <td class="p-0 v-align-middle">
                  <input type="text" class="form-control border-0 rounded-0" v-model="speakerDetailData.job_title">
                </td>
              </tr>
              <tr>
                <td>英文職稱 (若無則同上)</td>
                <td v-if="speakerDetailData.job_title_e !== null && speakerDetailData.job_title_e !== ''" class="p-0 v-align-middle">
                  <input type="text" class="form-control border-0 rounded-0" v-model="speakerDetailData.job_title_e">
                </td>
                <td v-else class="p-0 v-align-middle">
                  <input type="text" class="form-control border-0 rounded-0" :placeholder="speakerDetailData.job_title"
                    v-model="speakerDetailData.job_title_e">
                </td>
              </tr>
              <tr>
                <td>個人介紹</td>
                <td class="p-0 v-align-middle">
                  <textarea class="form-control border-0 rounded-0" v-model="speakerDetailData.bio" maxlength="120">
                      {{ speakerDetailData.bio }}
                  </textarea>
                </td>
              </tr>
              <tr>
                <td>個人介紹 (英文)</td>
                <td class="p-0 v-align-middle">
                  <textarea class="form-control border-0 rounded-0" v-model="speakerDetailData.bio_e" maxlength="240">
                    {{ speakerDetailData.bio_e }}
                  </textarea>
                </td>
              </tr>
              <tr>
                <td>照片</td>
                <td>
                  <img :src="speakerDetailData.photo" alt="" srcset="" width="120px"><br>
                  <a v-if="speakerDetailData.photo !== null" download :href="speakerDetailData.photo"
                    target="_blank">下載檔案</a>
                  <input type="file" name="file" class="form-control-file" id="personalPhoto"
                    @change="valideFile($event)">
                </td>
              </tr>
              <tr>
                <td>Facebook</td>
                <td class="p-0 v-align-middle">
                  <div class="input-group">
                    <input type="url" class="form-control border-0 rounded-0" v-model="speakerDetailData.link_fb"
                      id="link_fb" @blur="checkUrl('link_fb')">
                    <div class="input-group-append align-items-center" v-if="speakerDetailData.link_fb !== null">
                      <a :href="speakerDetailData.link_fb" target="_blank" class="btn btn-primary rounded-0">link</a>
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
                <td>Github</td>
                <td class="p-0 v-align-middle">
                  <div class="input-group">
                    <input type="url" class="form-control border-0 rounded-0" v-model="speakerDetailData.link_github"
                      id="link_github" @blur="checkUrl('link_github')">
                    <div class="input-group-append" v-if="speakerDetailData.link_github !== null">
                      <a :href="speakerDetailData.link_github" target="_blank"
                        class="btn btn-primary rounded-0">link</a>
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
                <td>Twitter</td>
                <td class="p-0 v-align-middle">
                  <div class="input-group">
                    <input type="url" class="form-control border-0 rounded-0" v-model="speakerDetailData.link_twitter"
                      id="link_twitter" @blur="checkUrl('link_twitter')">
                    <div class="input-group-append" v-if="speakerDetailData.link_twitter !== null">
                      <a :href="speakerDetailData.link_twitter" target="_blank"
                        class="btn btn-primary rounded-0">link</a>
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
                <td>其他(如 Website / Blog)</td>
                <td class="p-0 v-align-middle">
                  <div class="input-group">
                    <input type="url" class="form-control border-0 rounded-0" v-model="speakerDetailData.link_other"
                      id="link_other" @blur="checkUrl('link_other')">
                    <div class="input-group-append" v-if="speakerDetailData.link_other !== null">
                      <a :href="speakerDetailData.link_other" target="_blank" class="btn btn-primary rounded-0">link</a>
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
                <th rowspan="16" scope="row" width="120px">議程資料</th>
                <td>演講主題</td>
                <td class="p-0 v-align-middle">
                  <input type="text" class="form-control border-0 rounded-0" v-model="speakerDetailData.topic"
                    maxlength="150">
                </td>
              </tr>
              <tr>
                <td>演講主題 (英文)</td>
                <td class="p-0 v-align-middle">
                  <input type="text" class="form-control border-0 rounded-0" v-model="speakerDetailData.topic_e"
                    maxlength="150">
                </td>
              </tr>
              <tr>
                <td>演講摘要</td>
                <td class="p-0 v-align-middle">
                  <textarea class="form-control border-0 rounded-0" v-model="speakerDetailData.summary" maxlength="240">
                    {{ speakerDetailData.summary }}
                  </textarea>
                </td>
              </tr>
              <tr>
                <td>演講摘要 (英文)</td>
                <td class="p-0 v-align-middle">
                  <textarea class="form-control border-0 rounded-0" v-model="speakerDetailData.summary_e"
                    maxlength="480">
                    {{ speakerDetailData.summary_e }}
                  </textarea>
                </td>
              </tr>
              <tr>
                <td>標籤</td>
                <td>
                  <div class="form-check-inline" v-for="(name, index) in tagsItem" :key="name">
                    <input class="form-check-input" type="checkbox" :id="'tag' + index" :value="index"
                      v-if="speakerDetailData.tag !== null" v-model="speakerDetailData.tag">
                    <input class="form-check-input" type="checkbox" :id="'tag' + index" :value="index" v-else
                      v-model="tags">
                    <label class="form-check-label" :for="'tag' + index">
                      {{ name }}
                    </label>
                  </div>
                </td>
              </tr>
              <tr>
                <td>難易度</td>
                <td>
                  <div class="form-check-inline" v-for="(name, index) in levelItem" :key="name">
                    <input class="form-check-input" type="radio" :id="'level' + index" :value="index"
                      v-model="speakerDetailData.level">
                    <label class="form-check-label" :for="'level' + index">
                      {{ name }}
                    </label>
                  </div>
                </td>
              </tr>
              <tr>
                <td>目標會眾</td>
                <td class="p-0 v-align-middle">
                  <textarea class="form-control border-0 rounded-0" v-model="speakerDetailData.target_audience"
                    maxlength="64">
                    {{ speakerDetailData.target_audience }}
                  </textarea>
                </td>
              </tr>
              <tr>
                <td>先備知識</td>
                <td class="p-0 v-align-middle">
                  <textarea class="form-control border-0 rounded-0" v-model="speakerDetailData.prerequisites"
                    maxlength="120">
                    {{ speakerDetailData.prerequisites }}
                  </textarea>
                </td>
              </tr>
              <tr>
                <td>預期收穫</td>
                <td class="p-0 v-align-middle">
                  <textarea class="form-control border-0 rounded-0" v-model="speakerDetailData.expected_harvest"
                    maxlength="120">
                    {{ speakerDetailData.expected_harvest }}
                  </textarea>
                </td>
              </tr>
              <!-- <tr>
                <td>授權方式 (2019)</td>
                <td>
                  <div class="form-check-inline">
                    <input class="form-check-input" type="radio" id="license_0"
                      v-model="speakerDetailData.agree_record" value="1">
                    <label class="form-check-label" for="license_0">
                      授予 MOPCON 演講時錄影，後製與上傳至公開線上影音平台之權利。
                    </label>
                  </div>
                  <div class="form-check-inline">
                    <input class="form-check-input" type="radio" id="license_4"
                      v-model="speakerDetailData.agree_record" value="0">
                    <label class="form-check-label" for="license_4">
                      謝絕所有錄音錄影，但接受 MOPCON 工作人員文字紀錄。
                    </label>
                  </div>
                </td>
              </tr> -->
              <!-- 2021 -->
              <tr>
                <td>授權方式 (1)</td>
                <td>
                  <div class="form-check-inline" v-for="(name, index) in agreePolicyItem" :key="name">
                    <input class="form-check-input" type="radio" :id="'license' + index" :value="index"
                      v-model="speakerDetailData.agree_record">
                    <label class="form-check-label" :for="'agreed_policy_' + index">
                      {{ name }}
                    </label>
                  </div>
                </td>
              </tr>
              <tr>
                <td>授權方式 (2)</td>
                <td>
                  <div class="form-check-inline" v-for="(name, index) in licenseItem" :key="name">
                    <input class="form-check-input" type="radio" :id="'license' + index" :value="index"
                      v-model="speakerDetailData.license">
                    <label class="form-check-label" :for="'license' + index">
                      {{ name }}
                    </label>
                  </div>
                </td>
              </tr>
              <tr>
                <td>投影片連結</td>
                <td class="p-0 v-align-middle">
                  <div class="input-group">
                    <input type="url" class="form-control border-0 rounded-0" v-model="speakerDetailData.link_slide"
                      id="link_slide" @blur="checkUrl('link_slide')">
                    <div class="input-group-append" v-if="speakerDetailData.link_slide !== null">
                      <a :href="speakerDetailData.link_slide" target="_blank"
                        class="btn btn-primary rounded-0">link</a>
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
                <td>預錄影片連結</td>
                <td class="p-0 v-align-middle">
                  <div class="input-group">
                    <input type="url" class="form-control border-0 rounded-0" v-model="speakerDetailData.link_video"
                      id="link_pre_video" @blur="checkUrl('link_pre_video')">
                    <div class="input-group-append" v-if="speakerDetailData.link_pre_video !== null">
                      <a :href="speakerDetailData.link_pre_video" target="_blank"
                        class="btn btn-primary rounded-0">link</a>
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
                <td>錄影檔影片連結</td>
                <td class="p-0 v-align-middle">
                  <div class="input-group">
                    <input type="url" class="form-control border-0 rounded-0" v-model="speakerDetailData.link_video"
                      id="link_video" @blur="checkUrl('link_video')">
                    <div class="input-group-append" v-if="speakerDetailData.link_video !== null">
                      <a :href="speakerDetailData.link_video" target="_blank"
                        class="btn btn-primary rounded-0">link</a>
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
                <td>是否願意被 MOPCON 的粉專提及或標註？(是/否)</td>
                <td>
                  <div class="form-check-inline" v-for="(name, index) in promotionItem" :key="name">
                    <input class="form-check-input" type="radio" :id="'open' + index" :value="index"
                      v-model="speakerDetailData.promotion">
                    <label class="form-check-label" :for="'open' + index">
                      {{ name }}
                    </label>
                  </div>
                </td>
              </tr>
              <tr>
                <td>是否願意轉發 MOPCON 的講者宣傳文和大會其他文章？ (是/否)</td>
                <td>
                  <div class="form-check-inline" v-for="(name, index) in promotionItem" :key="name">
                    <input class="form-check-input" type="radio" :id="'will' + index" :value="index"
                      v-model="speakerDetailData.will_forward_posts">
                    <label class="form-check-label" :for="'will' + index">
                      {{ name }}
                    </label>
                  </div>
                </td>
              </tr>
              <tr>
                <th rowspan="8" scope="row">行政資訊</th>
                <td>真實姓名</td>
                <td class="p-0 v-align-middle">
                  <input type="text" class="form-control border-0 rounded-0" v-model="speakerDetailData.real_name">
                </td>
              </tr>
              <tr>
                <td>聯絡 Email</td>
                <td class="p-0 v-align-middle">
                  <input type="email" class="form-control border-0 rounded-0" v-model="speakerDetailData.contact_email">
                </td>
              </tr>
              <tr>
                <td>聯絡電話</td>
                <td class="p-0 v-align-middle">
                  <input type="tel" class="form-control border-0 rounded-0" v-model="speakerDetailData.contact_phone">
                </td>
              </tr>
              <tr>
                <td>聯絡地址</td>
                <td class="p-0 v-align-middle">
                  <input type="tel" class="form-control border-0 rounded-0" v-model="speakerDetailData.contact_address">
                </td>
              </tr>
              <tr>
                <td>T-shirt 尺寸</td>
                <td>
                  <div class="form-check-inline" v-for="(name, index) in tshirtSizeItem" :key="name">
                    <input class="form-check-input" type="radio" :id="'size' + index" :value="index"
                      v-model="speakerDetailData.tshirt_size">
                    <label class="form-check-label" :for="'size' + index">
                      {{ name }}
                    </label>
                  </div>
                </td>
              </tr>
              <tr>
                <td>您是否需有停車需求？</td>
                <td>
                  <div class="form-check-inline" v-for="(name, index) in promotionItem" :key="name">
                    <input class="form-check-input" type="radio" :id="'parking' + index" :value="index"
                      v-model="speakerDetailData.need_parking_space">
                    <label class="form-check-label" :for="'parking' + index">
                      {{ name }}
                    </label>
                  </div>
                </td>
              </tr>
              <tr>
                <td>敬邀參加講者晚宴</td>
                <td>
                  <div class="form-check-inline" v-for="(name, index) in promotionItem" :key="name">
                    <input class="form-check-input" type="radio" :id="'dinner' + index" :value="index"
                      v-model="speakerDetailData.has_dinner">
                    <label class="form-check-label" :for="'dinner' + index">
                      {{ name }}
                    </label>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="text-nowrap">葷素食偏好 (葷/全素/奶蛋素)</td>
                <td>
                  <div class="form-check-inline" v-for="(name, index) in mealPreferenceItem" :key="name">
                    <input class="form-check-input" type="radio" :id="'eatLike' + index" :value="index"
                      v-model="speakerDetailData.meal_preference">
                    <label class="form-check-label" :for="'eatLike' + index">
                      {{ name }}
                    </label>
                  </div>
                </td>
              </tr>
              <tr>
                <td>晚宴攜伴人數</td>
                <td class="p-0 v-align-middle">
                  <input type="number" class="form-control border-0 rounded-0"
                    v-model="speakerDetailData.has_companion">
                </td>
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
                    v-model="speakerDetailData.speaker_status">
                  <label class="form-check-label" :for="item">{{ item }}</label>
                </div>
              </div>
            </div>
          </fieldset>
          <fieldset class="form-group mb-0">
            <div class="row">
              <legend class="col-form-label col-sm-2 pt-0">修改類型</legend>
              <div class="col-sm-10">
                <div class="form-check form-check-inline" v-for="(item, index) in types" :key="item">
                  <input class="form-check-input" type="radio" name="speakerType" :id="item" :value="index"
                    v-model="speakerDetailData.speaker_type">
                  <label class="form-check-label" :for="item">{{ item }}</label>
                </div>
              </div>
            </div>
          </fieldset>
          <fieldset class="form-group">
            <div class="row">
              <legend class="col-form-label col-sm-2 pt-0">為 Keynote 講者</legend>
              <div class="col-sm-10">
                <div class="form-check form-check-inline" v-for="(item, index) in promotionItem" :key="item">
                  <input class="form-check-input" type="radio" name="isKeynote" :id="item" :value="index"
                    v-model="speakerDetailData.is_keynote">
                  <label class="form-check-label" :for="item">{{ item }}</label>
                </div>
              </div>
            </div>
          </fieldset>
          <fieldset class="form-group">
            <div class="row">
              <legend class="col-form-label col-sm-2 pt-0">參與年份</legend>
              <div class="col-sm-10">
                <div class="form-check form-check-inline" v-for="(item, index) in year" :key="item">
                  <input class="form-check-input" type="radio" name="attendYear" :id="item" :value="item"
                    v-model="speakerDetailData.year">
                  <label class="form-check-label" :for="item">{{ item }}</label>
                </div>
              </div>
            </div>
          </fieldset>
          <div class="form-group">
            <label for="remark">備註</label>
            <textarea class="form-control" id="remark" rows="3"
              v-model="speakerDetailData.note">{{ speakerDetailData.note }}</textarea>
          </div>
          <h5>資訊</h5>
          <div class="form-group">
            <label for="speaker_form_url">連結</label>
            <div class="input-group">
              <input type="text" class="form-control" id="speaker_form_url" :value="speakerDetailData.external_link">
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
        <div v-if="action === 'new'">
          <div v-if="step === 1">
            <button type="button" class="btn btn-light" data-dismiss="modal" @click="resetStep()">取消</button>
            <button type="button" class="btn btn-primary" @click="postSpeakerUrlData()">確認建立</button>
          </div>
          <div v-if="step === 2">
            <button type="button" class="btn btn-primary" data-dismiss="modal" @click="resetStep()">返回清單</button>
          </div>
        </div>
        <div v-if="action === 'detail'">
          <button type="button" class="btn btn-primary" @click="updateSpeakerData(speakerDetailData.id)">更新</button>
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
        page_info: {},
        types: [],
        tagsItem: [],
        levelItem: [],
        licenseItem: [],
        tshirtSizeItem: [],
        mealPreferenceItem: [],
        promotionItem: ['否', '是'],
        year: [2019, 2020,2021],
        editStatusList: [],
        step: 1,
        fullData: [],
        allSelected: false,
        checkboxSelectedList: [],
        speakerDetailData: {},
        tags: [],
        createSpeakerData: {
          name: '',
          type: 0,
          external_link: '',
          access_secret: '',
        },
        action: 'new',
        searchText: '',
        filter:{
          year: 2021,
          status: 'all'
        },
      }
    },
    computed: {
      filterData() {
        const data = JSON.parse(JSON.stringify(this.filter));
        if (data.status == 'all') {
          delete data.status
        }
        return data
      }
    },
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
          vm.agreePolicyItem = res.agreePolicyItem;
          vm.tshirtSizeItem = res.tshirtSizeItem;
          vm.mealPreferenceItem = res.mealPreferenceItem;
          vm.editStatusList = res.speakerStatusItem;
        }).catch(error => {
          helper.alert(error.response.data.message, 'danger');
        });
      },
      getSpeakerData() {
        const vm = this;
        axios.get(
          'api/speaker?&page=' + vm.page_info.current_page + '&search=' + vm.searchText + '&filter=' + JSON.stringify(vm.filterData)
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
          helper.alert(error.response.data.message, 'danger');
        });
      },
      postSpeakerUrlData() {
        const vm = this;
        axios.post('api/speaker', {
          name: vm.createSpeakerData.name,
          speaker_type: vm.createSpeakerData.type
        }).then(response => {
          const res = response.data;
          if (res.success) {
            vm.step++;
            vm.createSpeakerData.external_link = res.data.external_link;
            vm.createSpeakerData.access_secret = res.data.access_secret;
          }
        }).catch(error => {
          vm.resetStep();
          $('#speakerModal').modal('hide');
          helper.alert(error.response.data.message, 'danger');
        });
      },
      valideFile(e) {
        const file = e.target.files[0];
        const img = new Image();
        const _URL = window.URL || window.webkitURL;
        img.onload = () => {
          if (img.width < 500 || img.height < 500) {
            alert("寬高需大於 500");
            document.getElementById('personalPhoto').value = "";
          }
        };
        img.src = _URL.createObjectURL(file);
      },
      checkUrl(key) {
        if (!document.getElementById(key).checkValidity()) {
          document.getElementById(key).value = ''
          alert('請輸入 url')
        }
      },
      updateSpeakerData(id) {
        const vm = this;
        let updateData = vm.speakerDetailData;
        Object.keys(updateData).forEach((key) => {
          if (key.includes('_text') || key.includes('access_') || key.includes('updated')) {
            delete updateData[key];
          }
        })
        var bodyFormData = new FormData();
        let file = document.getElementById('personalPhoto').files[0];
        if (file !== undefined) {
          bodyFormData.set('file', file);
        }
        bodyFormData.set('_method', 'PUT')
        Object.keys(updateData).forEach(key => {
          if (updateData[key] !== null && updateData[key] !== '') {
            bodyFormData.set(key, updateData[key]);
          } else if (updateData[key] === '') {
            bodyFormData.set(key, updateData[key]);
          }
        });
        if (vm.speakerDetailData.tag !== null) {
          for (let i = 0; i < vm.speakerDetailData.tag.length; i++) {
            bodyFormData.append('tag[]', vm.speakerDetailData.tag[i]);
          }
        } else {
          for (let i = 0; i < vm.tags.length; i++) {
            bodyFormData.append('tag[]', vm.tags[i]);
          }
        }
        axios.post(`api/speaker/${id}`, bodyFormData).then(response => {
          const res = response.data;
          $('#speakerModal').modal('hide');
          if (res.success) {
            helper.alert(res.message, 'success');
            vm.getSpeakerData();
          } else {
            helper.alert(res.message, 'danger');
          }
        }).catch(error => {
          $('#speakerModal').modal('hide');
          helper.alert(error.response.data.message, 'danger');
        });
      },
      onChangePage(page) {
        const vm = this;
        vm.page_info.current_page = page;
        vm.getSpeakerData();
      },
      searchKeyword(event) {
        const vm = this;
        vm.getSpeakerData();
      },
      openAddspeaker() {
        const vm = this;
        vm.action = 'new';
        $('#speakerModal').modal('show');
      },
      openspeakerDetail(speaker_id) {
        const vm = this;
        vm.action = 'detail';
        axios.get(     
          'api/speaker/'+ speaker_id
        ).then(response => {
          const res = response.data.data;
          vm.speakerDetailData = res;
          if (vm.speakerDetailData['speaker_status'] == null) {
            vm.speakerDetailData['speaker_status'] = 0;
          }
          if (vm.speakerDetailData['agree_record'] == null) {
            vm.speakerDetailData['agree_record'] = 1;
          }
        }).catch(error => {
          helper.alert(error.response.data.message, 'danger');
        });
        $('#speakerModal').modal('show');
      },
      resetStep() {
        const vm = this;
        vm.createSpeakerData.name = '';
        vm.createSpeakerData.type = 0;
        vm.step = 1;
        vm.getSpeakerData();
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
      hasChecked() {
        const checkedId = document.querySelectorAll('.speaker-check');
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
          'api/speaker?&limit=' + vm.page_info.total
          ).then(response => {
            const speakerAllData = response.data.data.data
            speakerAllData.map(speaker => allIds.push(speaker.id))
            window.location = `api/speaker/export?ids=${allIds}`;
          }).catch(error => {
            helper.alert(error.response.data.message, 'danger');
          });
        } else {
          window.location = `api/speaker/export?ids=${data}`;
        }
      },
      openFileSelect() {
        $('#importFile').click()
      },
      importData() {
        const vm = this;
        const formData = new FormData();
        const importFile = document.querySelector('#importFile');
        formData.append("upload", importFile.files[0]);
        axios.post('/api/speaker/import', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        }).then(response => {
          $("#importFile").val('');
          helper.alert(response.data.message)
          vm.getSpeakerData();
        }).catch(error => {
          $("#importFile").val('');
          helper.alert(error.response.data.message, 'danger')
        })
      }
    },
    mounted() {
      this.initCol();
      this.getSpeakerOption();
      this.getSpeakerData();
      const clipboard = new Clipboard('.copy');
    },
  };
</script>

<style scoped>
  .v-align-middle {
    vertical-align: middle !important;
  }
</style>

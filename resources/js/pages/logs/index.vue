<template>
  <div class="container-fluid">
    <h1>System log</h1>
    <div class="row mb-3">
      <div class="col-12 col-sm-3 col-md-2 col-lg-2">
        <div class="input-group input-group-sm">
          <div class="input-group-addon" style="background-color: #eee">
            <i class="glyphicon glyphicon-bookmark"></i>
          </div>
          <select class="form-control" name="table_status"
            v-model="selectedType" @change="handleSendSearch">
            <option v-for="item in types" :key="item.key"
              :value="item.key">{{ item.value
              }}
            </option>
          </select>
        </div>
      </div>
      <div class="col-12 col-sm-3 col-md-3 col-lg-3">
        <div class="input-group input-group-sm">
          <input type="search" class="form-control"
            placeholder="Search" aria-controls="staff"
            v-model.trim="keyword" @keyup.enter="handleSendSearch">
        </div>
      </div>
    </div>
    <div id="staff_wrapper" class="dataTables_wrapper dt-bootstrap">
      <div class="row">
        <div class="col-10 col-sm-12 col-md-12 col-lg-12 table-responsive">
          <table id="staff" class="table table-bordered table-striped dataTable"
            role="grid" aria-describedby="staff_info">
            <thead>
              <tr role="row">
                <th v-for="row in logHead" class="sortfield"
                  :key="row.key" tabindex="0">
                  {{ row.value }}
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in logContentsBySearch"
                :key="item.id">
                <td>{{ item.createdAt |
                  timeFormat}}</td>
                <td>{{ item.user }}</td>
                <td>{{ item.type.value }}</td>
                <td>{{ item.desc }}</td>
                <td>{{ item.device }}</td>
                <td>{{ item.ip }}</td>
                <td>{{ item.browser }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="row">
        <div class="col-12 col-sm-5">
          <div class="dataTables_info" id="group_info"
            role="status" aria-live="polite">
            Showing {{ pageInfo.list_from }} to
            {{ pageInfo.list_to
            }} of {{ pageInfo.total }} entries
          </div>
        </div>
        <div class="col-12 col-sm-7">
          <Pagination :pageInfo="pageInfo"
            @onChangePage="onChangePage" />
        </div>
      </div>
    </div>

  </div>
</template>
<script>
import axios from "axios";
import logContentsData from "../../../json/logs.json";
export default {
  name: 'logs',
  data() {
    return {
      logHead: [
        {
          value: "時間",
          key: "createdAt"
        },
        {
          value: "使用者",
          key: "user"
        },
        {
          value: "類型",
          key: "type"
        },
        {
          value: "內容",
          key: "desc"
        },
        {
          value: "Device",
          key: "device"
        },
        {
          value: "IP",
          key: "ip"
        },
        {
          value: "Browser",
          key: "browser"
        }
      ],
      logContents: [
        // {
        //   id: 0,
        //   createdAt: "1558759864244",
        //   user: "Mars",
        //   type: {
        //     key: "edit",
        //     value: "編輯"
        //   },
        //   desc: "器材管理",
        //   device: "Mac OS",
        //   ip: "127.0.0.0.1",
        //   browser: "chrome 74.0.1"
        // }
      ],
      types: [
        {
          key: "all",
          value: "All"
        },
        {
          key: "edit",
          value: "編輯"
        },
        {
          key: "created",
          value: "新增"
        },
        {
          key: "delete",
          value: "刪除"
        }
      ],
      selectedType: "all",
      keyword: "",
      keywordFilter: "",
      pageInfo: {
        current_page: 1,
        limit: 25,
        last_page: 1,
        total: 1,
        list_from: 1,
        list_to: 25
      }
    };
  },
  computed: {
    // client search
    logContentsBySearch() {
      let tempData = this.logContents;
      // 過濾 type
      if (this.selectedType !== "all") {
        tempData = tempData.filter(item => item.type.key === this.selectedType);
      }
      // 過濾 keyword (user、desc)
      const filterByUser = this.fuzzyQuery(
        tempData,
        "user",
        this.keywordFilter
      );
      const filterByContent = this.fuzzyQuery(
        tempData,
        "desc",
        this.keywordFilter
      );
      // 將 filter 完的 user、desc 資料合併，最後使用 Set 剔除重複內容
      let finalData = filterByUser.concat(filterByContent);
      finalData = [...new Set(finalData)];
      if (finalData) tempData = finalData;
      this.pageInfo.total = finalData.length;
      this.pageInfo.last_page = Math.ceil(
        this.pageInfo.total / this.pageInfo.limit
      );
      // 依據創建時間排序
      return tempData.sort((a, b) => {
        return b.createdAt - a.createdAt; //從大到小
      });
    }
  },
  watch: {
    // 監聽 search 輸入框
    keyword(val) {
      this.keywordFilter = val;
    }
  },
  methods: {
    // 模糊搜尋
    fuzzyQuery(data, queryType, keyword) {
      const reg = new RegExp(keyword, "gi");
      var arr = [];
      for (var i = 0; i < data.length; i++) {
        if (reg.test(data[i][queryType])) {
          arr.push(data[i]);
        }
      }
      return arr;
    },
    onChangePage(page) {
      this.pageInfo.current_page = page;
      this.handleSendSearch();
      console.log("change", page);
    },
    handleSendSearch() {
      const searchData = {
        keyword: this.keyword,
        type: this.selectedType
      };
      // 發送 api ...
      // let self = this;
      // const apiUrl = "/api/logs?search";
      // axios
      //   .get(
      //     apiUrl +
      //       this.keywordFilter +
      //       "&limit=" +
      //       self.pageInfo.limit +
      //       "&page=" +
      //       self.pageInfo.current_page
      //   )
      //   .then(response => {
      //     let self = this;
      //     let res = response.data.data;
      //     self.list = res.data;
      //     self.pageInfo.current_page = res.current_page;
      //     self.pageInfo.last_page = res.last_page;
      //     self.pageInfo.total = res.total;
      //     self.pageInfo.list_from = res.from;
      //     self.pageInfo.list_to = res.to;
      //   })
      //   .catch(error => {
      //     console.log(error);
      //   });
    },
    // 本地假資料
    logContentsInit() {
      this.logContents = logContentsData.logContents;
    }
  },
  created() {
    this.logContentsInit();
  },
  mounted() {
    this.handleSendSearch();
  }
};
</script>

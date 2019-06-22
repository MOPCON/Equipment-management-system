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
            v-model="selectedType">
            <option v-for="item in types" :key="item.id"
              :value="item.id">{{ item.name }}</option>
          </select>
        </div>
      </div>
      <div class="col-12 col-sm-9 col-md-9 col-lg-9">
        <form class="form-inline" @submit.prevent="loadSystemLog">
          <div class="form-group input-group-sm">
            <input type="search" class="form-control" placeholder="使用者" aria-controls="staff" v-model.trim="username">
            <input type="search" class="form-control ml-2" placeholder="內容" aria-controls="staff" v-model.trim="content">
          </div>
          <button type="submit" class="btn btn-primary btn-s ml-2">搜尋</button>
        </form>
      </div>
    </div>
    <div class="row" v-if="error">
      <div class="col">
        <div class="alert alert-danger" role="alert">{{errorMsg}}</div>
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
                  :class="row.key" :key="row.key" tabindex="0">
                  {{ row.value }}
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in logContentsBySearch" :key="item.id">
                <td>{{ item.updated_at }}</td>
                <td>{{ item.user.name }}</td>
                <td>{{ item.type.name }}</td>
                <td>{{ item.content }}</td>
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
          <div class="dataTables_info" id="group_info" role="status" aria-live="polite">
            Showing {{ pageInfo.list_from }} to {{ pageInfo.list_to }} of {{ pageInfo.total }} entries
          </div>
        </div>
        <div class="col-12 col-sm-7">
          <Pagination :pageInfo="pageInfo" @onChangePage="onChangePage" />
        </div>
      </div>
    </div>

  </div>
</template>
<script>
import axios from "axios";
import logContentsData from "../../../json/logs.json";
export default {
  name: "logs",
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
      logContents: [],
      types: [
        {
          id: 0,
          name: "All"
        }
      ],
      selectedType: 0,
      username: "",
      content: "",
      pageInfo: {
        current_page: 1,
        limit: '15',
        last_page: 1,
        total: 1,
        list_from: 1,
        list_to: 15
      },
      error: false,
      errorMsg: '',
    };
  },
  computed: {
    logContentsBySearch() {
      let tempData = this.logContents;
      // 過濾 type
      if (this.selectedType !== 0) {
        tempData = tempData.filter(item => item.type_id === this.selectedType);
      }

      this.pageInfo.total = tempData.length;
      this.pageInfo.last_page = Math.ceil(
        this.pageInfo.total / this.pageInfo.limit
      );
      // 依據創建時間排序
      return tempData.sort((a, b) => {
        return b.createdAt - a.createdAt; //從大到小
      });
    }
  },
  methods: {
    onChangePage(page) {
      this.pageInfo.current_page = page;
      this.loadSystemLog();
    },
    loadSystemLogType() {
      this.errorInit();

      axios
        .get("api/system-log-type")
        .then(({ data, status }) => {
          if (status === 200) {
            if (this.types.length === 1) {
              this.types = this.types.concat(data.data);
            }
          }
        })
        .catch(error => {
          this.error = true;
          this.errorMsg = error.message;
        });
    },
    loadSystemLog() {
      this.errorInit();

      const searchData = {
        search: {
          username: this.username,
          content: this.content
        },
        page: this.pageInfo.current_page
      };
      const url = 'api/system-log';

      axios
        .get(url, { params: searchData })
        .then(({ data, status }) => {
          if (status === 200) {
            this.logContents = data.data.data;
            this.pageInfo.current_page = data.data.current_page;
            this.pageInfo.last_page = data.data.last_page;
            this.pageInfo.total = data.data.total;
            this.pageInfo.list_from = data.data.from;
            this.pageInfo.list_to = data.data.to;

            this.searchInit();
          }
        })
        .catch(error => {
          this.error = true;
          this.errorMsg = error.message
        });
    },
    errorInit() {
      this.error = false;
      this.errorMsg = '';
    },
    searchInit() {
      this.username = '';
      this.content = '';
      this.selectedType = 0;
    }
  },
  mounted() {
    this.loadSystemLogType();
    this.loadSystemLog();
  }
};
</script>

<style lang="scss" scoped>
.sortfield.type {
  min-width: 120px;
}

.btn-s {
  padding: 3px 20px;
}

@media (max-width: 1024px) {
  .sortfield.type {
    min-width: 80px;
  }
}
</style>

<template>
    <div class="container-fluid">
        <h1>
            學生驗票
            <small>Student Verify</small>
        </h1>
        <div class="row mb-3">
            <div class="col-12 col-sm-2 col-md-2 col-lg-1">
                <button type="button" class="btn btn-sm btn-primary btn-block" v-on:click="openFileSelect">
                    <font-awesome-icon icon="plus"/>
                    Upload
                </button>
                <input type="file" style="display:none" id="importFile" v-on:change="getData()">
            </div>
        </div>
        <div class="row">
            <div class="col-10 col-sm-12 col-md-12 col-lg-12 table-responsive">
                <table id="student" class="table table-bordered table-striped dataTable" role="grid"
                       aria-describedby="staff_info">
                    <thead>
                    <tr role="row">
                        <th class="sortfield" tabindex="0">驗證狀態</th>
                        <th class="sortfield" tabindex="0">驗證</th>
                        <th class="sortfield" tabindex="0">驗證人員</th>
                        <th class="sortfield" tabindex="0">訂單編號</th>
                        <th class="sortfield" tabindex="0">報名序號</th>
                        <th class="sortfield" tabindex="0">購票日期</th>
                        <th class="sortfield" tabindex="0">姓名</th>
                        <th class="sortfield" tabindex="0">Email</th>
                        <th class="sortfield" tabindex="0">學校名稱</th>
                        <th class="sortfield" tabindex="0">上傳檔案</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item, index) in list">
                        <td>
                            <span v-show="item.is_verify" class="label label-success">通過</span>
                            <span v-show="!item.is_verify" class="label label-default">未驗證</span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-default btn-block"
                                    v-on:click="openVerifyData(index)">
                                <font-awesome-icon icon="edit"/>
                            </button>
                            <button type="button" class="btn btn-sm btn-default btn-block"
                                    v-on:click="update(index, true, false)" v-show="!item.is_verify">
                                <font-awesome-icon icon="check"/>
                            </button>
                            <button v-show="item.id != null" type="button" class="btn btn-sm btn-default btn-block"
                                    v-on:click="deleteData(item.id, index)">
                                <font-awesome-icon icon="trash"/>
                            </button>
                        </td>
                        <td>{{ item.verify_user_name }}</td>
                        <td>{{ item.order_id }}</td>
                        <td>{{ item.register_no }}</td>
                        <td>{{ item.purchase_date}}</td>
                        <td>{{ item.name}}</td>
                        <td>{{ item.email }}</td>
                        <td>{{ item.school }}</td>
                        <td>
                            <img class="pointer" v-bind:src="item.file_url" v-show="item.file_type === 'image'"
                                 v-on:click="openWindow(item.file_url)" width="100px">
                            <span v-show="item.file_type === 'pdf'">
                                                    <a v-bind:href="item.file_url" target="_blank">
                                                        <font-awesome-icon icon="file-pdf"/>
                                                    </a>
                                                    {{ item.file_url }}
                                                </span>
                            <span v-show="item.file_type !== 'image' && item.file_type !== 'pdf'">
                                                    <a v-bind:href="item.file_url"
                                                       target="_blank"> {{ item.file_url }}</a>
                                                </span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <Modal target="verifyStudent" size="xs">
            <template v-slot:title>
                <h4 class="modal-title" id="myModalLabel">Student Verify</h4>
            </template>
            <template v-slot:header>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </template>
            <template v-slot:body>
                <form name="addStaff">
                    <div class="form-group">
                        <strong>kktix 訂單編號: </strong>
                        {{ student_verify.order_id }}
                    </div>
                    <div class="form-group">
                        <strong>kktix 報名序號: </strong>
                        {{ student_verify.register_no }}
                    </div>
                    <div class="form-group">
                        <strong>kktix 檔案: </strong>
                        <img class="pointer" v-bind:src="student_verify.file_url"
                             v-show="student_verify.file_type === 'image'"
                             v-on:click="openWindow(student_verify.file_url)" width="300px">
                        <span v-show="student_verify.file_type === 'pdf'">
                                                    <a v-bind:href="student_verify.file_url" target="_blank">
                                                        <span class="fa fa-file-pdf-o fa-2x"></span>
                                                    </a>
                                                    {{ student_verify.file_url }}
                                                </span>
                        <span v-show="student_verify.file_type !== 'image' && student_verify.file_type !== 'pdf'">
                                                    <a v-bind:href="student_verify.file_url" target="_blank"> {{ student_verify.file_url }}</a>
                                                </span>
                    </div>
                    <div class="form-group">
                        <strong>購票日期</strong>
                        <input type="date" v-model="student_verify.purchase_date" name="purchase_date"
                               class="form-control" required>
                    </div>
                    <div class="form-group">
                        <strong>驗證通過</strong>
                        <input type="checkbox" v-model="student_verify.is_verify" name="is_verify">
                    </div>
                    <div class="form-group">
                        <strong>姓名</strong>
                        <input type="text" v-model="student_verify.name" name="name"
                               class="form-control" placeholder="Name" required>
                    </div>
                    <div class="form-group">
                        <strong>Email</strong>
                        <input type="text" v-model="student_verify.email" name="email"
                               class="form-control" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <strong>學校名稱</strong>
                        <input type="text" v-model="student_verify.school" name="school"
                               class="form-control" placeholder="School" required/>
                    </div>
                    <div>
                        <strong>審核者備註</strong>
                        <textarea class="form-control" v-model="student_verify.comment"></textarea>
                    </div>
                </form>
            </template>
            <template v-slot:footer>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary"
                        v-on:click="update(verify_index, student_verify.is_verify, true)">
                    儲存
                </button>
            </template>
        </Modal>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                list: [],
                student_verify: {},
                verify_index: 0
            };
        },
        methods: {
            openFileSelect() {
                $('#importFile').click();
            },
            getData() {
                let self = this;
                let formData = new FormData();
                let importFile = document.querySelector('#importFile');
                self.list = null;
                formData.append("file", importFile.files[0]);

                axios.post(
                    '/api/student/upload', formData
                ).then(response => {
                    console.log(response);
                    self.list = response.data.data;
                    helper.alert(response.data.message);
                }).catch(error => {
                    console.error(error);
                    helper.alert('發生錯誤!', 'danger');
                });
            },
            openVerifyData(index) {
                let self = this;
                self.student_verify = Object.assign({}, self.list[index]);
                self.verify_index = index;
                $('#verifyStudent').modal('show');
            },
            update(index, is_verify, hide_modal = false) {
                let self = this;
                let verify_data = self.list[index];
                let data = {
                    verify_year: new Date().getFullYear(),
                    is_verify: is_verify,
                    order_id: verify_data.order_id,
                    register_no: verify_data.register_no,
                    purchase_date: (hide_modal) ? self.student_verify.purchase_date : verify_data.purchase_date,
                    name: (hide_modal) ? self.student_verify.name : verify_data.name,
                    email: (hide_modal) ? self.student_verify.email : verify_data.email,
                    school_name: (hide_modal) ? self.student_verify.school : verify_data.school,
                    file_link: verify_data.file_url,
                    comment: (hide_modal) ? self.student_verify.comment : verify_data.comment
                };
                axios.post(
                    '/api/student', data
                ).then(response => {
                    let res = response.data.data;
                    res.school = res.school_name;
                    res.file_url = res.file_link;
                    res.file_type = verify_data.file_type;
                    res.verify_user_name = res.user.name;
                    this.$set(self.list, index, res);
                    if (hide_modal) {
                        $('#verifyStudent').modal('hide');
                    }
                    helper.alert(response.data.message);
                }).catch(error => {
                    console.error(error);
                    if (hide_modal) {
                        $('#verifyStudent').modal('hide');
                    }
                    helper.alert('發生錯誤!', 'danger');
                });
            },
            deleteData(id, index) {
                let self = this;
                helper.deleteConfirm(function () {
                    axios.delete(
                        '/api/student/' + id
                    ).then(response => {
                        console.log(response);
                        self.list.splice(index, 1);
                        helper.alert(response.data.message);
                    }).catch(error => {
                        console.log(error);
                        helper.alert('發生錯誤!', 'danger');
                    });
                });
            },
            openWindow(url) {
                window.open(url);
            }
        },
        mounted() {

        }
    };
</script>

<style scoped>

</style>
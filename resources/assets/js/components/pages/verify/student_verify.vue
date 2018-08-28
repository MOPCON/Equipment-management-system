<template>
    <div>
        <section class="content-header">
            <h1>
                學生驗票
                <small>Student Verify</small>
            </h1>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="box">
                    <div class="box-body">
                        <div id="student_verify_wrapper" class="dataTables_wrapper dt-bootstrap">
                            <div class="row">
                                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-1">
                                    <button type="button" class="btn btn-sm btn-primary btn-block" v-on:click="openFileSelect">
                                        <span class="glyphicon glyphicon-plus"></span> Upload
                                    </button>
                                    <input type="file" style="display:none" id="importFile" v-on:change="getData()">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-10 col-sm-12 col-md-12 col-lg-12 table-responsive">
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
                                                <button type="button" class="btn btn-sm btn-default btn-block" v-on:click="openVerifyData(index)">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            </td>
                                            <td>哈西</td>
                                            <td>{{ item.order_id }}</td>
                                            <td>{{ item.no }}</td>
                                            <td>{{ item.purchase_date}}</td>
                                            <td>{{ item.name}}</td>
                                            <td>{{ item.email }}</td>
                                            <td>{{ item.school }}</td>
                                            <td>
                                                <img v-bind:src="item.file_url" v-show="item.file_type === 'image'" width="100px">
                                                <span v-show="item.file_type === 'pdf'"><a v-bind:href="item.file_url" target="_blank"><span class="fa fa-file-pdf-o fa-2x"></span></a> {{ item.file_url }}</span>
                                                <span v-show="item.file_type !== 'image' && item.file_type !== 'pdf'"><a v-bind:href="item.file_url" target="_blank"> {{ item.file_url }}</a></span>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="verifyStudent" tabindex="-1" role="dialog"
                             aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <h4 class="modal-title" id="myModalLabel">Student Verify</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form name="addStaff">
                                            <div class="form-group">
                                                <strong>kktix 訂單編號: </strong>
                                                {{ student_verify.order_id }}
                                            </div>
                                            <div class="form-group">
                                                <strong>kktix 報名序號: </strong>
                                                {{ student_verify.no }}
                                            </div>
                                            <div class="form-group">
                                                <strong>kktix 檔案網址: </strong>
                                                {{ student_verify.file_url }}
                                            </div>
                                            <div class="form-group">
                                                <strong>購票日期</strong>
                                                <input type="date" v-model="student_verify.purchase_date" name="purchase_date"
                                                       class="form-control" required>
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
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                        </button>
                                        <button type="button" class="btn btn-primary" v-on:click="verifyData(verify_index)">
                                            儲存並通過驗證
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                list: [],
                student_verify: {},
                verify_index: 0
            }
        },
        methods: {
            openFileSelect() {
                $('#importFile').click()
            },
            getData() {
                let self = this;
                var formData = new FormData();
                var importFile = document.querySelector('#importFile');
                formData.append("file", importFile.files[0]);

                axios.post(
                    '/api/student/upload', formData
                ).then(response => {
                    console.log(response);
                    self.list = response.data.data;
                }).catch(error => {
                    console.error(error);
                });
            },
            openVerifyData(index) {
                let self = this;
                self.student_verify = self.list[index];
                self.verify_index = index;
                $('#verifyStudent').modal('show');
            },
            verifyData() {
                let self = this;
                var data = {
                    verify_year: new Date().getFullYear(),
                    order_id: self.student_verify.order_id,
                    register_no: self.student_verify.no,
                    purchase_date: self.student_verify.purchase_date,
                    name: self.student_verify.name,
                    email: self.student_verify.email,
                    school_name: self.student_verify.school,
                    file_link: self.student_verify.file_url,
                    comment: self.student_verify.comment
                };
                axios.post(
                    '/api/student', data
                ).then(response => {
                    self.list[self.verify_index] = self.student_verify;
                    self.list[self.verify_index].is_verify = true;
                    $('#verifyStudent').modal('hide');
                    console.log(self.list[self.verify_index]);
                }).catch(error => {
                    console.error(error);
                });
            }
        },
        created: function () {

        }
    }
</script>

<style scoped>

</style>
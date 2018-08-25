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
                                        <input type="file" style="display:none" id="importFile" v-on:change="getData()">
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-10 col-sm-12 col-md-12 col-lg-12 table-responsive">
                                    <table id="student" class="table table-bordered table-striped dataTable" role="grid"
                                           aria-describedby="staff_info">
                                        <thead>
                                        <tr role="row">
                                            <th class="sortfield" tabindex="0">驗證通過</th>
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
                                        <tr v-for="item in list">
                                            <td><input type="checkbox"></td>
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
                list: []
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
            }
        },
        created: function () {

        }
    }
</script>

<style scoped>

</style>
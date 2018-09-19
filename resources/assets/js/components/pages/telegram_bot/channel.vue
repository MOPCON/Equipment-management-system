<template>
    <div>
        <section class="content-header">
            <h1>
                頻道
                <small>Telegram Channel</small>
            </h1>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="box">
                    <div class="box-body">
                        <div id="student_verify_wrapper" class="dataTables_wrapper dt-bootstrap">
                            <div class="row">
                                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-1">
                                    <button type="button" class="btn btn-sm btn-primary btn-block" v-on:click="openAddChannel">
                                        <span class="glyphicon glyphicon-plus"></span> Add
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-10 col-sm-12 col-md-12 col-lg-12 table-responsive">
                                    <table id="student" class="table table-bordered table-striped dataTable" role="grid"
                                           aria-describedby="staff_info">
                                        <thead>
                                        <tr role="row">
                                            <th class="sortfield" tabindex="0">id</th>
                                            <th class="sortfield" tabindex="0">名稱</th>
                                            <th class="sortfield" tabindex="0">Code</th>
                                            <th class="sortfield" tabindex="0">Created At</th>
                                            <th class="sortfield" tabindex="0">Updated At</th>
                                            <th class="sortfield" tabindex="0"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="item in list">
                                            <td>{{ item.id }}</td>
                                            <td>{{ item.name }}</td>
                                            <td>{{ item.code }}</td>
                                            <td>{{ item.created_at}}</td>
                                            <td>{{ item.updated_at}}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary"
                                                        v-on:click="openEditChannel(item.id)">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger"
                                                        v-on:click="deleteChannel(item.id)">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="addChannel" tabindex="-1" role="dialog"
                         aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span aria-hidden="true">&times;</span>
                                        <span class="sr-only">Close</span>
                                    </button>
                                    <h4 v-if="action === 'new'" class="modal-title">Add Channel</h4>
                                    <h4 v-if="action === 'edit'" class="modal-title">Edit Channel</h4>
                                </div>
                                <div class="modal-body">
                                    <form name="addStaff">
                                        <div class="form-group">
                                            <strong>名稱</strong>
                                            <input type="text" name="name" v-model="add_channel.name"
                                                   class="form-control" placeholder="Name" required>
                                        </div>
                                        <div class="form-group">
                                            <strong>Code</strong>
                                            <input type="text" name="code" v-model="add_channel.code"
                                                   class="form-control" placeholder="Code" required>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button v-if="action === 'new'" type="button" class="btn btn-primary" v-on:click="addChannel">新增</button>
                                    <button v-if="action === 'edit'" type="button" class="btn btn-primary" v-on:click="editChannel(add_channel.id)">修改</button>
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
                add_channel: {
                    name: '',
                    code: ''
                },
                list: [],
                action: 'new'
            }
        },
        methods: {
            getAllChannel() {
                let self = this;
                axios.get(
                    '/api/telegram-channel'
                ).then(response => {
                    self.list = response.data.data;
                }).catch(error => {
                    console.log(error);
                });
            },
            openAddChannel() {
                let self = this;
                self.initChannel();
                $('#addChannel').modal('show');
            },
            addChannel() {
                let self = this;
                console.log(self.add_channel);
                axios.post(
                    '/api/telegram-channel', self.add_channel
                ).then(response => {
                    $('#addChannel').modal('hide');
                    self.getAllChannel();
                    helper.alert(response.data.message);
                }).catch(error => {
                    console.log(error.response);
                    helper.alert(error.response.data.message, 'danger');
                });
            },
            openEditChannel(id) {
                let self = this;
                axios.get(
                    '/api/telegram-channel/' + id
                ).then(response => {
                    self.add_channel = response.data.data;
                    self.action = 'edit';
                    $('#addChannel').modal('show');
                }).catch(error => {
                    console.log(error)
                });
            },
            editChannel(id) {
                let self = this;
                let data = {
                    id: self.add_channel.id,
                    name: self.add_channel.name,
                    code: self.add_channel.code,
                    _method: 'PUT'
                };
                axios.post(
                    '/api/telegram-channel/' + id, data
                ).then(response => {
                    $('#addChannel').modal('hide');
                    self.getAllChannel();
                    helper.alert(response.data.message);
                }).catch(error => {
                    console.log(error)
                    helper.alert(error.response.data.message, 'danger')
                })
            },
            deleteChannel(id) {
                let self = this;
                helper.deleteConfirm(function () {
                    axios.delete(
                        '/api/telegram-channel/' + id
                    ).then(response => {
                        helper.alert(response.data.message);
                        self.getAllChannel();
                    }).catch(error => {
                        console.log(error);
                        helper.alert(error.response.data.message, 'danger');
                    });
                });
            },
            initChannel() {
                let self = this;
                self.add_channel = {
                    name: '',
                    code: ''
                };
            }
        },
        created: function () {
            let self = this;
            self.getAllChannel();
        }
    }
</script>
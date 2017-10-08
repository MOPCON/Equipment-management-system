<template>
    <div>
        <section class="content-header">
            <h1>
                使用者管理 <small>Users</small>
            </h1>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="box">
                    <div class="box-body">
                        <div id="user_wrapper" class="dataTables_wrapper dt-bootstrap">
                            <div class="row">
                                <div class="col-xs-12 col-sm-1 col-md-1 col-lg-1">
                                    <button type="button" class="btn btn-sm btn-primary btn-block" v-on:click="openAddUser()">
                                        <span class="glyphicon glyphicon-plus"></span>&nbsp;Add
                                    </button>
                                </div>
                                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-1">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-addon" style="background-color: #eee">
                                            <i class="glyphicon glyphicon-list"></i>
                                        </div>
                                        <select class="form-control" name="user_length" v-model="page_info.limit" @change="setPageLimit()">
                                            <option value="10">10</option>
                                            <option value="15">15</option>
                                            <option value="20">20</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-addon" style="background-color: #eee"><i class="glyphicon glyphicon-search"></i></span>
                                        <input type="search" class="form-control" placeholder="Search" aria-controls="user" v-model="page_info.search" v-on:keyup="searchKeyword($event)">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-10 col-sm-12 col-md-12 col-lg-12 table-responsive">
                                    <table id="user" class="table table-bordered table-striped dataTable" role="grid"
                                           aria-describedby="user_info">
                                        <thead>
                                        <tr role="row">
                                            <th v-for="row in col" class="sortfield" tabindex="0" v-on:click="changeSort(row.key)">
                                                {{ row.name }}
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="item in list">
                                            <td>{{ item.id }}</td>
                                            <td>{{ item.name }}</td>
                                            <td>{{ item.email }}</td>
                                            <td>{{ item.created_at }}</td>
                                            <td>{{ item.updated_at }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary" v-on:click="openEditUser(item.id, 'edit')">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-warning" v-on:click="openEditPassword(item.id)">
                                                    <i class="fa fa-key"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger" v-on:click="deleteUser(item.id)">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="dataTables_info" id="user_info" role="status" aria-live="polite">
                                        Showing {{ page_info.list_from }} to {{ page_info.list_to }} of {{ page_info.total }} entries
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <div class="dataTables_paginate paging_simple_numbers" id="user_paginate">
                                        <ul class="pagination">
                                            <li class="paginate_button previous" id="user_previous" v-bind:class="[page_info.current_page-1 == 0 ? 'disabled' : '']">
                                                <a aria-controls="user" data-dt-idx="0" tabindex="0" v-on:click="changePage(page_info.current_page-1)">Previous</a>
                                            </li>
                                            <li v-for="i in getPageArray" class="paginate_button" v-bind:class="[page_info.current_page == i ? 'active' : '']">
                                                <a aria-controls="user" data-dt-idx="1" tabindex="0" v-on:click="changePage(i)">{{ i }}</a>
                                            </li>
                                            <li class="paginate_button next" id="user_next" v-bind:class="[page_info.current_page+1 > page_info.last_page ? 'disabled' : '']">
                                                <a aria-controls="user" data-dt-idx="7" tabindex="0"  v-on:click="changePage(page_info.current_page+1)">Next</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- 新增/修改 Modal -->
                        <div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <h4 v-if="action == 'new'" class="modal-title" id="myModalLabel">Add User</h4>
                                        <h4 v-if="action == 'edit'" class="modal-title" id="myModalLabel">Edit User</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form name="addUser">
                                            <div v-if="action == 'edit'" class="form-group">
                                                <strong>ID: </strong>
                                                {{ add_user.id }}
                                            </div>
                                            <div class="form-group">
                                                <strong>名稱</strong>
                                                <input type="text" v-model="add_user.name" name="name" class="form-control" placeholder="Name" required>
                                            </div>
                                            <div class="form-group">
                                                <strong>Email</strong>
                                                <input type="text" v-model="add_user.email" name="email" class="form-control" placeholder="Email" required>
                                            </div>
                                            <div v-if="action == 'new'" class="form-group">
                                                <strong>密碼</strong>
                                                <input type="password" v-model="add_user.password" name="password" class="form-control" placeholder="Password" required>
                                            </div>
                                            <div v-if="action == 'new'" class="form-group">
                                                <strong>確認密碼</strong>
                                                <input type="password" v-model="add_user.password_confirmation" name="password confirmation" class="form-control" placeholder="Password Confirmation" required>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button v-if="action == 'new'" type="button" class="btn btn-primary" v-on:click="createNewUser()">Create</button>
                                        <button v-if="action == 'edit'" type="button" class="btn btn-primary" v-on:click="saveUser(add_user.id)">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- 變更密碼 Modal -->
                        <div class="modal fade" id="changePassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <h4 vclass="modal-title" id="myModalLabel">Change Password</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form name="changePassword">
                                            <div class="form-group">
                                                <strong>ID: </strong>
                                                {{ change_password.id }}
                                            </div>
                                            <div class="form-group">
                                                <strong>密碼</strong>
                                                <input type="password" v-model="change_password.password" name="password" class="form-control" placeholder="Password" required>
                                            </div>
                                            <div class="form-group">
                                                <strong>確認密碼</strong>
                                                <input type="password" v-model="change_password.password_confirmation" name="password confirmation" class="form-control" placeholder="Password Confirmation" required>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" v-on:click="changePassword()">Change</button>

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
                col: [],
                page_info: [],
                add_user: [],
                change_password: [],
                action: 'new',
            }
        },
        computed: {
            getPageArray: function () {
                var self = this;
                var bottom = self.page_info.current_page - 2 <= 0 ? 1 : self.page_info.current_page - 2;
                var top = bottom + 5 > self.page_info.last_page ? self.page_info.last_page : bottom + 5;
                var array = [];
                for (var i = bottom; i <= top; i++) {
                    array.push(i);
                }
                return array;
            },
        },
        methods: {
            initCol: function() {
                var self = this;
                self.col = [{
                    name: 'id',
                    key: 'id'
                }, {
                    name: 'Name',
                    key: 'name'
                }, {
                    name: 'Email',
                    key: 'email'
                }, {
                    name: 'Created_At',
                    key: 'created_at'
                }, {
                    name: 'Update_At',
                    key: 'updated_at'
                }, {
                    name: '',
                    key: ''
                }];
            },
            initUser: function() {
                var self = this;
                self.add_user = {
                    id: '',
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                };
            },
            initPassword: function () {
                var self = this;
                self.change_password = {
                    id: '',
                    password: '',
                    password_confirmation: ''
                };
            },
            getAllUser: function() {
                var self = this;
                axios.get(
                    '/api/user?search=' + self.page_info.search + '&orderby_field=' + self.page_info.sort_key + '&orderby_method=' + self.page_info.sort_dir + '&limit=' + self.page_info.limit + '&page=' +  self.page_info.current_page
                ).then(response => {
                    var self = this;
                    var res = response.data.data;
                    self.list = res.data;
                    self.page_info.current_page = res.current_page;
                    self.page_info.last_page = res.last_page;
                    self.page_info.total = res.total;
                    self.page_info.list_from = res.from;
                    self.page_info.list_to = res.to;
                    console.log(response);
                }).catch(error => {
                    console.log(error);
                });
            },
            setPageLimit: function() {
                this.getAllUser();
            },
            searchKeyword: function(event) {
                if (event.which === 13) {
                    console.log(this.page_info.search);
                    this.getAllUser();
                }
            },
            changePage: function(page) {
                var self = this;
                if (page > 0 && page <= self.page_info.last_page) {
                    self.page_info.current_page = page;
                    this.getAllUser();
                }
            },
            changeSort: function(field) {
                var self = this;
                if (field != '') {
                    self.page_info.sort_dir = self.page_info.sort_dir == 'DESC' ? 'ASC' : 'DESC';
                    self.page_info.sort_key = field;
                    this.getAllUser();
                }
            },
            openAddUser: function() {
                this.action = 'new';
                this.initUser();
                $('#addUser').modal('show');
            },
            createNewUser: function() {
                var self = this;
                var data = {
                    name: self.add_user.name,
                    email: self.add_user.email,
                    password: self.add_user.password,
                    password_confirmation: self.add_user.password_confirmation
                };
                console.log(data);
                axios.post(
                    '/api/user', data
                ).then(response => {
                    $('#addUser').modal('hide');
                    self.getAllUser();
                    console.log(response);
                    helper.alert(response.data.message);
                }).catch(error => {
                    console.log(error.response);
                    helper.alert(error.response.data.message, 'danger');
                });
            },
            saveUser: function(id) {
                var self = this;
                var data = {
                    name: self.add_user.name,
                    email: self.add_user.email,
                    _method: 'PUT'
                };
                axios.post(
                    '/api/user/' + id, data
                ).then(response => {
                    $('#addUser').modal('hide');
                    self.getAllUser();
                    console.log(response);
                    helper.alert(response.data.message);
                }).catch(error => {
                    console.log(error);
                    helper.alert(error.response.data.message, 'danger');
                });
            },
            openEditUser: function(id) {
                var self = this;
                self.action = 'edit';
                axios.get(
                    '/api/user/' + id
                ).then(response => {
                    var res = response.data.data;
                    console.log(response);
                    self.form.action = 'edit'
                    self.add_user = {
                        id: res.id,
                        name: res.name,
                        email: res.email,
                    }
                    $('#addUser').modal('show');
                }).catch(error => {
                    console.log(error);
                });
            },
            openEditPassword: function (id) {
                var self = this;
                self.initPassword();
                self.change_password.id = id;
                $('#changePassword').modal('show');
            },
            changePassword: function() {
                var self = this;
                var data = {
                    password: self.change_password.password,
                    password_confirmation: self.change_password.password_confirmation
                };
                axios.post(
                    '/api/user/password/' + self.change_password.id, data
                ).then(response => {
                    $('#changePassword').modal('hide');
                    self.getAllUser();
                    console.log(response);
                    helper.alert(response.data.message);
                }).catch(error => {
                    console.log(error);
                    helper.alert(error.response.data.message, 'danger');
                });
            },
            deleteUser: function(id) {
                var _self = this;
                helper.deleteConfirm(function () {
                    axios.delete(
                        '/api/user/' + id
                    ).then(response => {
                        console.log(response);
                        helper.alert(response.data.message);
                        _self.getAllUser();
                    }).catch(error => {
                        console.log(error);
                        helper.alert('發生錯誤!', 'danger');
                    });
                });
            },
        },
        created: function () {
            var self = this;
            self.page_info = {
                current_page: 1,
                limit: '15',
                last_page: 1,
                total: 1,
                sort_key: 'id',
                sort_dir: 'DESC',
                search: '',
                list_from: 1,
                list_to: 15
            }
            self.form = {
                action: '',
                submitted: false
            };
            self.initCol();
            self.initUser();
            self.initPassword();
            self.getAllUser();
        },
        watch: {}
    }
</script>

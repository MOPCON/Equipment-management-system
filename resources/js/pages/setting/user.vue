<template>
    <div class="container-fluid">
        <h1>
            使用者管理
            <small>Users</small>
        </h1>

        <div class="row mb-3">
            <div class="col-12 col-sm-2 col-md-2 col-lg-2">
                <button type="button" class="btn btn-sm btn-primary btn-block" @click="openAddUser()">
                    <font-awesome-icon icon="plus"/>&nbsp;Add
                </button>
            </div>
            <div class="col-12 col-sm-2 col-md-2 col-lg-1">
                <div class="input-group input-group-sm">
                    <div class="input-group-addon" style="background-color: #eee">
                        <!--<font-awesome-icon icon="list"/>-->
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
            <div class="col-12 col-sm-3 col-md-3 col-lg-3">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon" style="background-color: #eee"><i
                            class="glyphicon glyphicon-search"></i></span>
                    <input type="search" class="form-control" placeholder="Search" aria-controls="user"
                           v-model="page_info.search" @keyup="searchKeyword($event)">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-10 col-sm-12 col-md-12 col-lg-12 table-responsive">
                <table id="user" class="table table-bordered table-striped dataTable" role="grid"
                       aria-describedby="user_info">
                    <thead>
                    <tr role="row">
                        <th v-for="row in col" class="sortfield" tabindex="0" @click="changeSort(row.key)">
                            {{ row.name }}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in list">
                        <td>{{ item.id }}</td>
                        <td>{{ item.name }}</td>
                        <td>{{ item.email }}</td>
                        <td>{{ item.telegram_id }}</td>
                        <td>{{ item.created_at }}</td>
                        <td>{{ item.updated_at }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary"
                                    @click="openEditUser(item.id, 'edit')">
                                <font-awesome-icon icon="edit"/>
                            </button>
                            <button type="button" class="btn btn-sm btn-warning" @click="openEditPassword(item.id)">
                                <font-awesome-icon icon="key"/>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" @click="deleteUser(item.id)">
                                <font-awesome-icon icon="trash"/>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-5">
                <div class="dataTables_info" id="group_info" role="status" aria-live="polite">
                    Showing {{ page_info.list_from }} to {{ page_info.list_to
                    }} of {{ page_info.total }} entries
                </div>
            </div>
            <div class="col-12 col-sm-7">
                <Pagination :pageInfo="page_info" @onChangePage="onChangePage"/>
            </div>
        </div>

        <!-- 新增/修改 Modal -->
        <Modal target="addUser" size="xs">
            <template v-slot:title>
                <h4 v-if="action == 'new'" class="modal-title">Add User</h4>
                <h4 v-if="action == 'edit'" class="modal-title">Edit User</h4>
            </template>
            <template v-slot:header>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </template>
            <template v-slot:body>
                <form name="addUser">
                    <div v-if="action == 'edit'" class="form-group">
                        <strong>ID: </strong>
                        {{ add_user.id }}
                    </div>
                    <div class="form-group">
                        <strong>名稱</strong>
                        <input type="text" v-model="add_user.name" name="name" class="form-control" placeholder="Name"
                               required>
                    </div>
                    <div class="form-group">
                        <strong>Email</strong>
                        <input type="text" v-model="add_user.email" name="email" class="form-control"
                               placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <strong>Telegram ID</strong>
                        <input type="text" v-model="add_user.telegram_id" name="telegram_id" class="form-control"
                               placeholder="Telegram ID">
                    </div>
                    <div v-if="action == 'new'" class="form-group">
                        <strong>密碼</strong>
                        <input type="password" v-model="add_user.password" name="password" class="form-control"
                               placeholder="Password" required>
                    </div>
                    <div v-if="action == 'new'" class="form-group">
                        <strong>確認密碼</strong>
                        <input type="password" v-model="add_user.password_confirmation" name="password confirmation"
                               class="form-control" placeholder="Password Confirmation" required>
                    </div>
                </form>
            </template>
            <template v-slot:footer>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button v-if="action == 'new'" type="button" class="btn btn-primary" @click="createNewUser()">
                    Create
                </button>
                <button v-if="action == 'edit'" type="button" class="btn btn-primary"
                        @click="saveUser(add_user.id)">Save
                </button>
            </template>
        </Modal>

        <!-- 變更密碼 Modal -->
        <Modal target="changePassword" size="xs">
            <template v-slot:title>
                <h4 vclass="modal-title" id="myModalLabel">Change Password</h4>
            </template>
            <template v-slot:header>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </template>
            <template v-slot:body>
                <form name="changePassword">
                    <div class="form-group">
                        <strong>ID: </strong>
                        {{ change_password.id }}
                    </div>
                    <div class="form-group">
                        <strong>密碼</strong>
                        <input type="password" v-model="change_password.password" name="password"
                               class="form-control" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <strong>確認密碼</strong>
                        <input type="password" v-model="change_password.password_confirmation"
                               name="password confirmation" class="form-control"
                               placeholder="Password Confirmation" required>
                    </div>
                </form>

            </template>
            <template v-slot:footer>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" @click="changePassword()">Change</button>
            </template>
        </Modal>

    </div>
</template>
<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                list: [],
                col: [],
                page_info: [],
                add_user: [],
                change_password: [],
                action: 'new',
            }
        },
        computed: {},
        methods: {
            initCol() {
                const self = this;
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
                    name: 'Telegram ID',
                    key: 'telegram_id'
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
            initUser() {
                const self = this;
                self.add_user = {
                    id: '',
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                };
            },
            initPassword() {
                const self = this;
                self.change_password = {
                    id: '',
                    password: '',
                    password_confirmation: ''
                };
            },
            onChangePage(page) {
                this.page_info.current_page = page;
                this.getAllUser();
            },
            getAllUser() {
                const self = this;
                axios.get(
                    '/api/user?search=' + self.page_info.search + '&orderby_field=' + self.page_info.sort_key + '&orderby_method=' + self.page_info.sort_dir + '&limit=' + self.page_info.limit + '&page=' + self.page_info.current_page
                ).then(response => {
                    const self = this;
                    const res = response.data.data;
                    self.list = res.data;
                    self.page_info.current_page = res.current_page;
                    self.page_info.last_page = res.last_page;
                    self.page_info.total = res.total;
                    self.page_info.list_from = res.from;
                    self.page_info.list_to = res.to;
                }).catch(error => {
                    console.log(error);
                });
            },
            setPageLimit() {
                this.getAllUser();
            },
            searchKeyword(event) {
                if (event.which === 13) {
                    this.getAllUser();
                }
            },
            changeSort(field) {
                const self = this;
                if (field !== '') {
                    self.page_info.sort_dir = self.page_info.sort_dir === 'DESC' ? 'ASC' : 'DESC';
                    self.page_info.sort_key = field;
                    this.getAllUser();
                }
            },
            openAddUser() {
                this.action = 'new';
                this.initUser();
                $('#addUser').modal('show');
            },
            createNewUser() {
                const self = this;
                const data = {
                    name: self.add_user.name,
                    email: self.add_user.email,
                    telegram_id: self.add_user.telegram_id,
                    password: self.add_user.password,
                    password_confirmation: self.add_user.password_confirmation
                };
                axios.post(
                    '/api/user', data
                ).then(response => {
                    $('#addUser').modal('hide');
                    self.getAllUser();
                    helper.alert(response.data.message);
                }).catch(error => {
                    console.log(error.response);
                    helper.alert(error.response.data.message, 'danger');
                });
            },
            saveUser(id) {
                const self = this;
                const data = {
                    name: self.add_user.name,
                    email: self.add_user.email,
                    telegram_id: self.add_user.telegram_id,
                    _method: 'PUT'
                };
                axios.post(
                    '/api/user/' + id, data
                ).then(response => {
                    $('#addUser').modal('hide');
                    self.getAllUser();
                    helper.alert(response.data.message);
                }).catch(error => {
                    console.log(error);
                    helper.alert(error.response.data.message, 'danger');
                });
            },
            openEditUser(id) {
                const self = this;
                self.action = 'edit';
                axios.get(
                    '/api/user/' + id
                ).then(response => {
                    const res = response.data.data;
                    self.form.action = 'edit'
                    self.add_user = {
                        id: res.id,
                        name: res.name,
                        email: res.email,
                        telegram_id: res.telegram_id,
                    }
                    $('#addUser').modal('show');
                }).catch(error => {
                    console.log(error);
                });
            },
            openEditPassword(id) {
                const self = this;
                self.initPassword();
                self.change_password.id = id;
                $('#changePassword').modal('show');
            },
            changePassword() {
                const self = this;
                const data = {
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
            deleteUser(id) {
                const self = this;
                helper.deleteConfirm(function () {
                    axios.delete(
                        '/api/user/' + id
                    ).then(response => {
                        helper.alert(response.data.message);
                        self.getAllUser();
                    }).catch(error => {
                        console.log(error);
                        helper.alert('發生錯誤!', 'danger');
                    });
                });
            },
        },
        mounted() {
            const self = this;
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
            };
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

<template>
    <div class="container-fluid">
        <h1>
            角色管理
            <small>Role</small>
        </h1>

        <div class="row mb-3">
            <div class="col-12 col-sm-2 col-md-2 col-lg-2">
                <button type="button" class="btn btn-sm btn-primary btn-block" @click="openAddRole()">
                    <font-awesome-icon icon="plus"/>&nbsp;Add
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-10 col-sm-12 col-md-12 col-lg-12 table-responsive">
                <table id="role" class="table table-bordered table-striped dataTable" role="grid"
                       aria-describedby="roleInfo">
                    <thead>
                    <tr role="row">
                        <th v-for="row in col" tabindex="0">
                            {{ row.name }}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in list">
                        <td>{{ item.id }}</td>
                        <td>{{ item.name }}</td>
                        <td>{{ item.created_at }}</td>
                        <td>{{ item.updated_at }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary"
                                    @click="openEditRole(item.id, 'edit')">
                                <font-awesome-icon icon="edit"/>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" @click="deleteRole(item.id)">
                                <font-awesome-icon icon="trash"/>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 新增/修改 Modal -->
        <Modal target="addRole" size="xs">
            <template v-slot:title>
                <h4 v-if="action === 'new'" class="modal-title">Add Role</h4>
                <h4 v-if="action === 'edit'" class="modal-title">Edit Role</h4>
            </template>
            <template v-slot:header>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </template>
            <template v-slot:body>
                <form name="addRole">
                    <div v-if="action === 'edit'" class="form-group">
                        <strong>ID: </strong>
                        {{ addRole.id }}
                    </div>
                    <div class="form-group">
                        <strong>名稱</strong>
                        <input type="text" v-model="addRole.name" name="name" class="form-control" placeholder="Name"
                               required>
                    </div>
                    <div class="form-group">
                        <strong>權限</strong><br>
                        <div class="form-check form-check-inline" v-for="(item, index) in permissionList">
                            <input class="form-check-input" type="checkbox" :id="'permission-' + index" :value="item.name" v-model="addRole.permissions">
                            <label class="form-check-label" :for="'permission-' + index">{{ item.description }}</label>
                        </div>
                    </div>
                </form>
            </template>
            <template v-slot:footer>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button v-if="action === 'new'" type="button" class="btn btn-primary" @click="createNewRole()">
                    Create
                </button>
                <button v-if="action === 'edit'" type="button" class="btn btn-primary" @click="saveRole(addRole.id)">
                    Save
                </button>
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
                addRole: [],
                action: 'new',
                permissionList: [],
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
            initRole() {
                const self = this;
                self.addRole = {
                    id: '',
                    name: '',
                    permissions: []
                };
            },
            getAllRole() {
                const self = this;
                axios.get(
                    '/api/role'
                ).then(response => {
                    self.list = response.data.data;
                }).catch(error => {
                    console.log(error);
                });
            },
            getAllPermission() {
                const self = this;
                axios.get(
                    '/api/permission'
                ).then(response => {
                    self.permissionList = response.data.data;
                }).catch(error => {
                    console.log(error);
                });
            },
            openAddRole() {
                this.action = 'new';
                this.initRole();
                $('#addRole').modal('show');
            },
            createNewRole() {
                const self = this;
                const data = {
                    name: self.addRole.name,
                    permissions: self.addRole.permissions
                };
                axios.post(
                    '/api/role', data
                ).then(response => {
                    $('#addRole').modal('hide');
                    self.getAllRole();
                    helper.alert(response.data.message);
                }).catch(error => {
                    console.log(error.response);
                    helper.alert(error.response.data.message, 'danger');
                });
            },
            saveRole(id) {
                const self = this;
                const data = {
                    name: self.addRole.name,
                    permissions: self.addRole.permissions,
                    _method: 'PUT'
                };
                axios.post(
                    '/api/role/' + id, data
                ).then(response => {
                    $('#addRole').modal('hide');
                    self.getAllRole();
                    helper.alert(response.data.message);
                }).catch(error => {
                    console.log(error);
                    helper.alert(error.response.data.message, 'danger');
                });
            },
            openEditRole(id) {
                const self = this;
                self.action = 'edit';
                axios.get(
                    '/api/role/' + id
                ).then(response => {
                    const res = response.data.data;
                    let permissions = res.permissions;
                    let permission = [];
                    permissions.forEach( function (item) {
                        permission.push(item.name);
                    });

                    self.form.action = 'edit';
                    self.addRole = {
                        id: res.id,
                        name: res.name,
                        permissions: permission
                    };
                    $('#addRole').modal('show');
                }).catch(error => {
                    console.log(error);
                });
            },
            deleteRole(id) {
                const self = this;
                helper.deleteConfirm(function () {
                    axios.delete(
                        '/api/role/' + id
                    ).then(response => {
                        helper.alert(response.data.message);
                        self.getAllRole();
                    }).catch(error => {
                        console.log(error);
                        helper.alert('發生錯誤!', 'danger');
                    });
                });
            },
        },
        mounted() {
            const self = this;
            self.form = {
                action: ''
            };
            self.initCol();
            self.initRole();
            self.getAllRole();
            self.getAllPermission();
        }
    }
</script>

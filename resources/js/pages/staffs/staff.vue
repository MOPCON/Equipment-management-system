<template>
    <div>
        <h1>
            工人管理
            <small>Staffs</small>
        </h1>
        <div class="row mb-3">
            <div class="col-12 col-sm-3 col-md-2 col-lg-1">
                <button type="button" class="btn btn-sm btn-primary btn-block"
                        @click="openAddStaff()">
                    <span class="glyphicon glyphicon-plus"></span>&nbsp;新增
                </button>
            </div>
            <div class="col-12 col-sm-3 col-md-2 col-lg-2">
                <div class="input-group input-group-sm">
                    <div class="input-group-addon" style="background-color: #eee">
                        <i class="glyphicon glyphicon-bookmark"></i>
                    </div>
                    <select class="form-control" name="table_status" v-model="group_id">
                        <option value="0">全部</option>
                        <option v-for="item in group" v-bind:value="item.id">{{ item.name }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-12 col-sm-2 col-md-2 col-lg-1">
                <div class="input-group input-group-sm">
                    <div class="input-group-addon" style="background-color: #eee">
                        <i class="glyphicon glyphicon-list"></i>
                    </div>
                    <select class="form-control" name="staff_length" v-model="page_info.limit"
                            @change="setPageLimit()">
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
                    <input type="search" class="form-control" placeholder="Search"
                           aria-controls="staff" v-model="page_info.search"
                           @keyup="searchKeyword($event)">
                </div>
            </div>
        </div>
        <div id="staff_wrapper" class="dataTables_wrapper dt-bootstrap">
            <div class="row">
                <div class="col-10 col-sm-12 col-md-12 col-lg-12 table-responsive">
                    <table id="staff" class="table table-bordered table-striped dataTable" role="grid"
                           aria-describedby="staff_info">
                        <thead>
                        <tr role="row">
                            <th v-for="row in col" class="sortfield" tabindex="0"
                                @click="changeSort(row.key)">
                                {{ row.name }}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item in list">
                            <td>{{ item.id }}</td>
                            <td>{{ item.name }}</td>
                            <td>{{ item.group_name }}</td>
                            <td>{{ item.role_name }}</td>
                            <td>{{ item.duties }}</td>
                            <td>{{ item.email }}</td>
                            <td>{{ item.phone }}</td>
                            <td>{{ item.barcode }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary"
                                        @click="openEditStaff(item.id, 'edit')">
                                    <font-awesome-icon icon="edit"/>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger"
                                        @click="deleteStaff(item.id)">
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
        </div>

        <Modal target="addStaff" size="xs">
            <template v-slot:title>
                <h4 v-if="action === 'new'" class="modal-title">Add Staff</h4>
                <h4 v-if="action === 'edit'" class="modal-title">Edit Staff</h4>
            </template>
            <template v-slot:header>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </template>
            <template v-slot:body>
                <form name="addStaff">
                    <div v-if="action === 'edit'" class="form-group">
                        <strong>ID: </strong>
                        {{ add_staff.id }}
                    </div>
                    <div class="form-group">
                        <strong>名稱</strong>
                        <input type="text" v-model="add_staff.name" name="name"
                               class="form-control" placeholder="Name" required>
                    </div>
                    <div class="form-group">
                        <strong>Email</strong>
                        <input type="text" v-model="add_staff.email" name="email"
                               class="form-control" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <strong>電話</strong>
                        <input type="text" v-model="add_staff.phone" name="phone"
                               class="form-control" placeholder="Phone" required>
                    </div>
                    <div class="form-group">
                        <strong>組別</strong>
                        <select class="form-control" v-model="add_staff.group">
                            <option v-for="item in group" v-bind:value="item.id">{{ item.name
                                }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <strong>角色</strong>
                        <select class="form-control" v-model="add_staff.role">
                            <option v-for="item in roles" v-bind:value="item.id">{{ item.name
                                }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <strong>職責</strong>
                        <input type="text" v-model="add_staff.duties" name="duties"
                               class="form-control" placeholder="Duties" required/>
                    </div>
                    <div v-if="action === 'edit'" class="form-group">
                        <strong>Barcode</strong>
                        <input type="text" v-model="add_staff.barcode" name="phone"
                               class="form-control" placeholder="Phone" required>
                    </div>
                </form>
            </template>
            <template v-slot:footer>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button v-if="action === 'new'" type="button" class="btn btn-primary"
                        @click="createNewStaff">Create
                </button>
                <button v-if="action === 'edit'" type="button" class="btn btn-primary"
                        @click="saveStaff(add_staff.id)">Save
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
                page_info: {},
                group: [],
                group_id: 0,
                add_staff: {
                    id: '',
                    name: '',
                    group: '1',
                    role: '1',
                    duties: '',
                    email: '',
                    phone: '',
                    barcode: ''
                },
                roles: [
                    {
                        id: 0,
                        name: '組員',
                    },
                    {
                        id: 1,
                        name: '副組長',
                    },
                    {
                        id: 2,
                        name: '組長',
                    }
                ],
                action: 'new',
            };
        },
        computed: {},
        methods:
            {
                initCol() {
                    const self = this;
                    self.col = [{
                        name: 'id',
                        key: 'id'
                    }, {
                        name: 'Name',
                        key: 'name'
                    }, {
                        name: 'Group',
                        key: 'group_id'
                    }, {
                        name: 'Role',
                        key: ''
                    }, {
                        name: 'Duties',
                        key: 'duties'
                    }, {
                        name: 'Email',
                        key: 'email'
                    }, {
                        name: 'Phone',
                        key: 'phone'
                    }, {
                        name: 'Barcode',
                        key: 'barcode'
                    }, {
                        name: '',
                        key: ''
                    }];
                },
                initStaff() {
                    this.add_staff = {
                        id: '',
                        name: '',
                        group: '1',
                        role: 0,
                        duties: '',
                        email: '',
                        phone: '',
                        barcode: ''
                    };
                },
                getGroup() {
                    let self = this;
                    axios.get(
                        '/api/group?orderby_method=asc'
                    ).then(response => {
                        const res = response.data.data;
                        self.group = res.data;

                    }).catch(error => {
                        console.log(error);
                    });
                },
                onChangePage(page) {
                    this.page_info.current_page = page;
                    this.getAllStaff();
                },
                getAllStaff() {
                    let self = this;
                    axios.get(
                        '/api/staff?search=' + self.page_info.search + '&orderby_field=' + self.page_info.sort_key + '&orderby_method=' + self.page_info.sort_dir + '&limit=' + self.page_info.limit + '&page=' + self.page_info.current_page +
                        (self.group_id == 0 ? '' : '&group_id[0]=' + self.group_id)
                    ).then(response => {
                        let self = this;
                        let res = response.data.data;
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
                    this.getAllStaff();
                },
                searchKeyword(event) {
                    if (event.which === 13) {
                        this.getAllStaff();
                    }
                },
                changeSort(field) {
                    if (field !== '') {
                        this.page_info.sort_dir = this.page_info.sort_dir === 'DESC' ? 'ASC' : 'DESC';
                        this.page_info.sort_key = field;
                        this.getAllStaff();
                    }
                },
                openAddStaff() {
                    this.action = 'new';
                    this.initStaff();
                    $('#addStaff').modal('show');
                },
                createNewStaff() {
                    let self = this;
                    let data = {
                        name: self.add_staff.name,
                        email: self.add_staff.email,
                        phone: self.add_staff.phone,
                        duties: self.add_staff.duties,
                        group_id: self.add_staff.group,
                        role: self.add_staff.role
                    };

                    axios.post(
                        '/api/staff', data
                    ).then(response => {
                        $('#addStaff').modal('hide');
                        self.getAllStaff();

                        helper.alert(response.data.message);
                    }).catch(error => {
                        console.log(error.response);
                        helper.alert(error.response.data.message, 'danger');
                    });
                },
                saveStaff(id) {
                    let self = this;
                    let data = {
                        name: self.add_staff.name,
                        email: self.add_staff.email,
                        phone: self.add_staff.phone,
                        duties: self.add_staff.duties,
                        group_id: self.add_staff.group,
                        role: self.add_staff.role,
                        barcode: self.add_staff.barcode,
                        _method: 'PUT'
                    };
                    axios.post(
                        '/api/staff/' + id, data
                    ).then(response => {
                        $('#addStaff').modal('hide');
                        self.getAllStaff();

                        helper.alert(response.data.message);
                    }).catch(error => {
                        console.log(error);
                        helper.alert(error.response.data.message, 'danger');
                    });
                },
                openEditStaff(id) {
                    let self = this;
                    self.action = 'edit';
                    axios.get(
                        '/api/staff/' + id
                    ).then(response => {
                        let res = response.data.data;

                        self.form.action = 'edit';
                        self.add_staff = {
                            id: res.id,
                            name: res.name,
                            email: res.email,
                            phone: res.phone,
                            duties: res.duties,
                            barcode: res.barcode,
                            group: res.group_id,
                            role: res.role
                        };
                        $('#addStaff').modal('show');
                    }).catch(error => {
                        console.log(error);
                    });
                },
                deleteStaff(id) {
                    let self = this;
                    helper.deleteConfirm(function () {
                        axios.delete(
                            '/api/staff/' + id
                        ).then(response => {
                            helper.alert(response.data.message);
                            self.getAllStaff();
                        }).catch(error => {
                            console.log(error);
                            helper.alert('發生錯誤!', 'danger');
                        });
                    });
                }
            },
        mounted() {
            this.page_info = {
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
            this.form = {
                action: '',
                submitted: false
            };
            this.initCol();
            this.initStaff();
            this.getAllStaff();
            this.getGroup();
        },
        watch: {
            group_id() {
                this.getAllStaff();
            }
        }
    };
</script>

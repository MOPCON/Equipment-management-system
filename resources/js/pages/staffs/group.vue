<template>
    <div class="container">
        <h1>
            組別管理
            <small>Groups</small>
        </h1>
        <div class="row mb-3">
            <div class="col-12 col-sm-2 col-md-2 col-lg-2">
                <button type="button" class="btn btn-sm btn-primary btn-block" @click="openAddGroup()">
                    <font-awesome-icon icon="plus"/>&nbsp;新增
                </button>
            </div>
            <div class="col-12 col-sm-4 col-md-3 col-lg-2">
                <div class="input-group input-group-sm">
                    <div class="input-group-addon" style="background-color: #eee">
                        <i class="glyphicon glyphicon-list"></i>
                    </div>
                    <select class="form-control" name="group_length" v-model="page_info.limit"
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
        </div>
        <div class="row">
            <div class="table-responsive">
                <table id="group" class="table table-bordered table-striped dataTable" role="grid"
                       aria-describedby="group_info">
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
                        <td>{{ item.manager_name }}</td>
                        <td>{{ item.deputy_manager_name }}</td>
                        <td>{{ item.number }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary"
                                    @click="openEditGroup(item.id, 'edit')">
                                <font-awesome-icon icon="edit"/>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger"
                                    @click="deleteGroup(item.id)">
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

        <Modal target="addgroup" size="xs">
            <template v-slot:title>
                <h4 v-if="action === 'new'" class="modal-title">Add group</h4>
                <h4 v-if="action === 'edit'" class="modal-title">Edit group</h4>
            </template>
            <template v-slot:header>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </template>
            <template v-slot:body>
                <form name="addgroup">
                    <div v-if="action == 'edit'" class="form-group">
                        <strong>ID: </strong>
                        {{ add_group.id }}
                    </div>
                    <div class="form-group">
                        <strong>名稱</strong>
                        <input type="text" v-model="add_group.name" name="name"
                               class="form-control" placeholder="Name" required>
                    </div>
                    <div class="form-group">
                        <strong>組長</strong>
                        <input type="text" v-model="add_group.manager_name" class="form-control"
                               disabled>
                    </div>
                    <div class="form-group">
                        <strong>副組長</strong>
                        <input type="text" v-model="add_group.deputy_manager_name"
                               class="form-control" disabled>
                    </div>
                </form>
            </template>
            <template v-slot:footer>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button v-if="action === 'new'" type="button" class="btn btn-primary"
                        @click="createNewGroup">Create
                </button>
                <button v-if="action === 'edit'" type="button" class="btn btn-primary"
                        @click="saveGroup(add_group.id)">Save
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
                page_info: [],
                add_group: [],
                action: 'new',
            };
        },
        computed: {
            getPageArray() {
                let self = this;
                let bottom = self.page_info.current_page - 2 <= 0 ? 1 : self.page_info.current_page - 2;
                let top = bottom + 5 > self.page_info.last_page ? self.page_info.last_page : bottom + 5;
                let array = [];
                for (let i = bottom; i <= top; i++) {
                    array.push(i);
                }
                return array;
            },
        },
        methods:
            {
                initCol() {
                    let self = this;
                    self.col = [{
                        name: 'id',
                        key: 'id'
                    }, {
                        name: 'Name',
                        key: 'name'
                    }, {
                        name: 'Manager',
                        key: 'manager'
                    }, {
                        name: 'Deputy Manager',
                        key: 'deputy_manager'
                    }, {
                        name: 'Number',
                        key: ''
                    }, {
                        name: '',
                        key: ''
                    }];
                },
                initGroup() {
                    this.add_group = {
                        id: '',
                        name: '',
                        manager: '0',
                        deputy_manager: '0',
                    };
                },
                onChangePage(page) {
                    this.page_info.current_page = page;
                    this.getAllGroup();
                },
                getAllGroup() {
                    let self = this;
                    axios.get(
                        '/api/group?orderby_field=' + self.page_info.sort_key + '&orderby_method=' + self.page_info.sort_dir + '&limit=' + self.page_info.limit + '&page=' + self.page_info.current_page
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
                    this.getAllGroup();
                },
                changeSort(field) {
                    if (field !== '') {
                        this.page_info.sort_dir = this.page_info.sort_dir === 'DESC' ? 'ASC' : 'DESC';
                        this.page_info.sort_key = field;
                        this.getAllGroup();
                    }
                },
                openAddGroup() {
                    this.action = 'new';
                    this.initGroup();
                    $('#addgroup').modal('show');
                },
                createNewGroup() {
                    let self = this;
                    let data = {
                        name: self.add_group.name,
                        manager: self.add_group.manager,
                        deputy_manager: self.add_group.deputy_manager,
                    };
                    axios.post(
                        '/api/group', data
                    ).then(response => {
                        $('#addgroup').modal('hide');
                        self.getAllGroup();
                        helper.alert(response.data.message);
                    }).catch(error => {
                        console.log(error.response);
                        helper.alert(error.response.data.message, 'danger');
                    });
                },
                saveGroup(id) {
                    let self = this;
                    let data = {
                        id: self.add_group.id,
                        name: self.add_group.name,
                        manager: self.add_group.manager,
                        deputy_manager: self.add_group.deputy_manager,
                        _method: 'PUT'
                    };
                    axios.post(
                        '/api/group/' + id, data
                    ).then(response => {
                        $('#addgroup').modal('hide');
                        self.getAllGroup();
                        helper.alert(response.data.message);
                    }).catch(error => {
                        console.log(error);
                        helper.alert(error.response.data.message, 'danger');
                    });
                },
                openEditGroup(id) {
                    let self = this;
                    self.action = 'edit';
                    axios.get(
                        '/api/group/' + id
                    ).then(response => {
                        let res = response.data.data;
                        self.form.action = 'edit';
                        self.add_group = {
                            id: res.id,
                            name: res.name,
                            manager: res.manager,
                            deputy_manager: res.deputy_manager,
                            manager_name: res.manager_name,
                            deputy_manager_name: res.deputy_manager_name,
                        };
                        $('#addgroup').modal('show');
                    }).catch(error => {
                        console.log(error);
                    });
                },
                deleteGroup(id) {
                    let self = this;
                    helper.deleteConfirm(function () {
                        axios.delete(
                            '/api/group/' + id
                        ).then(response => {
                            helper.alert(response.data.message);
                            self.getAllGroup();
                        }).catch(error => {
                            console.log(error);
                            helper.alert(error.response.data.message, 'danger');
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
                list_from: 1,
                list_to: 15
            };
            this.form = {
                action: '',
                submitted: false
            };
            this.initCol();
            this.initGroup();
            this.getAllGroup();
        },
        watch: {}
    };
</script>

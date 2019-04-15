<template>
    <div class="container-fluid">
        <h1>
            募集物資管理
            <small>Raise Equipments</small>
        </h1>
        <div class="row mb-3">
            <div class="col-12 col-sm-2 col-md-1 col-lg-1">
                <button type="button" class="btn btn-sm btn-primary btn-block"
                        v-on:click="openAddEquipment()">
                    <font-awesome-icon icon="plus"/>&nbsp;Add
                </button>
            </div>
            <div class="col-12 col-sm-2 col-md-2 col-lg-1">
                <div class="input-group input-group-sm">
                    <select class="form-control" name="equipment_length" v-model="page_info.limit"
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
                                        <span class="input-group-addon" style="background-color: #eee"><i
                                                class="glyphicon glyphicon-search"></i></span>
                    <input type="search" class="form-control" placeholder="Search"
                           aria-controls="equipment" v-model="page_info.search"
                           v-on:keyup="searchKeyword($event)">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-10 col-sm-12 col-md-12 col-lg-12 table-responsive">
                <table id="equipment" class="table table-bordered table-striped dataTable"
                       role="grid"
                       aria-describedby="equipment_info">
                    <thead>
                    <tr role="row">
                        <th v-for="row in col" class="sortfield" tabindex="0"
                            v-on:click="changeSort(row.key)">
                            {{ row.name }}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in list">
                        <td>{{ item.id }}</td>
                        <td>{{ item.name }}</td>
                        <td>{{ item.staff_name }}</td>
                        <td>
                            <span v-if="item.status === 0" class="label label-info">{{ item.status_name }}</span>
                            <span v-if="item.status === 1" class="label label-success">{{ item.status_name }}</span>
                            <span v-if="item.status === 2" class="label label-danger">{{ item.status_name }}</span>
                            <span v-if="item.status === 3" class="label label-info">{{ item.status_name }}</span>
                        </td>
                        <td>{{ item.barcode }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary"
                                    v-on:click="openEditEquipment(item.id, 'edit')">
                                <font-awesome-icon icon="edit"/>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger"
                                    v-on:click="deleteEquipment(item.id)">
                                <font-awesome-icon icon="trash"/>
                            </button>
                            <button v-if="item.status === 0" type="button" class="btn btn-sm btn-secondary"
                                    v-on:click="changeStatus(item.id, 1)">
                                <font-awesome-icon icon="hand-holding"/>
                                已收到
                            </button>
                            <button v-if="item.status === 1" type="button" class="btn btn-sm btn-success"
                                    v-on:click="changeStatus(item.id, 3)">
                                <font-awesome-icon icon="undo"/>
                                已歸還
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-5">
                <div class="dataTables_info" id="equipment_info" role="status" aria-live="polite">
                    Showing {{ page_info.list_from }} to {{ page_info.list_to
                    }} of {{ page_info.total }} entries
                </div>
            </div>
            <div class="col-sm-7">
                <Pagination :pageInfo="page_info" @onChangePage="onChangePage"/>
            </div>
        </div>

        <Modal target="addEquipment" size="xs">
            <template v-slot:title>
                <h4 v-if="action === 'new'" class="modal-title">Add Equipment</h4>
                <h4 v-if="action === 'edit'" class="modal-title">Edit Equipment</h4>
            </template>
            <template v-slot:header>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </template>
            <template v-slot:body>
                <form name="addEquipment">
                    <div v-if="action === 'edit'" class="form-group">
                        <strong>ID: </strong>
                        {{ add_equipment.id }}
                    </div>
                    <div class="form-group">
                        <strong>名稱</strong>
                        <input type="text" v-model="add_equipment.name" name="name"
                               class="form-control" placeholder="Name" required>
                    </div>
                    <div class="form-group">
                        <strong>出借者</strong>
                        <select name="staff_id" class="form-control" v-model="add_equipment.staff_id">
                            <option value="0"> --- Select Staff ---</option>
                            <option v-for="item in staff_list" v-bind:value="item.id">{{ item.name }}</option>
                        </select>
                    </div>
                    <div v-if="action === 'edit'" class="form-group">
                        <strong>Barcode</strong>
                        <input type="text" v-model="add_equipment.barcode" name="barcode"
                               class="form-control" placeholder="Memo">
                    </div>
                    <div v-if="action === 'edit'" class="form-group">
                        <strong>狀態</strong>
                        <select name="status" class="form-control" v-model="add_equipment.status">
                            <option value="0">未收到</option>
                            <option value="1">未出借</option>
                            <option value="2">出借中</option>
                            <option value="3">已歸還</option>
                        </select>
                    </div>
                </form>

            </template>
            <template v-slot:footer>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button v-if="action === 'new'" type="button" class="btn btn-primary"
                        v-on:click="createNewEquipment()">Create
                </button>
                <button v-if="action === 'edit'" type="button" class="btn btn-primary"
                        v-on:click="saveEquipment(add_equipment.id)">Save
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
                col: [],
                page_info: [],
                add_equipment: [],
                staff_list: [],
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
                        name: 'Staff Name',
                        key: 'staff_name'
                    }, {
                        name: 'Status',
                        key: 'status_name'
                    }, {
                        name: 'Barcode',
                        key: 'barcode'
                    }, {
                        name: '',
                        key: ''
                    }];
                },
                initEquipment() {
                    this.add_equipment = {
                        id: '',
                        name: '',
                        staff_id: 0,
                        status: 0,
                        barcode: '',
                    };
                },
                getAllStaff() {
                    axios.get(
                        '/api/staff?all=true&orderby_field=name&orderby_method=asc'
                    ).then(response => {
                        const self = this;
                        const res = response.data.data;
                        self.staff_list = res;
                    }).catch(error => {
                        console.log(error);
                    });
                },
                getAllEquipment() {
                    const self = this;
                    axios.get(
                        '/api/raise_equipment?search=' + self.page_info.search + '&orderby_field=' + self.page_info.sort_key + '&orderby_method=' + self.page_info.sort_dir + '&limit=' + self.page_info.limit + '&page=' + self.page_info.current_page
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
                    this.getAllEquipment();
                },
                searchKeyword(event) {
                    if (event.which === 13) {
                        this.getAllEquipment();
                    }
                },
                onChangePage(page) {
                    this.page_info.current_page = page;
                    this.getAllEquipment();
                },
                changeSort(field) {
                    if (field !== '') {
                        this.page_info.sort_dir = this.page_info.sort_dir === 'DESC' ? 'ASC' : 'DESC';
                        this.page_info.sort_key = field;
                        this.getAllEquipment();
                    }
                },
                openAddEquipment() {
                    this.action = 'new';
                    this.initEquipment();
                    $('#addEquipment').modal('show');
                },
                createNewEquipment() {
                    const self = this;
                    const data = {
                        name: self.add_equipment.name,
                        staff_id: self.add_equipment.staff_id,
                    };
                    axios.post(
                        '/api/raise_equipment', data
                    ).then(response => {
                        $('#addEquipment').modal('hide');
                        self.getAllEquipment();
                        helper.alert(response.data.message);
                    }).catch(error => {
                        console.log(error.response);
                        helper.alert(error.response.data.message, 'danger');
                    });
                },
                saveEquipment(id) {
                    const self = this;
                    const data = {
                        name: self.add_equipment.name,
                        staff_id: self.add_equipment.staff_id,
                        status: self.add_equipment.status,
                        barcode: self.add_equipment.barcode,
                        _method: 'PUT'
                    };

                    axios.post(
                        '/api/raise_equipment/' + id, data
                    ).then(response => {
                        $('#addEquipment').modal('hide');
                        self.getAllEquipment();

                        helper.alert(response.data.message);
                    }).catch(error => {
                        console.log(error.response);
                        helper.alert(error.response.data.message, 'danger');
                    });
                },
                openEditEquipment(id) {
                    const self = this;
                    self.action = 'edit';
                    axios.get(
                        '/api/raise_equipment/' + id
                    ).then(response => {
                        const res = response.data.data;

                        self.form.action = 'edit';
                        self.add_equipment = {
                            id: res.id,
                            name: res.name,
                            staff_id: res.staff_id,
                            status: res.status,
                            barcode: res.barcode,
                        };
                        $('#addEquipment').modal('show');
                    }).catch(error => {
                        console.log(error);
                    });
                },
                deleteEquipment(id) {
                    const _self = this;
                    helper.deleteConfirm(function () {
                        axios.delete(
                            '/api/raise_equipment/' + id
                        ).then(response => {

                            helper.alert(response.data.message);
                            _self.getAllEquipment();
                        }).catch(error => {
                            console.log(error);
                            helper.alert('發生錯誤!', 'danger');
                        });
                    });
                },
                changeStatus(id, status) {
                    const self = this;
                    axios.get(
                        '/api/raise_equipment/change_status/' + id + '/' + status,
                    ).then(response => {
                        self.getAllEquipment();

                        helper.alert(response.data.message);
                    }).catch(error => {
                        console.log(error.response);
                        helper.alert(error.response.data.message, 'danger');
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
            this.initEquipment();
            this.getAllEquipment();
            this.getAllStaff();
        },
        watch:
            {}
    };
</script>

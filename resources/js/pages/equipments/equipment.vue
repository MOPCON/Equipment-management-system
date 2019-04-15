<template>
    <div class="container-fluid">
        <h1>
            器材管理
            <small>Equipments</small>
        </h1>
        <div class="row mb-3">
            <div class="col-12 col-sm-3 col-md-2 col-lg-1">
                <button type="button" class="btn btn-sm btn-primary btn-block"
                        @click="openAddEquipment()">
                    <font-awesome-icon icon="plus"/>&nbsp;Add
                </button>
            </div>
            <div class="col-12 col-sm-2 col-md-2 col-lg-1">
                <div class="input-group input-group-sm">
                    <div class="input-group-addon" style="background-color: #eee">
                        <i class="glyphicon glyphicon-list"></i>
                    </div>
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
                           @keyup="searchKeyword($event)">
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
                            @click="changeSort(row.key)">
                            {{ row.name }}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in list">
                        <td>{{ item.id }}</td>
                        <td>{{ item.name }}</td>
                        <td>{{ item.source }}</td>
                        <td>{{ item.memo }}</td>
                        <td>{{ item.amount }}</td>
                        <td v-if="item.hasBarcode === 0">無</td>
                        <td v-if="item.hasBarcode === 1">有</td>
                        <td>{{ item.prefix }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary"
                                    @click="openEditEquipment(item.id, 'edit')">
                                <font-awesome-icon icon="edit"/>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" @click="deleteEquipment(item.id)">
                                <font-awesome-icon icon="trash"/>
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
                    Showing {{ page_info.list_from }} to {{ page_info.list_to }} of {{ page_info.total }} entries
                </div>
            </div>
            <div class="col-sm-7">
                <Pagination :pageInfo="page_info" @onChangePage="onChangePage"/>
            </div>
        </div>

        <Modal target="addEquipment" size="xs">
            <template v-slot:title>
                <h4 v-if="action == 'new'" class="modal-title">
                    Add Equipment</h4>
                <h4 v-if="action == 'edit'" class="modal-title">
                    Edit Equipment</h4>
            </template>
            <template v-slot:header>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </template>
            <template v-slot:body>
                <form name="addEquipment">
                    <div v-if="action == 'edit'" class="form-group">
                        <strong>ID: </strong>
                        {{ add_equipment.id }}
                    </div>
                    <div class="form-group">
                        <strong>名稱</strong>
                        <input type="text" v-model="add_equipment.name" name="name"
                               class="form-control" placeholder="Name" required>
                    </div>
                    <div class="form-group">
                        <strong>來源</strong>
                        <input type="text" v-model="add_equipment.source" name="source"
                               class="form-control" placeholder="Source">
                    </div>
                    <div class="form-group">
                        <strong>Memo</strong>
                        <input type="text" v-model="add_equipment.memo" name="memo"
                               class="form-control" placeholder="Memo">
                    </div>
                    <div class="form-group">
                        <strong>數量</strong>
                        <input type="number" v-model="add_equipment.amount" name="amount"
                               class="form-control" placeholder="Amount" min="0" max="10000"
                               required>
                    </div>
                    <div class="form-group">
                        <strong>Barcode</strong>
                        <div class="radio">
                            <label>
                                <input name="hasBarcode" v-model="add_equipment.hasBarcode"
                                       type="radio" value="0">無
                            </label>
                            &nbsp&nbsp&nbsp&nbsp
                            <label>
                                <input name="hasBarcode" v-model="add_equipment.hasBarcode"
                                       type="radio" value="1">有
                            </label>
                        </div>
                    </div>
                    <div v-if="add_equipment.hasBarcode == '1'" class="form-group">
                        <strong>Prefix</strong>
                        <input type="text" v-model="add_equipment.prefix" name="prefix"
                               class="form-control" placeholder="Prefix" required>
                    </div>
                </form>
            </template>
            <template v-slot:footer>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button v-if="action === 'new'" type="button" class="btn btn-primary"
                        @click="createNewEquipment()">Create
                </button>
                <button v-if="action === 'edit'" type="button" class="btn btn-primary"
                        @click="saveEquipment(add_equipment.id)">Save
                </button>
            </template>
        </Modal>
    </div>
</template>
<script>
    import axios from "axios";

    export default {
        data() {
            return {
                list: [],
                col: [],
                page_info: [],
                group: [],
                group_id: 0,
                add_equipment: [],
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
                        name: 'Source',
                        key: 'source'
                    }, {
                        name: 'Memo',
                        key: 'memo'
                    }, {
                        name: 'Amount',
                        key: 'amount'
                    }, {
                        name: 'Has_Barcode',
                        key: 'hasBarcode'
                    }, {
                        name: 'Prefix',
                        key: 'prefix'
                    }, {
                        name: '',
                        key: ''
                    }];
                },
                initEquipment() {
                    this.add_equipment = {
                        id: '',
                        name: '',
                        source: '',
                        memo: '',
                        amount: '0',
                        hasBarcode: '',
                        prefix: ''
                    };
                },
                onChangePage(page) {
                    this.page_info.current_page = page;
                    this.getAllEquipment();
                },
                getAllEquipment() {
                    const self = this;
                    axios.get(
                        '/api/equipment?search=' + self.page_info.search + '&orderby_field=' + self.page_info.sort_key + '&orderby_method=' + self.page_info.sort_dir + '&limit=' + self.page_info.limit + '&page=' + self.page_info.current_page
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
                        source: self.add_equipment.source,
                        memo: self.add_equipment.memo,
                        amount: self.add_equipment.amount,
                        hasBarcode: self.add_equipment.hasBarcode,
                        prefix: self.add_equipment.hasBarcode === '1' ? self.add_equipment.prefix : ''
                    };
                    axios.post(
                        '/api/equipment', data
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
                        source: self.add_equipment.source,
                        memo: self.add_equipment.memo,
                        amount: self.add_equipment.amount,
                        hasBarcode: self.add_equipment.hasBarcode,
                        prefix: self.add_equipment.hasBarcode === '1' ? self.add_equipment.prefix : '',
                        _method: 'PUT'
                    };

                    axios.post(
                        '/api/equipment/' + id, data
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
                        '/api/equipment/' + id
                    ).then(response => {
                        const res = response.data.data;

                        self.form.action = 'edit';
                        self.add_equipment = {
                            id: res.id,
                            name: res.name,
                            source: res.source,
                            memo: res.memo,
                            amount: res.amount,
                            hasBarcode: res.hasBarcode,
                            prefix: res.prefix
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
                            '/api/equipment/' + id
                        ).then(response => {

                            helper.alert(response.data.message);
                            _self.getAllEquipment();
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
            this.initEquipment();
            this.getAllEquipment();
        },
        watch:
            {}
    };
</script>

<template>
    <div class="container">
        <h1>
            條碼管理
            <small>Barcode</small>
        </h1>
        <div class="row mb-3">
            <div class="col-12 col-sm-3 col-md-2 col-lg-1">
                <div class="input-group input-group-sm">
                    <div class="input-group-addon" style="background-color: #eee">
                        <i class="glyphicon glyphicon-list"></i>
                    </div>
                    <select class="form-control" name="equ_barcode_length" v-model="page_info.limit"
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
                           aria-controls="equ_barcode" v-model="page_info.search"
                           v-on:keyup="searchKeyword(event)">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-10 col-sm-12 col-md-12 col-lg-12 table-responsive">
                <table id="equ_barcode" class="table table-bordered table-striped dataTable"
                       role="grid"
                       aria-describedby="equ_barcode_info">
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
                        <td>{{ item.equipment_name }}</td>
                        <td>{{ item.barcode }}</td>
                        <td v-if="item.status === 0"><span class="label label-success">未出借</span></td>
                        <td v-if="item.status === 1"><span class="label label-danger">出借中</span></td>
                        <td>
                            <button v-if="item.status === 0" type="button"
                                    class="btn btn-sm btn-primary"
                                    v-on:click="openEditEqubarcode(item.id, item.barcode)">
                                <font-awesome-icon icon="edit"/>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-5">
                <div class="dataTables_info" id="equ_barcode_info" role="status" aria-live="polite">
                    Showing {{ page_info.list_from }} to {{ page_info.list_to
                    }} of {{ page_info.total }} entries
                </div>
            </div>
            <div class="col-sm-7">
                <Pagination :pageInfo="page_info" @onChangePage="onChangePage"/>
            </div>
        </div>
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
            };
        },
        computed: {},
        methods:
            {
                initCol() {
                    this.col = [{
                        name: 'id',
                        key: 'id'
                    }, {
                        name: 'Equipment',
                        key: 'equipment'
                    }, {
                        name: 'Barcode',
                        key: 'barcode'
                    }, {
                        name: 'Status',
                        key: 'status'
                    }, {
                        name: '',
                        key: ''
                    }];
                },
                getAllEquBarcode() {
                    const self = this;
                    axios.get(
                        '/api/equipment/barcode?search=' + self.page_info.search + '&orderby_field=' + self.page_info.sort_key + '&orderby_method=' + self.page_info.sort_dir + '&limit=' + self.page_info.limit + '&page=' + self.page_info.current_page + '&status=' + self.page_info.status
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
                    this.getAllEquBarcode();
                },
                searchKeyword(event) {
                    if (event.which === 13) {
                        this.getAllEquBarcode();
                    }
                },
                onChangePage(page) {
                    this.page_info.current_page = page;
                    this.getAllEquBarcode();
                },
                changeSort(field) {
                    if (field !== '') {
                        this.page_info.sort_dir = this.page_info.sort_dir === 'DESC' ? 'ASC' : 'DESC';
                        this.page_info.sort_key = field;
                        this.getAllEquBarcode();
                    }
                },
                openEditEqubarcode(id, barcode) {
                    const self = this;
                    swal({
                        title: 'Update Barcode',
                        input: 'text',
                        inputValue: barcode,
                        showCancelButton: true,
                        inputValidator(value) {
                            return new Promise(function (resolve, reject) {
                                if (value) {
                                    resolve();
                                    const data = {
                                        barcode: value,
                                        _method: 'PUT'
                                    };
                                    axios.post(
                                        '/api/equipment/barcode/' + id, data
                                    ).then(response => {
                                        self.getAllEquBarcode();
                                        helper.alert(response.data.message);
                                    }).catch(error => {
                                        console.log(error.response);
                                        helper.alert(error.response.data.message, 'danger');
                                    });
                                } else {
                                    reject('You need to write something!');
                                }
                            });
                        }
                    }).then(function (result) {
                        swal({
                            type: 'success',
                            html: 'You entered: ' + result
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
                list_to: 15,
                status: '-1'
            };
            this.initCol();
            this.getAllEquBarcode();
        },
        watch:
            {}
    };
</script>

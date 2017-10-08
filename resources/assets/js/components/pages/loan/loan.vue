<template>
    <div>
        <section class="content-header">
            <h1>
                批量管理
                <small>Log</small>
            </h1>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="box">
                    <div class="box-body">
                        <div id="loan_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                            <div class="row" style="display:">
                                <div class="col-xs-10 col-sm-2 col-md-2 col-lg-1">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-addon" style="background-color: #eee">
                                            <i class="glyphicon glyphicon-list"></i>
                                        </div>
                                        <select class="form-control" name="loan_length" v-model="page_info.status"
                                                @change="setPageStatus()">
                                            <option value="">全部</option>
                                            <option value="0">出借中</option>
                                            <option value="1">已歸還</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-10 col-sm-2 col-md-2 col-lg-1">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-addon" style="background-color: #eee">
                                            <i class="glyphicon glyphicon-list"></i>
                                        </div>
                                        <select class="form-control" name="loan_length" v-model="page_info.limit"
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
                                <div class="col-xs-10 col-sm-3 col-md-3 col-lg-3">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-addon" style="background-color: #eee"><i
                                                class="glyphicon glyphicon-search"></i></span>
                                        <input type="search" class="form-control" placeholder="Barcode"
                                               aria-controls="loan" v-model="page_info.search"
                                               v-on:keyup="searchKeyword($event)">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-10 col-sm-12 col-md-12 col-lg-12 table-responsive">
                                    <table id="loan" class="table table-bordered table-striped dataTable" role="grid"
                                           aria-describedby="loan_info">
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
                                            <td>{{ item.staff_name }}</td>
                                            <td>{{ item.equipment_name }}</td>
                                            <td>{{ item.amount }}</td>
                                            <td>{{ item.return_back }}</td>
                                            <td>{{ item.barcode }}</td>
                                            <td v-if="item.status == '0'">出借中</td>
                                            <td v-if="item.status == '1'">已歸還</td>
                                            <td>{{ item.return_at }}</td>
                                            <td>{{ item.created_at }}</td>
                                            <td>{{ item.updated_at }}</td>
                                            <td><button v-if="item.status == '0'"
                                                        class="btn btn-success btn-sm"
                                                        v-on:click="returnLoan(item.id, item.barcode)">歸還</button></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="dataTables_info" id="loan_info" role="status" aria-live="polite">
                                        Showing {{ page_info.list_from }} to {{ page_info.list_to
                                        }} of {{ page_info.total }} entries
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <div class="dataTables_paginate paging_simple_numbers" id="loan_paginate">
                                        <ul class="pagination">
                                            <li class="paginate_button previous" id="loan_previous"
                                                v-bind:class="[page_info.current_page-1 == 0 ? 'disabled' : '']">
                                                <a aria-controls="loan" data-dt-idx="0" tabindex="0"
                                                   v-on:click="changePage(page_info.current_page-1)">Previous</a>
                                            </li>
                                            <li v-for="i in getPageArray" class="paginate_button"
                                                v-bind:class="[page_info.current_page == i ? 'active' : '']">
                                                <a aria-controls="loan" data-dt-idx="1" tabindex="0"
                                                   v-on:click="changePage(i)">{{ i }}</a>
                                            </li>
                                            <li class="paginate_button next" id="loan_next"
                                                v-bind:class="[page_info.current_page+1 > page_info.last_page ? 'disabled' : '']">
                                                <a aria-controls="loan" data-dt-idx="7" tabindex="0"
                                                   v-on:click="changePage(page_info.current_page+1)">Next</a>
                                            </li>
                                        </ul>
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
                page_info: []
            }
        },
        computed: {
            getPageArray: function () {
                var self = this
                var bottom = self.page_info.current_page - 2 <= 0 ? 1 : self.page_info.current_page - 2
                var top = bottom + 5 > self.page_info.last_page ? self.page_info.last_page : bottom + 5
                var array = []
                for (var i = bottom; i <= top; i++) {
                    array.push(i)
                }
                return array
            },
        },
        methods:
            {
                initCol: function () {
                    var self = this
                    self.col = [{
                        name: 'id',
                        key: 'id'
                    }, {
                        name: 'Staff',
                        key: 'staff'
                    }, {
                        name: 'Equipment',
                        key: 'equipment'
                    }, {
                        name: 'Amount',
                        key: 'amount'
                    }, {
                        name: 'Return',
                        key: 'return'
                    }, {
                        name: 'Barcode',
                        key: 'barcode'
                    }, {
                        name: 'Status',
                        key: 'status'
                    }, {
                        name: 'Return_At',
                        key: 'return_at'
                    }, {
                        name: 'Created_At',
                        key: 'created_at'
                    }, {
                        name: 'Updated_At',
                        key: 'updated_at'
                    }, {
                        name: 'Action',
                        key: ''
                    }]
                },
                getAllLoan: function () {
                    var self = this
                    console.log(self.page_info.status)
                    axios.get(
                        '/api/loan?barcode=' + self.page_info.search + '&orderby_field=' + self.page_info.sort_key + '&orderby_method=' + self.page_info.sort_dir + '&limit=' + self.page_info.limit + '&page=' + self.page_info.current_page + (self.page_info.status == '' ? '' : '&status[0]=' + self.page_info.status)
                    ).then(response => {
                        var self = this
                        var res = response.data.data
                        self.list = res.data
                        self.page_info.current_page = res.current_page
                        self.page_info.last_page = res.last_page
                        self.page_info.total = res.total
                        self.page_info.list_from = res.from
                        self.page_info.list_to = res.to
                        console.log(response)
                    }).catch(error => {
                        console.log(error)
                    })
                },
                setPageLimit: function () {
                    this.getAllLoan()
                },
                searchKeyword: function (event) {
                    if (event.which === 13) {
                        console.log(this.page_info.search)
                        this.getAllLoan()
                    }
                },
                changePage: function (page) {
                    var self = this
                    if (page > 0 && page <= self.page_info.last_page) {
                        self.page_info.current_page = page
                        this.getAllLoan()
                    }
                },
                changeSort: function (field) {
                    var self = this
                    if (field != '') {
                        self.page_info.sort_dir = self.page_info.sort_dir == 'DESC' ? 'ASC' : 'DESC'
                        self.page_info.sort_key = field
                        this.getAllLoan()
                    }
                },
                setPageStatus: function () {
                    this.getAllLoan()
                },
                returnLoan(id, barcode) {
                    let self = this;
                    swal({
                        title: '請輸入數量',
                        input: 'number',
                        showCancelButton: true,
                        confirmButtonText: 'Submit',
                        showLoaderOnConfirm: true,
                        allowOutsideClick: false
                    }).then(function (amount) {
                        let data = {
                            loan_id: id,
                            barcode: barcode,
                            amount: amount
                        };
                        axios.post(
                            '/api/loan/return', data
                        ).then(response => {
                            console.log(response.data);
                            helper.alert(response.data.message, 'success');
                            self.getAllLoan();
                        }).catch(error => {
                            console.log(error.response.data);
                            helper.alert(error.response.data.message, 'danger');
                        });
                    })
                }
            },
        created: function () {
            var self = this
            self.page_info = {
                current_page: 1,
                limit: '15',
                last_page: 1,
                total: 1,
                sort_key: 'id',
                sort_dir: 'DESC',
                search: '',
                list_from: 1,
                list_to: 15,
                status: ''
            }
            self.initCol();
            self.getAllLoan();
        },
        watch:
            {}
    }
</script>

<template>
    <div class="box-body">
        <div id="equ_barcode_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row" style="display:">
                <div class="col-xs-10 col-sm-2 col-md-2 col-lg-1">
                    <div class="input-group input-group-sm">
                        <div class="input-group-addon" style="background-color: #eee">
                            <i class="glyphicon glyphicon-list"></i>
                        </div>
                        <select class="form-control" name="equ_barcode_length" v-model="page_info.limit" @change="setPageLimit()">
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
                         <span class="input-group-addon" style="background-color: #eee"><i class="glyphicon glyphicon-search"></i></span>
                         <input type="search" class="form-control" placeholder="Search" aria-controls="equ_barcode" v-model="page_info.search" v-on:keyup="searchKeyword($event)">
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-xs-10 col-sm-12 col-md-12 col-lg-12 table-responsive">
                    <table id="equ_barcode" class="table table-bordered table-striped dataTable" role="grid"
                           aria-describedby="equ_barcode_info">
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
                                <td>{{ item.equipment_name }}</td>
                                <td>{{ item.barcode }}</td>
                                <td v-if="item.status == '0'">未出借</td>
                                <td v-if="item.status == '1'">出借中</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-5">
                    <div class="dataTables_info" id="equ_barcode_info" role="status" aria-live="polite">
                        Showing {{ page_info.list_from }} to {{ page_info.list_to }} of {{ page_info.total }} entries
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="dataTables_paginate paging_simple_numbers" id="equ_barcode_paginate">
                        <ul class="pagination">
                            <li class="paginate_button previous" id="equ_barcode_previous" v-bind:class="[page_info.current_page-1 == 0 ? 'disabled' : '']">
                                <a href="#" aria-controls="equ_barcode" data-dt-idx="0" tabindex="0" v-on:click="changePage(page_info.current_page-1)">Previous</a>
                            </li>
                            <li v-for="i in getPageArray" class="paginate_button" v-bind:class="[page_info.current_page == i ? 'active' : '']">
                                <a href="#" aria-controls="equ_barcode" data-dt-idx="1" tabindex="0" v-on:click="changePage(i)">{{ i }}</a>
                            </li>
                            <li class="paginate_button next" id="equ_barcode_next" v-bind:class="[page_info.current_page+1 > page_info.last_page ? 'disabled' : '']">
                                <a href="#" aria-controls="equ_barcode" data-dt-idx="7" tabindex="0"  v-on:click="changePage(page_info.current_page+1)">Next</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data: function ()
        {
            return {
                list: [],
                col: [],
                page_info: [],
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
        methods:
        {
            initCol: function() {
                var self = this;
                self.col = [{
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
            // initEquipment: function() {
            //     var self = this;
            //     self.add_equipment = {
            //         id: '',
            //         name: '',
            //         source: '',
            //         memo: '',
            //         amount: '0',
            //         hasBarcode: '',
            //         prefix: ''
            //     }
            // },
            getAllEquBarcode: function() {
                var self = this;
                axios.get(
                    '/api/equipment/barcode?search=' + self.page_info.search + '&orderby_field=' + self.page_info.sort_key + '&orderby_method=' + self.page_info.sort_dir + '&limit=' + self.page_info.limit + '&page=' +  self.page_info.current_page + '&status=' + self.page_info.status
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
                this.getAllEquBarcode();
            },
            searchKeyword: function(event) {
                if (event.which === 13) {
                    console.log(this.page_info.search);
                    this.getAllEquBarcode();
                }
            },
            changePage: function(page) {
                var self = this;
                if (page > 0 && page <= self.page_info.last_page) {
                    self.page_info.current_page = page;
                    this.getAllEquBarcode();
                }
            },
            changeSort: function(field) {
                var self = this;
                if (field != '') {
                    self.page_info.sort_dir = self.page_info.sort_dir == 'DESC' ? 'ASC' : 'DESC';
                    self.page_info.sort_key = field;
                    this.getAllEquBarcode();
                }
            }
        },
        created: function()
        {
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
                list_to: 15,
                status: '-1'
            }
            // self.form = {
            //     action: '',
            //     submitted: false
            // };
            self.initCol();
            // self.initEquipment();
            self.getAllEquBarcode();
        },
        watch:
        {

        }
    }
</script>

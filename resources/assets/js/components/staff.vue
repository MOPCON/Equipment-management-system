<template>
    <div class="box-body">
        <div id="staff_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row">
                <div class="col-sm-6">
                    <div class="dataTables_length" id="staff_length">
                        <label>Show
                            <select name="staff_length" aria-controls="staff"
                                    class="form-control input-sm" v-model="page_info.limit" @change="setPageLimit()">
                                <option value="15">15</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select> entries
                        </label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div id="staff_filter" class="dataTables_filter">
                        <label>Search:
                            <input type="search" class="form-control input-sm" placeholder=""
                                   aria-controls="staff" v-model="page_info.search">
                        </label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <table id="staff" class="table table-bordered table-striped dataTable" role="grid"
                           aria-describedby="staff_info">
                        <thead>
                            <tr role="row">
                                <th v-for="row in col" class="sorting" tabindex="0" rowspan="1" colspan="1">
                                    {{ row.name }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in list" class="odd">
                                <td>{{ item.id }}</td>
                                <td>{{ item.name }}</td>
                                <td>{{ item.group_name }}</td>
                                <td>{{ item.email }}</td>
                                <td>{{ item.phone }}</td>
                                <td>{{ item.barcode }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger">
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-5">
                    <div class="dataTables_info" id="staff_info" role="status" aria-live="polite">
                        Showing {{ page_info.list_from }} to {{ page_info.list_to }} of {{ page_info.total }} entries
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="dataTables_paginate paging_simple_numbers" id="staff_paginate">
                        <ul class="pagination">
                            <li class="paginate_button previous disabled" id="staff_previous">
                                <a href="#" aria-controls="staff" data-dt-idx="0" tabindex="0">Previous</a>
                            </li>
                            <li class="paginate_button active">
                                <a href="#" aria-controls="staff" data-dt-idx="1" tabindex="0">1</a>
                            </li>
                            <li class="paginate_button ">
                                <a href="#" aria-controls="staff" data-dt-idx="2" tabindex="0">2</a>
                            </li>
                            <li class="paginate_button ">
                                <a href="#" aria-controls="staff" data-dt-idx="3" tabindex="0">3</a>
                            </li>
                            <li class="paginate_button ">
                                <a href="#" aria-controls="staff" data-dt-idx="4" tabindex="0">4</a>
                            </li>
                            <li class="paginate_button ">
                                <a href="#" aria-controls="staff" data-dt-idx="5" tabindex="0">5</a>
                            </li>
                            <li class="paginate_button ">
                                <a href="#" aria-controls="staff" data-dt-idx="6" tabindex="0">6</a>
                            </li>
                            <li class="paginate_button next" id="staff_next">
                                <a href="#" aria-controls="staff" data-dt-idx="7" tabindex="0">Next</a>
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
        methods:
        {
            initCol: function() {
                var self = this;
                self.col = [{
                    name: 'id',
                    show_dsc: '1'
                }, {
                    name: 'Name',
                    show_dsc: '1'
                }, {
                    name: 'Group',
                    show_dsc: '1'
                }, {
                    name: 'Email',
                    show_dsc: '1'
                }, {
                    name: 'Phone',
                    show_dsc: '1'
                }, {
                    name: 'Barcode',
                    show_dsc: '1'
                }, {
                    name: '',
                    show_dsc: '0'
                }];
            },
            getAllStaff: function() {
                var self = this;
                axios.get(
                    '/api/staff?search=' + self.page_info.search + '&orderby_field=' + self.page_info.sort_key + '&orderby_method=' + self.page_info.sort_dir + '&limit=' + self.page_info.limit
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
                var self = this;
                self.getAllStaff();
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
                list_to: 15
            }
            self.initCol();
            self.getAllStaff();
        },
        watch:
        {

        }
    }
</script>

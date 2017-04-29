<template>
    <div class="box-body">
        <div id="staff_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row" style="display:">
                <div class="col-lg-1">
                    <button type="button" class="btn btn-sm btn-primary" v-on:click="openAddStaff()">
                        <span class="glyphicon glyphicon-plus"></span>&nbsp;Add
                    </button>
                </div>
                <div class="col-lg-2">
                    <div class="input-group input-group-sm">
                        <span class="input-group-addon" style="background-color: #eee">
                            <i class="glyphicon glyphicon-bookmark"></i>
                        </span>
                        <select class="form-control" name="table_status"  v-model="group_id" @change="setGroup()">
                            <option value="0">全部</option>
                            <option v-for="item in group" v-bind:value="item.id">{{ item.name }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="input-group input-group-sm">
                        <span class="input-group-addon" style="background-color: #eee">
                            <i class="fa fa-thumb-tack"></i>
                        </span>
                        <select class="form-control" name="staff_length" v-model="page_info.limit" @change="setPageLimit()">
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="input-group input-group-sm">
                         <span class="input-group-addon" style="background-color: #eee"><i class="glyphicon glyphicon-search"></i></span>
                         <input type="search" class="form-control pull-right" placeholder="Search" aria-controls="staff" v-model="page_info.search" v-on:keyup="searchKeyword($event)">
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-12">
                    <table id="staff" class="table table-bordered table-striped dataTable" role="grid"
                           aria-describedby="staff_info">
                        <thead>
                            <tr role="row">
                                <th v-for="row in col" class="sortfield" tabindex="0" v-on:click="changeSort(row.key)">
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
                                        <button type="button" class="btn btn-sm btn-primary" v-on:click="openEditStaff(item.id, 'edit')">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger">
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
                            <li class="paginate_button previous" id="staff_previous" v-bind:class="[page_info.current_page-1 == 0 ? 'disabled' : '']">
                                <a href="#" aria-controls="staff" data-dt-idx="0" tabindex="0" v-on:click="changePage(page_info.current_page-1)">Previous</a>
                            </li>
                            <li v-for="i in getPageArray" class="paginate_button" v-bind:class="[page_info.current_page == i ? 'active' : '']">
                                <a href="#" aria-controls="staff" data-dt-idx="1" tabindex="0" v-on:click="changePage(i)">{{ i }}</a>
                            </li>
                            <li class="paginate_button next" id="staff_next" v-bind:class="[page_info.current_page+1 > page_info.last_page ? 'disabled' : '']">
                                <a href="#" aria-controls="staff" data-dt-idx="7" tabindex="0"  v-on:click="changePage(page_info.current_page+1)">Next</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="addStaff" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <h4 v-if="action == 'new'" class="modal-title" id="myModalLabel">Add Staff</h4>
                        <h4 v-if="action == 'edit'" class="modal-title" id="myModalLabel">Edit Staff</h4>
                    </div>
                    <div class="modal-body">
                        <form name="addStaff">
                            <div v-if="action == 'edit'" class="form-group">
                                <strong>ID: </strong>
                                {{ add_staff.id }}
                            </div>
                            <div class="form-group">
                                <strong>名稱</strong>
                                <input type="text" v-model="add_staff.name" name="name" class="form-control" placeholder="Name" required>
                            </div>
                            <div class="form-group">
                                <strong>Email</strong>
                                <input type="text" v-model="add_staff.email" name="email" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <strong>電話</strong>
                                <input type="text" v-model="add_staff.phone" name="phone" class="form-control" placeholder="Phone" required>
                            </div>
                            <div class="form-group">
                                <strong>組別</strong>
                                <select class="form-control" v-model="add_staff.group">
                                    <option v-for="item in group" v-bind:value="item.id">{{ item.name }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <strong>角色</strong>
                                <select class="form-control" v-model="add_staff.role">
                                    <option value="0">組員</option>
                                    <option value="1">副組長</option>
                                    <option value="2">組長</option>
                                </select>
                            </div>
                            <div v-if="action == 'edit'" class="form-group">
                                <strong>Barcode</strong>
                                <input type="text" v-model="add_staff.barcode" name="phone" class="form-control" placeholder="Phone" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button v-if="action == 'new'" type="button" class="btn btn-primary" v-on:click="createNewStaff()">Create</button>
                        <button v-if="action == 'edit'" type="button" class="btn btn-primary" v-on:click="saveStaff(add_staff.id)">Save</button>
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
                group: [],
                group_id: 0,
                add_staff: [],
                action: 'new',
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
                    name: 'Name',
                    key: 'name'
                }, {
                    name: 'Group',
                    key: 'group_id'
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
            initStaff: function() {
                var self = this;
                self.add_staff = {
                    id: '',
                    name: '',
                    group: '1',
                    role: '0',
                    email: '',
                    phone: '',
                    barcode: ''
                }
            },
            getGroup: function() {
                var self = this;
                axios.get(
                    '/api/group?orderby_method=asc'
                ).then(response => {
                      var self = this;
                      var res = response.data.data;
                      self.group = res.data;
                      console.log(response);
                }).catch(error => {
                      console.log(error);
                });
            },
            getAllStaff: function() {
                var self = this;
                axios.get(
                    '/api/staff?search=' + self.page_info.search + '&orderby_field=' + self.page_info.sort_key + '&orderby_method=' + self.page_info.sort_dir + '&limit=' + self.page_info.limit + '&page=' +  self.page_info.current_page +
                    (self.group_id == 0 ? '' : '&group_id[0]='+self.group_id)
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
                this.getAllStaff();
            },
            setGroup: function () {
                this.getAllStaff();
            },
            searchKeyword: function(event) {
                if (event.which === 13) {
                    console.log(this.page_info.search);
                    this.getAllStaff();
                }
            },
            changePage: function(page) {
                var self = this;
                if (page > 0 && page <= self.page_info.last_page) {
                    self.page_info.current_page = page;
                    this.getAllStaff();
                }
            },
            changeSort: function(field) {
                var self = this;
                if (field != '') {
                    self.page_info.sort_dir = self.page_info.sort_dir == 'DESC' ? 'ASC' : 'DESC';
                    self.page_info.sort_key = field;
                    this.getAllStaff();
                }
            },
            openAddStaff: function() {
                this.action = 'new';
                this.initStaff();
                $('#addStaff').modal('show');
            },
            createNewStaff: function() {
                var self = this;
                var data = {
                    name: self.add_staff.name,
                    email: self.add_staff.email,
                    phone: self.add_staff.phone,
                    group_id: self.add_staff.group,
                    role: self.add_staff.role
                };
                axios.post(
                    '/api/staff', data
                ).then(response => {
                    $('#addStaff').modal('hide');
                    self.getAllStaff();
                    console.log(response);
                }).catch(error => {
                    console.log(error);
                });
            },
            saveStaff: function(id) {
                var self = this;
                var data = {
                    name: self.add_staff.name,
                    email: self.add_staff.email,
                    phone: self.add_staff.phone,
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
                    console.log(response);
                }).catch(error => {
                    console.log(error);
                });
            },
            openEditStaff: function(id) {
                var self = this;
                self.action = 'edit';
                axios.get(
                    '/api/staff/' + id
                ).then(response => {
                      var res = response.data.data;
                      console.log(response);
                      self.form.action = 'edit'
                      self.add_staff = {
                          id: res.id,
                          name: res.name,
                          email: res.email,
                          phone: res.phone,
                          barcode: res.barcode,
                          group: res.group_id,
                          role: res.role
                      }
                      $('#addStaff').modal('show');
                }).catch(error => {
                      console.log(error);
                });
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
            self.form = {
                action: '',
                submitted: false
            };
            self.initCol();
            self.initStaff();
            self.getAllStaff();
            self.getGroup();
        },
        watch:
        {

        }
    }
</script>

<template>
    <div class="box-body">
        <div id="group_wrapper" class="dataTables_wrapper  dt-bootstrap col-xs-offset-0 col-xs-10 col-sm-offset-0 col-sm-10 col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6">
            <div class="row form-inline" style="display:">
                <div class="col-xs-10 col-sm-2 col-md-2 col-lg-2">
                    <button type="button" class="btn btn-sm btn-primary" v-on:click="openAddgroup()">
                        <span class="glyphicon glyphicon-plus"></span>&nbsp;Add
                    </button>
                </div>
                <div class="col-xs-10 col-sm-4 col-md-3 col-lg-2">
                    <div class="input-group input-group-sm">
                        <div class="input-group-addon" style="background-color: #eee">
                            <i class="glyphicon glyphicon-list"></i>
                        </div>
                        <select class="form-control" name="group_length" v-model="page_info.limit" @change="setPageLimit()">
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
            <br>
            <div class="row">
                <div class="table-responsive">
                    <table id="group" class="table table-bordered table-striped dataTable" role="grid"
                           aria-describedby="group_info">
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
                                <td>{{ item.name }}</td>
                                <td>{{ item.manager_name }}</td>
                                <td>{{ item.deputy_manager_name }}</td>
                                <td>{{ item.number }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" v-on:click="openEditgroup(item.id, 'edit')">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" v-on:click="deletegroup(item.id)">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>21
            <div class="row">
                <div class="col-sm-5">
                    <div class="dataTables_info" id="group_info" role="status" aria-live="polite">
                        Showing {{ page_info.list_from }} to {{ page_info.list_to }} of {{ page_info.total }} entries
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="dataTables_paginate paging_simple_numbers" id="group_paginate">
                        <ul class="pagination">
                            <li class="paginate_button previous" id="group_previous" v-bind:class="[page_info.current_page-1 == 0 ? 'disabled' : '']">
                                <a href="#" aria-controls="group" data-dt-idx="0" tabindex="0" v-on:click="changePage(page_info.current_page-1)">Previous</a>
                            </li>
                            <li v-for="i in getPageArray" class="paginate_button" v-bind:class="[page_info.current_page == i ? 'active' : '']">
                                <a href="#" aria-controls="group" data-dt-idx="1" tabindex="0" v-on:click="changePage(i)">{{ i }}</a>
                            </li>
                            <li class="paginate_button next" id="group_next" v-bind:class="[page_info.current_page+1 > page_info.last_page ? 'disabled' : '']">
                                <a href="#" aria-controls="group" data-dt-idx="7" tabindex="0"  v-on:click="changePage(page_info.current_page+1)">Next</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="addgroup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <h4 v-if="action == 'new'" class="modal-title" id="myModalLabel">Add group</h4>
                        <h4 v-if="action == 'edit'" class="modal-title" id="myModalLabel">Edit group</h4>
                    </div>
                    <div class="modal-body">
                        <form name="addgroup">
                            <div v-if="action == 'edit'" class="form-group">
                                <strong>ID: </strong>
                                {{ add_group.id }}
                            </div>
                            <div class="form-group">
                                <strong>名稱</strong>
                                <input type="text" v-model="add_group.name" name="name" class="form-control" placeholder="Name" required>
                            </div>
                            <div class="form-group">
                                <strong>組長</strong>
                                <input type="text" v-model="add_group.manager_name" class="form-control" disabled>
                            </div>
                            <div class="form-group">
                                <strong>副組長</strong>
                                <input type="text" v-model="add_group.deputy_manager_name" class="form-control" disabled>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button v-if="action == 'new'" type="button" class="btn btn-primary" v-on:click="createNewgroup()">Create</button>
                        <button v-if="action == 'edit'" type="button" class="btn btn-primary" v-on:click="savegroup(add_group.id)">Save</button>
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
                add_group: [],
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
            initGroup: function() {
                var self = this;
                self.add_group = {
                    id: '',
                    name: '',
                    manager: '0',
                    deputy_manager: '0',
                };
            },
            getAllGroup: function() {
                var self = this;
                axios.get(
                    '/api/group?orderby_field=' + self.page_info.sort_key + '&orderby_method=' + self.page_info.sort_dir + '&limit=' + self.page_info.limit + '&page=' +  self.page_info.current_page
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
                this.getAllGroup();
            },
            changePage: function(page) {
                var self = this;
                if (page > 0 && page <= self.page_info.last_page) {
                    self.page_info.current_page = page;
                    this.getAllGroup();
                }
            },
            changeSort: function(field) {
                var self = this;
                if (field != '') {
                    self.page_info.sort_dir = self.page_info.sort_dir == 'DESC' ? 'ASC' : 'DESC';
                    self.page_info.sort_key = field;
                    this.getAllGroup();
                }
            },
            openAddgroup: function() {
                this.action = 'new';
                this.initGroup();
                $('#addgroup').modal('show');
            },
            createNewgroup: function() {
                var self = this;
                var data = {
                    name: self.add_group.name,
                    manager: self.add_group.manager,
                    deputy_manager: self.add_group.deputy_manager,
                };
                axios.post(
                    '/api/group', data
                ).then(response => {
                    $('#addgroup').modal('hide');
                    self.getAllGroup();
                    console.log(response);
                    helper.alert(response.data.message);
                }).catch(error => {
                    console.log(error.response);
                    helper.alert(error.response.data.message, 'danger');
                });
            },
            savegroup: function(id) {
                var self = this;
                var data = {
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
                    console.log(response);
                    helper.alert(response.data.message);
                }).catch(error => {
                    console.log(error);
                    helper.alert(error.response.data.message, 'danger');
                });
            },
            openEditgroup: function(id) {
                var self = this;
                self.action = 'edit';
                axios.get(
                    '/api/group/' + id
                ).then(response => {
                      var res = response.data.data;
                      console.log(response);
                      self.form.action = 'edit'
                      self.add_group = {
                          id: res.id,
                          name: res.name,
                          manager: res.manager,
                          deputy_manager: res.deputy_manager,
                          manager_name: res.manager_name,
                          deputy_manager_name: res.deputy_manager_name,
                      }
                      $('#addgroup').modal('show');
                }).catch(error => {
                      console.log(error);
                });
            },
            deletegroup: function(id) {
                var _self = this;
                helper.deleteConfirm(function () {
                    axios.delete(
                        '/api/group/' + id
                    ).then(response => {
                          console.log(response);
                          helper.alert(response.data.message);
                          _self.getAllGroup();
                    }).catch(error => {
                          console.log(error);
                          helper.alert(error.response.data.message, 'danger');
                    });
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
                list_from: 1,
                list_to: 15
            }
            self.form = {
                action: '',
                submitted: false
            };
            self.initCol();
            self.initGroup();
            self.getAllGroup();
        },
        watch:
        {

        }
    }
</script>

<template>
    <div class="box-body">
        <div id="staff_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row">
                <div class="col-sm-6">
                    <div class="dataTables_length" id="staff_length">
                        <label>Show
                            <select name="staff_length" aria-controls="staff"
                                    class="form-control input-sm">
                                <option value="10">10</option>
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
                                   aria-controls="staff">
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
                                <th v-for="item in column" class="sorting" tabindex="0" rowspan="1"
                                    colspan="1" style="width: 295px;">
                                    {{ item.name }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in data" class="odd">
                                <td class="sorting_1">{{ item.id }}</td>
                                <td>{{ item.name }}</td>
                                <td>{{ item.group_name }}</td>
                                <td>{{ item.email }}</td>
                                <td>{{ item.phone }}</td>
                                <td>{{ item.barcode }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-5">
                    <div class="dataTables_info" id="staff_info" role="status" aria-live="polite">Showing 1
                        to 10 of 57 entries
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
        data: function () {
            return {
                data: [],
                column: [],
            }
        },
        methods:
        {
            initCol: function() {
                var self = this;
                self.column = [{
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
                }];
            },
            getAllStaff: function() {
                var self = this;
                axios.get('/api/staff')
                  .then(response => {
                      var self = this;
                      self.data = response.data.data.data;
                      console.log(response);
                  })
                  .catch(error => {
                      console.log(error);
                  });
            }
        },
        created: function()
        {
            var self = this;
            self.initCol();
            self.getAllStaff();
        }
    }
</script>

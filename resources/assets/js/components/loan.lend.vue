<template>
    <div>
        <div class="box">
            <h4 class="box-title" style="text-align: center">
                Scanner Form
            </h4>
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-offset-2 col-lg-4">
                        <div class="form-group">
                            <label for="equbar" class="control-label"><i class="glyphicon glyphicon-hdd"></i> <strong>Equipment &nbsp&nbsp</strong></label>&nbsp&nbsp
                            <label><input type="radio" name="EquipmentType" value="0" v-model="add_loan.equipment_type" checked>Barcode</label>
                            <label><input type="radio" name="EquipmentType" value="1" v-model="add_loan.equipment_type">Select</label>
                            <input v-if="add_loan.equipment_type == '0'" type="text" class="form-control input-lg" v-model="add_loan.equipment_barcode" placeholder="Equipment Barcode" tabindex="1" v-on:keyup="equi_bar($event)">
                            <div v-if="add_loan.equipment_type == '1'">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <select class="form-control" v-model="add_loan.equipment_id">
                                            <option value="0"> --- Select Equipment --- </option>
                                            <option v-for="item in equipment_list" v-if="item.hasBarcode == '0'" v-bind:value="item.id">{{ item.name }}-({{ item.amount-item.loan }})</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="number" class="form-control" v-model="add_loan.amount" min="1" placeholder="Amount">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="staffbar" class="control-label"><i class="glyphicon glyphicon-user"></i> <strong>Staff Barcode &nbsp&nbsp</strong></label>
                            <label><input type="radio" name="StaffType" value="0" v-model="add_loan.staff_type" checked>Barcode</label>
                            <label><input type="radio" name="StaffType" value="1" v-model="add_loan.staff_type">Select</label>
                            <input id="staffbar" v-if="add_loan.staff_type == '0'" type="text" class="form-control input-lg" v-model="add_loan.staff_barcode" placeholder="Staff Barcode" tabindex="2" v-on:keyup="staff_bar($event)">
                            <div v-if="add_loan.staff_type == '1'">
                                <select class="form-control" v-model="add_loan.staff_id">
                                    <option value="0"> --- Select Staff --- </option>
                                    <option v-for="item in staff_list" v-bind:value="item.id">{{ item.name }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6" v-if="big_info.had=='1'">
                        <div class="small-box bg-maroon">
                            <div class="icon">
                                <i class="glyphicon glyphicon-hdd"></i>
                            </div>
                            <div class="inner">
                                <h3>{{ big_info.equipment_name }} X {{ big_info.amount }}</h3>
                                <h4>{{ big_info.equipment_barcode }}&nbsp</h4>
                            </div>
                        </div>
                        <div class="small-box bg-maroon">
                            <div class="icon">
                                <i class="glyphicon glyphicon-user"></i>
                            </div>
                            <div class="inner">
                                <h3>{{ big_info.staff_name }}</h3>
                                <h4>{{ big_info.staff_barcode }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-offset-4 col-lg-4">
                        <button v-on:click="loanEquipment()" type="button" class="btn btn-block btn-success btn-lg">Submit</button>
                    </div>

                </div>
            </div>

        </div>
        <div class="box">
            <h4 class="box-title" style="text-align: center">
                Scanner log
            </h4>
            <div class="box-body">
                <div class="table-responsive">
                    <table id="group" class="table table-bordered table-striped dataTable" role="grid"
                           aria-describedby="group_info">
                        <thead>
                        <tr role="row">
                            <th v-for="row in col">
                                {{ row.name }}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in log">
                                <td>{{ item.id }}</td>
                                <td>{{ item.staff_name }}</td>
                                <td>{{ item.staff_barcode }}</td>
                                <td>{{ item.equipment_name }}</td>
                                <td>{{ item.equipment_barcode }}</td>
                                <td>{{ item.amount }}</td>
                                <td>{{ item.lend_time }}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                col: [],
                log: [],
                add_loan: [],
                staff_list: [],
                equipment_list: [],
                big_info: [],
            }
        },
        methods: {
            initCol: function () {
                var self = this;
                self.col = [{
                    name: 'id',
                    key: 'id'
                }, {
                    name: 'Staff',
                    key: ''
                }, {
                    name: 'Staff Barcode',
                    key: ''
                }, {
                    name: 'Equipment',
                    key: ''
                }, {
                    name: 'Equipment Barcode',
                    key: ''
                }, {
                    name: 'Amount',
                    key: ''
                }, {
                    name: 'Lend Time',
                    key: ''
                }];
            },
            initLoan: function () {
                var self = this;
                self.add_loan = {
                    staff_type:         '0',    // 0->barcode, 1->select
                    staff_id:           '0',
                    staff_barcode:      '',
                    equipment_type:     '0',    // 0->barcode, 1->select
                    equipment_id:       '0',
                    equipment_barcode:  '',
                    amount:             '1'
                }
            },
            initEquipment: function () {
                var self = this;
                axios.get(
                    '/api/equipment?all=true&orderby_field=name&orderby_method=asc'
                ).then(response => {
                      var res = response.data.data;
                      self.equipment_list = res;
                      console.log(self.equipment_list);
                }).catch(error => {
                      console.log(error);
                });
            },
            initList: function () {
                var self = this;
                axios.get(
                    '/api/staff?all=true&orderby_field=name&orderby_method=asc'
                ).then(response => {
                      var res = response.data.data;
                      self.staff_list = res;
                      console.log(self.staff_list);
                }).catch(error => {
                      console.log(error);
                });
                self.big_info = {
                    had:                '0',    // have
                    number:             0,
                    equipment_type:     '0',    // 0->barcode, 1->name
                    equipment_name:     '',
                    equipment_barcode:  '',
                    staff_name:         '',
                    staff_barcode:      '',
                    amount:             '1'
                };
            },
            loanEquipment: function () {
                var self = this;
                var data = {
                    equipment_id: '0',
                    staff_id: '0',
                    amount: '1'
                };
                if (self.add_loan.equipment_type == '0') {
                    data.equipment_barcode = self.add_loan.equipment_barcode;
                } else {
                    data.equipment_id = self.add_loan.equipment_id;
                    data.amount = self.add_loan.amount;
                }
                if (self.add_loan.staff_type == '0') {
                    data.staff_barcode = self.add_loan.staff_barcode;
                } else {
                    data.staff_id = self.add_loan.staff_id;
                }
                console.log(data);
                axios.post(
                    '/api/loan', data
                ).then(response => {
                    var res = response.data.data;
                    console.log(response);
                    helper.alert(response.data.message);
                    self.big_info.had = '1';
                    self.big_info.number++;
                    self.big_info.equipment_type = self.add_loan.equipment_type;
                    self.big_info.equipment_barcode = res.barcode;
                    self.big_info.equipment_name = res.equipment_name;
                    self.big_info.staff_name = res.staff_name;
                    self.big_info.staff_barcode = res.staff.barcode;
                    self.big_info.amount = res.amount;
                    var tmp_log = {
                        id: self.big_info.number,
                        staff_name: res.staff_name,
                        staff_barcode: res.staff.barcode,
                        equipment_name: res.equipment_name,
                        equipment_barcode: res.barcode,
                        amount: res.amount,
                        lend_time: res.created_at
                    };
                    self.log.push(tmp_log);
                    self.initEquipment();
                }).catch(error => {
                    console.log(error.response);
                    helper.alert(error.response.data.message, 'danger');
                });
            },
            equi_bar: function (event) {
                var self = this;
                if (event.which === 13 && self.add_loan.staff_type == '0') {
                    $("#staffbar").focus();
                }
            },
            staff_bar: function (event) {
                var self = this;
                if (event.which === 13) {
                    self.loanEquipment();
                }
            }
        }, created: function () {
            var self = this;
            self.initCol();
            self.initLoan();
            self.initEquipment();
            self.initList();
        }
    }
</script>

<template>
    <div>
        <div class="box">
            <h4 class="box-title" style="text-align: center">
                Scanner Form
            </h4>
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-offset-2 col-lg-8">
                        <div class="callout callout-danger" v-if="top_info.success == 2">
                            <h4><i class="glyphicon glyphicon-remove"></i> {{ top_info.message }}</h4>
                        </div>
                        <div class="callout callout-success" v-if="top_info.success == 1">
                            <h4><i class="glyphicon glyphicon-ok"></i> {{ top_info.message }}</h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-offset-1 col-lg-5">
                        <form class="form-inline">
                            <label class="control-label"><i class="glyphicon glyphicon-hdd"></i> <strong>Equipment &nbsp&nbsp</strong></label>
                            <div class="radio">
                                <label><input type="radio" name="EquipmentType" value="0" v-model="add_loan.equipment_type"
                                              checked> Barcode</label>
                            </div>
                            &nbsp
                            <div class="radio">
                                <label><input type="radio" name="EquipmentType" value="1" v-model="add_loan.equipment_type"> Select</label>
                            </div>
                        </form>
                        <div class="form-group">
                            <div class="input-group" v-if="add_loan.equipment_type == '0'">
                                <input id="equibar" type="text"
                                       class="form-control input-lg" v-model="add_loan.equipment_barcode"
                                       placeholder="Equipment Barcode" tabindex="1" v-on:keyup.enter="equi_bar()">
                                <span class="input-group-btn"><button class="btn btn-default btn-lg" type="button"
                                                                      v-on:click="equi_clear()"><i
                                        class="glyphicon glyphicon-repeat"></i> </button></span>
                            </div>
                            <div v-if="add_loan.equipment_type == '1'" class="row">
                                <div class="col-xs-12" style="margin-bottom: 5px">
                                    <select class="form-control" v-model="add_loan.equipment_id">
                                        <option value="0"> --- Select Equipment --- </option>
                                        <option v-for="item in equipment_list" v-if="item.hasBarcode == '0'"
                                                v-bind:value="item.id">
                                            {{ item.name }} ({{ item.amount - item.loan }})
                                        </option>
                                    </select>
                                </div>
                                <div class="col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon" style="font-size: 15px">數量</span>
                                        <input type="number" class="form-control input-lg" v-model="add_loan.amount" min="1"
                                               placeholder="Amount">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default btn-lg" type="button" v-on:click="add_loan.amount = add_loan.amount > 1 ? add_loan.amount - 1 : add_loan.amount">&nbsp-1&nbsp</button>
                                        </span>
                                        <span class="input-group-btn">
                                            <button class="btn btn-default btn-lg" type="button" v-on:click="add_loan.amount++">&nbsp+1&nbsp</button>
                                        </span>
                                        <span class="input-group-btn">
                                            <button class="btn btn-default btn-lg" type="button" v-on:click="add_loan.amount = 1">Reset</button>
                                        </span>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <form class="form-inline">
                            <label for="staffbar" class="control-label"><i class="glyphicon glyphicon-user"></i>
                                <strong>Staff Barcode &nbsp&nbsp</strong></label>
                            <div class="form-group">
                                <div class="radio"><label><input type="radio" value="0" v-model="add_loan.staff_type" checked> Barcode</label></div>
                            </div>&nbsp
                            <div class="form-group">
                                <div class="radio"><label><input type="radio" value="1" v-model="add_loan.staff_type"> Select</label></div>
                            </div>&nbsp
                            <div class="form-group">
                                <div class="checkbox"><label><input type="checkbox" value="1" v-model="staff_continue"> Continue</label></div>
                            </div>
                        </form>
                        <div class="form-group">
                            <div class="input-group" v-if="add_loan.staff_type == '0'">
                                <input id="staffbar" type="text"
                                       class="form-control input-lg" v-model="add_loan.staff_barcode"
                                       placeholder="Staff Barcode" v-on:keyup.enter="staff_bar()">
                                <span class="input-group-btn"><button class="btn btn-default btn-lg" type="button"
                                                                      v-on:click="staff_clear()"><i
                                        class="glyphicon glyphicon-repeat"></i> </button></span>
                            </div>
                            <div v-if="add_loan.staff_type == '1'">
                                <select class="form-control" v-model="add_loan.staff_id">
                                    <option value="0"> --- Select Staff --- </option>
                                    <option v-for="item in staff_list" v-bind:value="item.id">{{ item.name }} ({{ item.barcode }})</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5" v-if="big_info.had=='1'">
                        <div class="small-box bg-aqua-gradient">
                            <div class="icon">
                                <i class="glyphicon glyphicon-hdd"></i>
                            </div>
                            <div class="inner">
                                <h3>{{ big_info.equipment_name }} * {{ big_info.amount }}</h3>
                                <h4>{{ big_info.equipment_barcode }}&nbsp</h4>
                            </div>
                        </div>
                        <div class="small-box bg-aqua-gradient">
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
                        <button v-on:click="loanEquipment()" type="button" class="btn btn-block btn-lg bg-purple">
                            Submit
                        </button>
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
                add_loan: {
                    staff_type: '0',    // 0->barcode, 1->select
                    staff_id: '0',
                    staff_barcode: '',
                    equipment_type: '0',    // 0->barcode, 1->select
                    equipment_id: '0',
                    equipment_barcode: '',
                    amount: '1'
                },
                staff_list: [],
                equipment_list: [],
                big_info: [],
                top_info: [],
                staff_continue: false,
            }
        },
        methods: {
            initCol: function () {
                const self = this;
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
            intTopInfo: function () {
                const self = this;
                self.top_info = {
                    success: 0, //0->none, 1->success, 2->error
                    message: '',
                }
            },
            initLoan: function () {
                const self = this;
                self.add_loan = {
                    staff_type: self.add_loan.staff_type ? self.add_loan.staff_type : '0',    // 0->barcode, 1->select
                    staff_id: self.staff_continue ? self.add_loan.staff_id: '0',
                    staff_barcode: self.staff_continue ? self.add_loan.staff_barcode : '',
                    equipment_type: self.add_loan.equipment_type ? self.add_loan.equipment_type : '0',    // 0->barcode, 1->select
                    equipment_id: '0',
                    equipment_barcode: '',
                    amount: '1'
                }
            },
            initEquipment: function () {
                const self = this;
                axios.get(
                    '/api/equipment?all=true&orderby_field=name&orderby_method=asc'
                ).then(response => {
                    const res = response.data.data;
                    self.equipment_list = res;
                    console.log(self.equipment_list);
                }).catch(error => {
                    console.log(error);
                });
            },
            initBigInfo: function () {
                const self = this;
                self.big_info.equipment_type = '0';
                self.big_info.equipment_name = '';
                self.big_info.equipment_barcode = '';
                self.big_info.staff_name = '';
                self.big_info.staff_barcode = '';
                self.big_info.amount = '1';
            },
            initList: function () {
                const self = this;
                axios.get(
                    '/api/staff?all=true&orderby_field=name&orderby_method=asc'
                ).then(response => {
                    const res = response.data.data;
                    self.staff_list = res;
                    console.log(self.staff_list);
                }).catch(error => {
                    console.log(error);
                });
                self.big_info = {
                    had: '0',    // have
                    number: 0,
                    equipment_type: '0',    // 0->barcode, 1->name
                    equipment_name: '',
                    equipment_barcode: '',
                    staff_name: '',
                    staff_barcode: '',
                    amount: '1',
                };
            },
            loanEquipment: function () {
                const self = this;
                const data = {
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
                    const res = response.data.data;
                    console.log(response);
                    self.top_info.message = response.data.message;
                    self.top_info.success = 1;
                    self.big_info.had = '1';
                    self.big_info.number++;
                    self.big_info.equipment_type = self.add_loan.equipment_type;
                    self.big_info.equipment_barcode = res.barcode;
                    self.big_info.equipment_name = res.equipment_name;
                    self.big_info.staff_name = res.staff_name;
                    self.big_info.staff_barcode = res.staff.barcode;
                    self.big_info.amount = res.amount;
                    const tmp_log = {
                        id: self.big_info.number,
                        staff_name: res.staff_name,
                        staff_barcode: res.staff.barcode,
                        equipment_name: res.equipment_name,
                        equipment_barcode: res.barcode,
                        amount: res.amount,
                        lend_time: res.created_at
                    };
                    self.log.reverse();
                    self.log.push(tmp_log);
                    self.log.reverse();
                    self.initEquipment();
                    if (self.add_loan.equipment_type == '0') {
                        $("#equibar").focus();
                    }
                    self.initLoan();
                }).catch(error => {
                    console.log(error.response);
                    self.top_info.message = error.response.data.message;
                    self.top_info.success = 2;
                    $("#equibar").focus();
                    $("#equibar").select();
                });
            },
            equi_bar: function () {
                const self = this;
                if (self.add_loan.staff_type == '0') {
                    $("#staffbar").focus();
                }
                if (self.top_info.success === 2) {
                    $("#staffbar").select();
                }
                self.intTopInfo();
                self.initBigInfo();
            },
            staff_bar: function () {
                const self = this;
                self.loanEquipment();
            },
            equi_clear: function () {
                const self = this;
                self.add_loan.equipment_barcode = '';
                $("#equibar").focus();
            },
            staff_clear: function () {
                const self = this;
                self.add_loan.staff_barcode = '';
                self.staff_continue = false;
                $("#staffbar").focus();
            }
        }, created: function () {
            const self = this;
            self.initCol();
            self.initLoan();
            self.initEquipment();
            self.initList();
            self.intTopInfo();
        }, mounted() {
            setTimeout(function () {
                $("#equibar").focus();
            }, 100);
        }
    }
</script>

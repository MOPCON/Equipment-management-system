<template>
    <div>
        <div class="card">
            <h5 class="card-header text-center">Scanner Form</h5>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-6">
                        <div class="alert alert-danger" v-if="top_info.success == 2" role="alert">
                            <h4>
                                <font-awesome-icon icon="exclamation"/>
                                {{ top_info.message }}
                            </h4>
                        </div>
                        <div class="alert alert-success" v-if="top_info.success == 1">
                            <h4>
                                <font-awesome-icon icon="check"/>
                                {{ top_info.message }}
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <form class="form-inline">
                            <label class="control-label">
                                <font-awesome-icon icon="hdd"/>&nbsp;<strong>器材 Equipment &nbsp;&nbsp;</strong>
                            </label>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="EquipmentType" value="0" v-model="add_loan.equipment_type"
                                           checked> Barcode</label>
                            </div>
                            &nbsp
                            <div class="radio">
                                <label><input type="radio" name="EquipmentType" value="1"
                                              v-model="add_loan.equipment_type"> Select</label>
                            </div>
                        </form>
                        <div class="form-group">
                            <div class="input-group" v-if="add_loan.equipment_type == '0'">
                                <input id="equibar" type="text"
                                       class="form-control input-lg" v-model="add_loan.equipment_barcode"
                                       placeholder="Equipment Barcode" tabindex="1" @keyup.enter="equi_bar()">

                                <div class="input-group-append">
                                    <button class="btn btn-outline-danger btn-lg" type="button" @click="equi_clear()">
                                        <font-awesome-icon icon="times" size="lg"/>
                                    </button>
                                </div>
                            </div>
                            <div v-if="add_loan.equipment_type == '1'" class="row">
                                <div class="col-12" style="margin-bottom: 5px">
                                    <select class="form-control input-lg-select" v-model="add_loan.equipment_id">
                                        <option value="0"> --- Select Equipment ---</option>
                                        <option v-for="item in equipment_list" v-if="item.hasBarcode == '0'"
                                                v-bind:value="item.id">
                                            {{ item.name }} ({{ item.amount - item.loan }})
                                        </option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" style="font-size: 15px">數量</span>
                                        </div>
                                        <div class="input-group-prepend">
                                            <button class="btn btn-outline-info btn-lg" type="button"
                                                    @click="add_loan.amount = add_loan.amount > 1 ? add_loan.amount - 1 : add_loan.amount">
                                                <font-awesome-icon icon="minus" size="lg"/>
                                            </button>
                                        </div>
                                        <input type="number" class="form-control input-lg" v-model="add_loan.amount"
                                               min="1"
                                               placeholder="Amount">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-info btn-lg" type="button"
                                                    @click="add_loan.amount++">
                                                <font-awesome-icon icon="plus" size="lg"/>
                                            </button>
                                        </div>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-danger btn-lg" type="button"
                                                    @click="add_loan.amount = 1">
                                                <font-awesome-icon icon="times" size="lg"/>
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <form class="form-inline">
                            <label for="staffbar" class="control-label">
                                <font-awesome-icon icon="user"/>
                                &nbsp;<strong>工人條碼 Staff Barcode &nbsp&nbsp</strong></label>
                            <div class="form-group">
                                <div class="radio"><label><input type="radio" value="0" v-model="add_loan.staff_type"
                                                                 checked> Barcode</label></div>
                            </div>
                            &nbsp
                            <div class="form-group">
                                <div class="radio"><label><input type="radio" value="1" v-model="add_loan.staff_type">
                                    Select</label></div>
                            </div>
                            &nbsp
                            <div class="form-group">
                                <div class="checkbox"><label><input type="checkbox" value="1" v-model="staff_continue">
                                    Continue</label></div>
                            </div>
                        </form>
                        <div class="form-group">
                            <div class="input-group" v-if="add_loan.staff_type == '0'">
                                <input id="staffbar" type="text"
                                       class="form-control input-lg" v-model="add_loan.staff_barcode"
                                       placeholder="Staff Barcode" @keyup.enter="staff_bar()">

                                <div class="input-group-append">
                                    <button class="btn btn-outline-danger btn-lg" type="button" @click="staff_clear()">
                                        <font-awesome-icon icon="times" size="lg"/>
                                    </button>
                                </div>
                            </div>
                            <div v-if="add_loan.staff_type == '1'">
                                <select class="form-control input-lg-select" v-model="add_loan.staff_id">
                                    <option value="0"> --- Select Staff ---</option>
                                    <option v-for="item in staff_list" v-bind:value="item.id">{{ item.name }} ({{
                                        item.barcode }})
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="alert alert-primary" v-if="big_info.had === '1'">
                            <div class="row">
                                <div class="col-2">
                                    <h2>
                                        <strong>
                                            <font-awesome-icon icon="hdd" size="2x"/>
                                        </strong>
                                    </h2>
                                </div>
                                <div class="col-10">
                                    <h2>{{ big_info.equipment_name }} * {{ big_info.amount }}</h2>
                                    <h4>{{ big_info.equipment_barcode }}&nbsp</h4>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-primary" v-if="big_info.had === '1'">
                            <div class="row">
                                <div class="col-2">
                                    <h2>
                                        <strong>
                                            <font-awesome-icon icon="user" size="2x"/>
                                        </strong>
                                    </h2>
                                </div>
                                <div class="col-10">
                                    <h2>{{ big_info.staff_name }}</h2>
                                    <h4>{{ big_info.staff_barcode }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 col-sm-3">
                        <button v-on:click="loanEquipment()" type="button" class="btn btn-block btn-lg btn-primary">
                            送出
                        </button>
                    </div>
                </div>
            </div>

        </div>
        <div class="card mt-3">
            <h5 class="card-header text-center">
                Scanner log
            </h5>
            <div class="card-body">
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
        data() {
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
            };
        },
        methods: {
            initCol() {
                this.col = [{
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
            intTopInfo() {
                this.top_info = {
                    success: 0, //0->none, 1->success, 2->error
                    message: '',
                };
            },
            initLoan() {
                this.add_loan = {
                    staff_type: this.add_loan.staff_type ? this.add_loan.staff_type : '0',    // 0->barcode, 1->select
                    staff_id: this.staff_continue ? this.add_loan.staff_id : '0',
                    staff_barcode: this.staff_continue ? this.add_loan.staff_barcode : '',
                    equipment_type: this.add_loan.equipment_type ? this.add_loan.equipment_type : '0',    // 0->barcode, 1->select
                    equipment_id: '0',
                    equipment_barcode: '',
                    amount: '1'
                };
            },
            initEquipment() {
                const self = this;
                axios.get(
                    '/api/equipment?all=true&orderby_field=name&orderby_method=asc'
                ).then(response => {
                    const res = response.data.data;
                    self.equipment_list = res;
                }).catch(error => {
                    console.log(error);
                });
            },
            initBigInfo() {
                this.big_info.equipment_type = '0';
                this.big_info.equipment_name = '';
                this.big_info.equipment_barcode = '';
                this.big_info.staff_name = '';
                this.big_info.staff_barcode = '';
                this.big_info.amount = '1';
            },
            initList() {
                const self = this;
                axios.get(
                    '/api/staff?all=true&orderby_field=name&orderby_method=asc'
                ).then(response => {
                    const res = response.data.data;
                    self.staff_list = res;
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
            loanEquipment() {
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
                axios.post(
                    '/api/loan', data
                ).then(response => {
                    const res = response.data.data;
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
            equi_bar() {
                if (this.add_loan.staff_type == '0') {
                    $("#staffbar").focus();
                }
                if (this.top_info.success === 2) {
                    $("#staffbar").select();
                }
                this.intTopInfo();
                this.initBigInfo();
            },
            staff_bar() {
                this.loanEquipment();
            },
            equi_clear() {
                this.add_loan.equipment_barcode = '';
                $("#equibar").focus();
            },
            staff_clear() {
                this.add_loan.staff_barcode = '';
                this.staff_continue = false;
                $("#staffbar").focus();
            }
        },
        mounted() {
            this.initCol();
            this.initLoan();
            this.initEquipment();
            this.initList();
            this.intTopInfo();
            setTimeout(function () {
                $("#equibar").focus();
            }, 100);
        }
    };
</script>

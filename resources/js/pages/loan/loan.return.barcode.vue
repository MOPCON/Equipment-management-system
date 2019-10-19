<template>
    <div>
        <div class="card">
            <h5 class="card-header text-center">
                Scanner Form
            </h5>
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
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="control-label">
                                <font-awesome-icon icon="hdd"/>&nbsp;<strong>器材 Equipment &nbsp;&nbsp;</strong>
                            </label>
                            <div class="input-group">
                                <input id="equrbar" type="text"
                                       class="form-control input-lg" v-model="return_barcode"
                                       placeholder="Equipment Barcode" tabindex="1" v-on:keyup.enter="equi_bar()"
                                       autofocus>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-danger btn-lg" type="button" @click="equi_clear()">
                                        <font-awesome-icon icon="times" size="lg"/>
                                    </button>
                                </div>
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
                        <button v-on:click="retuenEquipment()" type="button" class="btn btn-block btn-lg btn-primary">
                            送出
                        </button>
                    </div>
                </div>
            </div>

        </div>
        <div class="card">
            <h4 class="card-header text-center">
                Scanner log
            </h4>
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
                            <td>{{ item.return_time }}</td>
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
                return_barcode: '',
                big_info: [],
                top_info: [],
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
                    name: 'Return Time',
                    key: ''
                }];
            },
            intTopInfo() {
                this.top_info = {
                    success: 0, //0->none, 1->success, 2->error
                    message: '',
                };
            },
            initData() {
                this.return_barcode = '';
            },
            initBigInfo() {
                this.big_info.equipment_name = '';
                this.big_info.equipment_barcode = '';
                this.big_info.staff_name = '';
                this.big_info.staff_barcode = '';
                this.big_info.amount = '1';
            },
            initList() {
                this.big_info = {
                    had: '0',    // have
                    number: 0,
                    equipment_name: '',
                    equipment_barcode: '',
                    staff_name: '',
                    staff_barcode: '',
                    amount: '1',
                };
            },
            retuenEquipment() {
                const self = this;
                const data = {
                    loan_id: '0',
                    barcode: self.return_barcode,
                    amount: '1'
                };
                axios.post(
                    '/api/loan/return', data
                ).then(response => {
                    const res = response.data.data;
                    self.top_info.message = response.data.message;
                    self.top_info.success = 1;
                    self.big_info.had = '1';
                    self.big_info.number++;
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
                        return_time: res.return_at
                    };
                    self.log.reverse();
                    self.log.push(tmp_log);
                    self.log.reverse();
                    self.initData();
                    $("#equrbar").focus();
                }).catch(error => {
                    console.log(error.response);
                    switch(error.response.status) {
                        case 419:
                           self.top_info.message = "The access token has expired, please refresh this page.";
                        default:
                            self.top_info.message = error.response.data.message;
                    }
                    self.top_info.success = 2;
                    $("#equrbar").select();
                });
            },
            equi_bar() {
                this.retuenEquipment();
                this.intTopInfo();
                this.initBigInfo();
            },
            equi_clear() {
                this.return_barcode = '';
                $("#equrbar").focus();
            }
        },
        mounted() {
            this.initCol();
            this.initData();
            this.initList();
            this.intTopInfo();
        }
    };
</script>

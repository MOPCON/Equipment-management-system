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
                    <div class="col-lg-offset-2 col-lg-4">
                        <div class="form-group">
                            <label for="equbar" class="control-label"><i class="glyphicon glyphicon-hdd"></i> <strong>Equipment &nbsp&nbsp</strong></label>&nbsp&nbsp
                            <div class="input-group">
                                <input id="equrbar" type="text"
                                       class="form-control input-lg" v-model="return_barcode"
                                       placeholder="Equipment Barcode" tabindex="1" v-on:keyup.enter="equi_bar()" autofocus>
                                <span class="input-group-btn"><button class="btn btn-default btn-lg" type="button"
                                                                      v-on:click="equi_clear()"><i
                                        class="glyphicon glyphicon-repeat"></i> </button></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4" v-if="big_info.had=='1'">
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
                        <button v-on:click="retuenEquipment()" type="button" class="btn btn-block btn-lg bg-purple">
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
        data: function () {
            return {
                col: [],
                log: [],
                return_barcode: '',
                big_info: [],
                top_info: [],
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
                    name: 'Return Time',
                    key: ''
                }];
            },
            intTopInfo: function () {
                const self = this;
                self.top_info = {
                    success: 0, //0->none, 1->success, 2->error
                    message: '',
                };
            },
            initData: function () {
                const self = this;
                self.return_barcode = '';
            },
            initBigInfo: function () {
                const self = this;
                self.big_info.equipment_name = '';
                self.big_info.equipment_barcode = '';
                self.big_info.staff_name = '';
                self.big_info.staff_barcode = '';
                self.big_info.amount = '1';
            },
            initList: function () {
                const self = this;
                self.big_info = {
                    had: '0',    // have
                    number: 0,
                    equipment_name: '',
                    equipment_barcode: '',
                    staff_name: '',
                    staff_barcode: '',
                    amount: '1',
                };
            },
            retuenEquipment: function () {
                const self = this;
                const data = {
                    loan_id: '0',
                    barcode: self.return_barcode,
                    amount: '1'
                };
                console.log(data);
                axios.post(
                    '/api/loan/return', data
                ).then(response => {
                    const res = response.data.data;
                    console.log(response);
                    self.top_info.message = response.data.message;
                    self.top_info.success = 1;
//                    helper.alert(response.data.message);
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
                    console.log(self.big_info.number);
                    self.log.reverse();
                    self.log.push(tmp_log);
                    self.log.reverse();
                    self.initData();
                    $("#equrbar").focus();
                }).catch(error => {
                    console.log(error.response);
                    self.top_info.message = error.response.data.message;
                    self.top_info.success = 2;
                    $("#equrbar").select();
                });
            },
            equi_bar: function () {
                const self = this;
                self.retuenEquipment();
                self.intTopInfo();
                self.initBigInfo();
            },
            equi_clear: function () {
                const self = this;
                self.return_barcode = '';
                $("#equrbar").focus();
            }
        }, created: function () {
            const self = this;
            self.initCol();
            self.initData();
            self.initList();
            self.intTopInfo();
        }
    }
</script>

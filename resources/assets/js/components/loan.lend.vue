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
                            <label for="equbar" class="control-label"><i class="glyphicon glyphicon-hdd"></i> <strong>Equipment Barcode</strong></label>
                            <input type="email" class="form-control input-lg" id="equbar"
                                   placeholder="Equipment Barcode">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"><span class="text-red">Remember Equipment!</span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="staffbar" class="control-label"><i class="glyphicon glyphicon-user"></i> <strong>Staff Barcode</strong></label>
                            <input type="email" class="form-control input-lg" id="staffbar" placeholder="Staff Barcode">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"><span class="text-red">Remember Staff!</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="small-box bg-maroon">
                            <div class="icon">
                                <i class="glyphicon glyphicon-hdd"></i>
                            </div>
                            <div class="inner">
                                <h3>無線電對講機</h3>
                                <p>EQ00001</p>
                            </div>
                        </div>
                        <div class="small-box bg-maroon">
                            <div class="icon">
                                <i class="glyphicon glyphicon-user"></i>
                            </div>
                            <div class="inner">
                                <h3>奕翔</h3>
                                <p>ST00001</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-offset-4 col-lg-4">
                        <button type="button" class="btn btn-block btn-success btn-lg">Submit</button>
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
                        <!--<tr v-for="item in log">-->
                        <!--<td>{{ item.id }}</td>-->
                        <!--<td>{{ item.name }}</td>-->
                        <!--<td>{{ item.manager_name }}</td>-->
                        <!--<td>{{ item.deputy_manager_name }}</td>-->
                        <!--<td>{{ item.number }}</td>-->
                        <!--<td>-->
                        <!--<button type="button" class="btn btn-sm btn-primary"-->
                        <!--v-on:click="openEditgroup(item.id, 'edit')">-->
                        <!--<i class="fa fa-edit"></i>-->
                        <!--</button>-->
                        <!--<button type="button" class="btn btn-sm btn-danger" v-on:click="deletegroup(item.id)">-->
                        <!--<i class="fa fa-trash-o"></i>-->
                        <!--</button>-->
                        <!--</td>-->
                        <!--</tr>-->
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
        }, created: function () {
            var self = this;
            self.initCol();
        },


    }
</script>

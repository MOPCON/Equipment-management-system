<template>
    <div>
        <section class="content-header">
            <h1>
                發送訊息
                <small>Telegram Message</small>
            </h1>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="box">
                    <div class="box-body">
                        <div id="student_verify_wrapper" class="dataTables_wrapper dt-bootstrap">
                            <div class="row">
                                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-1">
                                    <button type="button" class="btn btn-sm btn-primary btn-block" v-on:click="openAddContent">
                                        <span class="glyphicon glyphicon-plus"></span> Add
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-10 col-sm-12 col-md-12 col-lg-12 table-responsive">
                                    <table id="student" class="table table-bordered table-striped dataTable" role="grid"
                                           aria-describedby="staff_info">
                                        <thead>
                                        <tr role="row">
                                            <th class="sortfield" tabindex="0">id</th>
                                            <th class="sortfield" tabindex="0">是否已發送</th>
                                            <th class="sortfield" tabindex="0">排成時間</th>
                                            <th class="sortfield" tabindex="0">發言人員</th>
                                            <th class="sortfield" tabindex="0">頻道</th>
                                            <th class="sortfield" tabindex="0">名稱</th>
                                            <th class="sortfield" tabindex="0">內容</th>
                                            <th class="sortfield" tabindex="0">修改</th>
                                            <th class="sortfield" tabindex="0">刪除</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <!--<tr v-for="(item, index) in list">-->
                                            <!--<td>-->
                                                <!--<span v-show="item.is_verify" class="label label-success">通過</span>-->
                                                <!--<span v-show="!item.is_verify" class="label label-default">未驗證</span>-->
                                            <!--</td>-->
                                            <!--<td>-->
                                                <!--<button type="button" class="btn btn-sm btn-default btn-block" v-on:click="openVerifyData(index)">-->
                                                    <!--<i class="fa fa-edit"></i>-->
                                                <!--</button>-->
                                                <!--<button type="button" class="btn btn-sm btn-default btn-block" v-on:click="update(index, true, false)" v-show="!item.is_verify">-->
                                                    <!--<i class="fa fa-check"></i>-->
                                                <!--</button>-->
                                                <!--<button v-show="item.id != null" type="button" class="btn btn-sm btn-default btn-block" v-on:click="deleteData(item.id, index)">-->
                                                    <!--<i class="fa fa-trash-o"></i>-->
                                                <!--</button>-->
                                            <!--</td>-->
                                            <!--<td>{{ item.verify_user_name }}</td>-->
                                            <!--<td>{{ item.order_id }}</td>-->
                                            <!--<td>{{ item.register_no }}</td>-->
                                            <!--<td>{{ item.purchase_date}}</td>-->
                                            <!--<td>{{ item.name}}</td>-->
                                            <!--<td>{{ item.email }}</td>-->
                                            <!--<td>{{ item.school }}</td>-->
                                            <!--<td>-->
                                                <!--<img class="pointer" v-bind:src="item.file_url" v-show="item.file_type === 'image'" v-on:click="openWindow(item.file_url)" width="100px">-->
                                                <!--<span v-show="item.file_type === 'pdf'">-->
                                                    <!--<a v-bind:href="item.file_url" target="_blank">-->
                                                        <!--<span class="fa fa-file-pdf-o fa-2x"></span>-->
                                                    <!--</a>-->
                                                    <!--{{ item.file_url }}-->
                                                <!--</span>-->
                                                <!--<span v-show="item.file_type !== 'image' && item.file_type !== 'pdf'">-->
                                                    <!--<a v-bind:href="item.file_url" target="_blank"> {{ item.file_url }}</a>-->
                                                <!--</span>-->
                                            <!--</td>-->
                                        <!--</tr>-->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="addContent" tabindex="-1" role="dialog"
                             aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <h4 class="modal-title" id="myModalLabel">Add Content</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form name="addStaff">
                                            <div class="form-group">
                                                <strong>排成日期</strong>
                                                <input type="date" name="date" v-model="add_content.schedule_date"
                                                       class="form-control" placeholder="Date" required>
                                            </div>
                                            <div class="form-group">
                                                <strong>排成時間</strong>
                                                <input type="time" name="time" v-model="add_content.schedule_time"
                                                       class="form-control" placeholder="Time" required>
                                            </div>
                                            <div class="form-group">
                                                <strong>頻道</strong>
                                                <select class="form-control" v-model="add_content.channelId">
                                                    <option value="0"> --- 請選擇 --- </option>
                                                    <option value="1"> 頻道1 </option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <strong>廣播名稱</strong>
                                                <input type="text" name="name" v-model="add_content.name"
                                                       class="form-control" placeholder="Name" required>
                                            </div>
                                            <div class="form-group">
                                                <strong>內容</strong>
                                                <textarea class="form-control" v-model="add_content.content" required></textarea>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" v-on:click="addContent">新增</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                add_content: {}
            }
        },
        methods: {
            openAddContent() {
                let self = this;
                self.initContent();
                $('#addContent').modal('show');
            },
            initContent () {
                let self = this;
                self.add_content = {
                    id: '',
                    schedule_date: new Date(),
                    schedule_time: new Date(),
                    channelId: 0,
                    name: '',
                    content: '',
                    user_id: 0
                };
            },
            addContent() {
                let self = this;
                $('#addContent').modal('hide');
            }
        },
        created: function () {
            let self = this;
            self.initContent();
        }
    }
</script>
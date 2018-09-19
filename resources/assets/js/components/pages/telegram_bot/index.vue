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
                                    <button type="button" class="btn btn-sm btn-primary btn-block" v-on:click="openAddMessage">
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
                                            <th class="sortfield" tabindex="0">頻道</th>
                                            <th class="sortfield" tabindex="0">名稱</th>
                                            <th class="sortfield" tabindex="0" width="40%">內容</th>
                                            <th class="sortfield" tabindex="0">發言人員</th>
                                            <th class="sortfield" tabindex="0">狀態</th>
                                            <th class="sortfield" tabindex="0">排成時間</th>
                                            <th class="sortfield" tabindex="0"> </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="item in list">
                                            <td>{{ item.id }}</td>
                                            <td>{{ item.channel.name}} ({{ item.channel.id}})</td>
                                            <td>{{ item.display_name }}</td>
                                            <td>{{ item.content }}</td>
                                            <td>{{ item.user.name}}</td>
                                            <td v-if="item.status === 0">
                                                <span class="label label-default">等待發送</span>
                                            </td>
                                            <td v-if="item.status === 1">
                                                <span class="label label-success">已發送</span>
                                            </td>
                                            <td v-if="item.status === 2">
                                                <span class="label label-danger">發送失敗</span>
                                            </td>
                                            <td>{{ item.sending_time }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-success" v-if="item.status === 0 || item.status === 2"
                                                        v-on:click="openEditChannel(item.id)" title="立即發送">
                                                    <i class="fa fa-flash"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-primary" v-if="item.status === 0 || item.status === 2"
                                                        v-on:click="openEditChannel(item.id)" title="編輯">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger" v-if="item.status === 0"
                                                        v-on:click="deleteChannel(item.id)" title="刪除">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="dataTables_info" id="staff_info" role="status" aria-live="polite">
                                        Showing {{ page_info.list_from }} to {{ page_info.list_to
                                        }} of {{ page_info.total }} entries
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <div class="dataTables_paginate paging_simple_numbers" id="staff_paginate">
                                        <ul class="pagination">
                                            <li class="paginate_button previous" id="staff_previous"
                                                v-bind:class="[page_info.current_page-1 == 0 ? 'disabled' : '']">
                                                <a aria-controls="staff" data-dt-idx="0" tabindex="0"
                                                   v-on:click="changePage(page_info.current_page-1)">Previous</a>
                                            </li>
                                            <li v-for="i in getPageArray" class="paginate_button"
                                                v-bind:class="[page_info.current_page == i ? 'active' : '']">
                                                <a aria-controls="staff" data-dt-idx="1" tabindex="0"
                                                   v-on:click="changePage(i)">{{ i }}</a>
                                            </li>
                                            <li class="paginate_button next" id="staff_next"
                                                v-bind:class="[page_info.current_page+1 > page_info.last_page ? 'disabled' : '']">
                                                <a aria-controls="staff" data-dt-idx="7" tabindex="0"
                                                   v-on:click="changePage(page_info.current_page+1)">Next</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="addMessage" tabindex="-1" role="dialog"
                             aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                        <h4 class="modal-title" id="myModalLabel">Add Message</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form name="addStaff">
                                            <div class="form-inline">
                                                <label class="control-label"><strong>發送形式 &nbsp&nbsp</strong></label>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" value="1" v-model="add_message.now_send">
                                                        立即執行
                                                    </label>
                                                </div>
                                                &nbsp
                                                <div class="radio">
                                                    <label><input type="radio" value="0" v-model="add_message.now_send">
                                                        設定時間
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group" v-show="add_message.now_send === '0'">
                                                <input type="datetime-local" name="date" v-model="add_message.sending_time"
                                                       class="form-control" placeholder="Date">
                                            </div>
                                            <div class="form-group">
                                                <strong>頻道</strong>
                                                <select class="form-control" v-model="add_message.channel_id">
                                                    <option v-for="channel in channel_list" v-bind:value="channel.id">{{ channel.name }} ({{ channel.id }})</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <strong>廣播名稱</strong>
                                                <input type="text" name="name" v-model="add_message.display_name"
                                                       class="form-control" placeholder="Name" required>
                                            </div>
                                            <div class="form-group">
                                                <strong>內容</strong>
                                                <textarea class="form-control" v-model="add_message.content" required rows="10"></textarea>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" v-on:click="addMessage">新增</button>
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
                add_message: {
                    id: '',
                    now_send: 1,
                    sending_time: new Date(),
                    channel_id: 0,
                    display_name: '',
                    content: '',
                    user_id: 0
                },
                page_info: [],
                list: [],
                channel_list: []
            }
        },
        computed: {
            getPageArray: function () {
                let self = this;
                let bottom = self.page_info.current_page - 2 <= 0 ? 1 : self.page_info.current_page - 2;
                let top = bottom + 5 > self.page_info.last_page ? self.page_info.last_page : bottom + 5;
                let array = [];
                for (let i = bottom; i <= top; i++) {
                    array.push(i);
                }
                return array;
            },
        },
        methods: {
            getAllMessage() {
                let self = this;
                axios.get(
                    '/api/telegram-message?search=' + self.page_info.search + '&orderby_field=' + self.page_info.sort_key + '&orderby_method=' + self.page_info.sort_dir + '&limit=' + self.page_info.limit + '&page=' + self.page_info.current_page
                ).then(response => {
                    console.log(response);
                    let res = response.data.data
                    self.list = res.data
                    self.page_info.current_page = res.current_page
                    self.page_info.last_page = res.last_page
                    self.page_info.total = res.total
                    self.page_info.list_from = res.from
                    self.page_info.list_to = res.to
                    console.log(self.list);
                }).catch(error => {
                    console.log(error)
                })
            },
            getAllChannel() {
                let self = this;
                axios.get(
                    '/api/telegram-channel'
                ).then(response => {
                    self.channel_list = response.data.data;
                }).catch(error => {
                    console.log(error);
                });
            },
            openAddMessage() {
                let self = this;
                self.initMessage();
                $('#addMessage').modal({
                    backdrop: 'static',
                    keyboard: false
                });
            },
            initMessage () {
                let self = this;
                self.add_message = {
                    id: '',
                    now_send: 1,
                    sending_time: new Date(),
                    channel_id: (self.channel_list.length > 0) ? self.channel_list[0].id : 0,
                    display_name: '',
                    content: '',
                    user_id: 0
                };
            },
            addMessage() {
                let self = this;
                $('#addMessage').modal('hide');
                axios.post(
                    '/api/telegram-message', self.add_message
                ).then(response => {
                    $('#addMessage').modal('hide');
                    self.getAllMessage();
                    helper.alert(response.data.message);
                }).catch(error => {
                    console.log(error.response);
                    helper.alert(error.response.data.message, 'danger');
                });
            },
            searchKeyword: function (event) {
                if (event.which === 13) {
                    console.log(this.page_info.search);
                    this.getAllMessage();
                }
            },
            changePage: function (page) {
                let self = this;
                if (page > 0 && page <= self.page_info.last_page) {
                    self.page_info.current_page = page;
                    this.getAllMessage();
                }
            },
            changeSort: function (field) {
                let self = this;
                if (field !== '') {
                    self.page_info.sort_dir = self.page_info.sort_dir === 'DESC' ? 'ASC' : 'DESC';
                    self.page_info.sort_key = field;
                    this.getAllMessage();
                }
            }
        },
        created: function () {
            let self = this;
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
            };
            self.getAllMessage();
            self.getAllChannel();
            self.initMessage();
        }
    }
</script>
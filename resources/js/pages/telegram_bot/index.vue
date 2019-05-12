<template>
    <div>
        <h1>
            發送訊息
            <small>Telegram Message</small>
        </h1>
        <div class="row mb-3">
            <div class="col-xs-12 col-sm-2 col-md-2 col-lg-1">
                <button type="button" class="btn btn-sm btn-primary btn-block" @click="openAddMessage">
                    <font-awesome-icon class="icon" icon="plus"/> Add
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
                        <th class="sortfield" tabindex="0">顯示名稱</th>
                        <th class="sortfield" tabindex="0" width="40%">內容</th>
                        <th class="sortfield" tabindex="0">發送人員</th>
                        <th class="sortfield" tabindex="0">狀態</th>
                        <th class="sortfield" tabindex="0">預計發送時間</th>
                        <th class="sortfield" tabindex="0">實際發送時間</th>
                        <th class="sortfield" tabindex="0"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in list">
                        <td>{{ item.id }}</td>
                        <td v-if="item.channel">{{ item.channel.name}}</td>
                        <td v-if="!item.channel">(已刪除)</td>
                        <td>{{ item.display_name }}</td>
                        <td>{{ item.content }}</td>
                        <td v-if="item.user">{{ item.user.name }}</td>
                        <td v-if="!item.user">(已刪除)</td>
                        <td v-if="item.status === 0">
                            <span class="label label-default">等待排程</span>
                        </td>
                        <td v-if="item.status === 1">
                            <span class="label label-success">已發送</span>
                        </td>
                        <td v-if="item.status === 2">
                            <span class="label label-danger">發送失敗</span>
                        </td>
                        <td v-if="item.status === 3">
                            <span class="label label-default">發送中</span>
                        </td>
                        <td>{{ item.es_time || '-' }}</td>
                        <td>{{ item.as_time || '-' }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-success"
                                    v-if="item.status === 0 || item.status === 2"
                                    v-on:click="nowSendMessage(item.id)" title="立即發送 / 重啟排程">
                                <font-awesome-icon class="icon" icon="play"/>
                            </button>
                            <button type="button" class="btn btn-sm btn-primary"
                                    v-if="item.status === 0 || item.status === 2"
                                    v-on:click="openEditMessage(item.id)" title="編輯">
                                <font-awesome-icon class="icon" icon="edit"/>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" v-if="item.status === 0"
                                    v-on:click="deleteMessage(item.id)" title="刪除">
                                <font-awesome-icon class="icon" icon="trash"/>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-5">
                <div class="dataTables_info" id="group_info" role="status" aria-live="polite">
                    Showing {{ page_info.list_from }} to {{ page_info.list_to
                    }} of {{ page_info.total }} entries
                </div>
            </div>
            <div class="col-12 col-sm-7">
                <Pagination :pageInfo="page_info" @onChangePage="onChangePage"/>
            </div>
        </div>

        <Modal target="addMessage" size="xs">
            <template v-slot:title>
                <h4 v-if="action === 'add'" class="modal-title">Add Message</h4>
                <h4 v-if="action === 'edit'" class="modal-title">Edit Message</h4>
            </template>
            <template v-slot:header>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </template>
            <template v-slot:body>
                <form name="addStaff">
                    <div class="form-inline">
                        <label class="control-label"><strong>發送形式 &nbsp;&nbsp;</strong></label>
                        <div class="radio">
                            <label>
                                <input name="now_send" type="radio" value="1" v-model="add_message.now_send">
                                立即執行
                            </label>
                        </div>
                        &nbsp;
                        <div class="radio">
                            <label>
                                <input name="now_send" type="radio" value="0" v-model="add_message.now_send">
                                設定時間
                            </label>
                        </div>
                    </div>
                    <div class="form-group" v-show="add_message.now_send === '0'">
                        <Datetimepicker target="es_time" :value="add_message.es_time" @onChangeValue="onChangeValue"/>
                    </div>
                    <div class="form-group">
                        <strong>頻道</strong>
                        <select class="form-control" v-model="add_message.channel_id">
                            <option v-for="channel in channel_list" v-bind:value="channel.id">{{ channel.name
                                }} ({{ channel.id }})
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <strong>顯示名稱</strong>
                        <input type="text" name="name" v-model="add_message.display_name"
                               class="form-control" placeholder="Name" required>
                    </div>
                    <div class="form-group">
                        <strong>內容</strong>
                        <textarea class="form-control" v-model="add_message.content" required rows="10"></textarea>
                    </div>
                </form>
            </template>
            <template v-slot:footer>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button v-if="action === 'add'" type="button" class="btn btn-primary" @click="addMessage">新增
                </button>
                <button v-if="action === 'edit'" type="button" class="btn btn-primary" @click="editMessage">儲存
                </button>
            </template>
        </Modal>

    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        data: function () {
            return {
                add_message: {
                    id: '',
                    now_send: 1,
                    es_time: '',
                    channel_id: 0,
                    display_name: '',
                    content: '',
                    user_id: 0
                },
                action: '',
                page_info: [],
                list: [],
                channel_list: [],
                getAllMessageInterval: null
            }
        },
        methods: {
            onChangePage(page) {
                this.page_info.current_page = page;
                this.getAllMessage();
            },
            onChangeValue(value) {
                this.add_message.es_time = value;
            },
            getAllMessage() {
                let self = this;
                axios.get(
                    '/api/telegram-message?search=' + self.page_info.search + '&orderby_field=' + self.page_info.sort_key + '&orderby_method=' + self.page_info.sort_dir + '&limit=' + self.page_info.limit + '&page=' + self.page_info.current_page
                ).then(response => {
                    let res = response.data.data;
                    self.list = res.data;
                    self.page_info.current_page = res.current_page;
                    self.page_info.last_page = res.last_page;
                    self.page_info.total = res.total;
                    self.page_info.list_from = res.from;
                    self.page_info.list_to = res.to;
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
                this.initMessage();
                $('#addMessage').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                this.action = 'add';
            },
            addMessage() {
                let self = this;
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
            openEditMessage(id) {
                let self = this;
                axios.get(
                    '/api/telegram-message/' + id
                ).then(response => {
                    response.data.data.now_send = '0';
                    self.add_message = response.data.data;
                    self.action = 'edit';
                    $('#addMessage').modal('show');
                }).catch(error => {
                    console.log(error);
                });
            },
            editMessage() {
                let self = this;
                self.add_message.es_time = $("#es_time input").val();
                axios.put(
                    '/api/telegram-message/' + self.add_message.id, self.add_message
                ).then(response => {
                    $('#addMessage').modal('hide');
                    self.getAllMessage();
                    helper.alert(response.data.message);
                }).catch(error => {
                    console.log(error.response);
                    helper.alert(error.response.data.message, 'danger');
                });
            },
            deleteMessage(id) {
                let self = this;
                helper.deleteConfirm(function () {
                    axios.delete(
                        '/api/telegram-message/' + id
                    ).then(response => {
                        helper.alert(response.data.message);
                        self.getAllMessage();
                    }).catch(error => {
                        console.log(error);
                        helper.alert(error.response.data.message, 'danger');
                    });
                });
            },
            nowSendMessage(id) {
                axios.post(
                    '/api/telegram-message/send-now/' + id
                ).then(response => {
                    helper.alert(response.data.message);
                }).catch(error => {
                    console.log(error.response);
                    helper.alert(error.response.data.message, 'danger');
                });
            },
            initMessage() {
                this.add_message = {
                    id: '',
                    now_send: 1,
                    es_time: "",
                    channel_id: (this.channel_list.length > 0) ? this.channel_list[0].id : 0,
                    display_name: '',
                    content: '',
                    user_id: 0
                };
            }
        },
        mounted() {
            this.page_info = {
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
            this.getAllMessage();
            this.getAllChannel();
            this.initMessage();

            let self = this;
            this.getAllMessageInterval = setInterval(function () {
                self.getAllMessage();
            }, 1000 * 10);
        }
    }
</script>
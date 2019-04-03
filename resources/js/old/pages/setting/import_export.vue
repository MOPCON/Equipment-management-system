<template>
    <div>
        <section class="content-header">
            <h1>
                匯入匯出
                <small>Import & Export</small>
            </h1>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="box">
                    <div class="box-body">
                        <div class="dataTables_wrapper dt-bootstrap">
                            <form class="form-horizontal">
                                <div class="form-group">
                                    <label  class="col-sm-2 col-md-1">
                                        操作項目：
                                    </label>
                                    <div class="col-sm-6 col-md-4">
                                        <div v-for="item in models" class="radio col-sm-6 col-lg-4">
                                            <label>
                                                <input type="radio" v-bind:value="item.id" v-model="select_model" checked>
                                                {{  item.text  }} ({{ item.id }})
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label  class="col-sm-2 col-md-1">
                                        匯出類型：
                                    </label>
                                    <div class="col-sm-6 col-md-4">
                                        <div v-for="item in types" class="radio col-sm-2 col-md-1">
                                            <label>
                                                <input type="radio" v-bind:value="item" v-model="select_type" checked>
                                                {{ item }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="row">
                                <div class="col-xs-4 col-sm-4 col-md-2">
                                    <button class="btn btn-block btn-primary" v-on:click="exportData()">
                                        匯出
                                    </button>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-2">
                                    <button class="btn btn-block btn-success" v-on:click="openFileSelect">
                                        匯入
                                    </button>
                                    <input type="file" style="display:none" id="importFile" v-on:change="importData()">
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-2">
                                    <button class="btn btn-block btn-warning" v-on:click="downloadTemplate">
                                        下載樣版
                                    </button>
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
                models: [{id: 'staff', text: '工人名單'}, {id: 'equipment', text: '器材名單'}],
                types: ['xls', 'xlsx', 'csv'],
                select_model: 'staff',
                select_type: 'xls',
            }
        },
        computed: {},
        methods: {
            openFileSelect() {
                $('#importFile').click()
            },
            importData() {
                const formData = new FormData();
                const importFile = document.querySelector('#importFile');
                console.log(importFile.files[0]);
                formData.append("upload", importFile.files[0]);
                axios.post('/api/import/' + this.select_model, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(response => {
                    $("#importFile").val('');
                    console.log(response)
                    helper.alert(response.data.message)
                }).catch(error => {
                    $("#importFile").val('');
                    console.log(error.response)
                    helper.alert(error.response.data.message, 'danger')
                })
            },
            exportData() {
                location.href = "/api/export/" + this.select_model + "/" + this.select_type;
            },
            downloadTemplate() {
                location.href = "/api/template/" + this.select_model + "/" + this.select_type;
            }
        },
        created: function () {

        },
        watch: {}
    }
</script>

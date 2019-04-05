<template>
    <div class="container-fluid">
        <h1>
            匯入匯出
            <small>Import & Export</small>
        </h1>
        <form class="form-horizontal">
            <div class="row form-group">
                <label class="col-sm-4 col-md-2">
                    操作項目：
                </label>
                <div class="form-inline col-sm-8 col-md-10">
                    <div v-for="item in models" class="radio">
                        <label class="mr-2">
                            <input type="radio" v-bind:value="item.id" v-model="select_model" checked>
                            {{  item.text  }} ({{ item.id }})
                        </label>
                    </div>
                </div>
            </div>
            <div class="row form-group">
                <label class="col-sm-4 col-md-2">
                    匯出類型：
                </label>
                <div class="form-inline col-sm-8 col-md-10">
                    <div v-for="item in types" class="radio">
                        <label class="mr-2">
                            <input type="radio" v-bind:value="item" v-model="select_type" checked>
                            {{ item }}
                        </label>
                    </div>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-4 col-sm-4 col-md-2">
                <button class="btn btn-block btn-primary" @click="exportData()">
                    匯出
                </button>
            </div>
            <div class="col-4 col-sm-4 col-md-2">
                <button class="btn btn-block btn-success" @click="openFileSelect">
                    匯入
                </button>
                <input type="file" style="display:none" id="importFile" @change="importData">
            </div>
            <div class="col-4 col-sm-4 col-md-2">
                <button class="btn btn-block btn-warning" @click="downloadTemplate">
                    下載樣版
                </button>
            </div>
        </div>
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
                formData.append("upload", importFile.files[0]);
                axios.post('/api/import/' + this.select_model, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(response => {
                    $("#importFile").val('');
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
        created() {

        },
        watch: {}
    }
</script>

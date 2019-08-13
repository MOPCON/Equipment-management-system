<template>
    <div class="container">
        <h1>更改密碼</h1>
        <p class="lead">
            自己的密碼自己更改！
        </p>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <Input type="password" label="舊密碼" name="oldPassword" v-validate="'required|min:8'"
                               :error="errors.first('oldPassword')"
                               v-model="oldPassword" />
                        <Input type="password" label="新密碼" name="newPassword" v-validate="'required|min:8'"
                               :error="errors.first('newPassword')"
                               v-model="newPassword" />
                        <Input type="password" label="新密碼確認" name="newPasswordConfirm"
                               v-validate="'required|min:8'" :error="errors.first('newPasswordConfirm')"
                               v-model="newPasswordConfirm"/>
                        <button class="btn btn-primary" @click="onSubmit">送出</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                newPassword: '',
                newPasswordConfirm: '',
                oldPassword: '',
            };
        },
        methods: {
            async onSubmit() {
                let success = await this.$validator.validateAll();
                if (success) {
                    axios.post('api/auth/change-password', {
                        old_password: this.oldPassword,
                        password: this.newPassword,
                        password_confirmation: this.newPasswordConfirm
                    })
                        .then(response => {
                            this.init();
                            helper.alert(response.data.message);
                        })
                        .catch(({ response }) => {
                            this.init();
                            helper.alert(response.data.message, 'danger');
                        });
                }
            },
            init() {
                this.newPasswordConfirm = '';
                this.newPassword = '';
                this.oldPassword = '';
                this.$validator.reset();
            }
        }
    };
</script>

<style scoped lang="scss">

</style>

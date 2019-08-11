<template>
    <div class="navbar navbar-dark navbar-custom">
        <a class="navbar-brand" href="#">EMS</a>

        <div class="form-inline">
            <a class="nav-link text-white mr-2">
                <div class="row no-gutters">
                    <div class="col mr-3">
                        <a class="text-white" href="https://github.com/puckwang/Equipment-management-system" target="_blank">
                            <font-awesome-icon :icon="['fab', 'github']" size="lg"/>
                        </a>
                    </div>
                    <div class="col">
                        <a onclick="toogleFullscreen()">
                            <font-awesome-icon icon="expand" size="lg" />
                        </a>
                    </div>
                </div>
            </a>

            <div class="nav-item">
                <div class="dropdown">
                    <a id="dropdownMenu" class="dropdown-toggle mr-1" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img :src="user.avatar" class="rounded-circle mr-1">
                        <span>{{ user.name }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu">
                        <a class="dropdown-item" href="#/auth/change-password">更改密碼</a>
                        <a class="dropdown-item" href="/logout">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapActions, mapState } from 'vuex'

    export default {
        data() {
            return {

            }
        },
        methods: {
            ...mapActions('auth', [
                'whoAmI'
            ])
        },
        computed: {
            ...mapState('auth', [
                'user'
            ])
        },
        watch: {

        },
        components: {

        },
        mounted() {
            this.whoAmI();
        }
    }
</script>

<style scoped lang="scss">
    @import '../../sass/variables';
    .navbar-custom {
        background-color: #4980b5;
        height: $navbar-height;
        position: fixed;
        z-index: 1000;
        width: 100%;
        img {
            width: 35px;
            height: 35px;
        }
    }
    .dropdown-toggle {
        color: #FFF;
        text-decoration: none;
    }
</style>

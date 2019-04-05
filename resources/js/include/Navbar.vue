<template>
    <div class="navbar navbar-dark navbar-custom">
        <a class="navbar-brand" href="#">EMS</a>
        <div class="dropdown">
            <a id="dropdownMenu" class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img :src="user.avatar" class="rounded-circle">
                <span>{{ user.name }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu">
                <a class="dropdown-item" href="/logout">Logout</a>
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
        img {
            width: 35px;
            height:35px;
        }
    }
    
    .dropdown-toggle {
        color: #FFF;
        text-decoration: none;
    }
</style>
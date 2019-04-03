<template>
    <div class="navbar navbar-dark navbar-custom">
        <a class="navbar-brand" href="#">EMS</a>
        <img :src="user.avatar" class="rounded-circle">
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
</style>
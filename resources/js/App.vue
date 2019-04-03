<template>
    <div class="h-100">
        <Navbar/>
        <Sidebar/>
        <div id="main" class="main">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    import Navbar from "./include/Navbar";
    import Sidebar from "./include/Sidebar";

    export default {
        data() {
            return {}
        },
        methods: {},
        computed: {},
        watch: {},
        components: {
            Navbar,
            Sidebar
        },
        mounted() {

        }
    }
</script>

<style scoped lang="scss">
    @import '../sass/variables';
    .main {
        width: $main-width;
        margin-left: $sidebar-width;
        margin-top: 15px;
    }

    .main-extend {
        width: $main-extend-width;
        margin-left: $sidebar-extend-width;
    }
</style>
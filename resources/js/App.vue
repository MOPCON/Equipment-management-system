<template>
    <div class="wrapper h-100">
        <Navbar/>
        <Sidebar/>
        <div id="main" class="main container-fluid">
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
        min-height: $sidebar-height;
        height: auto;
        margin-left: $sidebar-width;
        margin-top: $main-margin-top;
        transition: 0.3s;
    }

    .main-extend {
        width: $main-extend-width;
        margin-left: $sidebar-extend-width;
        transition: 0.3s;
    }

    .wrapper {
        height: 100%;
        position: relative;
        overflow-x: hidden;
        overflow-y: hidden;
    }
</style>
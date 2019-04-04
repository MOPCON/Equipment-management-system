<template>
    <div id="sidebar" class="sidebar">
        <div class="sidebar-menu">
            <ul>
                <li class="menu" @click="changeSidebarExtend">
                    <font-awesome-icon class="icon" icon="bars"/>
                    <span class="sidebar-menu-text"> Menu </span>
                </li>
                <li class="menu" @click="changeRouterPage('/staffs')">
                    <font-awesome-icon class="icon" icon="user"/>
                    <span class="sidebar-menu-text"> 工人管理 </span>
                </li>
                <li class="menu" @click="changeRouterPage('/groups')">
                    <font-awesome-icon class="icon" icon="users"/>
                    <span class="sidebar-menu-text"> 群組管理 </span>
                </li>
                <li class="menu" @click="changeRouterPage('/equipments')">
                    <font-awesome-icon class="icon" icon="hdd"/>
                    <span class="sidebar-menu-text"> 器材管理 </span>
                </li>
                <li class="menu" @click="changeRouterPage('/equipments/barcode')">
                    <font-awesome-icon class="icon" icon="barcode"/>
                    <span class="sidebar-menu-text"> 器材條碼管理 </span>
                </li>
                <li class="menu" @click="changeRouterPage('/equipments/raise')">
                    <font-awesome-icon class="icon" icon="suitcase"/>
                    <span class="sidebar-menu-text"> 募集物資管理 </span>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                sidebarExtend: false
            }
        },
        methods: {
            changeSidebarExtend () {
                let self = this
                if (self.sidebarExtend) {
                    // 移除展開 Menu
                    self.sidebarExtend = false
                    $('#sidebar').removeClass('sidebar-extend');
                    $('#main').removeClass('main-extend');
                } else {
                    // 展開 Menu
                    self.sidebarExtend = true
                    $('#sidebar').addClass('sidebar-extend');
                    $('#main').addClass('main-extend');
                }
            },
            changeRouterPage (router_name) {
                this.$router.push(router_name);
            }
        },
        computed: {},
        watch: {},
        components: {},
        mounted () {

        }
    }
</script>

<style scoped lang="scss">
    @import '../../sass/variables';

    .sidebar {
        width: $sidebar-width;
        min-height: 100%;
        background: black;
        font-size: 18px;
        line-height: 18px;
        position: absolute;
        z-index: 1000;
        transition: transform .3s ease-in-out, width .3s ease-in-out;

        .sidebar-menu {
            width: 100%;

            ul, li {
                border: 0;
                margin: 0;
                padding: 0;
                text-decoration: none;
                color: #999999;

                li {
                    padding: 15px 0px;

                    .icon {
                        width: $sidebar-width;
                        text-align: center;
                        float: left;
                    }

                    .sidebar-menu-text {
                        width: calc(#{$sidebar-extend-width} - #{$sidebar-width});
                        text-align: left;
                        display: none;
                        position: absolute;
                    }

                    &:hover, &:hover a {
                        width: $sidebar-extend-width;
                        background: #666666;
                        color: #FFFFFF;
                        cursor: pointer;

                        @extend %sidebar-hover;
                    }

                    a {
                        color: #999999;
                        text-decoration: none;
                        display: block;
                    }
                }
            }
        }
    }

    .sidebar-extend {
        width: $sidebar-extend-width;

        .sidebar-menu li {
            @extend %sidebar-hover;
        }
    }

    %sidebar-hover {
        .icon {
            width: $sidebar-width;
        }

        .sidebar-menu-text {
            width: calc(#{$sidebar-extend-width} - #{$sidebar-width});
            display: inline !important;
            //opacity:1;
        }
    }
</style>
<template>
    <sidebar-menu id="sidebar" :menu="menu" width="200px" :collapsed="true" @collapse="changeSidebarExtend" />
</template>

<script>
    import { SidebarMenu } from 'vue-sidebar-menu'
    import 'vue-sidebar-menu/dist/vue-sidebar-menu.css'

    export default {
        data() {
            return {
                sidebarExtend: false,
                menu: [
                    {
                        title: '工人管理',
                        icon: 'fas fa-user',
                        child: [
                            {
                                href: '/staffs',
                                title: '工人資料管理',
                                icon: 'fas fa-user'
                            }, {
                                href: '/groups',
                                title: '群組管理',
                                icon: 'fas fa-users'
                            }
                        ]
                    }, {
                        title: '器材管理',
                        icon: 'fas fa-hdd',
                        child: [
                            {
                                href: '/equipments',
                                title: '器材管理',
                                icon: 'fas fa-hdd'
                            }, {
                                href: '/equipments/barcode',
                                title: '器材條碼管理',
                                icon: 'fas fa-barcode'
                            }, {
                                href: '/equipments/raise',
                                title: '募集物資管理',
                                icon: 'fas fa-suitcase'
                            }
                        ]
                    }, {
                        title: '借還系統',
                        icon: 'fas fa-exchange-alt',
                        child: [
                            {
                                href: '/loan/action',
                                title: '借還系統',
                                icon: 'fas fa-exchange-alt'
                            }, {
                                href: '/loan',
                                title: '批量管理',
                                icon: 'fas fa-tasks'
                            }
                        ]
                    }, {
                        title: 'Telegram Bot',
                        icon: 'fab fa-telegram',
                        child: [
                            {
                                href: '/telegram-message',
                                title: '訊息發送',
                                icon: 'fas fa-comment'
                            }, {
                                href: '/telegram-channel',
                                title: '頻道管理',
                                icon: 'fas fa-users'
                            }
                        ]
                    }, {
                        title: '學生驗票',
                        icon: 'fas fa-id-card',
                        href: '/student-verify'
                    }, {
                        title: '使用者管理',
                        icon: 'fas fa-users-cog',
                        child: [
                            {
                                href: '/user',
                                title: '使用者管理',
                                icon: 'fas fa-user-secret'
                            }, {
                                href: '/user/role',
                                title: '角色管理',
                                icon: 'fas fa-id-badge'
                            }
                        ]
                    }, {
                        title: '設定',
                        icon: 'fas fa-cogs',
                        child: [
                            {
                                href: '/tool/print',
                                title: '條碼列印',
                                icon: 'fas fa-barcode'
                            }, {
                                href: '/tool/imexport',
                                title: '匯入匯出',
                                icon: 'fas fa-exchange-alt'
                            }
                        ]
                    }, {
                      title: 'System log',
                      icon: 'far fa-clock',
                      href: '/logs'
                    }
                ]
            };
        },
        methods: {
            changeSidebarExtend() {
                let self = this;
                if (self.sidebarExtend) {
                    // 移除展開 Menu
                    self.sidebarExtend = false;
                    $('#main').removeClass('main-extend');
                } else {
                    // 展開 Menu
                    self.sidebarExtend = true;
                    $('#main').addClass('main-extend');
                }
            }
        },
        computed: {},
        watch: {},
        components: {
            SidebarMenu
        },
        mounted() {

        }
    };
</script>

<style scoped lang="scss">
    @import '../../sass/variables';
    #sidebar {
        margin-top: $navbar-height;
        height: $sidebar-height;
    }
</style>
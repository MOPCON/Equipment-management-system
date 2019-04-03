import Vue from 'vue'
import VueRouter from 'vue-router'
import Index from './pages/Index'

Vue.use(VueRouter)

const router = new VueRouter({
    base: '/',
    routes: [
        {
            path: '/',
            component: Index,
        },
        // {
        //     path: '/staffs',
        //     component: require('../components/pages/staffs/staff.vue'),
        // }, {
        //     path: '/groups',
        //     component: require('../components/pages/staffs/group.vue'),
        // }, {
        //     path: '/equipments',
        //     component: require('../components/pages/equipments/equipment.vue'),
        // }, {
        //     path: '/equipments/barcode',
        //     component: require('../components/pages/equipments/equbarcode.vue'),
        // }, {
        //     path: '/equipments/raise',
        //     component: require('../components/pages/equipments/raise.vue'),
        // }, {
        //     path: '/loan',
        //     component: require('../components/pages/loan/loan.vue'),
        // }, {
        //     path: '/loan/action',
        //     component: require('../components/pages/loan/action.vue'),
        // }, {
        //     path: '/user',
        //     component: require('../components/pages/setting/user.vue'),
        // }, {
        //     path: '/tool/print',
        //     component: require('../components/pages/setting/tool.print.vue'),
        // }, {
        //     path: '/tool/imexport',
        //     component: require('../components/pages/setting/import_export.vue'),
        // }, {
        //     path: '/student-verify',
        //     component: require('../components/pages/verify/student_verify'),
        // }, {
        //     path: '/telegram-message',
        //     component: require('../components/pages/telegram_bot/index.vue'),
        // }, {
        //     path: '/telegram-channel',
        //     component: require('../components/pages/telegram_bot/channel.vue'),
        // },
        {
            path: '/*',
            redirect: '/'
        }
    ]
})

export default router
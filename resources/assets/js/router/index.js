import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)
export default new Router({
    routes: [
        {
            path: '/',
            component: require('../components/pages/home.vue'),
        }, {
            path: '/staffs',
            component: require('../components/pages/staffs/staff.vue'),
        }, {
            path: '/groups',
            component: require('../components/pages/staffs/group.vue'),
        }, {
            path: '/equipments',
            component: require('../components/pages/equipments/equipment.vue'),
        }, {
            path: '/equipments/barcode',
            component: require('../components/pages/equipments/equbarcode.vue'),
        }, {
            path: '/loan',
            component: require('../components/pages/loan/loan.vue'),
        }, {
            path: '/loan/action',
            component: require('../components/pages/loan/action.vue'),
        },{
            path: '/user',
            component: require('../components/pages/setting/user.vue'),
        }, {
            path: '/tool/print',
            component: require('../components/pages/setting/tool.print.vue'),
        }, {
            path: '/*',
            redirect: '/'
        }
    ],
})

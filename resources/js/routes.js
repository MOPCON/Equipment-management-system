import Vue from 'vue';
import VueRouter from 'vue-router';
import Index from './pages/Index';
import staff from './pages/staffs/staff';
import group from './pages/staffs/group';
import equipment from "./pages/equipments/equipment";
import equbarcode from "./pages/equipments/equbarcode";
import raise from "./pages/equipments/raise";
import telegram_message from './pages/telegram_bot/index';
import telegram_channel from './pages/telegram_bot/channel';
import student_verify from './pages/verify/student_verify';
import user from './pages/users/user';
import user_role from './pages/users/role';
import setting_print from './pages/setting/tool.print';
import setting_imexport from './pages/setting/import_export.vue';
import loan from "./pages/loan/loan";
import action from "./pages/loan/action";
import logs from "./pages/logs";
import formSpeaker from "./pages/form/Speaker";
import page_403 from "./pages/error/403";
import sponsor_upload from "./pages/sponsor/sponsor_upload";

Vue.use(VueRouter);

const router = new VueRouter({
    base: '/',
    routes: [
        {
            path: '/',
            component: Index,
        }, {
            path: '/staffs',
            component: staff,
        }, {
            path: '/groups',
            component: group,
        }, {
            path: '/equipments',
            component: equipment,
        }, {
            path: '/equipments/barcode',
            component: equbarcode,
        }, {
            path: '/equipments/raise',
            component: raise,
        }, {
            path: '/loan',
            component: loan,
        }, {
            path: '/loan/action',
            component: action,
        }, {
            path: '/user',
            component: user,
        }, {
            path: '/user/role',
            component: user_role,
        }, {
            path: '/tool/print',
            component: setting_print,
        }, {
            path: '/tool/imexport',
            component: setting_imexport,
        }, {
            path: '/student-verify',
            component: student_verify,
        }, {
            path: '/telegram-message',
            component: telegram_message,
        }, {
            path: '/telegram-channel',
            component: telegram_channel,
        }, {
            path: '/logs',
            component: logs,
        }, {
            path: '/form/speaker',
            component: formSpeaker,
        }, {
            path: '/403',
            component: page_403,
        },
        {
            path: '/sponsor/upload',
            component: sponsor_upload,
        },
        {
            path: '/*',
            redirect: '/'
        }
    ]
});

export default router;
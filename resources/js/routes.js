import Vue from 'vue';
import VueRouter from 'vue-router';
import Index from './pages/Index';
import staff from './pages/staffs/staff';
import group from './pages/staffs/group';
import equipment from "./pages/equipments/equipment";
import equbarcode from "./pages/equipments/equbarcode";
import raise from "./pages/equipments/raise";
import bot_message from './pages/bot/Messages';
import bot_channel from './pages/bot/Channels';
import student_verify from './pages/verify/student_verify';
import user from './pages/users/user';
import user_role from './pages/users/role';
import setting_print from './pages/setting/tool.print';
import setting_imexport from './pages/setting/import_export.vue';
import loan from "./pages/loan/loan";
import action from "./pages/loan/action";
import logs from "./pages/logs";
import formSpeaker from "./pages/form/Speaker";
import speaker from "./pages/speakers/speaker";
import page_403 from "./pages/error/403";
import sponsor from "./pages/sponsor/sponsor";
import ChangePassword from './pages/auth/ChangePassword';

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
            path: '/bot-message',
            component: bot_message,
        }, {
            path: '/bot-channel',
            component: bot_channel,
        }, {
            path: '/logs',
            component: logs,
        }, {
            path: '/form/speaker',
            component: formSpeaker,
        },{
            path: '/speaker/speaker',
            component: speaker,
        }, {
            path: '/403',
            component: page_403,
        },
        {
            path: '/sponsor/sponsor',
            component: sponsor,
        },
        {
            path: '/auth/change-password',
            component: ChangePassword
        },
        {
            path: '/*',
            redirect: '/'
        }
    ]
});

export default router;

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('staff', require('./components/staff.vue'));
Vue.component('group', require('./components/group.vue'));
Vue.component('equipment', require('./components/equipment.vue'));
Vue.component('equbarcode', require('./components/equbarcode.vue'));
Vue.component('loan', require('./components/loan.vue'));
Vue.component('lend', require('./components/loan.lend.vue'));

const app = new Vue({
    el: '#app'
});

import bootstrap from "./bootstrap";
import Vue from 'vue';
import router from './routes';
import store from './store';
import App from './App.vue'
import { library } from '@fortawesome/fontawesome-svg-core'
import { fas } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(fas);
Vue.component('font-awesome-icon', FontAwesomeIcon);

// Include All Components
const files = require.context('./components', true, /\.vue$/i);
files.keys().forEach(key => {
    Vue.component(key.split('/').pop().split('.')[0], files(key).default);
});

const vue = new Vue({
    el: '#app',
    render: h => h(App),
    router,
    store,
});


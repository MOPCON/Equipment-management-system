import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

// Include All Store
const files = require.context('./stores', true, /\.js$/i);
let modules = {};
files.keys().forEach(key => {
    modules[key.split('/').pop().split('.')[0]] = files(key).default;
});

const isDebug = process.env.NODE_ENV !== 'production';

const store = new Vuex.Store({
    modules: modules,
    strict: isDebug
});

export default store

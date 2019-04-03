import Vue from 'vue'
import Vuex from 'vuex'
import auth from './stores/auth'

Vue.use(Vuex);

const isDebug = process.env.NODE_ENV !== 'production';

const store = new Vuex.Store({
    modules: {
        auth: auth,
    },
    strict: isDebug
});

export default store
import axios from 'axios';

const state = {
    user: {
        id: 0,
        name: '',
        email: '',
        avatar: '',
    },
    requiredPermission: []
};
const actions = {
    whoAmI: (context) => {
        axios.get('/api/whoami').then(response => {
            context.commit('setUser', response.data);
        });
    },
    pushRequiredPermissions: (context, payload) => {
        context.commit('pushRequiredPermissions', payload);
    },
    clearRequiredPermission: (context) => {
        context.commit('clearRequiredPermission');
    }
};
const mutations = {
    setUser: (state, payload) => {
        state.user = payload;
    },
    pushRequiredPermissions: (state, payload) => {
        state.requiredPermission.push(...payload);
    },
    clearRequiredPermission: (state) => {
        state.requiredPermission = [];
    }
};
const getters = {};

export default {
    namespaced: true,
    state,
    actions,
    getters,
    mutations
};

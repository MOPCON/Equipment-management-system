import axios from 'axios'

const state = {
    user: {
        id: 0,
        name: '',
        email: '',
        avatar: '',
    },
}
const actions = {
    whoAmI: (context, payload) => {
        axios.get('/api/whoami').then(response => {
            context.commit("setUser", response.data);
        })
    }
}
const mutations = {
    setUser: (state, payload) => {
        state.user = payload;
    }
}
const getters = {}

export default {
    namespaced: true,
    state,
    actions,
    getters,
    mutations
}
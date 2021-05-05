import axios from 'axios';
import router from '../router'
import i18n from '../i18n'

const state = {
    registered: false,
    error: null,
    loading: false,
}

const getters = {

}

const actions = {
    register({dispatch, commit}, payload){
        commit('registerRequest', payload.email)
        return axios.post('/register', payload)
            .then( ({data}) => {
                commit('registerSuccess', data)
                dispatch('alert/success', i18n.t('success.create'), { root: true });
                return data
            })
            .catch( error => {
                commit('registerFailure', error);
                dispatch('alert/error', error, { root: true });
            })
    }
};

const mutations = {
    registerRequest(state) {
        state.loading = true
    },
    registerSuccess(state) {
        state.loading = false
        state.registered = true
    },
    registerFailure(state, error) {
        state.loading = false;
        state.error = error;
    }
};

const registerService = {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}

export default registerService;

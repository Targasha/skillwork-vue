import axios from 'axios';
import i18n from '../i18n';
import router from "../router";

const state = {
    items: [],
    item: {},
    error: null,
    loading: false
};

const getters = {

}

const actions = {
    obtainArticles({ commit, dispatch }) {
        commit('obtainArticlesRequest');
        return axios.get('/articles')
            .then(({ data }) => {
                commit('obtainArticlesSuccess', data)
                return data
            })
            .catch(error => {
                commit('obtainArticlesFailure', error);
                dispatch('alert/error', error, { root: true });
            });
    },

    createArticle({commit, dispatch}, item) {
        commit('createArticleRequest');
        return axios.post('/articles', item)
            .then(({ data }) => {
                commit('createArticleSuccess', data);
                dispatch('alert/success', i18n.t('success.create'), { root: true });
                router.push({ name: 'ListArticles'})
            })
            .catch(error => {
                commit('createArticleFailure', error);
                dispatch('alert/error', error, { root: true });
            });
    },

    obtainArticle({ commit, dispatch }, id) {
        commit('obtainArticleRequest');
        return axios.get(`/articles/${id}`)
            .then(({ data }) => {
                commit('obtainArticleSuccess', data);
            })
            .catch(error => {
                commit('obtainArticleFailure', error);
                dispatch('alert/error', error, { root: true });
            });
    },

    updateArticle({ commit, dispatch }, item) {
        commit('updateArticleRequest', item);
        return axios.put(`/articles/${item.id}`, item)
            .then(({ data }) => {
                commit('updateArticleSuccess', data);
                dispatch('alert/success', i18n.t('success.update'), { root: true });
            })
            .catch(error => {
                commit('updateArticleFailure', error);
                dispatch('alert/error', error, { root: true });
            });
    },

    deleteArticle({ commit, dispatch }, id) {
        commit('deleteArticleRequest');
        return axios.delete(`/articles/${id}`)
            .then(() => {
                commit('deleteArticleSuccess', id);
                dispatch('alert/success', i18n.t('success.delete'), { root: true });
            })
            .catch(error => {
                commit('deleteArticleFailure');
                dispatch('alert/error', error, { root: true });
            });
    }

}

const mutations = {
    obtainArticlesRequest(state) {
        state.loading = true;
    },
    obtainArticlesSuccess(state, items) {
        state.loading = false;
        state.items = items;
    },
    obtainArticlesFailure(state, error) {
        state.loading = false;
        state.error = error ;
    },
    createArticleRequest(state) {
        state.loading = true;
    },
    createArticleSuccess(state, item) {
        state.loading = false;
        state.item = item;
    },
    createArticleFailure(state, error) {
        state.loading = false;
        state.item = {};
        state.error = error;
    },
    obtainArticleRequest(state) {
        state.loading = true;
    },
    obtainArticleSuccess(state, item) {
        state.loading = false;
        state.item = item;
    },
    obtainArticleFailure(state, error) {
        state.loading = false;
        state.item = {};
        state.error = error;
    },
    updateArticleRequest(state) {
        state.loading = true;
    },
    updateArticleSuccess(state, item) {
        state.loading = false;
        state.item = item;
    },
    updateArticleFailure(state, error) {
        state.loading = false;
        state.error = error;
    },
    deleteArticleRequest(state, id) {
        // add 'deleting:true' property to item being deleted
        state.items = state.items.map(item =>
            item.id === id
                ? { ...item, deleting: true }
                : item
        )
    },
    deleteArticleSuccess(state, id) {
        // remove deleted item from state
        state.items = state.items.filter(item => item.id !== id)
    },
    deleteArticleFailure(state, { id, error }) {
        // remove 'deleting:true' property and add 'deleteError:[error]' property to item
        state.items = state.items.map(item => {
            if (item.id === id) {
                // make copy of item without 'deleting:true' property
                const { deleting, ...itemCopy } = item;
                // return copy of item with 'deleteError:[error]' property
                return { ...itemCopy, deleteError: error };
            }

            return item;
        })
    }
}

const articleService = {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}

export default articleService

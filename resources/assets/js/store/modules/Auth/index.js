import Vue from 'vue';
import {CLIENT_ID, CLIENT_SECRET} from '../../../.env.js';
import {AUTH_LOGOUT, AUTH_SET_TOKEN, AUTH_SET_USER} from '../../types';

const state = {
    user: JSON.parse(localStorage.getItem('vuebook-user')),
    token: localStorage.getItem('vuebook-token'),
    authenticated: !!localStorage.getItem('vuebook-token')
};

const actions = {
    login({commit}, {username, password, onSuccess, onFailure}) {
        const data = {
            'grant_type': 'password',
            'client_id': CLIENT_ID,
            'client_secret': CLIENT_SECRET,
            'username': username,
            'password': password,
            'scope': ''
        };

        Vue.http.post('/oauth/token', data)
            .then(response => {
                commit(AUTH_SET_TOKEN, response.body.access_token);

                if (typeof onSuccess == 'function') {
                    onSuccess(response);
                }
            })
            .catch(response => {
                if (typeof onFailure == 'function') {
                    onFailure(response);
                }
            });
    },

    fetchUser({commit}) {
        Vue.http.get('/api/user').then(response => {
            commit(AUTH_SET_USER, response.data);
        }).catch(response => {

        });
    },

    logout({commit}) {
        commit(AUTH_LOGOUT);
    },

    register({commit}, {data, onSuccess, onFailure}) {
        Vue.http.post('register', data)
            .then(response => {
                commit(AUTH_SET_TOKEN, response.body.access_token);
                commit(AUTH_SET_USER, response.body.user);

                if (typeof onSuccess == 'function') {
                    onSuccess(response);
                }
            })
            .catch(response => {
                if (typeof onFailure == 'function') {
                    onFailure(response);
                }
            });
    }
};

const getters = {
    check(state) {
        return state.authenticated;
    },

    guest(state, getters) {
        return !getters.check;
    },

    getToken(state) {
        return state.token;
    },

    getUser(state) {
        return state.user;
    }
};

const mutations = {
    [AUTH_SET_TOKEN](state, token) {
        state.token = token;
        state.authenticated = true;

        localStorage.setItem('vuebook-token', token);
        Vue.http.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('vuebook-token');
    },

    [AUTH_SET_USER](state, user) {
        state.user = user;

        localStorage.setItem('vuebook-user', JSON.stringify(user));
    },

    [AUTH_LOGOUT](state) {
        state.authenticated = false;
        state.user = null;
        state.token = null;

        localStorage.removeItem('vuebook-token');
        localStorage.removeItem('vuebook-user');
    }
};

export default {
    state,
    getters,
    mutations,
    actions
};
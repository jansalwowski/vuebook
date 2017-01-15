import Vue from 'vue';
import {CLIENT_ID, CLIENT_SECRET} from '../../../.env.js';
import {
    AUTH_LOGOUT, AUTH_SET_TOKEN, AUTH_SET_USER, AUTH_USER_SET_AVATAR, AUTH_USER_SET_COVER_PHOTO,
    PROFILE_SET_COVER_PHOTO, PROFILE_SET_AVATAR
} from '../../types';

const state = {
    user: JSON.parse(localStorage.getItem('vuebook-user')),
    token: localStorage.getItem('vuebook-token'),
    authenticated: !!localStorage.getItem('vuebook-token')
};

const mutations = {
    [AUTH_SET_TOKEN](state, token) {
        state.token = token;
        state.authenticated = true;

        localStorage.setItem('vuebook-token', token);
        Vue.http.headers.common['Authorization'] = 'Bearer ' + token;
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
    },

    [AUTH_USER_SET_AVATAR] (state, avatar) {
        state.user.avatar = avatar;
    },

    [AUTH_USER_SET_COVER_PHOTO] (state, cover) {
        state.user.cover = cover;
    }
};

const actions = {
    login({dispatch, commit}, {username, password, onSuccess, onFailure}) {
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
                dispatch('fetchUser');

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
    },

    changeAvatar({commit, rootGetters}, data) {
        return new Promise((resolve, reject) => {

            Vue.http.post('avatars', data)
                .then(response => {
                    let avatar = response.body.avatar;
                    commit(AUTH_USER_SET_AVATAR, avatar);

                    if (rootGetters.isOwnProfile) {
                        commit(PROFILE_SET_AVATAR, avatar);
                    }

                    resolve(response.body);
                })
                .catch(response => {
                    reject(response.body);
                });
        });
    },

    changeCoverPhoto({commit, rootGetters}, data) {

        return new Promise((resolve, reject) => {
            Vue.http.post('covers', data)
                .then(response => {
                    let cover = response.body.cover;
                    commit(AUTH_USER_SET_COVER_PHOTO, cover);

                    if (rootGetters.isOwnProfile) {
                        commit(PROFILE_SET_COVER_PHOTO, cover);
                    }

                    resolve(response.body);
                })
                .catch(response => {
                    reject(response.body);
                });
        });
    },

    changePassword({commit}, data) {
        return new Promise((resolve, reject) => {
            Vue.http.patch('password', data)
                .then((response) => {
                    if (response.body.hasOwnProperty('token')) {
                        commit(AUTH_SET_TOKEN, response.body.token);
                    }

                    resolve(response.body);
                })
                .catch((response) => {
                    reject(response.body);
                });
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

export default {
    state,
    getters,
    mutations,
    actions
};
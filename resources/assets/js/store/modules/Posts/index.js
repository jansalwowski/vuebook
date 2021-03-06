import Vue from 'vue';
import {POST_CREATE, POST_DELETE, POST_UPDATE, POSTS_FETCH, POSTS_CLEAR} from '../../types.js';
import {POST_LIKE, POST_UNLIKE, SET_AVATAR} from "../../types";

const state = {
    posts: []
};

const getters = {
    getPostToUpdate(state, getters, rootState) {
        let id = rootState.modals.posts.update.id;

        if (typeof id !== 'number') {
            return null;
        }

        return state.posts.filter((p) => p.id === id)[0];
    }
};

const mutations = {
    [POST_CREATE] (state, post) {
        state.posts.unshift(post);
    },

    [POSTS_FETCH] (state, posts) {
        state.posts = state.posts.concat(posts);
    },

    [POST_UPDATE] (state, post) {
        for (let i = 0; i < state.posts.length; i++) {
            if (state.posts[i].id === post.id) {
                state.posts[i].body = post.body;
                state.posts[i].was_edited = post.was_edited;
                break;
            }
        }
    },

    [POST_DELETE] (state, id) {
        for (let i = 0; i < state.posts.length; i++) {
            if (state.posts[i].id === id) {
                state.posts.splice(i, 1);
                break;
            }
        }

    },

    [POSTS_CLEAR] (state) {
        state.posts = [];
    },

    [POST_LIKE] (state, id) {
        let post = state.posts.find((p) => p.id === id);

        if (post) {
            post.wasLiked = true;
            post.likes_count++;
        }
    },

    [POST_UNLIKE] (state, id) {
        let post = state.posts.find((p) => p.id === id);

        if (post) {
            post.wasLiked = false;
            post.likes_count--;
        }
    },

    [SET_AVATAR] (state, {userId, avatar}) {
        for (let i = 0; i < state.posts.length; i++) {
            if (state.posts[i].user_id === userId) {
                state.posts[i].user.avatar = avatar;
            }
        }
    }
};

const actions = {
    createPost({commit}, {postData, onSuccess, onFailure}) {
        Vue.http.post('posts', postData)
            .then((response) => {
                commit(POST_CREATE, response.body.post);

                if (typeof onSuccess == 'function') {
                    onSuccess(response);
                }
            })
            .catch((response) => {
                if (typeof onFailure == 'function') {
                    onFailure(response);
                }
            });
    },

    getPosts({commit}, {username = null, lastId = null, onSuccess, onFailure}) {
        let url = username ? username + '/wall' : 'wall';

        Vue.http.get(url, {params: {lastId: lastId}})
            .then((response) => {
                let newPosts = response.body.posts;

                commit(POSTS_FETCH, newPosts);

                if (typeof onSuccess == 'function') {
                    onSuccess(response);
                }
            })
            .catch((response) => {
                if (typeof onFailure == 'function') {
                    onFailure(response);
                }
            });
    },

    updatePost({commit}, {id, postData, onSuccess, onFailure}) {
        Vue.http.patch('posts/' + id, postData)
            .then((response) => {
                commit(POST_UPDATE, response.body.post);

                if (typeof onSuccess == 'function') {
                    onSuccess(response);
                }
            })
            .catch((response) => {
                if (typeof onFailure == 'function') {
                    onFailure(response);
                }
            });
    },

    deletePost({commit}, {id, onSuccess, onFailure}) {
        Vue.http.delete('posts/' + id)
            .then((response) => {
                commit(POST_DELETE, id);

                if (typeof onSuccess == 'function') {
                    onSuccess(response);
                }
            })
            .catch((response) => {
                if (typeof onFailure == 'function') {
                    onFailure(response);
                }
            });
    },

    clearPosts({commit}) {
        commit(POSTS_CLEAR);
    },

    getPost({state}, id) {
        return state.posts.filter((p) => p.id === id);
    },

    likePost({commit}, {id}) {
        Vue.http.post('posts/' + id + '/likes')
            .then((response) => {
                commit(POST_LIKE, id);
            })
            .catch((response) => {

            });
    },

    unlikePost({commit}, {id}) {
        Vue.http.delete('posts/' + id + '/likes')
            .then((response) => {
                commit(POST_UNLIKE, id);
            })
            .catch((response) => {

            });
    }
};

export default {
    state,
    getters,
    mutations,
    actions
};
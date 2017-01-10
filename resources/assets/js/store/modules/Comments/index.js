import {
    COMMENT_CREATE,
    COMMENTS_FETCH,
    COMMENT_UPDATE,
    COMMENT_DELETE,
    COMMENT_LIKE,
    COMMENT_UNLIKE, COMMENTS_CLEAR
} from "../../types";
const state = {
    comments: []
};

const getters = {
    getCommentToUpdate(state, getters, rootState) {
        let id = rootState.modals.comments.update.id;

        if (typeof id !== 'number') {
            return null;
        }

        // return state.comments.filter((c) => c.id === id)[0];
        return state.comments.find((c) => c.id === id);
    }
};

const mutations = {
    [COMMENT_CREATE] (state, comment) {
        state.comments.push(comment);
    },

    [COMMENTS_FETCH] (state, comments) {
        if( Object.prototype.toString.call(comments) !== '[object Array]' ) {
            return;
        }

        comments = comments.filter((c) => {
            let t = state.comments.find(fc => fc.id === c.id);
            return typeof t === 'undefined';
        });

        if (comments.length) {
            state.comments = state.comments.concat(comments);
        }
    },

    [COMMENTS_CLEAR] (state) {
        state.comments = [];
    },

    [COMMENT_UPDATE] (state, comment) {
        for (let i = 0; i < state.comments.length; i++) {
            if (state.comments[i].id === comment.id) {
                state.comments[i].body = comment.body;
                state.comments[i].was_edited = comment.was_edited;
                break;
            }
        }
    },

    [COMMENT_DELETE] (state, id) {
        for (let i = 0; i < state.comments.length; i++) {
            if (state.comments[i].id === id) {
                state.comments.splice(i, 1);
                break;
            }
        }

    },

    [COMMENT_LIKE] (state, id) {
        let comment = state.comments.find((c) => c.id === id);

        if (comment) {
            comment.wasLiked = true;
            comment.likes_count++;
        }
    },

    [COMMENT_UNLIKE] (state, id) {
        let comment = state.comments.find((c) => c.id === id);

        if (comment) {
            comment.wasLiked = false;
            comment.likes_count--;
        }
    }
};

const actions = {
    createComment({commit}, {commentData, postId, onSuccess, onFailure}) {
        Vue.http.post('posts/' + postId + '/comments', commentData)
            .then((response) => {
                commit(COMMENT_CREATE, response.body.comment);

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

    getComments({commit}, {postId, lastId = null, limit = null, onSuccess, onFailure}) {

        Vue.http.get('posts/' + postId + '/comments', {params: {lastId, limit}})
            .then((response) => {
                let newComments = response.body.comments;

                commit(COMMENTS_FETCH, newComments);

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

    updateComment({commit}, {id, commentData, onSuccess, onFailure}) {
        Vue.http.patch('comments/' + id, commentData)
            .then((response) => {
                commit(COMMENT_UPDATE, response.body.comment);

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

    deleteComment({commit}, {id, onSuccess, onFailure}) {
        Vue.http.delete('comments/' + id)
            .then((response) => {
                commit(COMMENT_DELETE, id);

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

    likeComment({commit}, {id}) {
        Vue.http.post('comments/' + id + '/likes')
            .then((response) => {
                commit(COMMENT_LIKE, id);
            })
            .catch((response) => {

            });
    },

    unlikeComment({commit}, {id}) {
        Vue.http.delete('comments/' + id + '/likes')
            .then((response) => {
                commit(COMMENT_UNLIKE, id);
            })
            .catch((response) => {

            });
    },

    clearComments({commit}) {
        commit(COMMENTS_CLEAR);
    }

};

export default {
    state,
    getters,
    mutations,
    actions
}
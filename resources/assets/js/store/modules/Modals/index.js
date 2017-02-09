import {
    MODALS_POST_SHOW_DELETE,
    MODALS_POST_HIDE_DELETE,
    MODALS_POST_HIDE_UPDATE,
    MODALS_POST_SHOW_UPDATE,
    MODALS_COMMENT_SHOW_DELETE,
    MODALS_COMMENT_HIDE_DELETE,
    MODALS_COMMENT_HIDE_UPDATE,
    MODALS_COMMENT_SHOW_UPDATE
} from '../../types';

const state = {
    posts: {
        update: {
            id: null,
            show: false
        },
        delete: {
            id: null,
            show: false
        }
    },
    comments: {
        update: {
            id: null,
            show: false
        },
        delete: {
            id: null,
            show: false
        }
    }
};

const mutations = {
    [MODALS_POST_SHOW_DELETE] (state, postId) {
        state.posts.delete.id = postId;
        state.posts.delete.show = true;
    },

    [MODALS_POST_HIDE_DELETE] (state) {
        state.posts.delete.id = null;
        state.posts.delete.show = false;
    },

    [MODALS_POST_SHOW_UPDATE] (state, postId) {
        state.posts.update.id = postId;
        state.posts.update.show = true;
    },

    [MODALS_POST_HIDE_UPDATE] (state) {
        state.posts.update.id = null;
        state.posts.update.show = false;
    },


    [MODALS_COMMENT_SHOW_DELETE] (state, commentId) {
        state.comments.delete.id = commentId;
        state.comments.delete.show = true;
    },

    [MODALS_COMMENT_HIDE_DELETE] (state) {
        state.comments.delete.id = null;
        state.comments.delete.show = false;
    },

    [MODALS_COMMENT_SHOW_UPDATE] (state, commentId) {
        state.comments.update.id = commentId;
        state.comments.update.show = true;
    },

    [MODALS_COMMENT_HIDE_UPDATE] (state) {
        state.comments.update.id = null;
        state.comments.update.show = false;
    }
};

export default {
    state,
    mutations
};
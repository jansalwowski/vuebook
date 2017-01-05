import * as types from '../../types.js';
import {Toast} from "../../../Models/Toast";

export default {
    state: {
        toasts: []
    },

    mutations: {
        [types.ADD_TOAST] (state, toast) {
            state.toasts.unshift(toast);
        },

        [types.REMOVE_TOAST] (state, toast) {
            let index = state.toasts.indexOf(toast);

            if (index >= 0) {
                state.toasts.splice(index, 1);
            }
        }

    },

    actions: {
        addToast({commit}, {message, type, options}) {
            if (typeof options !== 'object') {
                options = {};
            }

            if (typeof type === 'string') {
                options.theme = type;
            }

            let toast = new Toast(message, options);

            commit(types.ADD_TOAST, toast);
        },

        removeToast({commit}, toast) {
            commit(types.REMOVE_TOAST, toast);
        },
    },

    getters: {
        getToastPosition(state, toast) {
            return state.toasts.indexOf(toast);
        }
    }
}
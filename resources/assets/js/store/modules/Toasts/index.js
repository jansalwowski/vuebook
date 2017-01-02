import * as types from '../../types.js';

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

            if (index > -1) {
                console.log(index);
                state.toasts.splice(index, 1)
                // delete state.toasts[index];
            }
        }

    },

    actions: {
        addToast({commit}, toast) {
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
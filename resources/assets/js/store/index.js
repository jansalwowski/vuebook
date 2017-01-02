import Vue from 'vue';
import Vuex from 'vuex';
import PostsModule from './modules/Posts';
import ToastsModule from './modules/Toasts';

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
    modules: {
        posts: PostsModule,
        toasts: ToastsModule
    },
    strict: debug
});
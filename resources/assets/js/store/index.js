import Vue from 'vue';
import Vuex from 'vuex';
import PostsModule from './modules/Posts';

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
    modules: {
        posts: PostsModule
    },
    strict: debug
});
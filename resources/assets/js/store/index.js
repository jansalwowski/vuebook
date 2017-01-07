import Vue from 'vue';
import Vuex from 'vuex';
import AuthModule from './modules/Auth';
import ModalsModule from './modules/Modals';
import PostsModule from './modules/Posts';
import CommentsModule from './modules/Comments';
import ToastsModule from './modules/Toasts';

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
    modules: {
        auth: AuthModule,
        modals: ModalsModule,
        posts: PostsModule,
        comments: CommentsModule,
        toasts: ToastsModule
    },
    strict: debug
});
import Vue from 'vue';
import Vuex from 'vuex';
import AuthModule from './modules/Auth';
import CommentsModule from './modules/Comments';
import FollowersModule from './modules/Followers';
import ModalsModule from './modules/Modals';
import PostsModule from './modules/Posts';
import ProfileModule from './modules/Profile';
import ToastsModule from './modules/Toasts';

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
    modules: {
        auth: AuthModule,
        comments: CommentsModule,
        followers: FollowersModule,
        modals: ModalsModule,
        posts: PostsModule,
        profile: ProfileModule,
        toasts: ToastsModule
    },
    strict: debug
});
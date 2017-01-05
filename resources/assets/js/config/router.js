import Vue from "vue";
import VueRouter from "vue-router";
import routes from "./routes";
import {AUTH_LOGOUT} from '../store/types';

Vue.use(VueRouter);

const router = new VueRouter({
    routes
});

router.beforeEach((to, from, next) => {
    let authenticated = router.app.$store.state.auth.authenticated;

    if (to.path == '/logout') {
        router.app.$store.commit(AUTH_LOGOUT);
        next('/welcome');
    }

    if (to.matched.some(record => record.meta.auth) && !authenticated) {
        next({
            path: '/welcome',
            query: {redirect: to.fullPath}
        });
    } else if (to.matched.some(record => record.meta.guest) && authenticated) {
        next({path: '/'});
    } else {
        next();
    }
});

export default router;
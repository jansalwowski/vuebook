import Vue from "vue";
import VueRouter from "vue-router";
import routes from "./routes";
import auth from "../ServiceProviders/auth";

Vue.use(VueRouter);

const router = new VueRouter({
    routes
});

router.beforeEach((to, from, next) => {
    if (to.path == '/logout') {
        auth.logout();
        next('/welcome');
    }

    if (to.matched.some(record => record.meta.auth) && auth.guest()) {
        next({
            path: '/welcome',
            query: {redirect: to.fullPath}
        });
    } else if (to.matched.some(record => record.meta.guest) && auth.check()) {
        next({path: '/'});
    } else {
        next();
    }
});

export default router;
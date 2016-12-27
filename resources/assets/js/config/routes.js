import HomePage from "../pages/Home.vue";
import MainWall from "../pages/MainWall.vue";
import UserPage from "../pages/User.vue";
import LoginPage from "../pages/Login.vue";

export default [
    {path: '/', name: 'main', component: MainWall, meta: {auth: true}},
    {path: '/welcome', name: 'home', component: HomePage},
    {path: '/login', component: LoginPage, meta: {guest: true}},
    {path: '/logout', meta: {auth: true}},
    {path: '/:slug', name: 'user', component: UserPage}
]
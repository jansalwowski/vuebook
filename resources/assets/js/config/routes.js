import HomePage from "../pages/Home.vue";
import MainWall from "../pages/MainWall.vue";
import UserPage from "../pages/User.vue";
import LoginPage from "../pages/Login.vue";
import SettingsPage from "../pages/Settings.vue";

export default [
    {path: '/', name: 'main', component: MainWall, meta: {auth: true}},
    {path: '/welcome', name: 'home', component: HomePage, meta:{guest: true}},
    {path: '/login', name: 'login', component: LoginPage, meta: {guest: true}},
    {path: '/logout', name: 'logout', meta: {auth: true}},
    {path: '/settings', name: 'settings',component: SettingsPage,meta: {auth: true}},
    {path: '/:username', name: 'user', component: UserPage}
]
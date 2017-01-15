import HomePage from "../pages/Home.vue";
import MainWall from "../pages/MainWall.vue";
import UserPage from "../pages/User.vue";
import FollowingPage from "../pages/Following.vue";
import FollowersPage from "../pages/Followers.vue";
import PhotosPage from "../pages/Photos.vue";
import LoginPage from "../pages/Login.vue";
import SettingsPage from "../pages/Settings.vue";

export default [
    {path: '/', name: 'main', component: MainWall, meta: {auth: true}},
    {path: '/welcome', name: 'home', component: HomePage, meta:{guest: true}},
    {path: '/login', name: 'login', component: LoginPage, meta: {guest: true}},
    {path: '/logout', name: 'logout', meta: {auth: true}},
    {path: '/settings', name: 'settings',component: SettingsPage,meta: {auth: true}},
    {path: '/:username/following', name: 'following', component: FollowingPage},
    {path: '/:username/followers', name: 'followers', component: FollowersPage},
    {path: '/:username/photos', name: 'photos', component: PhotosPage},
    {path: '/:username', name: 'user', component: UserPage}
]
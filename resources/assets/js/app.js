window.Vue = require('vue');
window._ = require('lodash');
window.$ = window.jQuery = require('jquery');
require('bootstrap-sass');

import Vue from 'vue';
import VueResource from 'vue-resource';
import store from './store';
import {sync} from 'vuex-router-sync';
import App from './components/App.vue';
import router from './config/router'

Vue.use(VueResource);

Vue.http.options.root = '/api';
Vue.http.options.credentials = true;
Vue.http.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('vuebook-token');
Vue.http.headers.common['Access-Control-Allow-Origin'] = '*';
Vue.http.headers.common['Content-Type'] = 'application/json';
Vue.http.interceptors.push((request, next) => {
    request.headers.set('X-CSRF-TOKEN', Laravel.csrfToken);

    next();
});
Vue.http.interceptors.push((request, next ) => {
    next((response) => {
        if( 'Content-Type' in response.headers && response.headers['Content-Type'] == 'application/json' ){
            if( typeof response.data != 'object' ){
                response.data = JSON.parse( response.data );
            }
        }

        if( 'content-type' in response.headers
            && response.headers['content-type'] == 'application/json' ){
            if( typeof response.data != 'object' ){
                response.data = JSON.parse( response.data );
            }
        }
    });
});

sync(store, router);

/* eslint-disable no-new */
const myApp = new Vue({
    store,
    router,
    render: h => h(App)
}).$mount('#app');

router.init(myApp);
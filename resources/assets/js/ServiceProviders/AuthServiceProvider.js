window.Vue = require('vue');
import {CLIENT_ID, CLIENT_SECRET} from '../.env';

export default class AuthServiceProvider {
    constructor() {
        this.user = JSON.parse(localStorage.getItem('vuebook-user'));
        this.token = localStorage.getItem('vuebook-token');
        this.authenticated = !!this.token;
    }

    check() {
        return this.authenticated;
    }

    guest() {
        return !this.check();
    }

    logout() {
        this.authenticated = false;
        this.user = null;
        this.token = null;

        localStorage.removeItem('vuebook-token');
        localStorage.removeItem('vuebook-user');
    }

    login($context, username, password, callback) {
        const data = {
            'grant_type': 'password',
            'client_id': CLIENT_ID,
            'client_secret': CLIENT_SECRET,
            'username': username,
            'password': password,
            'scope': ''
        };

        $context.$http.post('/oauth/token', data)
            .then(response => {
                this.setToken(response.body.access_token);

                if (callback) {
                    callback(true, null);
                }

                this.response = response.body;

                this.fetchUser($context);
            })
            .catch(response => {
                if (callback) {
                    callback(false, response.body);
                }

                this.reset();
            });

    }

    fetchUser($context) {
        $context.$http.get('/api/user').then(response => {
            this.setUser(response.data);
        }).catch(response => {
            this.reset();
        });
    }

    getUser() {
        return this.user;
    }

    setToken(token) {
        this.token = token;
        this.authenticated = true;

        localStorage.setItem('vuebook-token', token);
        Vue.http.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('vuebook-token');
    }

    setUser(user) {
        this.user = user;
        this.authenticated = true;

        localStorage.setItem('vuebook-user', JSON.stringify(user));
    }

    reset() {
        this.authenticated = false;
        this.user = null;
        this.token = null;

        localStorage.removeItem('vuebook-user');
        localStorage.removeItem('vuebook-token');
    }

    getToken() {
        return this.token;
    }
}
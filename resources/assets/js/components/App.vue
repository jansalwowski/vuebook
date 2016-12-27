<template>
    <div>
        <div :class="{'without-nav': auth.guest()}">
            <navbar v-if="auth.check()"></navbar>

            <div class="content">
                <router-view></router-view>
            </div>

            <app-footer></app-footer>
        </div>
    </div>
</template>

<style>
    .content {
        margin-top: 50px;
    }

    .without-nav .content {
        margin-top: 100px
    }
</style>

<script>
    import Navbar from './Navbar.vue';
    import AppFooter from './AppFooter.vue';
    import store from '../store';
    import auth from '../ServiceProviders/auth';

    export default {
        store,
        data() {
            return {
                auth
            };
        },
        components: {
            Navbar,
            AppFooter
        }
    }
</script>

<template>
    <div>
        <div :class="{'without-nav': auth.guest()}">
            <navbar v-if="auth.check()"></navbar>

            <button type="button" name="button" @click="showTime">SHOW TIME</button>
            <div class="content">
                <router-view></router-view>
            </div>

            <app-footer></app-footer>
        </div>

        <toast-manager ref="toast"></toast-manager>
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
    import ToastManager from './utils/ToastManager.vue'

    export default {
        store,
        data() {
            return {
                auth,

                maxToasts: 6,
                position: 'bottom right',
                theme: 'error',
                timeLife: 3000,
                closeBtn: false,
            };
        },

        attached() {
            this.resetOptions()
        },

        methods: {
            resetOptions() {
                this.$refs.toast.setOptions({
                    delayOfJumps: this.delayOfJumps,
                    maxToasts: this.maxToasts,
                    position: this.position
                })
            },

            showTime() {
                this.$refs.toast.showToast('Przykładowy toast', {
                    theme: this.theme,
                    timeLife: this.timeLife,
                    closeBtn: this.closeBtn
                })
            }
        },

        components: {
            Navbar,
            AppFooter,
            ToastManager
        }
    }
</script>

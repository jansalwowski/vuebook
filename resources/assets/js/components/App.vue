<template>
    <div>
        <div :class="{'without-nav': guest}">
            <navbar v-if="check"></navbar>

            <div class="content">
                <router-view></router-view>
            </div>

            <app-footer></app-footer>
        </div>

        <toast-manager ref="toast"></toast-manager>
        <post-delete-modal></post-delete-modal>
        <post-update-modal></post-update-modal>
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
    import ToastManager from './utils/ToastManager.vue'
    import {mapGetters} from 'vuex';
    import PostDeleteModal from '../components/posts/PostDeleteModal.vue';
    import PostUpdateModal from '../components/posts/PostUpdateModal.vue';

    export default {
        components: {
            Navbar,
            AppFooter,
            ToastManager,
            PostDeleteModal,
            PostUpdateModal
        },

        computed: {
            ...mapGetters([
                'check',
                'guest'
            ])
        }
    }
</script>

<template>
    <div id="wrapper">
        <navbar v-if="check"></navbar>

        <div id="content" class="content">
            <router-view></router-view>
        </div>

        <app-footer></app-footer>

        <toast-manager ref="toast"></toast-manager>
        <post-delete-modal></post-delete-modal>
        <post-update-modal></post-update-modal>
        <comment-delete-modal></comment-delete-modal>
        <comment-update-modal></comment-update-modal>
    </div>
</template>

<style>
    html,
    body {
        margin:0;
        padding:0;
        height:100%;
    }

    #wrapper {
        min-height:100%;
        position:relative;
    }

    #content {
        padding-bottom:133px; /* Height of the footer element */
    }

    .content {
        padding-top: 100px;
    }
</style>

<script>
    import Navbar from './general/Navbar.vue';
    import AppFooter from './general/AppFooter.vue';
    import ToastManager from './utils/ToastManager.vue'
    import {mapGetters, mapActions} from 'vuex';
    import PostDeleteModal from './modals/PostDeleteModal.vue';
    import PostUpdateModal from './modals/PostUpdateModal.vue';
    import CommentDeleteModal from './modals/CommentDeleteModal.vue';
    import CommentUpdateModal from './modals/CommentUpdateModal.vue';

    export default {
        components: {
            Navbar,
            AppFooter,
            ToastManager,
            PostDeleteModal,
            PostUpdateModal,
            CommentDeleteModal,
            CommentUpdateModal
        },

        created() {
            if (this.check) {
                this.fetchUser();
            }
        },

        methods: {
            ...mapActions([
                'fetchUser'
            ])
        },

        computed: {
            ...mapGetters([
                'check',
                'guest'
            ])
        }
    }
</script>

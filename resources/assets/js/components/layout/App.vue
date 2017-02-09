<template>
    <div id="wrapper">
        <navbar v-if="check"></navbar>

        <div id="content" class="content">
            <transition name="fade" mode="out-in">
                <router-view class="view"></router-view>
            </transition>
        </div>

        <app-footer></app-footer>

        <toast-manager ref="toast"></toast-manager>
        <post-delete-modal></post-delete-modal>
        <post-update-modal></post-update-modal>
        <comment-delete-modal></comment-delete-modal>
        <comment-update-modal></comment-update-modal>
    </div>
</template>

<style lang="sass" rel="stylesheet/scss">
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

    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s ease;
    }

    .fade-enter, .fade-leave-active {
        opacity: 0
    }

    .child-view {
        transition: all .5s cubic-bezier(.55,0,.1,1);
    }
    .slide-left-enter, .slide-right-leave-active {
        opacity: 0;
        -webkit-transform: translate(100px, 0);
        transform: translate(100px, 0);
    }
    .slide-left-leave-active, .slide-right-enter {
        opacity: 0;
        -webkit-transform: translate(-100px, 0);
        transform: translate(-100px, 0);
    }
</style>

<script type="text/babel">
    import Navbar from './Navbar.vue';
    import AppFooter from './AppFooter.vue';
    import ToastManager from '../general/ToastManager.vue'
    import {mapGetters, mapActions} from 'vuex';
    import PostDeleteModal from '../modals/PostDeleteModal.vue';
    import PostUpdateModal from '../modals/PostUpdateModal.vue';
    import CommentDeleteModal from '../modals/CommentDeleteModal.vue';
    import CommentUpdateModal from '../modals/CommentUpdateModal.vue';

    export default {
        data () {
            return {
                transitionName: 'slide-left'
            }
        },

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

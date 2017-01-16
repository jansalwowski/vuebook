<template>
    <div>
        <create-post-panel :target="user"></create-post-panel>

        <hr>

        <post v-for="post in posts" :post="post"></post>

        <infinite-loading :on-infinite="loadMore" ref="infiniteLoading" v-show="showInfiniteScroll"></infinite-loading>
    </div>
</template>

<script type="text/babel">
    import Post from './Post.vue';
    import InfiniteLoading from 'vue-infinite-loading';
    import {mapActions} from 'vuex';
    import {Toast} from "../Models/Toast";
    import CreatePostPanel from './panels/CreatePostPanel.vue';

    export default {
        data() {
            return {
                lastId: null,
                firstLoad: true,
                allLoaded: false
            };
        },

        computed: {
            posts() {
                return this.$store.state.posts.posts;
            },

            showInfiniteScroll() {
                return !this.firstLoad && !this.allLoaded;
            }
        },

        created() {
            this.clearComments();
            this.clearPosts();
            this.fetchPosts();
        },

        methods: {
            ...mapActions([
                'addToast',
                'getPosts',
                'clearComments',
                'clearPosts'
            ]),

            fetchPosts() {
                let data = {
                    username: this.user ? this.user.username : null,
                    lastId: this.lastId,
                    onSuccess: (response) => {
                        this.loadNewPosts(response.body.posts);
                    },
                    onFailure: (response) => {
                        this.loadingFailed(response);
                    }
                };

                this.getPosts(data);
            },

            loadNewPosts(posts) {
                if (this.firstLoad) {
                    this.firstLoad = false;
                }

                if (posts.length > 0) {
                    this.lastId = posts[posts.length - 1].id;

                    this.loaded();
                } else {
                    this.allLoaded = true;
                    this.$refs.infiniteLoading.$emit('$InfiniteLoading:complete');
                }
            },

            loadingFailed(response) {
                if (typeof response.body == 'string') {
                    this.addToast({
                        message:response.body,
                        type: 'error'
                    });
                }

                if (response.status == 429) {
                    setTimeout(() => {
                        this.loaded();
                    }, 10000);
                } else {
                    this.loaded();
                }
            },

            loadMore() {
                if (this.showInfiniteScroll) {
                    this.fetchPosts();
                }
            },

            loaded() {
                this.$refs.infiniteLoading.$emit('$InfiniteLoading:loaded');
            }
        },

        props: ['user'],
        components: {
            Post,
            CreatePostPanel,
            InfiniteLoading
        }
    }
</script>
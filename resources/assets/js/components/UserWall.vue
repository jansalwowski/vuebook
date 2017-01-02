<template>
    <div>
        <post v-for="post in posts" :post="post"></post>

        <infinite-loading :on-infinite="loadMore" ref="infiniteLoading"></infinite-loading>
    </div>
</template>

<style>

</style>

<script type="text/babel">
    import Post from './Post.vue';
    import InfiniteLoading from 'vue-infinite-loading';
    import {mapActions} from 'vuex'; import {Toast} from "../Models/Toast";

    export default {
        data() {
            return {
                posts: [],
                lastId: null,
                firstLoad: true,
                allLoaded: false
            };
        },

        created() {
            this.fetchPosts();
        },

        methods: {
            ...mapActions([
                'addToast'
            ]),

            fetchPosts() {
                let url = this.user ? this.user.username + '/wall' : 'wall';

                this.$http.get(url, {params: {lastId: this.lastId}})
                    .then((response) => {
                    let newPosts = response.body.posts;

                    this.loadNewPosts(newPosts);
                })
            .catch((response) => {
                    if (typeof response.body == 'string') {
                        this.addToast(
                            new Toast(response.body, {theme: 'error'})
                        );
                    }

                    if (response.status == 429) {
                        setTimeout(() => {
                            this.loaded();
                        }, 10000);
                    } else {
                        this.loaded();
                    }

                });
            },

            loadNewPosts(posts) {
                if (posts.length > 0) {
                    this.posts = this.posts.concat(posts);
                    this.lastId = posts[posts.length - 1].id;

                    if (this.firstLoad) {
                        this.firstLoad = false;
                    }

                    this.loaded();
                } else {
                    this.allLoaded = true;
                    this.$broadcast('$InfiniteLoading:complete');
                }
            },

            loadMore() {
                if (!this.firstLoad && !this.allLoaded) {
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
            InfiniteLoading
        }
    }
</script>
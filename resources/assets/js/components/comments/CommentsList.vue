<template>
    <div class="comments">
        <comment v-for="comment in comments" :comment="comment"></comment>

        <a href="#" class="comments__show-more" @click.prevent="fetchComments()" v-show="loadMoreButton">Show more
            comments</a>

        <create-comment class="comments__create-comment" :post-id="postId"></create-comment>
    </div>
</template>

<style lang="sass" rel="stylesheet/scss">
    .comments {
        background: #fafafa;
        padding: 5px 0;

        &__show-more,
        &__create-comment {
            padding: 5px 15px 5px 15px;
        }
    }
</style>

<script type="text/babel">
    import Comment from './Comment.vue';
    import CreateComment from './CreateComment.vue';
    import {mapActions} from "vuex";

    export default {
        data() {
            return {
                lastId: null,
                limit: 2,
                loadMoreButton: true
            };
        },

        props: {
            postId: {
                type: Number,
                required: true
            }
        },

        created() {
            this.fetchComments();
        },

        methods: {
            ...mapActions(['addToast', 'getComments']),

            fetchComments() {

                this.getComments({
                    postId: this.postId,
                    lastId: this.lastId,
                    limit: this.limit,
                    onSuccess: (response) => {
                        this.loadComments(response.body.comments);
                    },
                    onFailure: (response) => {
//                        this.addToast({
//                            message: 'Comments not loaded, try again',
//                            type: 'warning'
//                        });
                    }
                });
            },

            loadComments(comments) {
                if (comments.length) {
                    this.lastId = comments[comments.length - 1].id;
                } else {
                    this.loadMoreButton = false;
                }

                if (this.limit === 2) {
                    this.limit = 5;
                }
            },
        },

        computed: {
            comments() {
                return this.$store.state.comments.comments.filter((comment) => {
                    return comment.commentable_id === this.postId && comment.commentable_type === 1;
                });
            }
        },

        components: {
            Comment,
            CreateComment
        }
    }
</script>
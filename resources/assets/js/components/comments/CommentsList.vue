<template>
    <div>
        <comment v-for="comment in comments"></comment>

        <create-comment post-id="postId"></create-comment>
    </div>
</template>

<style>

</style>

<script>
    import Comment from './Comment.vue';
    import CreateComment from './CreateComment.vue';

    export default {
        data() {
            return {
                comments: [],
                lastId
            };
        },

        props: ['id'],

        methods: {
            fetchComments() {

            },

            loadComments(comments) {
                if (comments.length) {
                    this.comments = this.comments.concat(comments);
                    this.lastId = comments[comments.length - 1].id;
                }
            }
        },

        components: {
            Comment,
            CreateComment
        }
    }
</script>
<template>
    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row post__top">
                <div class="col-md-1">
                    <avatar :user="post.user" :big="true"></avatar>
                </div>
                <div class="col-md-11">

                    <div class="h3 post__title">
                        <user-link :user="post.user"></user-link>
                        <span v-if="hasTarget()">
                    ->
                    <user-link :user="post.target"></user-link>
                </span>
                    </div>
                    <div class="h4 text-muted small">
                        {{ post.created_at }} <span v-if="post.was_edited">(Edited)</span>
                    </div>
                </div>
            </div>

            <p>{{ post.body }}</p>
        </div>

        <hr>

        <div class="panel-body">
            <a @click="showLikes" class="btn btn-xs btn-default">{{ post.likes_count }} <i class="glyphicon glyphicon-thumbs-up"></i></a>
            <a @click="showComments" href="#" class="btn btn-xs btn-default">{{ post.comments_count }} <i class="glyphicon glyphicon-chat"></i></a>
        </div>

        <div class="panel-body" v-if="showCommentsList">
            <comments-list :post-id="post.id"></comments-list>
        </div>
    </div>
</template>

<style lang="sass">
    .post {

        &__top {
             padding-bottom: 10px;
         }

        &__title {
            margin-top: 0;
         }
    }
</style>

<script>
    import CommentsList from './comments/CommentsList.vue';
    import Avatar from '../components/general/Avatar.vue';
    import UserLink from '../components/general/UserLink.vue';

    export default {
        data() {
            return {
                showCommentsList: false
            };
        },

        props: ['post'],

        methods: {
            showLikes() {

            },

            showComments() {
                this.showCommentsList = !this.showCommentsList;
            },

            hasTarget() {
                return this.post.target_id && this.post.target_id !== this.post.user_id;
            }
        },

        components: {
            CommentsList,
            Avatar,
            UserLink
        }
    }
</script>
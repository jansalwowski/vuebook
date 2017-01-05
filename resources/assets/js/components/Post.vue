<template>
    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row post__top">
                <div class="col-md-1">
                    <avatar :user="post.user" :big="true"></avatar>
                </div>
                <div class="col-md-10">

                    <div class="h3 post__title">
                        <user-link :user="post.user"></user-link>
                        <span v-if="hasTarget">
                            ->
                            <user-link :user="post.target"></user-link>
                        </span>
                    </div>
                    <div class="h4 text-muted small">
                        {{ post.created_at }} <span v-if="post.was_edited">(Edited)</span>
                    </div>
                </div>
                <div class="col-md-1">
                    <div v-if="isOwnPost">

                        <dropdown class="pull-right">

                            <ul slot="dropdown-menu" class="dropdown-menu">
                                <li>
                                    <a href="#" @click.prevent="showEditModal()">Edit</a>
                                </li>
                                <li>
                                    <a href="#" @click.prevent="showDeleteModal()">Delete</a>
                                </li>
                            </ul>
                        </dropdown>

                    </div>
                </div>
            </div>

            <p>{{ post.body }}</p>
        </div>

        <hr>

        <div class="panel-body">
            <a @click="showLikes" class="btn btn-xs btn-default">{{ post.likes_count }} <i
                    class="glyphicon glyphicon-thumbs-up"></i></a>
            <a @click="showComments" href="#" class="btn btn-xs btn-default">{{ post.comments_count }} <i
                    class="glyphicon glyphicon-chat"></i></a>
        </div>

        <div class="panel-body" v-if="showCommentsList">
            <comments-list :post-id="post.id"></comments-list>
        </div>
    </div>

</template>

<style lang="sass" rel="stylesheet/scss">
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
    import dropdown from 'vue-strap/src/Dropdown.vue';
    import modal from 'vue-strap/src/Modal.vue';
    import {mapGetters, mapActions} from 'vuex';
    import Form from "../classes/Form";
    import {MODALS_POST_SHOW_DELETE, MODALS_POST_SHOW_UPDATE} from "../store/types";

    export default {
        data() {
            return {
                showCommentsList: false,
                editForm: new Form({
                    body: this.post.body
                })
            };
        },

        props: ['post'],

        methods: {
            ...mapActions([
                'updatePost',
                'addToast'
            ]),

            showLikes() {

            },

            showComments() {
                this.showCommentsList = !this.showCommentsList;
            },

            showDeleteModal() {
                this.$store.commit(MODALS_POST_SHOW_DELETE, this.post.id);
            },

            showEditModal() {
                this.$store.commit(MODALS_POST_SHOW_UPDATE, this.post.id);
            }
        },

        computed: {
            ...mapGetters({
                currentUser: 'getUser',
                auth: 'check'
            }),

            isOwnPost() {
                return this.auth && this.post.user.id === this.currentUser.id;
            },

            hasTarget() {
                return this.post.target_id && this.post.target_id !== this.post.user.id;
            },
        },

        components: {
            CommentsList,
            Avatar,
            UserLink,
            dropdown,
            modal,
        }
    }
</script>
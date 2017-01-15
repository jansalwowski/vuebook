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
                            <i class="glyphicon glyphicon-menu-right post__chevron"></i>
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
                            <button slot="button" type="button" class="btn post__options__btn dropdown-toggle">
                                <span class="caret"></span>
                            </button>

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

        <hr class="post__separator">

        <div class="panel-body">
            <a href="#" @click.prevent="toggleLike()" :class="['post__link', {'post__link--liked': post.wasLiked}] ">
                {{ post.likes_count }} <i class="glyphicon glyphicon-thumbs-up post__link__icon"></i>
            </a>
            <a href="#" @click.prevent="commentsClick()" class="post__link">
                {{ post.comments_count }} <i class="glyphicon glyphicon-comment post__link__icon"></i>
            </a>
        </div>

        <hr class="post__separator" v-if="showComments">

        <div class="post__comments" v-if="showComments">
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

        &__separator {
            margin: 0;
        }

        &__link {
            color: #ababab;
            padding-right: 25px;
            text-decoration: none !important;

            &--liked {
                color: #428BCA !important;

                .post__link__icon {
                    color: #428BCA !important;
                }
            }

            &__icon {
                color: #ababab;
            }
        }

        &__comments {
            margin: 0 0 -15px;
            padding-bottom: 16px;
        }

        &__chevron {
            color: #ababab;
            font-size: 14px;
            position: relative;
            top: -2px;
        }

        &__options {
            &__btn {
                background-color: transparent !important;;
                box-shadow: none !important;
                font-weight: normal;
                color: #ababab;
                border-radius: 0;

                &:hover {
                    color: #717171;
                    font-weight: bold;
                }
            }
        }
    }
</style>

<script>
    import CommentsList from './comments/CommentsList.vue';
    import Avatar from './images/Avatar.vue';
    import UserLink from '../components/general/UserLink.vue';
    import dropdown from 'vue-strap/src/Dropdown.vue';
    import {mapGetters, mapActions} from 'vuex';
    import Form from "../classes/Form";
    import {MODALS_POST_SHOW_DELETE, MODALS_POST_SHOW_UPDATE} from "../store/types";

    export default {
        data() {
            return {
                forceShowComments: false
            };
        },

        props: ['post'],

        methods: {
            ...mapActions([
                'likePost',
                'unlikePost'
            ]),

            toggleLike() {
                if (this.post.wasLiked) {
                    this.unlike();
                } else {
                    this.like();
                }
            },

            like() {
                this.likePost({
                    id: this.post.id
                });
            },

            unlike() {
                this.unlikePost({
                    id: this.post.id
                });
            },

            showDeleteModal() {
                this.$store.commit(MODALS_POST_SHOW_DELETE, this.post.id);
            },

            showEditModal() {
                this.$store.commit(MODALS_POST_SHOW_UPDATE, this.post.id);
            },

            commentsClick() {
                this.forceShowComments = !this.forceShowComments;
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

            showComments() {
                return this.post.comments_count > 0 || this.forceShowComments;
            }
        },

        components: {
            CommentsList,
            Avatar,
            UserLink,
            dropdown,
        }
    }
</script>
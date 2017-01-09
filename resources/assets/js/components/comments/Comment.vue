<template>
    <div class="comment">
        <div class="comment__avatar">
            <avatar :user="comment.user" :small="true"></avatar>
        </div>

        <div class="comment__body">
            <user-link :user="comment.user"></user-link> {{ comment.body }}

            <div class="comment__details">
                <span v-show="hasLikes">{{ comment.likes_count }}</span> <a href="#" @click.prevent="toggleLike()">{{ likeText }}</a> <span class="text-muted">{{ comment.created_at }}</span> <span v-if="was_edited">, Edited</span>
            </div>
        </div>

        <dropdown class="comment__options">
            <button slot="button" type="button" class="btn btn-xs comment__options__btn dropdown-toggle">
                <i class="glyphicon glyphicon-pencil"></i>
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
</template>

<style lang="sass" rel="stylesheet/scss">
    .comment {
        padding: 5px 15px 10px 15px;
        position: relative;

        &:hover {
            background: #f1f1f1;

            .comment__options__btn {
                color: #ababab;
            }
        }
        
        &__avatar {
            display: inline-block;
            float: left;
        }

        &__body {
            display: inline-block;
            margin-left: 10px;
        }

        &__details {
            padding-top: 5px;
        }

        &__options {
            position: absolute;
            right: 5px;
            top: 5px;

            &__btn {
                background-color: transparent !important;;
                box-shadow: none !important;
                font-weight: normal;
                color: transparent;
                border-radius: 0;
                
                &:hover {
                    color: #717171;
                    font-weight: bold;
                }
            }
        }
    }
</style>

<script type="text/babel">
    import Avatar from '../general/Avatar.vue';
    import UserLink from '../general/UserLink.vue';
    import Dropdown from 'vue-strap/src/Dropdown.vue';
    import {MODALS_COMMENT_SHOW_DELETE, MODALS_COMMENT_SHOW_UPDATE} from "../../store/types"; import {mapActions} from "vuex";

    export default {
        props: {
            comment: {
                type: Object,
                required: true
            }
        },

        methods: {
            ...mapActions([
                'likeComment',
                'unlikeComment'
            ]),

            toggleLike() {
                if (this.comment.wasLiked) {
                    this.unlike();
                } else {
                    this.like();
                }
            },

            like() {
                this.likeComment({
                    id: this.comment.id
                });
            },

            unlike() {
                this.unlikeComment({
                    id: this.comment.id
                });
            },

            showDeleteModal() {
                this.$store.commit(MODALS_COMMENT_SHOW_DELETE, this.comment.id);
            },

            showEditModal() {
                this.$store.commit(MODALS_COMMENT_SHOW_UPDATE, this.comment.id);
            }
        },

        computed: {
            hasLikes() {
                return this.comment.likes_count > 0;
            },

            likeText() {
                return this.comment.wasLiked ? 'Unlike' : 'Like';
            }
        },

        components: {
            Avatar,
            UserLink,
            Dropdown
        }
    }
</script>
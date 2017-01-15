<template>
    <div>
        <div class="profile__top">

            <div class="profile__cover">
                <img class="profile__cover__image" :src="cover" alt="Background">

                <div class="profile__cover__edit" v-if="isOwnProfile">
                    <a href="#" @click.prevent="showCoverPhotoModal()" class="profile__cover__edit__btn">Change
                        cover</a>
                </div>

                <div class="profile__top__name">{{ user.name }} ({{ user.username }})</div>

                <div class="profile__cover__buttons">
                    <div class="btn-group">
                        <a href="#" class="btn btn-default" v-if="isOwnProfile">User History</a>
                        <a href="#" @click.prevent="followUser()" class="btn btn-default"
                           v-if="auth && !isOwnProfile && isNotFollowed">Follow</a>
                        <a href="#" @click.prevent="unfollowUser()" class="btn btn-default"
                           v-if="auth && !isOwnProfile && isFollowed">Unfollow</a>
                        <a href="#" class="btn btn-default">...</a>
                    </div>
                </div>
            </div>

            <div class="profile__menu">
                <ul class="profile__menu__list">
                    <li class="profile__menu__list-item">
                        <router-link :to="{name: 'user'}">Profile</router-link>
                    </li>
                    <li class="profile__menu__list-item">
                        {{ user.followersCount }} <router-link :to="{name: 'followers'}">Followers</router-link>
                    </li>
                    <li class="profile__menu__list-item">
                        {{ user.followingCount }} <router-link :to="{name: 'following'}">Following</router-link>
                    </li>
                    <li class="profile__menu__list-item">
                        <a href="#">Photos</a>
                    </li>
                </ul>
            </div>

            <div class="profile__avatar">
                <div style="position:relative;">
                    <avatar :user="user" :profile="true" v-if="user"></avatar>

                    <div class="profile__avatar-edit" v-if="isOwnProfile">
                        <a href="#" @click.prevent="showAvatarModal()" class="profile__avatar-edit__btn">Change
                            avatar</a>
                    </div>
                </div>
            </div>
        </div>

        <avatar-modal v-if="isOwnProfile"></avatar-modal>
        <cover-photo-modal v-if="isOwnProfile"></cover-photo-modal>
    </div>
</template>

<style lang="sass" rel="stylesheet/scss">
    $fontBorder: #747474;

    .profile {
        &__top {
            margin-bottom: 20px;
            position: relative;
            width: 100%;

            &__name {
                bottom: 10px;
                color: white;
                left: 150px;
                font: {
                    size: 24px;
                    weight: bold;
                }
                position: absolute;
                text-shadow: -1px 0 $fontBorder, 0 1px $fontBorder, 1px 0 $fontBorder, 0 -1px $fontBorder;
            }
        }

        &__avatar {
            position: absolute;
            bottom: 10px;
            left: 10px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            display: block;
            padding: 4px;

            &:hover {
                .profile__avatar-edit {
                    display: block;
                }
            }
        }

        &__avatar-edit {
            background: rgba(0, 0, 0, .4);
            bottom: 0;
            display: none;
            padding: 10px 0;
            position: absolute;
            text-align: center;
            width: 100%;

            &:hover {
                background: rgba(0, 0, 0, .8);
            }

            &__btn {
                color: #fff !important;
            }
        }

        &__cover {
            width: 100%;
            height: 300px;
            position: relative;

            &:hover {
                .profile__cover__edit {
                    display: block;
                }
            }

            &__edit {
                background: rgba(0, 0, 0, .4);
                border: 1px solid #747474;
                border-radius: 4px;
                display: none;
                left: 20px;
                padding: 5px 10px;
                position: absolute;
                text-align: center;
                top: 20px;

                &:hover {
                    background: rgba(0, 0, 0, .8);
                }

                &__btn {
                    color: #fff !important;
                }
            }

            &__buttons {
                position: absolute;
                bottom: 10px;
                right: 10px;
            }

            &__image {
                height: 300px;
                width: 100%;
            }
        }

        &__menu {
            background: #fff;
            border-bottom-left-radius: 4px;
            border-bottom-right-radius: 4px;
            width: 100%;

            &__list {
                list-style: none;
                margin-bottom: 0;
                margin-left: 110px;
            }

            &__list-item {
                border-right: 1px solid #ddd;
                display: inline-block;
                padding: 6px 16px;

                &:first-of-type {
                    border-left: 1px solid #ddd;
                }

                a {
                    font-size: 16px;
                }
            }
        }
    }
</style>

<script type="text/babel">
    import Avatar from '../general/Avatar.vue';
    import AvatarModal from '../modals/AvatarModal.vue';
    import CoverPhotoModal from '../modals/CoverPhotoModal.vue';
    import {mapGetters, mapActions} from "vuex";

    export default {
        data() {
            return {
                username: this.user.username
            };
        },

        props: ['user'],

        methods: {
            ...mapActions([
                'follow',
                'unfollow',
                'addToast'
            ]),

            showCoverPhotoModal() {
                this.$emit('show-cover-photo-modal');
            },

            showAvatarModal() {
                this.$emit('show-avatar-modal');
            },

            followUser() {
                this.follow(this.user.username)
                    .then(response => {
                        this.addToast({
                            message: 'You followed ' + this.user.name,
                            type: 'info'
                        });
                    });
            },

            unfollowUser() {
                this.unfollow(this.user.username)
                    .then(response => {
                        this.addToast({
                            message: 'You unfollowed ' + this.user.name,
                            type: 'success'
                        });
                    });
            },
        },

        computed: {
            ...mapGetters({
                auth: 'check',
                currentUser: 'getUser'
            }),

            isOwnProfile() {
                return this.auth && this.currentUser.id === this.user.id;
            },

            isFollowed() {
                return this.$store.state.profile.followed;
            },

            isNotFollowed() {
                return !this.isFollowed;
            },

            cover() {
                return this.user.cover || '';
            }
        },

        components: {Avatar, AvatarModal, CoverPhotoModal}
    }
</script>
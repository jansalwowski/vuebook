<template>
    <div class="container user">
        <div class="user__top">
            <div class="user__cover">
                <img class="user__cover__image" src="https://s-media-cache-ak0.pinimg.com/originals/75/12/78/7512787482ee6410f3c810361cefa084.jpg"
                     alt="Background">
                <div class="user__cover__buttons">
                    <div class="btn-group">
                        <a href="#" class="btn btn-default" v-if="isOwnProfile">User History</a>
                        <a href="#" class="btn btn-default" v-if="isOwnProfile">Edit background photo</a>
                        <a href="#" @click.prevent="followUser()" class="btn btn-default" v-if="auth && !isOwnProfile && isNotFollowed">Follow</a>
                        <a href="#" @click.prevent="unfollowUser()" class="btn btn-default" v-if="auth && !isOwnProfile && isFollowed">Unfollow</a>
                        <a href="#" class="btn btn-default">...</a>
                    </div>
                </div>
            </div>
            <div class="user__menu">
                <ul class="user__menu__list">
                    <li class="user__menu__list-item">
                        <a href="#">Profile</a>
                    </li>
                    <li class="user__menu__list-item">
                        <a href="#">Friends</a>
                    </li>
                    <li class="user__menu__list-item">
                        <a href="#">Photos</a>
                    </li>
                </ul>
            </div>
            <div class="user__top__avatar">
                <avatar :user="user" :profile="true" v-if="user"></avatar>
            </div>
        </div>

        <user-wall v-if="loadWall" :user="user"></user-wall>
    </div>
</template>

<style lang="sass" rel="stylesheet/scss">
    .user {
        margin-top: -50px;

        &__top {
            margin-bottom: 20px;
            position: relative;
            width: 100%;

            &__avatar {
                position: absolute;
                bottom: 10px;
                left: 10px;

                background-color: #fff;
                border: 1px solid #ddd;
                border-radius: 4px;
                display: block;
                padding: 4px;
            }
        }

        &__cover {
            width: 100%;
            height: 300px;
            position: relative;

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
    import UserWall from '../components/UserWall.vue';
    import Avatar from '../components/general/Avatar.vue';
    import {mapGetters, mapActions} from "vuex";

    export default {
        data() {
            return {
                username: this.$route.params.username,
            };
        },

        created() {
            this.fetchUser();
        },

        methods: {
            ...mapActions([
                'getProfile',
                'clearProfile',
                'follow',
                'unfollow',
                'addToast'
            ]),

            fetchUser() {
                this.clearProfile();
                this.getProfile({
                    username: this.username
                });
            },

            followUser() {
                this.follow({
                    username: this.user.username,
                    onSuccess: (response) => {
                        this.addToast({
                            message: 'You followed ' + this.user.name,
                            type: 'success'
                        });
                    }
                });
            },

            unfollowUser() {
                this.unfollow({
                    username: this.user.username,
                    onSuccess: (response) => {
                        this.addToast({
                            message: 'You unfollowed ' + this.user.name,
                            type: 'info'
                        });
                    }
                });
            }
        },

        computed: {
            ...mapGetters({
                auth: 'check',
                currentUser: 'getUser',
                user: 'getProfileUser'
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

            loadWall() {
                return this.user && this.user.hasOwnProperty('username');
            }
        },

        components: {UserWall, Avatar}
    }
</script>
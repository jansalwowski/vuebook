<template>
    <div class="container user">
        <div class="user__top">
            <div class="user__cover">
                <img class="user__cover__image" :src="cover"
                     alt="Background">
                <div class="user__top__name">{{ user.name }} ({{ user.username }})</div>
                <div class="user__cover__buttons">
                    <div class="btn-group">
                        <a href="#" class="btn btn-default" v-if="isOwnProfile">User History</a>
                        <a href="#" @click.prevent="showCoverPhotoModal = true" class="btn btn-default" v-if="isOwnProfile">Edit cover photo</a>
                        <a href="#" @click.prevent="followUser()" class="btn btn-default"
                           v-if="auth && !isOwnProfile && isNotFollowed">Follow</a>
                        <a href="#" @click.prevent="unfollowUser()" class="btn btn-default"
                           v-if="auth && !isOwnProfile && isFollowed">Unfollow</a>
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

        <modal :value="showCoverPhotoModal" @cancel="showCoverPhotoModal = false" effect="fade" BIG v-if="isOwnProfile">
            <div slot="modal-header" class="modal-header">
                <h4 class="modal-title">Change cover photo</h4>
            </div>

            <cover-photo-form @cover-photo-changed="showCoverPhotoModal = false"></cover-photo-form>

            <div slot="modal-footer" class="modal-footer">
                <button type="button" class="btn btn-default" @click="showCoverPhotoModal = false">Cancel</button>
            </div>
        </modal>
    </div>
</template>

<style lang="sass" rel="stylesheet/scss">
    $fontBorder: #747474;

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
    import CoverPhotoForm from '../components/CoverPhotoForm.vue';
    import Modal from 'vue-strap/src/Modal.vue';
    import {mapGetters, mapActions} from "vuex";

    export default {
        data() {
            return {
                showCoverPhotoModal: false
            };
        },

        created() {
            this.clearProfile();
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
                this.getProfile(this.username)
                    .catch(response => {
                        console.log('error', response);
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

            username() {
                return this.$route.params.username;
            },

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
            },

            cover() {
                return this.user.cover || '';
            }
        },

        watch: {
            '$route': 'fetchUser'
        },

        components: {UserWall, Avatar, Modal, CoverPhotoForm}
    }
</script>
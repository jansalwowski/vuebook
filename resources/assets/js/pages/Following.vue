<template>
    <div class="panel panel-default">
        <div class="panel-heading">
            Following ({{ followingCount }})
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-4" v-for="followingUser in following">
                    <div class="following__user">
                        <avatar :user="followingUser"></avatar>
                        <user-link :user="followingUser"></user-link>
                        <a href="#" @click.prevent="toggleFollow(followingUser)"
                           class="btn btn-sm btn-default pull-right" v-if="showButton(followingUser)">{{
                            followingUser.isFollowed ? 'Unfollow' : 'Follow' }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="sass" rel="stylesheet/scss">
    .following {
        &__user {
            border: 1px solid #f1f1f1;
            margin-bottom: 10px;
            padding: 10px;
        }
    }

</style>

<script type="text/babel">
    import Avatar from '../components/images/Avatar.vue';
    import UserLink from '../components/general/UserLink.vue';
    import {mapGetters, mapActions, mapState} from "vuex";

    export default {

        created() {
            this.load();
        },

        methods: {
            ...mapActions([
                'clearFollowing',
                'getFollowing',
                'follow',
                'unfollow',
                'addToast'
            ]),

            load() {
                this.clearFollowing();
                this.fetchFollowing();
            },

            fetchFollowing() {
                this.getFollowing(this.user.username)
                    .catch(response => {
                        console.log(response);
                    })
            },

            toggleFollow(user) {
                if (user.isFollowed) {
                    this.unfollow(user.username)
                        .then(response => {
                            this.addToast({
                                message: 'You unfollowed ' + user.name,
                                type: 'success'
                            });
                        });
                } else {
                    this.follow(user.username)
                        .then(response => {
                            this.addToast({
                                message: 'You followed ' + user.name,
                                type: 'info'
                            });
                        });
                }
            },

            showButton(user) {
                return this.auth && user.id !== this.currentUser.id;
            }
        },

        computed: {
            ...mapGetters({
                user: 'getProfileUser',
                auth: 'check',
                currentUser: 'getUser'
            }),

            ...mapState({
                following: state => state.followers.following,
                followingCount: state => state.followers.followingCount,
            }),
        },

        watch: {
            user() {
                this.load();
            }
        },

        components: {Avatar, UserLink}
    }
</script>
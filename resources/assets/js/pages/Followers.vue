<template>
    <div class="container user">
        <user-profile-top :user="user"></user-profile-top>

        <div class="panel panel-default">
            <div class="panel-heading">
                Followers ({{ followersCount }})
            </div>

        	<div class="panel-body">
                <div class="row">
                    <div class="col-md-4" v-for="follower in followers">
                        <div class="followers__user">
                            <avatar :user="follower"></avatar> <user-link :user="follower"></user-link>
                            <a href="#" @click.prevent="toggleFollow(follower)" class="btn btn-sm btn-default pull-right" v-if="showButton(follower)">{{ follower.isFollowed ? 'Unfollow' : 'Follow' }}</a>
                        </div>
                    </div>
                </div>
        	</div>
        </div>
    </div>
</template>

<style lang="sass" rel="stylesheet/scss">
    .followers {
        &__user {
            border: 1px solid #f1f1f1;
            margin-bottom: 10px;
            padding: 10px;
        }
    }

</style>

<script type="text/babel">
    import UserProfileTop from '../components/panels/UserProfileTop.vue';
    import Avatar from '../components/images/Avatar.vue';
    import UserLink from '../components/general/UserLink.vue';
    import {mapGetters, mapActions, mapState} from "vuex";

    export default {

        created() {
            this.load();
        },

        methods: {
            ...mapActions([
                'getProfile',
                'clearProfile',
                'getFollowers',
                'clearFollowers',
                'follow',
                'unfollow',
                'addToast'
            ]),

            load() {
                this.clearProfile();
                this.clearFollowers();
                this.fetchUser();
                this.fetchFollowers();
            },

            fetchUser() {
                this.getProfile(this.username)
                    .catch(response => {
                        console.log('error', response);
                    });
            },

            fetchFollowers() {
                this.getFollowers(this.username)
                    .catch(response => {
                        console.log(response);
                    });
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
                followers: state => state.followers.followers,
                followersCount: state => state.followers.followersCount,
            }),

            username() {
                return this.$route.params.username;
            }
        },

        watch: {
            '$route': 'load'
        },

        components: {UserProfileTop, Avatar, UserLink}
    }
</script>
<template>
    <div class="panel panel-default">
        <div class="panel-heading">
            Followers ({{ followersCount }})
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-4" v-for="follower in followers">
                    <div class="followers__user">
                        <avatar :user="follower"></avatar>
                        <user-link :user="follower"></user-link>
                        <a href="#" @click.prevent="toggleFollow(follower)" class="btn btn-sm btn-default pull-right"
                           v-if="showButton(follower)">{{ follower.isFollowed ? 'Unfollow' : 'Follow' }}</a>
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
    import Avatar from '../components/images/Avatar.vue';
    import UserLink from '../components/general/UserLink.vue';
    import {mapGetters, mapActions, mapState} from "vuex";

    export default {

        created() {
            this.load();
        },

        methods: {
            ...mapActions([
                'getFollowers',
                'clearFollowers',
                'follow',
                'unfollow',
                'addToast'
            ]),

            load() {
                this.clearFollowers();
                this.fetchFollowers();
            },

            fetchFollowers() {
                if (this.user.hasOwnProperty('username')) {
                    this.getFollowers(this.user.username)
                        .catch(response => {
                            console.log(response);
                        });
                }
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
            })
        },

        watch: {
            user() {
                this.load();
            }
        },

        components: {Avatar, UserLink}
    }
</script>
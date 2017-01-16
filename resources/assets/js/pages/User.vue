<template>
    <div class="container user">
        <user-profile-top :user="user"></user-profile-top>

        <transition :name="transitionName" mode="out-in">
        <!--<transition name="fade" mode="out-in">-->
            <router-view class="child-view"></router-view>
        </transition>
    </div>
</template>

<style lang="sass" rel="stylesheet/scss">
    .user {
        margin-top: -50px;
    }
</style>

<script type="text/babel">
    import UserProfileTop from '../components/panels/UserProfileTop.vue';
    import {mapGetters, mapActions} from "vuex";

    export default {
        data () {
            return {
                transitionName: 'slide-left'
            }
        },

        created() {
            this.clearProfile();
            this.fetchUser();
        },

        methods: {
            ...mapActions([
                'getProfile',
                'clearProfile'
            ]),

            fetchUser() {
                this.clearProfile();
                this.getProfile(this.username)
                    .catch(response => {
                        console.log('error', response);
                    });
            }
        },

        computed: {
            ...mapGetters({
                user: 'getProfileUser'
            }),

            username() {
                return this.$route.params.username;
            }
        },

        watch: {
            '$route'(to, from) {
                let routeUsername = to.params.username;
                if (this.user.hasOwnProperty('username') && this.user.username !== routeUsername) {
                    this.fetchUser();
                }

                const right = to.path.substring(to.path.length-1) === "/";
                this.transitionName = right ? 'slide-right' : 'slide-left';
            }
        },

        components: {UserProfileTop}
    }
</script>
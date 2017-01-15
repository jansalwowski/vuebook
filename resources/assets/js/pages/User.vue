<template>
    <div class="container user">
        <user-profile-top :user="user"></user-profile-top>

        <user-wall v-if="loadWall" :user="user"></user-wall>
    </div>
</template>

<style lang="sass" rel="stylesheet/scss">
    .user {
        margin-top: -50px;
    }
</style>

<script type="text/babel">
    import UserProfileTop from '../components/panels/UserProfileTop.vue';
    import UserWall from '../components/UserWall.vue';
    import {mapGetters, mapActions} from "vuex";

    export default {

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
            },
        },

        computed: {
            ...mapGetters({
                user: 'getProfileUser'
            }),

            username() {
                return this.$route.params.username;
            },

            loadWall() {
                return this.user && this.user.hasOwnProperty('username');
            }
        },

        watch: {
            '$route': 'fetchUser'
        },

        components: {UserWall, UserProfileTop}
    }
</script>
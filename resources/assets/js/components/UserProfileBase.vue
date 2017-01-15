<template>
    <div>
        <user-profile-top :user="user"></user-profile-top>
    </div>
</template>

<style lang="sass" rel="stylesheet/scss">

</style>

<script type="text/babel">

    import UserProfileTop from '../components/panels/UserProfileTop.vue';
    import {mapGetters, mapActions} from "vuex";

    export default {

        created() {
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
                user: 'getProfileUser',
                auth: 'check',
                currentUser: 'getUser'
            }),

            username() {
                return this.$route.params.username;
            },
        },

        watch: {
            '$route': 'load'
        },

        components: {UserProfileTop}
    }
</script>
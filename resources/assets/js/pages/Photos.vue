<template>
    <div class="container">
        <user-profile-top :user="user"></user-profile-top>

        <div class="panel panel-default">
        	<div class="panel-body">
        	   <theater :user="user"></theater>
        	</div>
        </div>
    </div>
</template>

<style lang="sass" rel="stylesheet/scss">

</style>

<script type="text/babel">
//    import UserProfileTop from '../components/panels/UserProfileTop.vue';
    import UserProfileBase from '../components/UserProfileBase.vue';
    import Theater from '../components/images/Theater.vue';

    export default {
        extends: UserProfileBase,

        data() {
            return {};
        },

        craeted() {
            this.load();
        },

        methods: {
            load() {
                this.fetchUser();
            }
        },

        components: {
//            UserProfileTop,
            Theater
        }
    }
</script>
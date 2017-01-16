<template>
    <div>
        <wall v-if="loadWall" :user="user"></wall>
    </div>
</template>

<style lang="sass" rel="stylesheet/scss">

</style>

<script type="text/babel">
    import Wall from '../components/Wall.vue';
    import {mapState} from "vuex";

    export default {
        computed: {
            ...mapState({
                'user': state => state.profile.user
            }),

            loadWall() {
                return this.user && this.user.hasOwnProperty('username');
            }
        },

        components: {
            Wall
        }
    }
</script>
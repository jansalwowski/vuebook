<template>
    <div>

        <div class="user__top">
            <div class="user__top__background">
                <div class="user__top__buttons">
                    <ul>
                        <li>
                            <a href="#history" class="btn btn-default">
                                <i class="fa fa-book"></i>
                                User History
                            </a>
                        </li>
                        <li>
                            <a href="#edit-background" class="btn btn-default">
                                <i class="fa fa-pencil"></i>
                                Edit background photo
                            </a>
                        </li>
                        <li>
                            <a href="#options" class="btn btn-default">
                                ...
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="user__top__menu">
                <ul class="list-unstyled user__top__menu__list">
                    <li>Profile</li>
                    <li>Friends</li>
                    <li>Photos</li>
                </ul>
            </div>
        </div>

        <div class="user__main">
            <user-wall v-if="user" :user="user"></user-wall>
        </div>

    </div>
</template>

<script type="text/babel">
    import UserWall from '../components/UserWall.vue';

    export default {
        data() {
            return {
                username: this.$route.params.username,
                user: null
            };
        },

        created() {
            this.fetchUser();
        },

        methods: {
            fetchUser() {
                this.$http.get('users/' + this.username)
                    .then(response => {
                        this.user = response.body.user;
                    })
                    .catch(response => {
                        console.log(response);
                    });
            }
        },

        components: {UserWall}
    }
</script>
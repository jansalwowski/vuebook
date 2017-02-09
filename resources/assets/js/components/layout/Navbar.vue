<template>
    <div>
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse"
                            data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <router-link class="navbar-brand" :to="{name: 'home'}">VueBook</router-link>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <div class="navbar-left" role="search">
                        <typeahead></typeahead>
                    </div>
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <user-link :user="user" v-if="user">
                                <avatar :user="user" :small="true" slot="before"></avatar>
                            </user-link>

                        </li>
                        <li class="dropdown">
                            <dropdown class="nav-dropdown">
                                <a slot="button" href="#" class="dropdown-toggle dropdown-caret">
                                    <span class="caret"></span>
                                </a>
                                <ul slot="dropdown-menu" class="dropdown-menu">
                                    <li>
                                        <router-link :to="{name: 'settings'}">Settings</router-link>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li>
                                        <router-link :to="{name: 'logout'}">Logout</router-link>
                                    </li>
                                </ul>
                            </dropdown>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div>
        </nav>
    </div>
</template>

<style lang="sass" rel="stylesheet/scss">
    .dropdown-caret {
        background: transparent !important;
        box-shadow: none !important;
        color: #747474;
        display: block;
        padding: 20px;


        &:active,
        &:hover {
            color: #333;
        }
    }
</style>

<script type="text/babel">
    import dropdown from 'vue-strap/src/Dropdown.vue';
    import typeahead from '../general/Typeahead.vue';
    import Avatar from '../images/Avatar.vue';
    import UserLink from '../general/UserLink.vue';
    import {mapState} from "vuex";

    export default {
        components: {
            typeahead,
            dropdown,
            Avatar,
            UserLink
        },

        computed: {
            ...mapState({
                user: (state) => state.auth.user
            })
        }
    }
</script>
<template>
    <div>
        <nav class="navbar navbar-default" role="navigation">
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
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">Link</a></li>
                        <li><a href="#">Link</a></li>
                    </ul>
                    <div class="navbar-left" role="search">
                        <typeahead></typeahead>
                    </div>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#">Link</a></li>
                        <li class="dropdown">
                        <!--<li>-->
                            <dropdown>
                                <a slot="button" class="dropdown-toggle">
                                    Action
                                    <span class="caret"></span>
                                </a>
                                <ul slot="dropdown-menu" class="dropdown-menu">
                                    <li><a href="#dropdown">Action</a></li>
                                    <li><a href="#dropdown">Another action</a></li>
                                    <li><a href="#dropdown">Something else here</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li>
                                        <router-link to="/logout">Logout</router-link>
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

<style>

</style>

<script>
    import dropdown from 'vue-strap/src/Dropdown.vue';
    import typeahead from '../components/general/typeahead.vue';

    export default {
        components: {
            typeahead,
            dropdown
        }
    }
</script>
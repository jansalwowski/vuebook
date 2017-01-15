<template>
    <div class="container home">

        <h1 class="text-center home__heading">Vue<span class="text-muted"></span>book</h1>

        <div class="row">
            <div class="col-md-6">
                <registration></registration>
            </div>
            <div class="col-md-6">
                <login></login>
            </div>
        </div>
    </div>
</template>

<style lang="sass" rel="stylesheet/scss">

    .home {
        margin-top: -50px;

        &__heading {
            margin-bottom: 50px;
        }
    }

</style>

<script type="text/babel">
    import Login from '../components/auth/Login.vue';
    import Registration from '../components/auth/Registration.vue';

    export default {
        components: {
            Login,
            Registration
        }
    }
</script>
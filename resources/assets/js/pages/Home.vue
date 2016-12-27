<template>
    <div class="container">
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

<style>

</style>

<script>
    import Login from '../components/auth/Login.vue';
    import Registration from '../components/auth/Registration.vue';

    export default {
        data() {
            return {};
        },

        components: {
            Login,
            Registration
        }
    }
</script>
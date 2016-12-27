<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <login></login>
            </div>
        </div>
    </div>
</template>

<style>

</style>

<script>
    import Login from '../components/auth/Login.vue';
    export default {
        data() {
            return {};
        },
        components: {
            Login
        }
    }
</script>
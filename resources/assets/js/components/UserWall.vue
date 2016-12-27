<template>
    <div>
        <post v-for="post in posts" :post="post"></post>
    </div>
</template>

<style>

</style>

<script>
    import Post from './Post.vue';

    export default {
        data() {
            return {
                posts: []
            };
        },
        pops: ['user'],
        components: {Post}
    }
</script>
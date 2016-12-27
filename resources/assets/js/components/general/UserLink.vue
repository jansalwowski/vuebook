<template>
    <router-link :to="{name: 'user', params: {slug: user.username}}">{{ user.name }}</router-link>
</template>

<script>
    export default {
        props: {
            user: {
                type: Object,
                required: true
            }
        }
    }
</script>
<template>
    <router-link :to="{name: 'user-wall', params: {username: user.username}}">
        <slot name="before" class="slot--inline"></slot>
        <span class="user-link__name">{{ user.name }}</span>
        <slot name="after"></slot>
    </router-link>
</template>

<style lang="sass" rel="stylesheet/scss">
    .slot {
        &--inline {
            display: inline-block;
        }
    }

    .avatar + .user-link__name {
        font-weight: bold;
        margin: 0 8px;
    }
</style>

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
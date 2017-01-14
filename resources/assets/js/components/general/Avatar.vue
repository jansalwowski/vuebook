<template>
    <img :src="user.avatar" :class="['avatar', {'avatar--big': big, 'avatar--small': small, 'avatar--profile': profile}]">
</template>

<style lang="sass" rel="stylesheet/scss">
    .avatar {
        height: 40px;
        width: 40px;

        &--big {
            height: 60px;
            width: 60px;
        }

        &--profile {
            height: 120px;
            width: 120px;
        }

        &--small {
            height: 25px;
            width: 25px;
        }
    }
</style>

<script>
    export default {
        ready() {
            if (this.big) {
                this.small = false;
            }
        },

        props: {
            user: {
                type: Object,
                required: true
            },
            small: {
                type: Boolean,
                default: false
            },
            big: {
                type: Boolean,
                default: false
            },
            profile: {
                type: Boolean,
                default: false
            }
        }
    }
</script>
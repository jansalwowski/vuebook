<template>
    <div>
        <div>
            <user-link user="comment.user"></user-link>
        </div>

        <div>
            <a @click="like">Like</a> <span class="text-muted">{{ comment.created_at }}</span> <span v-if="was_edited">, Edited</span>
        </div>
    </div>
</template>

<style>

</style>

<script>
    export default {
        data() {
            return {};
        }
    }
</script>
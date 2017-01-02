<template>
    <div class="container">
        <div class="row">

            <div class="col-md-2">
                <div class="panel">
                    <div class="panel-body">
                        User Info
                    </div>
                </div>
            </div>

            <div class="col-md-10">

                <avatar-form></avatar-form>

                <create-post-panel></create-post-panel>

                <hr>

                <post v-for="post in posts" :post="post"></post>

                <hr>

                <div class="text-center">
                    <a @click="fetchPosts" class="btn btn-default">Load More</a>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    import CreatePostPanel from '../components/CreatePostPanel.vue';
    import Post from '../components/Post.vue';
    import AvatarForm from '../components/AvatarForm.vue';

    export default {
        data() {
            return {
                posts: [],
                lastId: null
            };
        },

        created() {
            this.fetchPosts();
        },

        methods: {
            fetchPosts() {
                this.$http.get('wall', {params: {lastId: this.lastId}})
                    .then( (response) => {
                        let newPosts = response.body.posts;

                        this.loadNewPosts(newPosts);
                    })
                    .catch( (response) => {
                        console.log('fail', response);
                    });
            },

            loadNewPosts(posts) {
                if (posts.length > 0) {
                    this.posts = this.posts.concat(posts);
                    this.lastId = posts[posts.length - 1].id;
                }
            }
        },

        components: {
            CreatePostPanel,
            Post,
            AvatarForm
        }
    }
</script>
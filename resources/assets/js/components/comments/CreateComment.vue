<template>
    <div>
        <form method="post" role="form" @submit.prevent="submit">
            <div :class="['form-group', {'has-error': form.errors.has('body')}]">

                <div class="input-group">
                    <input type="text" class="form-control" name="body" v-model="form.body"
                           placeholder="Put your comment here" required autocomplete="off">
                    <span class="input-group-btn"><button class="btn btn-default" type="submit">Submit</button></span>
                </div>

            </div>
        </form>
    </div>
</template>

<style>

</style>

<script type="text/babel">
    import Form from "../../classes/Form";
    import {mapActions} from "vuex";

    export default {
        data() {
            return {
                form: new Form({
                    body: ''
                })
            };
        },

        methods: {
            ...mapActions(['createComment']),

            submit() {
                let data = this.form.getData();

                this.createComment({
                    postId: this.postId,
                    commentData: data,
                    onSuccess: (response) => {
                        this.form.clear();
                    },
                    onFailure: (response) => {
                        this.form.setErrors(response.body);
                    }
                });
            }
        },

        props: {
            postId: {
                type: Number
            }
        }
    }
</script>
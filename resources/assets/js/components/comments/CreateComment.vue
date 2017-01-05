<template>
    <div>
        <form method="post" role="form">

        	<div :class="['form-group', {'has-error': form.errors.has('body')}]">
        		<input type="text" class="form-control" name="" v-model="form.body" placeholder="Put your comment here">
        	</div>

        	<button type="submit" class="btn default">Submit</button>
        </form>
    </div>
</template>

<style>

</style>

<script>
    import Form from "../../classes/Form";

    export default {
        data() {
            return {
                form: new Form({
                    body: ''
                })
            };
        },

        methods: {
            submit() {
                let data = this.form.getData();
                data.commentable_id = this.id;
                data.commentable_type = 'post';


            }
        },

        props: {
            postId: {
                type: Number
            }
        }
    }
</script>
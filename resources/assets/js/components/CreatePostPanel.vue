<template>
    <div class="panel">
    	<div class="panel-body">
            <form method="post" role="form" @submit.prevent="submit" @keydown="form.errors.clear($event.target.name)">

            	<div :class="['form-group', {'has-error': form.errors.has('body')}]">
                    <textarea v-model="form.body" name="body" rows="4" class="form-control" placeholder="Write here your thoughts..."></textarea>
            	</div>

                <span class="text-danger" v-if="form.errors.has('body')" v-text="form.errors.get('body')"></span>

            	<button type="submit" class="btn btn-primary pull-right">Submit</button>
            </form>
    	</div>
    </div>
</template>

<style>

</style>

<script>
    import Form from '../classes/Form';

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

                this.$http.post('posts', data)
                    .then(response => {
                        console.log('Success', response);
                    })
                    .catch(response => {
                        console.log('Failure', response);
                        this.form.setErrors(response.body);
                    });
            }
        }
    }
</script>
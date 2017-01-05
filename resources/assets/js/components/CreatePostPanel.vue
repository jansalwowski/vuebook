<template>
    <div class="panel">
        <div class="panel-body">
            <form method="post" role="form" @submit.prevent="submit" @keydown="form.errors.clear($event.target.name)">

                <div :class="['form-group', {'has-error': form.errors.has('body')}]">
                    <textarea v-model="form.body" name="body" rows="4" class="form-control"
                              placeholder="Write here your thoughts..."></textarea>
                </div>

                <span class="text-danger" v-if="form.errors.has('body')" v-text="form.errors.get('body')"></span>

                <button type="submit" class="btn btn-primary pull-right">Submit</button>
            </form>
        </div>
    </div>
</template>

<style>

</style>

<script type="text/babel">
    import Form from '../classes/Form';
    import {mapActions} from 'vuex';

    export default {
        data() {
            return {
                form: new Form({
                    body: ''
                })
            };
        },

        props: {
            target: {
                default: null,
                type: Object
            }
        },

        methods: {
            ...mapActions([
                'createPost',
                'addToast'
            ]),

            submit() {
                let data = this.form.getData();

                if (this.target && this.target.hasOwnProperty('id')) {
                    data.target_id = this.target.id;
                }

                this.createPost({
                    postData: data,
                    onSuccess: (response) => {
                        this.addToast({
                            message: 'Post added',
                            type: 'success'
                        });
                        this.form.clear();
                    },
                    onFailure: (response) => {
                        this.form.setErrors(response.body);
                        this.addToast({
                            message: 'Post wasn\'t added, please check error messages',
                            type: 'error'
                        });
                    }
                });
            }
        }
    }
</script>
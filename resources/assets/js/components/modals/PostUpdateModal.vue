<template>
    <div>
        <modal :value="show" @cancel="show = false" effect="fade">
            <div slot="modal-header" class="modal-header">
                <h4 class="modal-title">Edit post</h4>
            </div>

            <form method="post" role="form" @submit.prevent="update" @keydown="form.errors.clear($event.target.name)">

                <div :class="['form-group', {'has-error': form.errors.has('body')}]">
                    <textarea v-model="form.body" name="body" rows="4" class="form-control"
                              placeholder="Write here your thoughts..."></textarea>
                </div>

                <span class="text-danger" v-if="form.errors.has('body')" v-text="form.errors.get('body')"></span>
            </form>

            <div slot="modal-footer" class="modal-footer">
                <button type="button" class="btn btn-default" @click="show = false">Cancel</button>
                <button type="button" class="btn btn-success" @click="update()">Save</button>
            </div>
        </modal>
    </div>
</template>

<style lang="sass" rel="stylesheet/scss">

</style>

<script type="text/babel">
    import {mapActions, mapGetters} from "vuex";
    import {MODALS_POST_HIDE_UPDATE} from '../../store/types';
    import Modal from 'vue-strap/src/Modal.vue';
    import Form from "../../helpers/Form";

    export default {
        data() {
            return {
                form: new Form({
                    body: ''
                })
            };
        },

        methods: {
            ...mapActions([
                'updatePost',
                'addToast',
                'getPost'
            ]),

            update() {
                this.updatePost({
                    id: this.post.id,
                    postData: this.form.getData(),
                    onSuccess: (response) => {
                        this.addToast({
                            message: 'Post updated',
                            type: 'success'
                        });
                        this.show = false;
                    },
                    onFailure: (response) => {
                        this.addToast({
                            message: 'Post could not have been updated',
                            type: 'error'
                        });
                        this.form.setErrors(response.body);
                    }
                });
            },
        },

        computed: {
            ...mapGetters({
                post: 'getPostToUpdate'
            }),

            show: {
                get() {
                    return this.$store.state.modals.posts.update.show;
                },

                set(value) {
                    if (!value) {
                        this.$store.commit(MODALS_POST_HIDE_UPDATE);
                    }
                }
            },
        },

        watch: {
            post(post) {
                if (post && post.hasOwnProperty('body')) {
                    this.form.body = post.body;
                }
            }
        },

        components: {
            Modal
        }
    }
</script>
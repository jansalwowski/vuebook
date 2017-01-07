<template>
    <div>
        <modal :value="show" @cancel="show = false" effect="fade" SMALL>
            <div slot="modal-header" class="modal-header">
                <h4 class="modal-title">Confirm deleting post</h4>
            </div>
            Are you sure you want to delete post?
            <div slot="modal-footer" class="modal-footer">
                <button type="button" class="btn btn-default" @click="show = false">Cancel</button>
                <button type="button" class="btn btn-danger" @click="confirmDelete()">Delete</button>
            </div>
        </modal>
    </div>
</template>

<style lang="sass" rel="stylesheet/scss">

</style>

<script type="text/babel">
    import {mapActions} from "vuex";
    import {MODALS_POST_HIDE_DELETE} from '../../store/types';
    import Modal from 'vue-strap/src/Modal.vue';

    export default {
        methods: {
            ...mapActions([
                'deletePost',
                'addToast'
            ]),

            confirmDelete() {
                let id = this.$store.state.modals.posts.delete.id;

                this.deletePost({
                    id,
                    onSuccess: (response) => {
                        this.addToast({
                            message: 'Post deleted',
                            type: 'success'
                        });
                        this.show = false;
                    },
                    onFailure: (response) => {
                        this.addToast({
                            message: 'Post could not have been deleted',
                            type: 'error'
                        });
                    }
                });
            },
        },

        computed: {
            show: {
                get() {
                    return this.$store.state.modals.posts.delete.show;
                },

                set(value) {
                    if (!value) {
                        this.$store.commit(MODALS_POST_HIDE_DELETE);
                    }
                }
            }
        },

        components: {
            Modal
        }
    }
</script>
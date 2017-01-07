<template>
    <div>
        <modal :value="show" @cancel="show = false" effect="fade" SMALL>
            <div slot="modal-header" class="modal-header">
                <h4 class="modal-title">Confirm deleting comment</h4>
            </div>
            Are you sure you want to delete comment?
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
    import {MODALS_COMMENT_HIDE_DELETE} from '../../store/types';
    import Modal from 'vue-strap/src/Modal.vue';

    export default {
        methods: {
            ...mapActions([
                'deleteComment',
                'addToast'
            ]),

            confirmDelete() {
                let id = this.$store.state.modals.comments.delete.id;

                this.deleteComment({
                    id,
                    onSuccess: (response) => {
                        this.addToast({
                            message: 'Comment deleted',
                            type: 'success'
                        });
                        this.show = false;
                    },
                    onFailure: (response) => {
                        this.addToast({
                            message: 'Comment could not have been deleted',
                            type: 'error'
                        });
                    }
                });
            },
        },

        computed: {
            show: {
                get() {
                    return this.$store.state.modals.comments.delete.show;
                },

                set(value) {
                    if (!value) {
                        this.$store.commit(MODALS_COMMENT_HIDE_DELETE);
                    }
                }
            }
        },

        components: {
            Modal
        }
    }
</script>
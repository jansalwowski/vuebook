<template>
    <modal :value="show" @cancel="show = false" effect="fade" BIG>
        <div slot="modal-header" class="modal-header">
            <h4 class="modal-title">Change cover photo</h4>
        </div>

        <cover-photo-form @cover-photo-changed="show = false"></cover-photo-form>

        <div slot="modal-footer" class="modal-footer">
            <button type="button" class="btn btn-default" @click="show = false">Cancel</button>
        </div>
    </modal>
</template>

<style lang="sass" rel="stylesheet/scss">

</style>

<script type="text/babel">
    import Modal from 'vue-strap/src/Modal.vue';
    import CoverPhotoForm from '../images/CoverPhotoForm.vue';

    export default {
        data() {
            return {
                show: false
            };
        },

        created() {
            this.$parent.$on('show-cover-photo-modal', () => {
                this.show = true;
            });
        },

        components: {
            Modal,
            CoverPhotoForm
        }
    }
</script>
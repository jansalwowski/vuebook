<template>
    <modal :value="show" @cancel="show = false" effect="fade" BIG>
        <div slot="modal-header" class="modal-header">
            <h4 class="modal-title">Change Avatar</h4>
        </div>

        <avatar-form @avatar-changed="show = false"></avatar-form>

        <div slot="modal-footer" class="modal-footer">
            <button type="button" class="btn btn-default" @click="show = false">Cancel</button>
        </div>
    </modal>
</template>

<style lang="sass" rel="stylesheet/scss">

</style>

<script type="text/babel">
    import Modal from 'vue-strap/src/Modal.vue';
    import AvatarForm from '../images/AvatarForm.vue';

    export default {
        data() {
            return {
                show: false
            };
        },

        created() {
            this.$parent.$on('show-avatar-modal', () => {
                this.show = true;
            });
        },

        components: {
            Modal,
            AvatarForm
        }
    }
</script>
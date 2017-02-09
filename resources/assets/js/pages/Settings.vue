<template>
    <div class="container">

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Avatar
                    </div>
                    <div class="panel-body">
                        <avatar-form></avatar-form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <change-password-panel></change-password-panel>
            </div>

            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Cover Photo
                    </div>
                    <div class="panel-body">

                        <cover-photo-form></cover-photo-form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<style lang="sass" rel="stylesheet/scss">

</style>

<script type="text/babel">
    import AvatarForm from '../components/images/AvatarForm.vue';
    import CoverPhotoForm from '../components/images/CoverPhotoForm.vue';
    import ChangePasswordPanel from '../components/users/ChangePasswordPanel.vue';
    import {mapState} from "vuex";

    export default {
        components: {
            AvatarForm,
            CoverPhotoForm,
            ChangePasswordPanel
        },

        computed: {
            ...mapState({
                user: (state) => state.auth.user
            })
        }
    }
</script>
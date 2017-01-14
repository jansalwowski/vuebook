<template>
    <div class="container">

        <div class="row">
            <div class="col-md-6">
                <avatar-panel :user="user"></avatar-panel>
            </div>

            <div class="col-md-6">
                <change-password-panel :user="user"></change-password-panel>
            </div>

            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Cover Photo
                    </div>
                    <div class="panel-body">

                        <cover-photo-panel></cover-photo-panel>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<style lang="sass" rel="stylesheet/scss">

</style>

<script type="text/babel">
    import AvatarPanel from '../components/AvatarPanel.vue';
    import CoverPhotoForm from '../components/CoverPhotoForm.vue';
    import ChangePasswordPanel from '../components/panels/ChangePasswordPanel.vue';
    import {mapState} from "vuex";

    export default {
        components: {
            AvatarPanel,
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
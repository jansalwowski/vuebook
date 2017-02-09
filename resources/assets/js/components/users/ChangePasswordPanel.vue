<template>
    <div class="panel panel-default">
        <div class="panel-body">
            <form action="" method="post" role="form" @submit.prevent="submit()" @keydown="form.errors.clear($event.target.name)">

                <div :class="['form-group', {'has-error': form.errors.has('old_password')}]">
                    <label for="old_password">Current password</label>
                    <input type="password" class="form-control" v-model.trim="form.old_password" name="old_password"
                           id="old_password" placeholder="Current password">
                    <span class="text-danger" v-if="form.errors.has('old_password')" v-text="form.errors.get('old_password')"></span>
                </div>

                <div :class="['form-group', {'has-error': form.errors.has('new_password')}]">
                    <label for="new_password">New password</label>
                    <input type="password" class="form-control" v-model.trim="form.new_password" name="new_password"
                           id="new_password" placeholder="Current password">
                    <span class="text-danger" v-if="form.errors.has('new_password')" v-text="form.errors.get('new_password')"></span>
                </div>

                <div :class="['form-group', {'has-error': form.errors.has('new_password_confirmation')}]">
                    <label for="new_password_confirmation">Confirm new password</label>
                    <input type="password" class="form-control" v-model.trim="form.new_password_confirmation"
                           name="new_password_confirmation" id="new_password_confirmation"
                           placeholder="Current password">
                    <span class="text-danger" v-if="form.errors.has('new_password_confirmation')" v-text="form.errors.get('new_password_confirmation')"></span>
                </div>

                <div class="checkbox">
                    <label>
                        <input type="checkbox" v-model="form.revokeToken" id="revokeToken">
                        Logout from all devices (revoke access token)
                    </label>
                </div>

                <button type="submit" class="btn btn-primary pull-right" :disabled="!canBeSaved">Save</button>
            </form>
        </div>
    </div>
</template>

<style lang="sass" rel="stylesheet/scss">

</style>

<script type="text/babel">
    import Form from "../../helpers/Form";
    import {AUTH_SET_TOKEN} from "../../store/types";
    import {mapActions} from "vuex";

    export default {
        data() {
            return {
                form: new Form({
                    'old_password': '',
                    'new_password': '',
                    'new_password_confirmation': '',
                    'revokeToken': false,
                })
            };
        },

        methods: {
            ...mapActions([
                'changePassword',
                'addToast'
            ]),

            submit() {
                let data = this.form.getData();

                this.changePassword(data)
                    .then(response => {
                        this.form.clear();

                        let message = 'Password changed! ';

                        if (response.hasOwnProperty('message')) {
                            message += response.message;
                        }

                        this.addToast({
                            message,
                            type: 'success'
                        });
                    })
                    .catch(response => {
                        this.form.setErrors(response);

                        let message = 'Password was not changed! ';

                        if (response.hasOwnProperty('message')) {
                            message += response.message;
                        }

                        this.addToast({
                            message,
                            type: 'error'
                        });
                    });
            }
        },

        computed: {
            passwordConfirmed() {
                return this.form.new_password && this.form.new_password === this.form.new_password_confirmation;
            },

            canBeSaved() {
                return this.form.old_password && this.form.new_password
                    && this.passwordConfirmed
                    && this.form.old_password !== this.form.new_password;
            }
        }
    }
</script>
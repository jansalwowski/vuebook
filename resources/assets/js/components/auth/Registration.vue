<template>
    <div class="panel panel-default">
        <div class="panel-heading">Registration</div>
        <div class="panel-body">
            <form method="post" role="form" @submit.prevent="submit()" @keydown="form.errors.clear($event.target.name)">

                <div :class="['form-group', {'has-error': form.errors.has('name')}]">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Name"
                           v-model="form.name">
                    <span class="text-danger small" v-if="form.errors.has('name')"
                          v-text="form.errors.get('name')"></span>
                </div>

                <div :class="['form-group', {'has-error': form.errors.has('username')}]">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="Username"
                           v-model="form.username">
                    <span class="text-danger small" v-if="form.errors.has('username')"
                          v-text="form.errors.get('username')"></span>
                </div>

                <div :class="['form-group', {'has-error': form.errors.has('email')}]">
                    <label for="email">E-mail</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="E-mail"
                           v-model="form.email">
                    <span class="text-danger small" v-if="form.errors.has('email')"
                          v-text="form.errors.get('email')"></span>
                </div>

                <div :class="['form-group', {'has-error': form.errors.has('password')}]">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password"
                           v-model="form.password">
                    <span class="text-danger small" v-if="form.errors.has('password')"
                          v-text="form.errors.get('password')"></span>
                </div>

                <div :class="['form-group', {'has-error': form.errors.has('password_confirmation')}]">
                    <label for="password_confirmation">Confirm password</label>
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation"
                           placeholder="Confirm Password" v-model="form.password_confirmation">
                    <span class="text-danger small" v-if="form.errors.has('password_confirmation')"
                          v-text="form.errors.get('password_confirmation')"></span>
                </div>

                <button type="submit" class="btn btn-primary pull-right">Register</button>
            </form>
        </div>
    </div>
</template>

<style>

</style>

<script type="text/babel">
    import Form from "../../classes/Form";
    import {mapActions} from 'vuex';

    export default {
        data() {
            return {
                form: new Form({
                    name: '',
                    username: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                })
            };
        },

        methods: {
            ...mapActions([
                'register'
            ]),

            submit() {
                const data = this.form.getData();

                this.register({
                    data,
                    onSuccess: (response) => {
                        this.$router.replace('/');
                    },
                    onFailure: (response) => {
                        this.form.setErrors(response.body);
                    }
                });
            }
        }
    }
</script>
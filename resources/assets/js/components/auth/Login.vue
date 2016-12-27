<template>
    <div class="panel panel-default">
        <div class="panel-heading">Login</div>
        <div class="panel-body">
            <form method="post" role="form" @submit.prevent="submit()" @keydown="form.errors.clear($event.target.name)">

                <div class="alert alert-danger" v-if="error" v-text="error.message"></div>

                <div :class="['form-group', {'has-errors': form.errors.has('username')}]">
                    <label for="username"></label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="Username" v-model="form.username">
                    <span class="text-danger small" v-if="form.errors.has('username')" v-text="form.errors.get('username')"></span>
                </div>

                <div :class="['form-group', {'has-errors': form.errors.has('password')}]">
                    <label for="password"></label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" v-model="form.password">
                    <span class="text-danger small" v-if="form.errors.has('password')" v-text="form.errors.get('password')"></span>
                </div>

                <button type="submit" class="btn btn-primary pull-right">Login</button>
            </form>
        </div>
    </div>
</template>

<style>

</style>

<script>
    import Form from "../../classes/Form";
    import auth from "../../ServiceProviders/auth";

    export default {
        data() {
            return {
                form: new Form({
                    username: 'jan.salwowski@o2.pl',
                    password: 'james123'
                }),
                auth: auth,
                error: null
            };
        },

        methods: {
            submit() {
                this.auth.login(
                    this,
                    this.form.username,
                    this.form.password,
                    (loggedIn, errors) => {
                        if (loggedIn) {
                            this.error = null;
//                            this.$router.replace(this.$route.query.redirect || '/')
                            this.$router.replace('/')
                        } else {
                            this.error = errors;
                        }
                    });
            }
        }
    }
</script>
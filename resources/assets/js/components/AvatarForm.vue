<template>
    <div class="panel panel-default">
        <div class="panel-heading">
            Upload Avatar
        </div>
        <div class="panel-body">

            <div class="row">

                <div class="col-md-5">
                    <img v-show="preview" class="Image-input__image" :src="preview">
                </div>

                <div class="col-md-7">

                    <form method="post" role="form" @submit.prevent="submit" enctype="multipart/form-data" ref="avatarForm">

                        <div :class="['form-group', {'has-error': form.errors.has('avatar')}]">
                            <label for="avatar"></label>
                            <input type="file" class="form-control" name="avatar" id="avatar" placeholder="Avatar" @change="attachFile">
                            <span class="text-danger" v-show="form.errors.has('avatar')">{{ form.errors.get('avatar') }}</span>
                        </div>

                        <button type="submit" class="btn btn-primary pull-right">Submit</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</template>

<style>

</style>

<script type="text/babel">
    import Form from "../classes/Form";
    import {mapActions} from 'vuex';
    import {Toast} from "../Models/Toast";


    export default {
        data() {
            return {
                form: new Form({
                    avatar: null
                }),
                preview: null
            }
        },

        props: {
            defaultAvatar: {
                default: null
            }
        },

        methods: {
            ...mapActions([
                'addToast'
            ]),

            attachFile(e) {
                let files = e.target.files || e.dataTransfer.files;

                if (!files.length) {
                    this.form.avatar = null;
                    this.preview = this.defaultAvatar;

                    return;
                }

                let reader = new FileReader();

                reader.onload = (event) => {
                    this.preview = event.target.result;
                };

                reader.readAsDataURL(files[0]);

                this.form.avatar = files[0];
            },

            submit() {
                let data = new FormData();
                data.append('avatar', this.form.avatar);

                this.$http.post('avatars', data)
                    .then((response) => {
                        this.addToast({
                            message: 'Avatar changed!',
                            type: 'success'
                        });
                        this.$refs.avatarForm.reset();
                        this.form.avatar = null;
                        this.preview = null;
                    })
                    .catch(response => {
                        this.form.setErrors(response.body);
                        this.addToast({
                            message: 'Failed to add avatar',
                            type: 'error'
                        });
                    });
            }
        },
    }
</script>
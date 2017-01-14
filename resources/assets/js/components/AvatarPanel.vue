<template>
    <div class="panel panel-default">
        <div class="panel-heading">
            Avatar
        </div>
        <div class="panel-body">

            <div class="row">

                <div class="col-md-5">
                    <img v-show="preview" class="avatar-form__preview" :src="preview">
                </div>

                <div class="col-md-7">

                    <form method="post" role="form" @submit.prevent="submit" enctype="multipart/form-data"
                          ref="avatarForm">

                        <div :class="['form-group', {'has-error': form.errors.has('avatar')}]">
                            <label for="avatar"></label>
                            <input type="file" class="form-control" name="avatar" id="avatar" placeholder="Avatar"
                                   @change="attachFile">
                            <span class="text-danger"
                                  v-show="form.errors.has('avatar')">{{ form.errors.get('avatar') }}</span>
                        </div>

                        <div class="pull-right">
                            <button type="reset" class="btn btn-danger" :disabled="!insertedImage" @click="resetImage">
                                Reset
                            </button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</template>

<style lang="sass" rel="stylesheet/scss">
    .avatar-form {
        &__preview {
            max-width: 100%;
        }
    }
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
                insertedImage: null
            }
        },

        props: {
            user: {
                default: null
            }
        },

        methods: {
            ...mapActions([
                'addToast',
                'changeAvatar'
            ]),

            attachFile(e) {
                let files = e.target.files || e.dataTransfer.files;

                if (!files.length) {
                    this.resetImage();

                    return;
                }

                let reader = new FileReader();

                reader.onload = (event) => {
                    this.insertedImage = event.target.result;
                };

                reader.readAsDataURL(files[0]);

                this.form.avatar = files[0];
            },

            submit() {
                let data = new FormData();
                data.append('avatar', this.form.avatar);

                this.changeAvatar({
                    data,
                    onSuccess: (response) => {
                        this.addToast({
                            message: 'Avatar changed!',
                            type: 'success'
                        });
                        this.resetImage();
                    },
                    onFailure: (response) => {
                        this.form.setErrors(response.body);
                        this.addToast({
                            message: 'Failed to add avatar',
                            type: 'error'
                        });
                    }
                });
            },

            resetImage() {
                this.$refs.avatarForm.reset();
                this.form.avatar = null;
                this.insertedImage = null;
            }
        },

        computed: {
            defaultAvatar() {
                return this.user.hasOwnProperty('avatar') ? this.user.avatar : '';
            },

            preview() {
                return this.insertedImage || this.defaultAvatar;
            }
        }
    }
</script>
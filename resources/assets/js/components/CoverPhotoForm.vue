<template>
    <div class="row">

        <div class="col-md-12">
            <img v-show="preview" class="cover-photo-form__preview" :src="preview">
        </div>

        <div class="col-md-12">

            <form method="post" role="form" @submit.prevent="submit" enctype="multipart/form-data"
                  ref="coverForm">

                <div :class="['form-group', {'has-error': form.errors.has('cover')}]">
                    <label for="cover"></label>
                    <input type="file" class="form-control" name="cover" id="cover" placeholder="CoverPhoto"
                           @change="attachFile">
                    <span class="text-danger"
                          v-show="form.errors.has('cover')">{{ form.errors.get('cover') }}</span>
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
</template>

<style lang="sass" rel="stylesheet/scss">
    .cover-photo-form {
        &__preview {
            width: 100%;
            margin-bottom: 20px;
        }
    }
</style>

<script type="text/babel">
    import Form from "../classes/Form";
    import {mapActions, mapState} from 'vuex';
    import {Toast} from "../Models/Toast";


    export default {
        data() {
            return {
                form: new Form({
                    cover: null
                }),
                insertedImage: null
            }
        },

        methods: {
            ...mapActions([
                'addToast',
                'changeCoverPhoto'
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

                this.form.cover = files[0];
            },

            submit() {
                let data = new FormData();
                data.append('cover', this.form.cover);

                this.changeCoverPhoto(data)
                    .then(response => {
                        this.$emit('cover-photo-changed');
                        this.addToast({
                            message: 'CoverPhoto changed!',
                            type: 'success'
                        });
                        this.resetImage();
                    })
                    .catch(response => {
                        this.form.setErrors(response);
                        this.addToast({
                            message: 'Failed to add cover photo',
                            type: 'error'
                        });
                    });
            },

            resetImage() {
                this.$refs.coverForm.reset();
                this.form.cover = null;
                this.insertedImage = null;
            }
        },

        computed: {
            ...mapState({
                user: (state) => state.auth.user
            }),

            defaultCoverPhoto() {
                return this.user.hasOwnProperty('cover') ? this.user.cover : '';
            },

            preview() {
                return this.insertedImage || this.defaultCoverPhoto;
            }
        }
    }
</script>
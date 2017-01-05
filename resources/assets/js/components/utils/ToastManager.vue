<template class="toast-manager">
    <div class="vue-toast-manager_container" :class="classesOfPosition">
        <v-toast
                v-for="(toast, index) in toasts"
                :toast="toast"
                :position="index"
        ></v-toast>
    </div>
</template>

<style lang="sass" rel="stylesheet/scss">
    .vue-toast-manager_container {
        position: fixed;
        width: 100%;

        &.--top {
            top: 60px;
        }
        &.--bottom {
            bottom: 20px;
        }
        &.--left {
            left: 10px;
        }
        &.--right {
            right: 10px;
        }
    }

    .vue-toast-manager_toasts {
        position: relative;
    }
</style>

<script>
    import VToast from './Toast.vue';
    import {Toast} from "../../Models/Toast";
    import {mapActions} from 'vuex';

    const defaultOptions = {
        maxToasts: 6,
        position: 'right top'
    };

    export default {
        data() {
            return {
                options: defaultOptions,
            }
        },

        computed: {
            classesOfPosition() {
                return this._updateClassesOfPosition(this.options.position);
            },

            directionOfJumping() {
                return this._updateDirectionOfJumping(this.options.position);
            },

            toasts() {
                return this.$store.state.toasts.toasts;
            }
        },

        methods: {
            ...mapActions([
                'addToast'
            ]),

            // Public
            showToast(message, options) {
                this._addToast(message, options);

                return this
            },

            setOptions(options) {
                this.options = Object.assign(this.options, options || {});

                return this;
            },

            // Private
            _addToast(message, options = {}) {
                if (!message) {
                    return;
                }

                options.directionOfJumping = this.directionOfJumping;

                this.addToast({
                    message: message,
                    options: options
                });
            },


            _updateClassesOfPosition(position) {
                return position.split(' ').reduce((prev, val) => {
                    prev[`--${val.toLowerCase()}`] = true;

                    return prev;
                }, {})
            },

            _updateDirectionOfJumping(position) {
                return position.match(/top/i) ? '+' : '-';
            }
        },

        components: {
            VToast
        }
    };
</script>
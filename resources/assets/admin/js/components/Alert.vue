<template>
    <transition name="fade">
        <div :class="`alert alert-block alert-${type}`">
            <button class="close" type="button" @click="closeClicked">×</button>

            <h4 class="alert-heading" v-if="title">{{ title }}</h4>
            <p v-html="message">{{ message }}</p>
            <p v-if="buttons">
                <button
                        v-for="button in buttons"
                        :class="`btn ${buttonType(button)}`"
                        @click="buttonClicked(button)"
                >
                    {{ button.label }}
                </button>
            </p>
        </div>
    </transition>
</template>

<script>
    export default {
        props: {
            title: String,
            message: String,
            type: {
                type: String,
                default: 'danger'
            },
            timer: {
                type: Number,
            },
            buttons: Array
        },
        data() {
            return {}
        },
        methods: {
            closeClicked() {
                this.$emit('close');
            },
            buttonClicked(button) {
                if (typeof button.handle === 'function') {
                    button.handle();
                }

                this.$emit('close');
            },
            buttonType(button) {
                if (button.type) {
                    return `btn-${button.type}`;
                }

                return '';
            }
        },
        mounted() {
            if (this.timer) {
                setTimeout(() => {
                    this.$emit('close')
                }, this.timer);
            }
        }
    }
</script>

<style lang="scss">
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0
    }

    .alert {
        button + button { margin-left: 10px }
    }
</style>
<template>
    <transition name="fade">
        <div :class="`alert alert-block alert-${type}`">
            <button class="close" type="button" @click="closeClicked">×</button>

            <h4 class="alert-heading" v-if="title">{{ title }}</h4>
            <div v-if="message" v-html="message">{{ message }}</div>
            <div v-if="buttons" class="mt-3">
                <button
                        v-for="button in buttons"
                        :class="`btn ${buttonType(button)}`"
                        @click="buttonClicked(button)"
                >
                    {{ button.label }}
                </button>
            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        props: {
            alertData: Object,
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
        computed: {
            type() {
                return this.alertData.type || 'danger';
            },
            title() {
                return this.alertData.title;
            },
            message() {
                return this.alertData.message;
            },
            buttons() {
                return this.alertData.buttons;
            },
            timer() {
                return this.alertData.timer;
            },
        },
        mounted() {
            if (this.timer) {
                setTimeout(() => {
                    this.$emit('close');
                }, this.timer);
            }
        }
    }
</script>

<style lang="scss">
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s
    }

    .fade-enter, .fade-leave-to {
        opacity: 0
    }

    .alert {
        button + button { margin-left: 10px }
    }
</style>
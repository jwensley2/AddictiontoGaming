<template>
    <modal
            name="confirmation"
            @before-open="beforeOpen"
            classes="confirmation-modal"
            height="auto"
    >
        <h3 class="title">{{ title }}</h3>
        <div class="content">
            <p v-html="message">{{ message }}</p>
        </div>

        <div class="buttons">
            <button
                    v-for="(button, i) in buttons"
                    @click="click(i, $event)"
                    :class="button.classes"
            >{{ button.title }}
            </button>
        </div>
    </modal>
</template>

<script>
    export default {
        name: 'ConfirmationModal',
        data() {
            return {
                params: {},
                title: '',
                message: '',
                buttons: [],
            }
        },

        methods: {
            beforeOpen(event) {
                this.params  = event.params;
                this.title   = event.params.title;
                this.message = event.params.message;
                this.buttons = event.params.buttons;
            },

            click(i, event) {
                let button = this.buttons[i];

                if (typeof button.handler === 'function') {
                    return button.handler(i, event)
                } else {
                    this.$modal.hide('confirmation')
                }
            }
        }

    }
</script>

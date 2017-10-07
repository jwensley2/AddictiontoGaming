<template>
    <a href="#" @click="deleteClicked($event)">
        <slot></slot>
    </a>
</template>

<script>
    export default {
        props: ['title', 'url', 'remove'],
        methods: {
            deleteClicked: function (event) {
                let _this = this;
                event.preventDefault();

                this.$modal.show('confirmation', {
                    title: 'Confirm Deletion',
                    message: `Are you sure you want to delete <strong>"${this.title}"</strong>?`,
                    buttons: [
                        {title: 'No'},
                        {
                            title: 'Yes',
                            classes: 'yes',
                            handler() {
                                axios.delete(_this.url)
                                    .then(response => {
                                        $(_this.remove).remove();
                                        _this.$modal.hide('confirmation');
                                    });
                            }
                        }
                    ]
                });
            }
        }
    }
</script>

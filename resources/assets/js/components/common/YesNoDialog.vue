<template>
    <b-modal @ok="handleOK" @cancel="handleCancel" ref="modal" title="Confirm" header-bg-variant="primary" header-text-variant="white" button-size="md">
        <p class="lead bold">{{ this.question }}</p>
    </b-modal>
</template>

<script>
    import Dialog from '../../plugins/Dialog';

    export default {
        data() {
            return {
                question: ""
            }
        },
        methods: {
            confirm(question) {
                this.question = question;
                this.$refs.modal.show();
            },
            handleOK() {
                this.$emit('answer', true);
            },
            handleCancel() {
                this.$emit('answer', false);
            }
        },
        created() {
            Dialog.yesNoDialog = this;
        }
    }
</script>



<template>
    <form @submit.prevent="$emit('submit')">
            <b-row class="my-2">
                <b-col sm="2"><label for="name">Name:</label></b-col>
                <b-col sm="10" md="6"><b-form-input id="name" type="text" v-model="record.name"></b-form-input></b-col>
            </b-row>
            <b-row class="my-2">
                <b-col sm="2"><label for="email">E-mail:</label></b-col>
                <b-col sm="10" md="6"><b-form-input id="email" type="text" v-model="record.email"></b-form-input></b-col>
            </b-row>
            <slot name="buttons"></slot>
    </form>
</template>

<script>
    export default {
        props: {
            record: Object
        }
    }
</script>
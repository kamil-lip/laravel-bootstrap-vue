<template>
    <b-row class="my-2">
        <b-col sm="2">
            <slot name="label"></slot>
        </b-col>
        <b-col sm="10" md="6">
            <slot name="component"></slot>
        </b-col>
    </b-row>
</template>

<script>
    export default {
        props: {
            for: {
                type: String,
                default: null
            },
            label: String
        }
    }
</script>
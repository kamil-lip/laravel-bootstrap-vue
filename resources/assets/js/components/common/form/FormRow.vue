<template>
    <b-row class="my-2">
        <b-col sm="2">
            <slot name="label"></slot>
        </b-col>
        <b-col sm="10" md="6">
            <slot name="component"></slot>
            <div class="invalid-feedback" v-show="errors.has(field)">{{ errors.first(field) }}</div>
        </b-col>
    </b-row>
</template>

<script>
    export default {
        inject: {
            $validator: '$validator'
        },
        props: {
            field: {
                type: String,
                default: null
            },
            label: String
        }
    }
</script>

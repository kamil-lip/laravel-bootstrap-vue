<template>
    <b-form :validated="validated" @submit.prevent.stop="$emit('submit')" novalidate>
        <form-row>
            <label slot="label" :for="record.name">Name:</label>
            <form-input autocomplete="name" slot="component" name="name" :validationRules="this.rules.name" v-model="record.name"></form-input>
        </form-row>
        <form-row>
            <label slot="label" :for="record.email">E-mail:</label>
            <form-input autocomplete="email" slot="component" type="email" name="email" :validationRules="this.rules.email" v-model="record.email"></form-input>
        </form-row>
        <form-row v-if="password">
            <label slot="label" :for="record.password">Password:</label>
            <form-input autocomplete="new-password" slot="component" type="password" name="password" :validationRules="this.rules.password" v-model="record.password"></form-input>
        </form-row>
        <b-row class="my-2">
            <b-col sm="12" md="8">
                <div class="alert alert-warning" role="alert" v-if="validated && errors.any()">
                    The form contains errors. Please correct them.
                </div>
            </b-col>
        </b-row>
        <slot name="buttons"></slot>
    </b-form>
</template>

<script>
    import FormRow from './FormRow';
    import FormInput from '../../common/form/Input';

    export default {
        inject: {
            $validator: '$validator'
        },
        props: {
            record: Object,
            validated: {
                type: Boolean,
                default: false
            },
            rules: {
                type: Object,
                default: {}
            },
            password: {
                type: Boolean,
                default: false
            }
        },
        components: {
            FormInput,
            FormRow
        }
    }
</script>
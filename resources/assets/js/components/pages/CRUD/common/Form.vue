<template>
    <b-form :validated="validated" @submit.prevent.stop="$emit('submit')" novalidate v-if="rules">
        <form-row field="name">
            <label slot="label" for="name">Name:</label>
            <form-input slot="component" autocomplete="name" name="name" id="name"
                        v-model="record.name" v-validate="rules.name"
                        :state="errors.has('name') ? false : null"></form-input>
        </form-row>
        <form-row field="email">
            <label slot="label" for="email">Email:</label>
            <form-input slot="component" autocomplete="email" name="email" id="email"
                        v-model="record.email" v-validate="rules.email"
                        :state="errors.has('email') ? false : null"></form-input>
        </form-row>
        <form-row v-if="password" field="password">
            <label slot="label" for="password">Password:</label>
            <form-input slot="component" autocomplete="new-password" type="password" name="password" id="password"
                        :state="errors.has('password') ? false : null" v-validate="rules.password"
                        v-model="record.password"></form-input>
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
    import FormRow from '../../../common/form/FormRow';
    import {FormInput} from '../../../common/form';

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
                default: null
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

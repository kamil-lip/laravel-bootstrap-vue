<template>
    <b-form :validated="validated" @submit.prevent="$emit('submit')" novalidate>
        <b-row class="my-2">
            <b-col sm="2"><label for="name">Name:</label></b-col>
            <b-col sm="10" md="6">
                <b-form-input autocomplete="email" v-validate="this.rules.name" :state="errors.has('name') ? false : null"
                              name="name" id="name" type="text" v-model="record.name"></b-form-input>
                <div class="invalid-feedback" v-show="errors.has('name')">{{ errors.first('name') }}</div>
            </b-col>
        </b-row>
        <b-row class="my-2">
            <b-col sm="2"><label for="email">E-mail:</label></b-col>
            <b-col sm="10" md="6">
                <b-form-input autocomplete="email" v-validate="this.rules.email" :state="errors.has('email') ? false : null"
                              id="email" name="email" type="text" v-model="record.email"></b-form-input>
                <div class="invalid-feedback" v-show="errors.has('email')">{{ errors.first('email') }}</div>
            </b-col>
        </b-row>
        <b-row class="my-2" v-if="password">
            <b-col sm="2"><label for="password">Password:</label></b-col>
            <b-col sm="10" md="6">
                <b-form-input autocomplete="new-password" v-validate="this.rules.password" :state="errors.has('password') ? false : null"
                              id="password" name="password" type="password" v-model="record.password"></b-form-input>
                <div class="invalid-feedback" v-show="errors.has('password')">{{ errors.first('password') }}</div>
            </b-col>
        </b-row>
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
    export default {
        inject: ['$validator'],
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
        }
    }
</script>
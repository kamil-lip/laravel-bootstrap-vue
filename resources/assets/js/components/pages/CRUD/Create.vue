<template>
    <vue-page id="resource-create-page" :loading="loading">
        <div v-if="rules !== null">
            <b-breadcrumb :items="breadcrumbItems"/>
            <h1>New user</h1>
            <hr/>
            <resource-form :rules="rules" :password="true" :validated="validated" :record="data"
                           @submit="submit">
                <b-row class="my-2" slot="buttons">
                    <b-col md="8" class="text-right">
                        <b-button type="submit" variant="primary" :disabled="errors.any()">Submit</b-button>
                    </b-col>
                </b-row>
            </resource-form>
        </div>
    </vue-page>
</template>

<script>
    import axios from 'axios';
    import S from 'string';
    import resourceForm from './common/Form';

    export default {
        components: {
            resourceForm
        },
        data() {
            return {
                data: {
                    name: '',
                    email: '',
                    password: ''
                },
                rules: null,
                validated: false,
                loading: false,
                breadcrumbItems: [{
                    text: 'Home',
                    to: {name: 'home'}
                }, {
                    text: 'Users',
                    to: {name: 'resource.index', resource: this.$route.params.resource}
                }, {
                    text: 'Create',
                    active: true
                }]
            }
        },
        methods: {
            displayErorrs(errors) {
                this.errors.clear();
                for (let [fieldName, messages] of Object.entries(errors)) {
                    this.errors.add({
                        field: fieldName,
                        msg: messages[0]
                    })
                }
            },
            saveData() {
                let path = '/api' + S(this.$route.fullPath).chompRight("/create").s;
                axios.post(path, this.data)
                    .then(() => {
                        this.$router.push({name: 'resource.index', resource: this.$route.params.resource});
                        this.$notify({
                            group: 'app',
                            type: 'success',
                            title: 'Success',
                            text: 'Record has created successfully.'
                        });
                    })
                    .catch((error) => {
                        let response = error.response;
                        let message = 'An error occurred. Record has not been saved.';

                        // check if the response contains validation errors (we can't rely on client side validation only)
                        if (response.status === 422 && response.data.errors !== undefined) {
                            //display the errors
                            this.displayErorrs(response.data.errors);
                            message = 'The form contains errors. Please correct them and try again.';
                        }

                        this.$notify({
                            group: 'app',
                            type: 'error',
                            title: 'Error',
                            text: message
                        });
                    })
            },
            submit() {
                // validate first
                this.$validator.validate().then((result) => {
                    this.validated = true;
                    if (result) {
                        this.saveData();
                        return;
                    }
                    this.$notify({
                        group: 'app',
                        type: 'error',
                        title: 'Error',
                        text: 'The form contains errors. Please correct them.'
                    });
                });
            },
            fetchValidationRules() {
                let path = '/api' + this.$route.fullPath.replace('/create', '/validation/rules');
                let params = {action: 'create'};
                this.loading = true;
                axios.get(path, {params})
                    .then((response) => {
                        this.rules = response.data;
                    }).then(() => {
                    this.loading = false;
                })
            },
        },
        mounted() {
            this.fetchValidationRules();
        }
    }
</script>
<template>
    <div>
        <b-breadcrumb :items="breadcrumbItems"/>
        <h1>New user</h1>
        <hr/>
        <resource-form :password="true" :validated="validated" :rules="rules" :record="data" v-if="data !== null"
                       @submit="submit">
            <b-row class="my-2" slot="buttons">
                <b-col md="8" class="text-right">
                    <b-button type="submit" variant="primary">Submit</b-button>
                </b-col>
            </b-row>
        </resource-form>
    </div>
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
                    email: ''
                },
                rules: {},
                validated: false,
                breadcrumbItems: [{
                    text: 'Home',
                    href: '/'
                }, {
                    text: 'Users',
                    to: {name: 'users.index'}
                }, {
                    text: 'Create',
                    active: true
                }]
            }
        },
        methods: {
            saveData() {
                let path = '/api' + S(this.$route.fullPath).chompRight("/create").s;
                axios.post(path, this.data)
                    .then(() => {
                        this.$router.push({name: 'users.index'});
                        this.$notify({
                            group: 'app',
                            type: 'success',
                            title: 'Success',
                            text: 'Record has created successfully.'
                        });
                    })
                    .catch(() => {
                        this.$notify({
                            group: 'app',
                            type: 'error',
                            title: 'Error',
                            text: 'An error occurred. Record has not been updated. Please try again.'
                        });
                    })
            },
            submit() {
                // validate first
                this.$validator.validateAll().then((result) => {
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
                let params = {action: 'store'};
                axios.get(path, {params})
                    .then((response) => {
                        this.rules = response.data;
                    })
            },
        },
        mounted() {
            this.fetchValidationRules();
        }
    }
</script>
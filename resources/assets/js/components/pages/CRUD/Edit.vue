<template>
    <vue-page id="resource-edit-page" :loading="loading">
        <div v-if="data !== null && rules !== null">
            <b-breadcrumb :items="breadcrumbItems"/>
            <h1>Edit user</h1>
            <hr/>
            <resource-form :rules="rules" :record="data" :validated="validated"
                           @submit="submit">
                <b-row class="my-2" slot="buttons">
                    <b-col md="8" class="text-right">
                        <b-button type="reset" variant="danger" @click="resetForm">Reset</b-button>
                        <b-button type="submit" variant="primary">Update</b-button>
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
                data: null,
                validated: false,
                rules: null,
                loading: false
            }
        },
        computed: {
            breadcrumbItems() {
                return this.data ? [{
                    text: 'Home',
                    to: {name: 'home'}
                }, {
                    text: 'Users',
                    to: {name: 'users.index'}
                }, {
                    text: this.data.name,
                    active: true
                }] : [];
            }
        },
        methods: {
            fetchData() {
                let path = '/api' + S(this.$route.fullPath).chompRight("/edit").s;
                let config = {params: {rules: true}};
                this.loading = true;
                axios.get(path, config)
                    .then((response) => {
                        this.data = response.data.data;
                        this.rules = response.data.rules;
                    })
                    .catch((error) => {
                        let response = error.response;
                        let message = 'An error occurred. Please refresh.';

                        if (response.status === 404) {
                            message = 'User does not exist.';
                            this.$router.replace({name: 'users.index'});
                        }

                        this.$notify({
                            group: 'app',
                            type: 'error',
                            title: 'Error',
                            text: message
                        });

                    }).then(() => {
                    this.loading = false;
                });
            },
            resetForm() {
                this.fetchData();
            },
            submit() {
                this.$validator.validate().then((result) => {
                    this.validated = true;
                    if (result) {
                        this.updateData();
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
            displayErorrs(errors) {
                this.errors.clear();
                for (let [fieldName, messages] of Object.entries(errors)) {
                    this.errors.add({
                        field: fieldName,
                        msg: messages[0]
                    })
                }
            },
            updateData() {
                let path = '/api' + S(this.$route.fullPath).chompRight("/edit").s;
                axios.put(path, this.data)
                    .then((response) => {
                        this.data = response.data;
                        this.$notify({
                            group: 'app',
                            type: 'success',
                            title: 'Success',
                            text: 'Record has been updated successfully.'
                        });
                    })
                    .catch((error) => {
                        let response = error.response;
                        let message = 'An error occurred. Record has not been updated. Please try again.';

                        // check if the response contains validation errors (we can't rely on client side validation only)
                        if (response.status === 422 && response.data.errors !== undefined) {
                            //display the errors
                            this.displayErorrs(response.data.errors);
                            message = 'The form contains errors. Please correct them.';
                        }

                        this.$notify({
                            group: 'app',
                            type: 'error',
                            title: 'Error',
                            text: message
                        });
                    })
            }
        },
        mounted() {
            this.fetchData();
        }
    }
</script>
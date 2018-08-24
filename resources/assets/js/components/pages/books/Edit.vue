<template>
    <vue-page id="resource-edit-page" :loading="loading">
        <div class="btn-group mb-3" role="group">
            <b-button variant="primary"
                      :to="{ name: 'books.show', params: { id: this.$route.params.id }}"><i
                class="fa fa-eye"></i> View book
            </b-button>
            <b-button variant="danger" @click="handleDeleteRecordClick"><i class="fa fa-remove"></i></b-button>
        </div>
        <b-card :header="'Edit book ' + data.name" v-if="data !== null && rules !== null" style="max-width: 800px;">
            <resource-form :rules="rules" :record="data" :validated="validated"
                           @submit="submit">
                <b-row class="my-2" slot="buttons">
                    <b-col class="text-right">
                        <b-button type="reset" variant="danger" @click="resetForm">Reset</b-button>
                        <b-button type="submit" variant="primary">Update</b-button>
                    </b-col>
                </b-row>
            </resource-form>
        </b-card>
    </vue-page>
</template>

<script>
    import axios from 'axios';
    import S from 'string';
    import resourceForm from './common/Form';
    import deleteCurrentRecord from './common/mixins/deleteCurrentRecord';

    export default {
        components: {
            resourceForm
        },
        mixins: [
            deleteCurrentRecord
        ],
        data() {
            return {
                data: null,
                validated: false,
                rules: null,
                loading: false
            }
        },
        watch: {
            'data.name'(name) {
                this.viewRoute.meta.label = name;
            }
        },
        methods: {
            fetchData() {
                let path = '/api' + S(this.$route.fullPath).chompRight("/edit").s;
                let config = {params: {rules: true}};
                axios.get(path, config)
                    .then((response) => {
                        this.data = response.data.data;
                        this.rules = response.data.rules;
                    })
                    .catch((error) => {
                        let response = error.response;
                        let message = 'An error occurred. Please refresh.';

                        if (response.status === 404) {
                            message = 'Book does not exist.';
                            this.$router.replace({name: 'books.index'});
                        }

                        this.$notify({
                            group: 'app',
                            type: 'error',
                            title: 'Error',
                            text: message
                        });

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
                        this.$router.push({name: 'books.show', params: {id: this.data.id}});
                        this.$notify({
                            group: 'app',
                            type: 'success',
                            title: 'Success',
                            text: 'Book has been updated successfully.'
                        });
                    })
                    .catch((error) => {
                        let response = error.response;
                        let message = 'An error occurred. Book has not been updated. Please try again.';

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
            const routesMatched = this.$route.matched;
            this.viewRoute = routesMatched[routesMatched.length - 2];
            this.viewRoute.meta.label = this.$route.params.id;
            this.fetchData();
        }
    }
</script>

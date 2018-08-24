<template>
    <vue-page id="resource-edit-page" :loading="loading">
        <div class="btn-group mb-3" role="group">
            <b-button variant="primary"
                      :to="{ name: 'users.edit', params: { id: this.$route.params.id }}"><i
                class="fa fa-edit"></i> Edit user
            </b-button>
            <b-button variant="danger" @click="handleDeleteRecordClick"><i class="fa fa-remove"></i></b-button>
        </div>
        <b-card no-body :header="data.name" style="max-width: 800px;" v-if="data">
            <dl class="resource-details">
                <div class="my-2">
                    <dt class="col-sm-4">Name</dt>
                    <dd class="col-sm-8">{{ data.name }}</dd>
                </div>
                <div class="my-2">
                    <dt class="col-sm-4">E-mail address</dt>
                    <dd class="col-sm-8">{{ data.email }}</dd>
                </div>
            </dl>
        </b-card>
    </vue-page>
</template>

<script>
    import axios from 'axios';
    import deleteCurrentRecord from './common/mixins/deleteCurrentRecord';

    export default {
        data() {
            return {
                data: null,
                loading: false
            };
        },
        mixins: [
            deleteCurrentRecord
        ],
        watch: {
            'data.name'(name) {
                this.viewRoute.meta.label = name;
            }
        },
        methods: {
            fetchData() {
                let path = '/api' + this.$route.fullPath;
                let config = {};
                this.loading = true;
                axios.get(path, config)
                    .then((response) => {
                        this.data = response.data;
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
            }
        },
        mounted() {
            const routesMatched = this.$route.matched;
            this.viewRoute = routesMatched[routesMatched.length - 2];
            this.viewRoute.meta.label = this.$route.params.id;
            this.fetchData();
        },

    }
</script>

<style>
    .resource-details > div {
        display: flex;
        border-bottom: 1px dashed rgba(0, 0, 0, 0.125);
    }

    .resource-details > div:last-child {
        border-bottom: none;
    }

    dl.resource-details {
        margin-bottom: 0;
    }

    .resource-details dd {
        color: 	#5c6873;
    }

</style>

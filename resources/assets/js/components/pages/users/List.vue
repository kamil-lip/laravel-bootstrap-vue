<template>
    <vue-page id="resource-list-page">
        <b-button variant="primary mb-3"
                  :to="{ name: 'users.create' }"><i
            class="fa fa-user-plus"></i> New user
        </b-button>
        <div class="card">
            <div class="card-header">Users</div>
            <div class="card-body">
                <div v-if="data !== null">
                    <div class="mb-3 clearfix">
                        <b-pagination-nav class="float-right" :use-router="true" :link-gen="pagLinkGen"
                                          :number-of-pages="data.last_page"
                                          v-model="data.current_page" align="right" v-if="!loading && data.total > 0"/>
                        <b-form @submit.prevent class="form-inline float-left">
                            <label class="mr-sm-2">Filter</label>
                            <input class="form-control filter" placeholder="Type to search" v-model.lazy="filter"
                                   v-debounce="filterDelay"/>
                        </b-form>
                    </div>
                    <div v-if="!loading && data.total > 0">
                        <b-table class="user-list-table" striped hover :items="data.data" :fields="tableFields">
                            <template slot="actions" slot-scope="row">
                                <b-button size="sm" variant="success"
                                          :to="{ name: 'users.show', params: { id: row.item.id }}">
                                    <i class="fa fa-eye"></i> View
                                </b-button>
                                <b-button size="sm" variant="primary"
                                          :to="{ name: 'users.edit', params: { id: row.item.id }}">
                                    <i class="fa fa-edit"></i> Edit
                                </b-button>
                                <b-button size="sm" @click.stop="handleDeleteRecordClick(row.item)" variant="danger">
                                    <i class="fa fa-remove"></i> Delete
                                </b-button>
                            </template>
                        </b-table>
                        <b-pagination-nav class="mb-3" :use-router="true" :link-gen="pagLinkGen"
                                          :number-of-pages="data.last_page"
                                          v-model="data.current_page" align="right"/>
                    </div>
                    <b-alert show v-if="!loading && data.total === 0">No results matching your search criteria found.
                    </b-alert>
                    <block-loader class="block-loader align-self-center justify-content-center" v-if="loading">
                    </block-loader>
                </div>
            </div>
        </div>
    </vue-page>
</template>

<script>
    import axios from 'axios';
    import debounce from 'v-debounce';
    import BlockLoader from '../../common/BlockLoader';

    export default {

        components: {
            BlockLoader
        },
        directives: {
            debounce
        },
        props: {
            resourceName: String
        },
        data() {
            return {
                data: null,
                tableFields: ["id", "name", "email", "created_at", "updated_at", "actions"],
                filter: '',
                filterDelay: 400,
                loading: false
            };
        },
        watch: {
            $route(route) {
                // don't fetch data if we are leaving index page
                if (route.name === 'users.index') {
                    this.fetchPageData();
                }
            },
            filter() {
                // after filtering than can be less pages so lets navigate to the first page
                this.$router.replace({name: 'users.index', params: {resource: this.$route.params.resource}});
                this.fetchPageData();
            }
        },
        methods: {
            fetchPageData() {
                this.loading = true;
                let params = {};
                if (this.filter.length > 0) {
                    params['filter'] = this.filter;
                }
                axios.get('/api' + this.$route.fullPath, {params})
                    .then((response) => {
                        this.data = response.data;
                    }).then(() => {
                    // always executed
                    this.loading = false
                });
            },
            pagLinkGen(pageNum) {
                return {
                    name: 'users.index',
                    query: {
                        page: pageNum
                    }
                }
            }
            ,
            deleteRecord(record) {
                axios.delete(route('users.destroy', {id: record.id}))
                    .then((response) => {
                        let records = this.data.data;
                        let recordIdx = records.findIndex((rec) => {
                            return rec.id === response.data.id;
                        });
                        if (recordIdx > -1) {
                            records.splice(recordIdx, 1);
                            this.fetchPageData();
                            this.$notify({
                                group: 'app',
                                type: 'success',
                                title: 'Success',
                                text: 'Record has been deleted successfully'
                            });
                        }

                    })
            }
            ,
            handleDeleteRecordClick(record) {
                this.$confirm('Are you sure?').then((confirmed) => {
                    if (confirmed) {
                        this.deleteRecord(record);
                    }
                });

            }
        }
        ,
        mounted() {
            this.fetchPageData();
        }
    }
</script>


<style>
    #resource-list-page .block-loader {
        height: 400px;
    }
</style>

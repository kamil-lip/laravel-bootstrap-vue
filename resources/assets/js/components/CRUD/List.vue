<template>
    <transition name="fade">
        <div class="resource-list" v-if="data !== null">
            <b-breadcrumb :items="breadcrumbItems"/>
            <h1>{{ resourceName.toUpperCase() }}</h1>
            <hr/>
            <b-button variant="primary" :to="{ name: 'users.create' }"><i class="fas fa-user-plus"></i> New user
            </b-button>
            <div class="my-4">
                <b-pagination-nav class="float-right" :use-router="true" :link-gen="pagLinkGen"
                                  :number-of-pages="data.last_page"
                                  v-model="data.current_page" align="right"/>
                <b-form inline class="float-left">
                    <label class="mr-sm-2">Filter</label>
                    <input class="form-control" placeholder="Type to search" v-model.lazy="filter"
                           v-debounce="filterDelay"/>
                </b-form>
            </div>
            <transition name="fade">
                <div v-if="!loading">
                    <b-table striped hover :items="data.data" :fields="tableFields">
                        <template slot="actions" slot-scope="row">
                            <b-button size="sm" variant="primary"
                                      :to="{ name: 'users.edit', params: { id: row.item.id }}">
                                <i class="fas fa-user-edit"></i> Edit
                            </b-button>
                            <b-button size="sm" @click.stop="handleDeleteRecordClick(row.item)" variant="danger">
                                <i class="fas fa-user-minus"></i> Delete
                            </b-button>
                        </template>
                    </b-table>
                    <b-pagination-nav :use-router="true" :link-gen="pagLinkGen" :number-of-pages="data.last_page"
                                      v-model="data.current_page" align="right"/>
                </div>
            </transition>
            <block-loader class="block-loader" v-if="loading"></block-loader>
        </div>
    </transition>
</template>

<script>
    import axios from 'axios';
    import BlockLoader from '../common/BlockLoader';
    import debounce from 'v-debounce';

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
                breadcrumbItems: [{
                    text: 'Home',
                    to: {name: 'home'}
                }, {
                    text: 'Users',
                    to: {name: 'users.index'}
                }],
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
                this.$router.replace({name: 'users.index'});
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
                axios.delete(route(this.resourceName + '.destroy', {id: record.id}))
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
    .resource-list {
        position: relative;
    }

    .resource-list .block-loader {
        position: absolute;
        left: 50%;
        top: 300px;
        margin-left: -100px;
    }
</style>
<template>
    <vue-page id="resource-list-page">
        <div v-if="data !== null">
            <b-breadcrumb :items="breadcrumbItems" />
            <h1>Books</h1>
            <hr/>
            <b-button variant="primary" :to="{ name: 'book.create' }"><i class="fas fa-user-plus"></i> New book
            </b-button>
            <div class="my-3 clearfix">
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
                <b-table class="book-list-table" striped hover :items="data.data" :fields="tableFields">
                    <template slot="actions" slot-scope="row">
                        <b-button size="sm" variant="primary"
                                  :to="{ name: 'book.edit', params: { id: row.item.id }}">
                            <i class="fas fa-edit"></i> Edit
                        </b-button>
                        <b-button size="sm" @click.stop="handleDeleteRecordClick(row.item)" variant="danger">
                            <i class="fas fa-user-minus"></i> Delete
                        </b-button>
                    </template>
                </b-table>
                <b-pagination-nav class="mb-3" :use-router="true" :link-gen="pagLinkGen"
                                  :number-of-pages="data.last_page"
                                  v-model="data.current_page" align="right"/>
            </div>
            <b-alert show v-if="!loading && data.total === 0">No results matching your search criteria found.
            </b-alert>
            <block-loader class="block-loader align-self-center justify-content-center" v-if="loading"></block-loader>
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
        data() {
            return {
                data: null,
                tableFields: ["id", "name", "author.name", "actions"],
                breadcrumbItems: [{
                    text: 'Home',
                    to: {name: 'home'}
                }, {
                    text: 'Books',
                    to: {name: 'book.index'}
                }],
                filter: '',
                filterDelay: 400,
                loading: false
            };
        },
        watch: {
            $route(route) {
                // don't fetch data if we are leaving index page
                if (route.name === 'book.index' ) {
                    this.fetchPageData();
                }
            },
            filter() {
                // after filtering than can be less pages so lets navigate to the first page
                this.$router.replace({name: 'book.index'});
                this.fetchPageData();
            }
        },
        methods: {
            fetchPageData() {
                this.loading = true;
                let params = {
                    with: 'author'
                };
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
                    name: 'book.index',
                    query: {
                        page: pageNum
                    }
                }
            }
            ,
            deleteRecord(record) {
                axios.delete(route('books.destroy', {id: record.id}))
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

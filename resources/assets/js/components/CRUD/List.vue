<template>
    <div>
        <h1>{{ resourceName.toUpperCase() }}</h1>
        <hr/>
        <b-pagination-nav :use-router="true" :link-gen="pagLinkGen" :number-of-pages="data.last_page"
                          v-model="data.current_page" align="right"/>
        <b-table striped hover :items="data.data" :fields="fields">
            <template slot="actions" slot-scope="row">
                <b-button size="sm" variant="primary" :to="{ name: 'users.edit', params: { id: row.item.id }}">
                    Edit
                </b-button>
                <b-button size="sm" @click.stop="handleDeleteRecordClick(row.item)" variant="danger">
                    Delete
                </b-button>
            </template>
        </b-table>
        <b-pagination-nav :use-router="true" :link-gen="pagLinkGen" :number-of-pages="data.last_page"
                          v-model="data.current_page" align="right"/>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        props: {
            resourceName: String
        },
        data() {
            return {
                data: [],
                fields: ["id", "name", "email", "created_at", "updated_at", "actions"]
            };
        },
        watch: {
            $route() {
                this.fetchPageData();
            }
        },
        methods: {
            fetchPageData() {
                axios.get('/api' + this.$route.fullPath)
                    .then((response) => {
                        this.data = response.data;
                    })
            },
            pagLinkGen(pageNum) {
                return {
                    name: 'users',
                    query: {
                        page: pageNum
                    }
                }
            },
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
            },
            handleDeleteRecordClick(record) {
                this.$confirm('Are you sure?').then((confirmed) => {
                    if (confirmed) {
                        this.deleteRecord(record);
                    }
                });

            }
        },
        mounted() {
            this.fetchPageData();
        }
    }
</script>
<template>
    <div>
        <h1>{{ resourceName.toUpperCase() }}</h1>
        <hr/>
        <b-pagination-nav :use-router="true" :link-gen="linkGen" :number-of-pages="data.last_page"
                          v-model="data.current_page" align="right"/>
        <b-table striped hover :items="data.data"></b-table>
        <b-pagination-nav :use-router="true" :link-gen="linkGen" :number-of-pages="data.last_page"
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
                data: []
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
            linkGen(pageNum) {
                return {
                    name: 'users',
                    query: {
                        page: pageNum
                    }
                }
            }
        },
        mounted() {
            this.fetchPageData();
        }
    }
</script>
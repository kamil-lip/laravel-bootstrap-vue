<template>
    <b-table striped hover :items="records"></b-table>
</template>

<script>
    import axios from 'axios';

    export default {
        props: {
            resourceName: String
        },
        data() {
            return {
                records: []
            };
        },
        methods: {
            fetchAll() {
                axios.get(route(this.resourceName + '.index'))
                    .then((response) => {
                        this.records = response.data
                    })
            }
        },
        mounted() {
            this.fetchAll();
        }
    }
</script>

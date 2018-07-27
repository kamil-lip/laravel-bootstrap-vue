<template>
    <div>
        <h1>Edit user</h1>
        <hr/>
        <resource-form :record="data" v-if="data !== null" @submit="submit">
            <b-row class="my-2" slot="buttons">
                <b-col md="8" class="text-right">
                    <b-button type="reset" variant="danger" @click="resetForm">Reset</b-button>
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
                data: null
            }
        },
        watch: {},
        methods: {
            fetchRecord() {
                let path = '/api' + S(this.$route.fullPath).chompRight("/edit").s;
                axios.get(path)
                    .then((response) => {
                        this.data = response.data;
                    })
            },
            resetForm() {
                this.fetchRecord();
            },
            submit() {
                // update record
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
                    .catch(() => {
                        this.$notify({
                            group: 'app',
                            type: 'error',
                            title: 'Error',
                            text: 'An error occurred. Record has not been updated. Please try again.'
                        });
                    })
            }
        },
        mounted() {
            this.fetchRecord();
        }
    }
</script>
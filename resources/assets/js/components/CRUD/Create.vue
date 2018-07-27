<template>
    <div>
        <h1>New user</h1>
        <hr/>
        <resource-form :record="data" v-if="data !== null" @submit="submit">
            <b-row class="my-2" slot="buttons">
                <b-col md="8" class="text-right">
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
                data: {
                    name: '',
                    email: ''
                }
            }
        },
        methods: {
            submit() {
                // update record
                let path = '/api' + S(this.$route.fullPath).chompRight("/create").s;
                axios.post(path, this.data)
                    .then(() => {
                        this.$router.push({ name: 'users.index' });
                        this.$notify({
                            group: 'app',
                            type: 'success',
                            title: 'Success',
                            text: 'Record has created successfully.'
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
        }
    }
</script>
<template>
    <b-form :validated="validated" @submit.prevent.stop="$emit('submit')" novalidate v-if="rules && books">
        <form-row field="name">
            <label slot="label" for="name">Name:</label>
            <form-input slot="component" autocomplete="name" name="name" id="name"
                        v-model="record.name" v-validate="rules.name"
                        :state="errors.has('name') ? false : null"></form-input>
        </form-row>
        <form-row field="author">
            <label slot="label" for="author">Author:</label>
            <form-select class="form-select" slot="component" autocomplete="author" name="author" id="author"
                         label="name" placeholder="Unknown"
                         v-model="author" :options="books" v-validate="rules.author_id"
                         :state="errors.has('author') ? false : null"></form-select>
        </form-row>
        <b-row class="my-2">
            <b-col sm="12" md="8">
                <div class="alert alert-warning" role="alert" v-if="validated && errors.any()">
                    The form contains errors. Please correct them.
                </div>
            </b-col>
        </b-row>
        <slot name="buttons"></slot>
    </b-form>
</template>

<script>
    import FormRow from '../../../common/form/FormRow';
    import {FormInput, FormSelect} from '../../../common/form';

    export default {
        inject: {
            $validator: '$validator'
        },
        data() {
            return {
                books: null,
                author: null
            }
        },
        watch: {
            author(author) {
                this.record.author_id = author ? author.id : null;
            },
            books(books) {
                if(this.record && this.record.author_id !== null) {
                    this.author = books.find(u => u.id === this.record.author_id);
                }
            }
        },
        props: {
            record: Object,
            validated: {
                type: Boolean,
                default: false
            },
            rules: {
                type: Object,
                default: null
            }
        },
        components: {
            FormInput,
            FormSelect,
            FormRow
        },
        methods: {
            fetchBooks() {
                this.loading = true;
                const params = {columns: ['id', 'name'], paginate: 0};
                axios.get('/api/users', {params})
                    .then((response) => {
                        this.books = response.data;
                    }).then(() => {
                    // always executed
                    this.loading = false
                });
            }
        },
        mounted() {
            this.fetchBooks();
        }
    }
</script>

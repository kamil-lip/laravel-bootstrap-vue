import axios from 'axios';

export default {
    methods: {
        deleteRecord(record) {
            axios.delete(route('users.destroy', {id: this.data.id}))
                .then((response) => {
                    this.$notify({
                        group: 'app',
                        type: 'success',
                        title: 'Success',
                        text: 'User has been deleted successfully'
                    });
                    this.$router.replace({name: 'users.index'});
                })
                .catch((error) => {

                    let message = 'An error occurred. User has not been deleted.';

                    this.$notify({
                        group: 'app',
                        type: 'error',
                        title: 'Error',
                        text: message
                    });
                })
        },
        handleDeleteRecordClick(record) {
            this.$confirm('Are you sure?').then((confirmed) => {
                if (confirmed) {
                    this.deleteRecord(record);
                }
            });

        }
    }
}

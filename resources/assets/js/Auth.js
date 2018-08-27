import axios from 'axios';

class Auth {

    constructor() {
        this.profile = null;
    }

    async getProfile(refresh = false) {
        return new Promise((resolve, reject) => {
            if(this.profile !== null) {
                resolve(this.profile);
            } else {
                axios.get('/api/profile').then((response) => {
                    this.profile = response.data;
                    resolve(this.profile);
                }).catch(error => {
                    reject('Error. Could not fetch profile.')
                })
            }
        });
    }
}

export default new Auth();

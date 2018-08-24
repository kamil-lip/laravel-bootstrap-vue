/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from './routes';
import VuePage from './components/VuePage';
import App from './components/layouts/App';
import axios from 'axios';

const router = new VueRouter({
    mode: 'history',
    routes
});

Vue.component('vue-page', VuePage)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

let app = new Vue({
    el: '#app',
    router,
    template: '<app />',
    components: {
        App
    },
    methods: {
        setupAxios() {
            axios.interceptors.response.use((response) => {
                // Do something with response data
                return response;
            }, (error) => {

                let response = error.response;

                if (response.status === 401) {
                    window.location.href = '/';
                    this.$notify({
                        group: 'app',
                        type: 'error',
                        title: 'Error',
                        text: 'You are not authorized to perform this operation'
                    });
                    return false;
                }

                return Promise.reject(error);
            });
        }
    },
    created() {
        this.setupAxios();
    }
});



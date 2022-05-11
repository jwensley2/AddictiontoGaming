/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from 'vue';
import Alert from './components/Alert';

require('./bootstrap');
require('tablesorter');
require('./main');

window.Vue = Vue;

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('alert', Alert);

const app = new Vue({
    el: '#app',
    data() {
        return {
            alertCount: 0,
            alerts: []
        }
    },
    methods: {
        closeAlert(alert) {
            this.alerts.splice(this.alerts.indexOf(alert), 1);
        }
    }
});

app.$on('alert', function (alert) {
    alert.key = this.alertCount++;
    this.alerts.push(alert);
});

export {app};

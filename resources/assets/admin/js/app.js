/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('tablesorter');
require('./main');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('alert', require('./components/Alert.vue'));

const app = new Vue({
    el: '#app',
    data() {
        return {
            alerts: []
        }
    },
    methods: {
        closeAlert(i) {
            this.$data.alerts.splice(i, 1);
        }
    }
});

app.$on('alert', function (alert) {
    this.$data.alerts.push(alert);
});

export {app};
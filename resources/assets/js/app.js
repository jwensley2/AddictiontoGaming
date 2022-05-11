/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import VModal from 'vue-js-modal'
import Vue from 'vue';
import DeleteButton from './components/DeleteButton';
import ConfirmationModal from './components/ConfirmationModal';

require('./bootstrap');
require('./jquery.h5validate');

window.Vue = Vue;

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(VModal, {dialog: true});

Vue.component('delete-button', DeleteButton);
Vue.component('confirmation', ConfirmationModal);

const app = new Vue({
    el: '#app',
});


/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
// import Event from 'ClassesDir/Event'

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// import {
//     TableComponent,
//     TableColumn
// } from 'vue-table-component';
// Vue.component('table-component', TableComponent);
// Vue.component('table-column', TableColumn);
//
// import vueSelect from 'vue-select'
// Vue.component('vueSelect', vueSelect);

/**
 * This is an example of how you would declare a component, you would utilise this by placing <example-component /> in your blade file
 */
//import exampleComponent from 'ComponentsDir/Utilities/ExampleComponent

const app = new Vue({
    el: '#app',
    components: {
        //exampleComponent,
    },
    data() {
        return {
            // fireEvent: window.Event,
            xsrfToken: document.head.querySelector('meta[name="csrf-token"]').content
        }
    },
});

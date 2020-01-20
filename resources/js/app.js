require('./bootstrap');

import ToDoList from './components/ToDoComponent.vue'

window.Vue = require('vue');
window.Fire = new Vue();

Vue.component('toto-application', ToDoList);

const app = new Vue({
    el: '#app',
});

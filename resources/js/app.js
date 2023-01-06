require('./bootstrap');

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

import { createApp } from 'vue';
import { createRouter } from 'vue-router';
import { createWebHashHistory } from 'vue-router';
import Navbar from './components/Navbar.vue';
import IndexContact from './components/ContactIndex.vue';

const routes = [
  {	path: '/',
    component: IndexContact,
    name: 'index' }
];

const router = createRouter({
    history: createWebHashHistory(),
	routes
});

const app = createApp({
  components: {
    Navbar,
    //Footer
  }
})
  .use(router);

app.mount('#app');
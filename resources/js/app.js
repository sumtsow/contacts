require('./bootstrap');

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

import { createApp } from 'vue';
import { createRouter } from 'vue-router';
import { createWebHashHistory } from 'vue-router';
import Navbar from './components/Navbar.vue';
import IndexContact from './components/ContactIndex.vue';
import IndexSubscriber from './components/admin/SubscriberIndex.vue';
import IndexGroup from './components/admin/GroupIndex.vue';
import IndexType from './components/admin/TypeIndex.vue';

const routes = [
  {	path: '/',
    component: IndexContact,
    name: 'index' },
  {	path: '/admin/group',
    component: IndexGroup,
    name: 'index-group' },
  {	path: '/admin/type',
    component: IndexType,
    name: 'index-type' },
  {	path: '/admin',
    component: IndexSubscriber,
    name: 'index-subscriber' },

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
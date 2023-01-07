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
import EditSubscriber from './components/admin/SubscriberEdit.vue';
import IndexGroup from './components/admin/GroupIndex.vue';
import EditGroup from './components/admin/GroupEdit.vue';
import IndexType from './components/admin/TypeIndex.vue';
import EditType from './components/admin/TypeEdit.vue';

const routes = [
  {	path: '/',
    component: IndexContact,
    name: 'index' },
  {	path: '/admin/groups',
    component: IndexGroup,
    name: 'index-group' },
  {	path: '/admin/group/:id',
    component: EditGroup,
    name: 'edit-group' },
  {	path: '/admin/types',
    component: IndexType,
    name: 'index-types' },
  {	path: '/admin/type/:id',
    component: EditType,
    name: 'edit-type' },
  {	path: '/admin',
    component: IndexSubscriber,
    name: 'index-subscriber' },
  {	path: '/admin/subscriber/:id',
    component: EditSubscriber,
    name: 'edit-subscriber' },
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
// resources/js/router.js

import { createRouter, createWebHistory } from 'vue-router';
import HomeComponent from './components/HomeComponent.vue';
import AboutComponent from './components/ExampleComponent.vue';

const routes = [
    {
        path: '/',
        name: 'home',
        component: HomeComponent,
    },
    {
        path: '/about',
        name: 'about',
        component: AboutComponent,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;

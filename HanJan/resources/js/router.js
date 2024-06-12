import { createWebHistory, createRouter } from 'vue-router';
import AppComponent from '../components/AppComponent.vue';
import TraditionalLiquorComponent from '../components/TraditionalLiquorComponent.vue';

const routes = [
    {
        path: '/',
        component: AppComponent,
    },
    {
        path: '/traditionalLiquor',
        component: TraditionalLiquorComponent,
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
import { createWebHistory, createRouter } from 'vue-router';
import TraditionalLiquorComponent from '../components/TraditionalLiquorComponent.vue';
import MainComponent from '../components/MainComponent.vue';
import LoginComponent from '../components/LoginComponent.vue';
import AgreeCompnent from '../components/AgreeComponent.vue';
import BagComponent from '../components/BagComponent.vue';
import ConfirmCompnent from '../components/ConfirmComponent.vue';
import DetailedCompnent from '../components/DetailedComponent.vue';
import ExchangeCompnent from '../components/ExchangeComponent.vue';
import InfoComponent from '../components/InfoComponent.vue';

const routes = [
    {
        path: '/',
        component: MainComponent,
    },
    {
        path: '/traditionalLiquor',
        component: TraditionalLiquorComponent,
    },
    {
        path: '/login',
        component: LoginComponent,
    },
    {
        path: '/agree',
        component: AgreeCompnent,
    },
    {
        path: '/bag',
        component: BagComponent,
    },
    {
        path: '/confirm',
        component: ConfirmCompnent,
    },
    {
        path: '/detailed',
        component: DetailedCompnent,
    },
    {
        path: '/exchange',
        component: ExchangeCompnent,
    },
    {
        path: '/info',
        component: InfoComponent,
    },

];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
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
import InquiryComponent from '../components/InquiryComponent.vue';
import CheckInquiryComponent from '../components/CheckInquiryComponent.vue';
import CheckOneInquiryComponent from '../components/CheckOneInquiryComponent.vue';
import ListTakjuComponent from '../components/ListTakjuComponent.vue';
import OrderComponent from '../components/OrderComponent.vue';
import RegistComponent from '../components/RegistComponent.vue';
import ReviewComponent from '../components/ReviewComponent.vue';
import ReviewCreateComponent from '../components/ReviewCreateComponent.vue';
import UpdateComponent from '../components/UpdateComponent.vue';
import InquiryOneComponent from '../components/InquiryOneComponent.vue';

const routes = [
    {
        path: '/',
        component: MainComponent,
    },
    {
        path: '/traditionalliquor',
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
    {
        path: '/inquiry',
        component: InquiryComponent,
    },
    {
        path: '/inquiryone',
        component: InquiryOneComponent,
    },
    {
        path: '/checkinquiry',
        component: CheckInquiryComponent,
    },
    {
        path: '/checkoneinquiry',
        component: CheckOneInquiryComponent,
    },
    {
        path: '/listtakju',
        component: ListTakjuComponent,
    },
    {
        path: '/order',
        component: OrderComponent,
    },
    {
        path: '/regist',
        component: RegistComponent,
    },
    {
        path: '/review',
        component: ReviewComponent,
    },
    {
        path: '/reviewcreate',
        component: ReviewCreateComponent,
    },
    {
        path: '/update',
        component: UpdateComponent,
    },

];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
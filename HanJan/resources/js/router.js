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
import InquiryProductComponent from '../components/InquiryProductComponent.vue';
import CheckInquiryComponent from '../components/CheckInquiryComponent.vue';
import CheckOneInquiryComponent from '../components/CheckOneInquiryComponent.vue';
import ListTakjuComponent from '../components/ListComponent.vue';
import OrderComponent from '../components/OrderComponent.vue';
import RegistComponent from '../components/RegistComponent.vue';
import ReviewComponent from '../components/ReviewComponent.vue';
import ReviewCreateComponent from '../components/ReviewCreateComponent.vue';
import UpdateComponent from '../components/UpdateComponent.vue';
import InquiryOneByeOneComponent from '../components/InquiryOneByOneComponent.vue';
import NoticeListComponent from '../components/NoticeListComponent.vue';
import NoticeComponent from '../components/NoticeComponent.vue';

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
        path: '/inquiryproduct',
        component: InquiryProductComponent,
    },
    {
        path: '/inquiryonebyone',
        component: InquiryOneByeOneComponent,
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
        path: '/list',
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
    {
        path: '/noticelist',
        component: NoticeListComponent,
    },
    {
        path: '/notice',
        component: NoticeComponent,
    },

];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
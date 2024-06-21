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
import OrderComponent from '../components/OrderComponent.vue';
import OrderCompleteComponent from '../components/OrderCompleteComponent.vue';
import RegistComponent from '../components/RegistComponent.vue';
import ReviewComponent from '../components/ReviewComponent.vue';
import ReviewCreateComponent from '../components/ReviewCreateComponent.vue';
import ReviewUpdateComponent from '../components/ReviewUpdateComponent.vue';
import UpdateComponent from '../components/UpdateComponent.vue';
import QnaProductComponent from '../components/QnaProductComponent.vue';
import QnaOneByeOneComponent from '../components/QnaOneByOneComponent.vue';
import QnaProductDetailComponent from '../components/QnaProductDetailComponent.vue';
import QnaOnebyOneDetailComponent from '../components/QnaOnebyOneDetailComponent.vue';
import NoticeListComponent from '../components/NoticeListComponent.vue';
import NoticeComponent from '../components/NoticeComponent.vue';
import store from './store';
import ListComponent from '../components/ListComponent.vue';

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
        beforeEnter: chkAuth,
    },
    {
        path: '/confirm',
        component: ConfirmCompnent,
        beforeEnter: chkAuth,
    },
    {
        path: '/detailed',
        component: DetailedCompnent,
        beforeEnter: (to, from, next) => {
            console.log(to.query.id);
            store.dispatch('setProductDetailData', to.query.id);
            store.dispatch('setProductReviewData', to.query.id);

            next();
        }
    },
    {
        path: '/exchange',
        component: ExchangeCompnent,
    },
    {
        path: '/info',
        component: InfoComponent,
        beforeEnter: chkAuth,
    },
    {
        path: '/qnaproductcreate',
        component: QnaProductComponent,
        beforeEnter: chkAuth,
    },
    {
        path: '/qnaonebyonecreate',
        component: QnaOneByeOneComponent,
        beforeEnter: chkAuth,
    },
    {
        path: '/qnaproductdetail',
        component: QnaProductDetailComponent,
        beforeEnter: (to, from, next) => {
            chkAuth(to, from, next)
            console.log(to.query.id);
            store.dispatch('getQnaProductDetailData', to.query.id);

            next();
        }, 
    },
    {
        path: '/qnaonebyonedetail',
        component: QnaOnebyOneDetailComponent,
        beforeEnter: (to, from, next) => {
            chkAuth(to, from, next)
            console.log(to.query.id);
            store.dispatch('getQnaOneByOneDetailData', to.query.id);

            next();
        }, 
    },
    {
        path: '/list',
        component: ListComponent,
        beforeEnter: (to, from, next) => {
            console.log(to.query);
            store.commit('setCurrentImage', to.query.type);
            store.dispatch('getList', to.query);

            next();
        }, 
    },
    {
        path: '/order',
        component: OrderComponent,
        beforeEnter: chkAuth,
    },
    {
        path: '/ordercomplete',
        component: OrderCompleteComponent,
        beforeEnter: chkAuth,
    },
    {
        path: '/regist',
        component: RegistComponent,
    },
    {
        path: '/review',
        component: ReviewComponent,
        beforeEnter: chkAuth,
    },
    {
        path: '/reviewcreate',
        component: ReviewCreateComponent,
        beforeEnter: chkAuth,
    },
    {
        path: '/reviewupdate',
        component: ReviewUpdateComponent,
        beforeEnter: chkAuth,
    },
    {
        path: '/update',
        component: UpdateComponent,
        beforeEnter: chkAuth,
    },
    {
        path: '/noticelist',
        component: NoticeListComponent,
        // beforeEnter: (to, from, next) => {
        //     console.log(to.query.page);
        //     store.dispatch('getNoticeData', to.query.page);

        //     next();
        // },
    },
    {
        path: '/notice',
        component: NoticeComponent,
        beforeEnter: (to, from, next) => {
            console.log(to.query.id);
            store.dispatch('getNoticeDetailData', to.query.id);

            next();
        }
    },

];

function chkAuth(to, from, next) {
    if(store.state.authFlg) {
        next();
    } else {
        alert('로그인이 필요한 서비스입니다.');
        next('/login');
    }
};

const router = createRouter({
    // 뒤로가기 했을때는 스크롤 위치 저장, 그 외는 최상단으로
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition
        } else {
            return { top: 0 }
        }
    },
    history: createWebHistory(),
    routes,
});

export default router;
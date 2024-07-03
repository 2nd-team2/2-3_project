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
import ErrorsComponent from '../components/ErrorsComponent.vue';
import AdminAppComponent from '../components/admin/AdminAppComponent.vue';
import AdminLoginComponent from '../components/admin/AdminLoginComponent.vue';
import AdminTestComponent from '../components/admin/AdminTestComponent.vue';

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
            // 숫자인지 검증
            const validId = /^\d+$/; 
            const IdValue = parseInt(to.query.id, 10);

            if(
                validId.test(to.query.id) &&
                IdValue >= 1 &&
                IdValue <= 68
            ) {
                // 유효한 경우
                store.dispatch('setProductDetailData', to.query.id);
                store.dispatch('setProductReviewData', to.query.id);
                next();
            } else {
                // 유효하지 않은 경우 에러 페이지로 리디렉션
                next({ name: 'NotFound' });
            }
        }
    },
    {
        path: '/exchange',
        component: ExchangeCompnent,
        beforeEnter: (to, from, next) => {
            chkAuth(to, from, next)
            store.dispatch('exchangeProduct', to.query.id);

            next();
        }, 
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
            store.dispatch('getQnaProductDetailData', to.query.id);

            next();
        }, 
    },
    {
        path: '/qnaonebyonedetail',
        component: QnaOnebyOneDetailComponent,
        beforeEnter: (to, from, next) => {
            chkAuth(to, from, next)
            store.dispatch('getQnaOneByOneDetailData', to.query.id);

            next();
        }, 
    },
    // {
    //     path: '/list',
    //     component: ListComponent,
    //     beforeEnter: (to, from, next) => {
    //         // 베스트 상품
    //         store.commit('setCurrentImage', to.query.type);
    //         // 리스트 상품
    //         store.dispatch('getList', to.query);

    //         next();
    //     },
    // },
    {
        path: '/list',
        component: ListComponent,
        beforeEnter: (to, from, next) => {
            // 쿼리 파라미터 검증
            // 유효한 type 값들
            const validTypes = ['99', '0', '1', '2']; 
            // 숫자인지 검증
            const validPage = /^\d+$/; 

            const pageValue = parseInt(to.query.page, 10);
    
            if (
                validTypes.includes(to.query.type) &&
                validPage.test(to.query.page) &&
                pageValue >= 1 &&
                pageValue <= 68
            ) {
                // 유효한 경우
                store.commit('setCurrentImage', to.query.type);
                store.dispatch('getList', to.query);
                next();
            } else {
                // 유효하지 않은 경우 에러 페이지로 리디렉션
                next({ name: 'NotFound' });
            }
        }
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
            store.dispatch('getNoticeDetailData', to.query.id);

            next();
        }
    },

    // --------------------------------------------------------------------- 관리자 페이지 -------------------------------------------------------------------------
    {
        path: '/admin',
        component: AdminLoginComponent,
        beforeEnter: chkAdmin
    },
    {
        path: '/admin/main',
        component: AdminAppComponent,
        beforeEnter: chkAdmin
    },
    {
        path: '/admin/test',
        component: AdminTestComponent,
        beforeEnter: chkAdmin
    },
    // 에러 페이지
    {
        path: '/:pathMatch(.*)*',
        name: 'NotFound',
        component: ErrorsComponent,
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
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition
        } else if (to.path === '/list' && to.query.page !== undefined) {
            // 페이지 번호를 숫자로 변환
            const pageNumber = parseInt(to.query.page);
            if (!isNaN(pageNumber) && pageNumber > 0) {
                // 새로고침 시 뷰포트 높이의 60% 위치로 스크롤
                const viewportHeight = window.innerHeight;
                return pageNumber === 1 ? { top: 0 } : { top: viewportHeight * 0.6 };
            }
        } 
        else {
            return { top: 0 }
        }
    },
    history: createWebHistory(),
    routes,
});

const restrictedPaths = ['/login', '/agree', '/regist']; 

router.beforeEach((to, from, next) => {
    const isAuthenticated = store.state.authFlg;
    if (isAuthenticated && restrictedPaths.includes(to.path)) {
        alert('이미 로그인한 상태입니다.');
        next(false);
        router.back(); 
    } else {
        next();
    }
});

// --------------------------------------------------------------------- 관리자 페이지 -------------------------------------------------------------------------
function chkAdmin(to, from, next) {
    store.commit('setAdminFlg', to.path.includes('admin'));
    console.log('chkAdmin');
}


export default router;
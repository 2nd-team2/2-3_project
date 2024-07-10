import axios from 'axios';
import { createStore } from 'vuex';
import router from './router';
import Cookies from 'js-cookie';

const store = createStore({
    state() {
        return {
            // ----------------------- 보원 시작 -------------------------
            // 장바구니 리스트
            bagsProductData: [],
            // 리뷰 리스트
            // reviewData: [],
            reviewData: localStorage.getItem('reviewData') ? JSON.parse(localStorage.getItem('reviewData')) : {current_page: '1'},
            // 리뷰관리 > 리뷰수정으로 데이터 넘기기(로컬스토리지에 저장하기 - 새로고침 누를시 없어지는 걸 방지)
            // reviewUpdateData :[],
            reviewToUpdate: localStorage.getItem('reviewToUpdate') ? JSON.parse(localStorage.getItem('reviewToUpdate')) : null,
            // 전체 선택 여부
            allChecked: false,
            // 장바구니 데이터 > 주문 페이지로 넘기기
            // bagsToOrder: [],
            orderProductData: localStorage.getItem('orderProductData') ? JSON.parse(localStorage.getItem('orderProductData')) : null,
            // 결제하기 > 주문 번호 저장
            exchangeProduct : [],
            // 카카오 로그인 이메일 데이터
            kakaoInfo: localStorage.getItem('kakaoInfo') ? JSON.parse(localStorage.getItem('kakaoInfo')) : null,
            // 이메일 인증
            // email: localStorage.getItem('email') ? JSON.parse(localStorage.getItem('email')) : null,
            email: localStorage.getItem('email') ? localStorage.getItem('email') : null,
            emailVerify: localStorage.getItem('emailVerify') ? localStorage.getItem('emailVerify') : true,
            emailCode: localStorage.getItem('emailCode') ? localStorage.getItem('emailCode') :  true,
            
            // ----------------------- 보원 끝 ---------------------------
            // ----------------------- 성환 시작 -------------------------
            // 다크모드 쿠키
            isDarkMode: false,
            // 유저정보
            authFlg: document.cookie.indexOf('auth=') >= 0 ? true : false,
            userInfo: localStorage.getItem('userInfo') ? JSON.parse(localStorage.getItem('userInfo')) : null,
            // 주문 목록
            infoData: localStorage.getItem('infoData') ? JSON.parse(localStorage.getItem('infoData')) : {current_page: '1'},
            // 1:1 문의 목록
            askSetData: localStorage.getItem('askSetData') ? JSON.parse(localStorage.getItem('askSetData')) : {current_page: '1'},
            // 상품 문의 목록
            productAskData: localStorage.getItem('productAskData') ? JSON.parse(localStorage.getItem('productAskData')) : {current_page: '1'},
            // ----------------------- 성환 끝 ---------------------------
            // ----------------------- 민서 시작 -------------------------
            // 상품 정보
            productDetail: {},
            // 베스트 정보
            bastData: [],
            // 상품 게시물 리스트
            listData: localStorage.getItem('listData') ? JSON.parse(localStorage.getItem('listData')) : {current_page: '1'},
            // 검색 상품 게시물 리스트
            searchListData: localStorage.getItem('searchListData') ? JSON.parse(localStorage.getItem('searchListData')).data : [],
            // 리뷰 게시물 리스트
            reviewDetail: [],
            // 디테일->장바구니 데이터 보내기
            CountData: [],
            // 리스트페이지 메인 이미지
            currentImage: '',
            // 키워드
            typeChk: [],
            // 상세페이지 에서 주문페이지으로 데이터 넘기기(로컬스토리지에 저장하기 - 새로고침 누를시 없어지는 걸 방지)
            // detailedUpdate: localStorage.getItem('detailedUpdate') ? JSON.parse(localStorage.getItem('detailedUpdate')) : null,
            // ----------------------- 민서 끝 ---------------------------
            // ----------------------- 호경 시작 -------------------------
            // 계절
            season: '',
            // 계절 추천 리스트
            seasonData: [],
            // 리뷰 게시물 리스트
            reviewListData: [],
            // 공지사항 게시물 리스트
            noticeData: localStorage.getItem('noticeData') ? JSON.parse(localStorage.getItem('noticeData')) : {current_page: '1'},
            // 공지사항 디테일 정보
            noticeDetail: {},
            // 상품문의 디테일
            qnaProductDetailData: [],
            // 1 : 1 문의 디테일
            qnaOneByOneDetailData: [],
            // 주문 목록
            productAskCreateData: localStorage.getItem('productAskCreateData') ? JSON.parse(localStorage.getItem('productAskCreateData')) : null,
            // 전통주 설명 데이터
            // TraditionalLiquorData: [],
            // 전통주 설명 데이터
            TraditionalLiquorData: localStorage.getItem('TraditionalLiquorData') ? JSON.parse(localStorage.getItem('TraditionalLiquorData')) : [],
            // ----------------------- 호경 끝 ---------------------------

            // --------------------------------------------------------------------- 관리자 페이지 -------------------------------------------------------------------------
            // ----------------------- 보원 시작 ---------------------------
            // ----------------------- 보원 끝 ---------------------------

            // ----------------------- 성환 시작 ---------------------------
            // ----------------------- 성환 끝 ---------------------------

            // ----------------------- 민서 시작 ---------------------------
            // ----------------------- 민서 끝 ---------------------------

            // ----------------------- 호경 시작 ---------------------------
            // 초기 관리자 페이지 입장 플래그
            adminFlg: false,
            // 로그인 플래그
            adminLoginFlg: document.cookie.indexOf('auth=') >= 0 ? true : false,
            // 월별 유저 통계
            userTatisticsData: [],
            // 유저 연령대 통계
            userAgeRangeData: [],
            // 매출 통계
            salesStatisticsData: [],
            // 관리자 페이지 전체 유저 리스트
            adminUserData: localStorage.getItem('adminUserData') ? JSON.parse(localStorage.getItem('adminUserData')) : {current_page: '1'},
            // 관리자 페이지 전체 상품 리스트
            adminProductData: localStorage.getItem('adminProductData') ? JSON.parse(localStorage.getItem('adminProductData')) : {current_page: '1'},
            // 관리자 페이지 전체 주문 리스트
            adminOrderData: localStorage.getItem('adminOrderData') ? JSON.parse(localStorage.getItem('adminOrderData')) : {current_page: '1'},
            // 관리자 페이지 전체 교환 및 반품 리스트
            adminExchangeData: localStorage.getItem('adminExchangeData') ? JSON.parse(localStorage.getItem('adminExchangeData')) : {current_page: '1'},
            // 관리자 페이지 전체 1:1문의 리스트
            adminOneByOneData: localStorage.getItem('adminOneByOneData') ? JSON.parse(localStorage.getItem('adminOneByOneData')) : {current_page: '1'},
            // 관리자 페이지 전체 상품문의 리스트
            adminProductQnaData: localStorage.getItem('adminProductQnaData') ? JSON.parse(localStorage.getItem('adminProductQnaData')) : {current_page: '1'},
            // 관리자 페이지 전체 공지사항 리스트
            adminNoticeData: localStorage.getItem('adminNoticeData') ? JSON.parse(localStorage.getItem('adminNoticeData')) : {current_page: '1'},
            // 상품 디테일
            adminProdcutDetailData: [],
            // 공지사항 디테일
            adminNoticeDetailData: [],
            // 유저 정보 수정
            adminUserToUpdate: localStorage.getItem('adminUserToUpdate') ? JSON.parse(localStorage.getItem('adminUserToUpdate')) : null,
            // 상품 수정
            adminProductToUpdate: localStorage.getItem('adminProductToUpdate') ? JSON.parse(localStorage.getItem('adminProductToUpdate')) : null,
            // 상품문의 답변 작성
            adminProductQnaToUpdate: localStorage.getItem('adminProductQnaToUpdate') ? JSON.parse(localStorage.getItem('adminProductQnaToUpdate')) : null,
            // 1:1문의 답변 작성
            adminOneByOneToUpdate: localStorage.getItem('adminOneByOneToUpdate') ? JSON.parse(localStorage.getItem('adminOneByOneToUpdate')) : null,
            // 공지사항 수정
            adminNoticeToUpdate: localStorage.getItem('adminNoticeToUpdate') ? JSON.parse(localStorage.getItem('adminNoticeToUpdate')) : null,
            // ----------------------- 호경 끝 ---------------------------
        }

    },
    mutations: {
        // ----------------------- 보원 시작 -------------------------
        
        // state.장바구니에 추가 될 리스트
        bagsSetProductData(state, data) {
            state.bagsProductData = data;
        },
        // state.리뷰에 추가 될 리스트
        reviewSetData(state, data) {
            state.reviewData = data;
            localStorage.setItem('reviewData', JSON.stringify(data));
        },
        // 리뷰관리에서 수정 페이지로 넘어갈때 데이터 전달
        reviewToUpdate(state, data) {
            state.reviewToUpdate = data;
            localStorage.setItem('reviewToUpdate', JSON.stringify(data));
        },
        // state.주문에 추가 될 리스트
        orderProductData(state, data) {
            state.orderProductData = data;
            localStorage.setItem('orderProductData', JSON.stringify(data));
        },
        exchangeProduct(state, data) {
            state.exchangeProduct = data;
        },
        // 카카오 로그인 정보 저장
        kakaoInfo(state, data) {
            state.kakaoInfo = data;
            localStorage.setItem('kakaoInfo', JSON.stringify(data));
        },
        // 이메일 인증
        setEmail(state, email) {
            state.email = email;
            // localStorage.setItem('email', JSON.stringify(email));
            localStorage.setItem('email', email);
        },
        setEmailVerify(state, status) {
            state.emailVerify = status;
            localStorage.setItem('emailVerify', status);
        },
        setEmailCode(state, status) {
            state.emailCode = status;
            localStorage.setItem('emailCode', status);
        },

        // ----------------------- 보원 끝 ---------------------------
        // ----------------------- 성환 시작 -------------------------
        setDarkMode(state, isDarkMode) {
            state.isDarkMode = isDarkMode;
        },
        // 인증 플래그 저장
        setAuthFlg(state, flg) {
            state.authFlg = flg;
        },
        //유저 정보 저장
        setUserInfo(state, userInfo) {
            state.userInfo = userInfo;
        },
        // 마이페이지 주문목록
        infoSetData(state, data) {
            state.infoData = data;
            localStorage.setItem('infoData', JSON.stringify(data))
        },
        // 상품문의목록
        productAskSetData(state, data) {
            state.productAskData = data;
            localStorage.setItem('productAskData', JSON.stringify(data))
        },
        // 1:1문의 목록
        askSetData(state, data) {
            state.askSetData = data;
            localStorage.setItem('askSetData', JSON.stringify(data))
        },
        // ----------------------- 성환 끝 ---------------------------
        // ----------------------- 민서 시작 -------------------------
        
        // 상품리스트
        listInfoData(state, data) {
            state.listData = data;
            localStorage.setItem('listData', JSON.stringify(data));
        },
        // 검색 상품리스트
        setSearchdata(state, data) {
            state.searchListData = data.data;
            localStorage.setItem('searchListData', JSON.stringify(data));
        },
        // 베스트리스트
        listBastData(state, data) {
            state.bastData = data;
        },
        // 상품리스트 데이터 보내기
        detailedNumData(state, data) {
            state.productDetail = data;
        },
        // 리뷰 데이터 보내기
        detailedReviewData(state, data) {
            state.reviewDetail = data;
        },
        // 디테일->장바구니 데이터 보내기
        detailedCountData(state, data) {
            state.CountData = data;
        },
        // 리스트 페이지 메인 이미지 변경
        setCurrentImage(state, type) {
            state.currentImage = '/img/list_img' + type + '.png';
        },
         // 상세페이지에서 주문페이지로 넘어갈때 데이터 전달
        setdetailedUpdate(state, data) {
            state.orderProductData = data;
            localStorage.setItem('orderProductData', JSON.stringify(data));
        },
        // 키워드
        listTypeChk(state, data) {
            state.typeChk = data;
        },
        // ----------------------- 민서 끝 ---------------------------
        // ----------------------- 호경 시작 -------------------------
        // 계절 
        setSeason(state, data) {
            state.season = data;
        },
        // 계절 추천 리스트
        setSeasonListData(state, data) {
            state.seasonData = data;
        },
        // 리뷰 게시물 리스트
        setReviewListData(state, data) {
            state.reviewListData = data;
        },
        // 공지사항 게시물 리스트
        setNoticeData(state, data) {
            state.noticeData = data;
            localStorage.setItem('noticeData', JSON.stringify(data))
        },
        // 공지사항 디테일 저장
        setNoticeDetailData(state, data) {
            state.noticeDetail = data;
        },
        // 상품문의내역 디테일
        setQnaProductDetailData(state, data) {
            state.qnaProductDetailData = data;
        },
        // 상품문의내역 작성 게시글 가장 앞에 추가
        setUnshiftQnaProductData(state, data) {
            state.qnaProductDetailData = data;
        },
        // 1 : 1 문의내역 디테일
        setQnaOneByOneDetailData(state, data) {
            state.qnaOneByOneDetailData = data;
        },
        // 1:1문의내역 작성 게시글 가장 앞에 추가
        setUnshiftQnaOneByOneData(state, data) {
            state.qnaOneByOneDetailData.unshift(data);
        },
        // 상품 문의 작성 게시글 정보
        setProductAskCreateData(state, data) {
            state.productAskCreateData = data;
            localStorage.setItem('productAskCreateData', JSON.stringify(data))
        },
        // 전통주 설명
        // setTraditionalLiquorData(state, data) {
        //     state.TraditionalLiquorData = data;
        // },
        // 전통주 설명
        setTraditionalLiquorData(state, data) {
            state.TraditionalLiquorData = data;
            localStorage.setItem('TraditionalLiquorData', JSON.stringify(data))
        },
        // ----------------------- 호경 끝 ---------------------------

        // --------------------------------------------------------------------- 관리자 페이지 -------------------------------------------------------------------------
        // ----------------------- 보원 시작 ---------------------------
        // ----------------------- 보원 끝 ---------------------------

        // ----------------------- 성환 시작 ---------------------------
        // ----------------------- 성환 끝 ---------------------------

        // ----------------------- 민서 시작 ---------------------------
        // ----------------------- 민서 끝 ---------------------------

        // ----------------------- 호경 시작 ---------------------------
        setAdminFlg(state, flg) {
            state.adminFlg = flg;
        },
        // 인증 플래그 저장
        setAdminLoginFlg(state, flg) {
            state.adminLoginFlg = flg;
        },
        // 월별 유저 통계
        setUserTatisticsData(state, data) {
            state.userTatisticsData = data;
        },
        // 유저 연령대 통계
        setUserAgeRangeData(state, data) {
            state.userAgeRangeData = data;
        },
        // 매출 통계
        setSalesStatisticsData(state, data) {
            state.salesStatisticsData = data;
        },
        // 전체 유저 정보
        setAdminUsersData(state, data) {
            state.adminUserData = data;
            localStorage.setItem('adminUserData', JSON.stringify(data))
        },
        // 전체 상품 정보
        setAdminProductsData(state, data) {
            state.adminProductData = data;
            localStorage.setItem('adminProductData', JSON.stringify(data))
        },
        // 전체 주문 정보
        setAdminOrdersData(state, data) {
            state.adminOrderData = data;
            localStorage.setItem('adminOrderData', JSON.stringify(data))
        },
        // 전체 교환 및 반품 정보
        setAdminExchangesData(state, data) {
            state.adminExchangeData = data;
            localStorage.setItem('adminExchangeData', JSON.stringify(data))
        },
        // 전체 1:1문의 정보
        setAdminOneByOnesData(state, data) {
            state.adminOneByOneData = data;
            localStorage.setItem('adminOneByOneData', JSON.stringify(data))
        },
        // 전체 상품문의 정보
        setAdminProductQnasData(state, data) {
            state.adminProductQnaData = data;
            localStorage.setItem('adminProductQnaData', JSON.stringify(data))
        },
        // 전체 공지사항 정보
        setAdminNoticesData(state, data) {
            state.adminNoticeData = data;
            localStorage.setItem('adminNoticeData', JSON.stringify(data))
        },
        // 상품 목록 게시글 가장 앞에 추가
        setUnshiftAdminProductData(state, data) {
            state.adminProdcutDetailData.unshift(data);
        },
        // 공지사항 작성 게시글 가장 앞에 추가
        setUnshiftAdminNoticeData(state, data) {
            state.adminNoticeDetailData.unshift(data);
        },
        // 유저 목록에서 수정 페이지로 넘어갈때 데이터 전달
        setAdminUserToUpdate(state, data) {
            state.adminUserToUpdate = data;
            localStorage.setItem('adminUserToUpdate', JSON.stringify(data));
        },
        // 상품 목록에서 수정 페이지로 넘어갈때 데이터 전달
        setAdminProductToUpdate(state, data) {
            state.adminProductToUpdate = data;
            localStorage.setItem('adminProductToUpdate', JSON.stringify(data));
        },
        // 상품문의 리스트에서 답변 페이지로 넘어갈때 데이터 전달
        setadminProductQnaToUpdate(state, data) {
            state.adminProductQnaToUpdate = data;
            localStorage.setItem('adminProductQnaToUpdate', JSON.stringify(data));
        },
        // 1:1문의 리스트에서 답변 페이지로 넘어갈때 데이터 전달
        setadminOneByOneToUpdate(state, data) {
            state.adminOneByOneToUpdate = data;
            localStorage.setItem('adminOneByOneToUpdate', JSON.stringify(data));
        },
        // 공지사항 리스트에서 수정 페이지로 넘어갈때 데이터 전달
        setAdminNoticeToUpdate(state, data) {
            state.adminNoticeToUpdate = data;
            localStorage.setItem('adminNoticeToUpdate', JSON.stringify(data));
        },
        // ----------------------- 호경 끝 ---------------------------

    },actions: {
        // ----------------------- 보원 시작 -------------------------

        /**
         * 장바구니에 최초 게시글 획득
         * 
         * @param {*} context
         */
        bagsGetProductData(context) {
            const url = '/api/bagsProduct';

            axios.get(url)
            .then(response => {
                // 데이터베이스->서버를 통해 받은 데이터를 bagsProductData에 저장
                context.commit('bagsSetProductData', response.data.data);
            })
            .catch(error => {
                alert('장바구니 상품 획득에 실패했습니다.(' + error.response.data.code + ')' )
            });
        },

        /**
         * 장바구니에 수량 감소한 데이터 저장
         * 
         * @param {*} context
         * @param {*} ba_id
         */
        bagsCountMinus(context, $ba_id) {
            const url = '/api/bagsCountMinus/' + $ba_id;

            axios.post(url)
            .then(response => {
                console.log(response.data.data);
            })
            .catch(error => {
                alert('수량 감소에 실패했습니다.(' + error.response.data.code + ')' )
            });
        },
        /**
         * 장바구니에 수량 증가한 데이터 저장
         * 
         * @param {*} context
         * @param {*} ba_id
         */
        bagsCountPlus(context, $ba_id) {
            const url = '/api/bagsCountPlus/' + $ba_id;

            axios.post(url)
            .then(response => {
                console.log(response.data.data);
            })
            .catch(error => {
                alert('수량 감소에 실패했습니다.(' + error.response.data.code + ')' )
            });
        },
        /**
         * 장바구니에 수량 입력 데이터 저장
         * 
         * @param {*} context
         * @param {*} $item
         */
        bagsCountChange(context, $item) {
            const url = '/api/bagsCountChange/' + $item.ba_id;
            // const item = $item.ba_count;
            const item = $item

            axios.post(url, item)
            .then(response => {
                console.log(response.data.data);
            })
            .catch(error => {
                alert('수량 입력에 실패했습니다.(' + error.response.data.code + ')' )
            });
        },

        /**
         * 장바구니에서 휴지통 버튼 클릭시 목록에서 삭제
         * 
         * @param {*} context
         * @param {*} ba_id
        */
        bagsDelete(context, ba_id) {
            const url = '/api/bagsDelete/' + ba_id;

            if (confirm('확인을 누르면 장바구니에서 삭제됩니다.')) {
                axios.delete(url)
                .then(response => {
                    console.log(response.data); // TODO : 삭제
                    store.dispatch('bagsGetProductData');
                })
                .catch(error => {
                    alert('장바구니 삭제에 실패했습니다.(' + error.response.data.code + ')' )
                });

            }

        },

        /**
         * 장바구니 페이지에서 선택된 상품만 삭제 처리
         * 
         * @param {*} context
         * @param {*} data
        */
        bagsSelectDelete(context, data) {
            const url = '/api/bagsSelectDelete';
    
            axios.post(url, data, {
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then(response => {
                console.log('응답 데이터:', response.data); // 응답 데이터 확인
                store.dispatch('bagsGetProductData'); // 데이터 갱신
            })
            .catch(error => {
                console.error('삭제 실패:', error);
                alert('장바구니 선택 삭제에 실패했습니다.');
            });
        },

        // bagsSelectDelete(context, data ) {
        //     const url = '/api/bagsSelectDelete/'
        //     // 선택된 데이터만 들고 와야되기 때문에 vue에서 먼저 처리후 데이터 넘겨줌
        //     // const data = new FormData(document.querySelector('#bagsProductData'));
        //     console.log('store에서 data 받오는 거 확인'); // TODO
        //     console.log(data);

        //     axios.post(url, data, {
        //         headers: {
        //             'Content-Type': 'application/json',
        //         }
        //     })
        //     .then(response => {
        //         console.log(response.data.data); // TODO : 삭제
        //         store.dispatch('bagsGetProductData');
        //     })
        //     .catch(error => {
        //         alert('장바구니 선택 삭제에 실패했습니다.(' + error.response.data.code + ')' )
        //     });
        // },

        /**
         * 장바구니 페이지에서 선택된 상품만 주문 페이지로 정보 전달
         * 
         * @param {*} context
         * @param {*} data
        */
        bagsToOrder(context, data) {
            
            const orderProductData = data;

            context.commit('orderProductData', orderProductData);
            localStorage.setItem('orderProductData', JSON.stringify(orderProductData));

            router.push('/order');
        },

        /**
         * order(주문) 페이지에서 결제하기 처리
         * 실제 결제하기 기능은 없고 각 테이블에 데이터 처리만 수행
         * 
         * @param {*} context
         * @param {*} orderComplete
        */
        orderComplete(context, orderComplete) {
            let orderItems = [];

            if(Array.isArray(store.state.orderProductData)){
                // store.state.orderProductData가 배열인 경우
                orderItems = store.state.orderProductData.map(item => (
                    { ...orderComplete, ...item }));
            } else if (typeof store.state.orderProductData === 'object') {
                // store.state.orderProductData가 객체인 경우
                orderItems = [ { ...orderComplete, ...store.state.orderProductData } ]; // 객체를 배열로 변환하여 저장
            } else {
                console.error('Invalid orderProductData format in Vuex state.');
                return; // 예외 처리: 유효하지 않은 데이터 형식인 경우 종료
            }

            const data = JSON.stringify({ data: orderItems}); // 키값을 포함하여 서버에 전달
            console.log(data); // TODO : 삭제
            const url = '/api/orderTrans';

            axios.post(url, data)
            router.push('/ordercomplete'); 

        },

        // orderComplete(context, bagsToOrder) {   
        //     if(confirm('확인을 누르면 결제가 진행됩니다.')) {
        //         // 1. orders테이블에 주문 데이터 저장 처리
        //         const url = '/api/orderComplete';
        //         const data = new FormData(document.querySelector('#orderComplete'));

        //         axios.post(url, data)
        //         .then(response => {
        //             console.log('주문 테이블 완료');

        //             // 2. orderproducts테이블에 주문 상품 데이터 저장 처리
        //             const url = '/api/orderProductComlete/' + response.data.data.or_id;
        
        //             axios.post(url, bagsToOrder)
        //             .then(response => {
        //                 console.log('주문상품 테이블 완료');

        //                 response.data.data.forEach(item => {
        //                     // 3. 구매확정(completes) 테이블 생성 (co_flg === 0 으로 초기데이터 생성)
        //                     // 4. 교환 및 반품(exchanges) 테이블 생성 (ex_flg === 0 으로 초기데이터 생성)
        //                     const multiUrl = '/api/orderComEx/' + item.orp_id;

        //                     axios.post(multiUrl)
        //                     .then(response => {
        //                         console.log('구매확정, 교환 및 반품 테이블 완료')
    
        //                         // TODO :
        //                         // 5. 장바구니에서 삭제 (장바구니 페이지에서 주문할 경우에만 적용)
        //                         // if(조건) {
        //                             // 장바구니에서 구매 완료시
        //                             // 주문 완료 시 장바구니 deleted_at 수정 처리
        //                             const url = '/api/bagsCompleteDelete';
            
        //                             axios.post(url, bagsToOrder)
        //                             .then(response => {
        //                                 console.log('주문 완료 > 장바구니 삭제')
        //                                 // 주문완료 페이지로 이동
        //                                 router.push('/ordercomplete');
        //                             })
        //                             .catch(error => {
        //                                 alert('결제에 실패하였습니다.-장바구니삭제(' + error.response.data.code + ')' )
        //                             });
        //                         // } else {
        //                         //     // 바로구매에서 구매 완료시
        //                         //     router.push('/ordercomplete');
        //                         // }
    
        //                     })
        //                     .catch(error => {
        //                         alert('결제에 실패하였습니다.-구매확정, 교환 및 반품(' + error.response.data.code + ')' )
        //                     });
        //                 })
        //             })
        //             .catch(error => {
        //                 alert('결제에 실패하였습니다.-주문 상품(' + error.response.data.code + ')' )
        //             });
        //         })
        //         .catch(error => {
        //             alert('결제에 실패하였습니다.-주문(' + error.response.data.code + ')' )
        //         });
        //     }
        // },

        /**
         * 리뷰관리에 최초 게시글 획득
         * 
         * @param {*} context
         * @param {*} page
        */
        reviewGet(context, page) {
            const param = page == 1 ? '' : '?page=' + page;
            const url = '/api/review' + param;
            
            axios.get(url)
            .then(response => {
               // 데이터베이스->서버를 통해 받은 데이터를 reviewtData에 저장
                context.commit('reviewSetData', response.data.data);
            })
            .catch(error => {
                alert('리뷰 획득에 실패하였습니다.(' + error.response.data.code + ')' )
            });
        },  

        /**
         * 리뷰관리에서 리뷰 수정페이지로 이동
         * 
         * @param {*} context
         * @param {*} item
        */
        reviewUpdate(context, item) {
            const reviewUpdateData = item;

            context.commit('reviewToUpdate', reviewUpdateData);
            localStorage.setItem('reviewToUpdate', JSON.stringify(reviewUpdateData));

            router.replace('/reviewupdate');
        },

        /**
         * 리뷰관리에서 리뷰 삭제
         * 
         * @param {*} context
         * @param {*} re_id
        */
        reviewDelete(context, re_id) {
            const url = '/api/reviewDelete/' + re_id;
            
            if (confirm('확인을 누르면 작성한 리뷰가 삭제됩니다. \n리뷰 삭제 시 다시 작성할 수 없습니다.')) {
                axios.delete(url)
                .then(responseData => {
                    context.dispatch('reviewGet', lastItemPaginate(context.state.reviewData));
                })
                .catch(error => {
                    alert('리뷰 삭제에 실패했습니다.(' + error.response.data.code + ')' )
                });

            }
        },

        /**
         * 리뷰작성에서 작성 완료
         * 
         * @param {*} context
        */
        reviewCreateSubmit(context) {
            const url = '/api/reviewCreateSubmit';
            const data = new FormData(document.querySelector('#reviewCreateForm'));

            axios.post(url, data)
            .then(response => {
                console.log(response.data.data); // TODO : 삭제


                //context.commit('reviewToUpdate', response.data.data);
                // localStorage.setItem('reviewToUpdate', JSON.stringify(response.data.data));

                alert('리뷰 작성을 완료하였습니다.');

                router.replace('/review');
            })
            .catch(error => {
                console.log(error.response); //  TODO : 삭제
                // 별점이 0점인경우
                if(error.response.data.code === 're_star_zero'){
                    alert('별점을 입력해주세요.' )
                }
                // 그 외
                else {
                    alert('리뷰 작성에 실패하였습니다.(' + error.response.data.code + ')' )
                }
            });
        }, 

        /**
         * 리뷰수정에서 수정 완료
         * 
         * @param {*} context
        */
        reviewUpdateSubmit(context) {
            const url = '/api/reviewUpdateSubmit';
            const data = new FormData(document.querySelector('#reviewUpdateForm'));

            axios.post(url, data)
            .then(response => {

                context.commit('reviewToUpdate', response.data.data);
                localStorage.setItem('reviewToUpdate', JSON.stringify(response.data.data));

                if(confirm('리뷰 수정을 완료하였습니다. \n확인을 누르면 리뷰 관리로 돌아갑니다.')){
                    router.replace('/review');
                }
            })
            .catch(error => {
                alert('리뷰 수정에 실패하였습니다.(' + error.response.data.code + ')' )
            });
        }, 


        /**
         * 교환 및 반품 페이지 초기값 획득
         * 
         * @param {*} context 
         */
        exchangeProduct(context, id) {
            const url = '/api/exchangeProduct/' + id;
            
            axios.get(url)
            .then(response => {
                console.log(response.data); // TODO
                context.commit('exchangeProduct', response.data.data);
            })
            .catch(error => {
                console.log(error.response); // TODO
                alert('교환 및 반품 데이터 습득에 실패했습니다.(' + error.response.data.code + ')');
            });
        },

        /**
         * 교환 및 반품 처리
         * 
         * @param {*} context 
         */
        exchage(context) {
            const url = '/api/exchage';
            const data = new FormData(document.querySelector('#exchage'));

            if (confirm('확인을 누르면 교환 및 반품 신청이 완료 됩니다.')) {
                axios.post(url, data)
                .then(response => {
                    console.log(response.data); // TODO 
                    alert('교환 및 반품이 완료 되었습니다.')
                    router.push('/info');
                })
                .catch(error => {
                    console.log(error.response); // TODO

                    if (error.response.data.code === 'E01') {
                        alert('교환 및 반품 사유, 회수 정보를 확인해주세요.');
                    } else {
                        alert('교환 및 반품에 실패했습니다.(' + error.response.data.code + ')');
                    }
                });
            }
            
            
        },
        /**
         * 카카오 로그인 처리
         * 
         * @param {*} context 
         * @param {*} response.data 
         */

        kakaoLogin(context, data) {
            const url = '/api/kakaoLogin'

            axios.post(url, data)
            .then(response => {
                console.log('카카오 로그인 정보 저장 성공')

                localStorage.setItem('userInfo', JSON.stringify(response.data.data));
                context.commit('setUserInfo', response.data.data);

                context.commit('setAuthFlg', true);

                localStorage.removeItem('kakaoInfo');

                router.replace('/'); // 메인 페이지로 이동
            })
            .catch(error => {
                console.log(error.response); // TODO
                alert('카카오 로그인 정보 저장 실패.(' + error.response.data.code + ')');
            });
        },

        /**
         * 이메일 검증
         *  >> 이메일 중복체크 먼저 진행 후 검증 코드 전송
         * 
         * @param {*} context 
         * @param {*} emailText
         */
        // async chkEmailOn(context, emailText) { 
        chkEmailOn(context, emailText) { 
            const url = '/api/sendVerificationEmail';

            axios.post(url, {email: emailText})
            .then(response => {
                if (response.data.code === '1') {
                    alert('유효하지 않은 이메일입니다.');
                } else if (response.data.code === '2') {
                    alert('이미 사용 중인 이메일입니다.');
                } else if (response.data.code === '3') {
                    alert('인증 메일 발송 중 오류가 발생했습니다.');
                } else {
                    alert('사용 가능한 이메일입니다. \n 해당 이메일로 인증 메일이 발송 되었습니다.\n 해당 이메일 : ' + emailText);
                    console.log('인증 메일을 성공적으로 보냈습니다.');
                    context.commit('setEmail', emailText);  // >> 회원가입이 완료되면 null 값으로 바꾸기
                    context.commit('setEmailVerify', false); // >> 회원가입이 완료되면 true로 바꾸기
                }
            })
            .catch(error => {
                console.error('이메일 검증 중 오류가 발생했습니다.', error);
            })

        },

        // 이메일 인증 코드 확인
        codeChk(context) {
            const url = '/api/codeChk';
            const data = new FormData(document.querySelector('#verifyCode'));

            axios.post(url, data)
            .then(response => {
                if (response.data.code === 1) {
                    console.log('코드 인증 성공');
                    context.commit('setEmailCode', false); // >> 회원가입이 완료되면 true로 바꾸기
                } else {
                    console.log('코드 인증 실패');
                }
            })
            .catch(error => {
                console.log('에러 발생:', error.response);
            });
        },

        
        // ----------------------- 보원 끝 ---------------------------
        // ----------------------- 성환 시작 -------------------------
        
        toggleDarkMode({ commit }, isDarkMode) {
            commit('setDarkMode', isDarkMode);
            Cookies.set('darkMode', isDarkMode.toString(), { expires: 7 });
        },
        /**
         * 로그인 처리
         * 
         * @param {*} context 
         */
        login(context) {
            const url = '/api/login';
            const form = document.querySelector('#login_form');
            const data = new FormData(form);
            axios.post(url, data)
            .then(responseData => {
                localStorage.setItem('userInfo', JSON.stringify(responseData.data.data));
                context.commit('setUserInfo', responseData.data.data);
                context.commit('setAuthFlg', true);
                router.replace('/');
            })
            .catch(responseData => {
                alert('로그인을 실패했습니다.');
                form.reset();
            });
        },

        // 로그아웃
        logout(context) {
            const url = '/api/logout';
            axios.post(url)
            .then(responseData => {
            })
            .catch(error => {
                if (error.response) {
                    console.error('로그아웃 오류:', error.response.data.code);
                    alert('로그아웃 실패 (' + error.response.data.code + ')');
                } else {
                    console.error('로그아웃 오류:', error);
                    alert('로그아웃 중 오류가 발생했습니다.');
                }
            })
            .finally(() => {
                localStorage.clear();
                context.commit('setAuthFlg', false);
                document.cookie = "auth=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                context.commit('setUserInfo', null);
                router.replace('/login');
            });
        },
       
        // 회원가입
        regist(context) {
            const url = '/api/regist';
            const data = new FormData(document.querySelector('#regist_form'));
            axios.post(url, data)
            .then(responseData => {
                // 카카오 로그인 로컬 지우기
                localStorage.removeItem('kakaoInfo');
                // 이메일 검증관련 정보 지우기
                context.commit('setEmail', null);
                context.commit('setEmailVerify', true);
                context.commit('setEmailCode', true);

                router.replace('login');
                alert('회원가입이 완료되었습니다.');
            })
        },

        // 회원정보 수정
        userUpdate(context) {
            const url = '/api/userUpdate';
            const data = new FormData(document.querySelector('#update_form'));
            axios.post(url, data)
            .then(responseData => {
                localStorage.setItem('userInfo', JSON.stringify(responseData.data.data));
                context.commit('setUserInfo',responseData.data.data);
                router.replace('info');
            });
        },

        // 회원 탈퇴
        userDelete(context) {
            const url = '/api/userDelete';
            const data = new FormData(document.querySelector('#update_form'));
            axios.delete(url, data)
            .then(responseData => {
                localStorage.clear();
                context.commit('setAuthFlg', false);
                context.commit('setUserInfo', null);
                store.dispatch('getReviewistData');
                router.replace('/');
            });
        },

        // 수정 전 비밀번호 재확인
        confirm(context, password) {
            const url = '/api/confirm';
            axios.post(url, { password: password })
            .then(responseData => {
                if (responseData.data.exists) {
                    router.replace('/update');
                } else {
                    alert('비밀번호가 일치하지 않습니다.');
                }
            });
        },

        // 마이페이지에서 주문목록 불러오기
        getInfoData(context, page) {
            const param = page == 1 ? '' : '?page=' + page;
            const url = '/api/info' + param;
            axios.get(url)
            .then(responseData => {
                localStorage.setItem('infoData', JSON.stringify(responseData.data.data));
                context.commit('infoSetData',responseData.data.data);
             })
             .catch(error => {
                 alert('주문목록 불러오기 실패.(' + error.responseData.data.code + ')' )
             });
         }, 

        //  주문목록 삭제
        orderItemDelete(context, orp_id) {
            const url = '/api/orderProductDelete/' + orp_id;
            axios.delete(url)
            .then(responseData => {
                context.dispatch('getInfoData', lastItemPaginate(context.state.infoData));
            })
            .catch(error => {
                alert('삭제에 실패했습니다.(' + error.response.data.code + ')' )
            });
        },

        // 상품 문의목록 불러오기
        getProductAskData(context, page) {
            const param = page == 1 ? '' : '?page=' + page;
            const url = '/api/productAsk' + param;
            axios.get(url)
            .then(responseData => {
                context.commit('productAskSetData', responseData.data.data);
             })
             .catch(error => {
                 alert('문의목록 불러오기 실패.(' + error.responseData.data.code + ')' )
             });
         }, 

        //  상품 문의 삭제
        productAskDelete(context, qnp_id) {
            const url = '/api/productAskDelete/' + qnp_id;
            axios.delete(url)
            .then(responseData => {
                context.dispatch('getProductAskData', lastItemPaginate(context.state.productAskData));
            })
            .catch(error => {
                alert('삭제에 실패했습니다.(' + error.responseData.data.code + ')' )
            });
        },

        // 1:1 문의목록 불러오기
        getAskData(context, page) {
            const param = page == 1 ? '' : '?page=' + page;
            const url = '/api/askData' + param;
            axios.get(url)
            .then(responseData => {
                context.commit('askSetData', responseData.data.data);
             })
             .catch(error => {
                 alert('문의목록 불러오기 실패.(' + error.responseData.data.code + ')' )
             });
         }, 
        
        //  1:1 문의 삭제
        askDelete(context, qn_id) {
            const url = '/api/askDelete/' + qn_id;
            axios.delete(url)
            .then(responseData => {
                context.dispatch('getAskData', lastItemPaginate(context.state.askSetData));
            })
            .catch(error => {
                alert('삭제에 실패했습니다.(' + error.responseData.data.code + ')' )
            });
        },

        // 구매확정
        completeBtn(context, orp_id) {
            const url = '/api/complete/' + orp_id;
            axios.post(url)
            .then(responseData => {
                context.dispatch('getInfoData', context.state.infoData.current_page);
            })
            .catch(error => {
                alert('실패했습니다.(' + error.responseData.data.code + ')' )
            });
        },
            
        // ----------------------- 성환 끝 ---------------------------
        // ----------------------- 민서 시작 -------------------------
        /**
         * 상품상세페이지 값 획득
         * 
         * @param {*} context
         */
        setProductDetailData(context, id) {
            const url = '/api/detailed/' + id;
            // console.log(url);
            axios.get(url)
            .then(response => {
                if(!response.data.data) {
                    // 에러 페이지 이동
                    router.replace({name: 'NotFound'})
                }
                // console.log('디테일 데이터', response.data);
                context.commit('detailedNumData', response.data.data);
            })
            .catch(error => {
                // console.log(error.response.data);
                alert('상세정보 불러오기 실패했습니다.(' + error.response.data.code + ')');
            });
        },

        /**
         * 상품획득
         * 
         * @param {*} context
         */
        getList(context, query) {
            const param = query.page == 1 ? '' : '&page=' + query.page;
            const url = '/api/list?type=' + query.type + param;

            axios.get(url)
            .then(response => {
                console.log(response.data);

                //type 추가
                response.data.data.type = query.type;

                // 데이터베이스->서버를 통해 받은 데이터를 listData 저장
                context.commit('listInfoData', response.data.data);
            })
            .catch(error => {
                // console.log(error.response.data);
                alert('선택한 상품이 없습니다.(' + error.response.data.code + ')' )
            });
        },
        // 검색리스트
        searchList(context, data) {
            const url ='/api/listck?search=' + data.search + '&page=' + data.page + '&type=' + data.type;
            axios.get(url)
            .then(response => {
                localStorage.setItem('searchword', data.search);
                //type 추가
                // response.data.data.type = data.type;
                // response.data.data.search = data.search;

                context.commit('setSearchdata', response.data);
                if(response.data.data.total !== 0) {
                    // router.replace('/search/recipe?page=' + data.page);
                    router.replace('/listck?search=' + data.search + '&page=' + data.page + '&type=' + data.type);
                } else {
                    alert('해당 주류가 존재하지 않습니다');
                }
            })
            .catch(error => { 
                console.log(error.response);
            }) 
        },
        /**
         * 베스트 상품 불러오기
         * 
         * @param {*} context
         */
        productBastDetail(context) {
            const url = '/api/listbast';

            axios.get(url)
            .then(response => {
                // console.log('베스트 상품 데이터',response.data.data);
                // 데이터베이스->서버를 통해 받은 데이터를 bastData 저장
                context.commit('listBastData', response.data.data);
            })
            .catch(error => {
                // console.log(error.response.data);
                alert('선택한 상품이 없습니다.(' + error.response.data.code + ')' )
            });
        },

        // /**
        //  * 리뷰 데이터 불러오기
        //  * 
        //  * @param {*} constext 
        //  */
        setProductReviewData(constext, id) {
            const url = '/api/reviewdetailed/' + id;

            axios.get(url)
            .then(response => {
                // console.log('리뷰 데이터', response.data);
                // 데이터베이스->서버를 통해 받은 데이터를 reviewDetail 저장
                constext.commit('detailedReviewData', response.data.data);
            })
            .catch(error => {
                // console.log(error.response.data);
                alert('디테일 리뷰데이터 불러오기 실패했습니다.(' + error.response.data.code + ')');
            });
        },

        // /**
        //  * 아이디 / 수량 데이터 보내기 (디테일->장바구니)
        //  * 
        //  * @param {*} constext 
        //  */
        detailedToCount(constext) {
            const url = '/api/detailedtocount';
            const data = new FormData(document.querySelector('#bagForm'));
            
            axios.post(url, data)
            .then(response => {
                // console.log('수량데이터', response.data);
                // 데이터베이스->서버를 통해 받은 데이터를 CountData 저장
                constext.commit('detailedCountData', response.data.data);
                if(confirm('확인을 클릭시 장바구니로 이동 됩니다. \n장바구니에 담은 총수량 : [ '+ response.data.data.ba_count +' ] 개')) {
                    // const router = useRouter();
                    router.push('/bag');
                }
            })
            .catch(error => {
                // 로그인이 되어있을경우
                if(store.state.userInfo) {
                    // console.log(error.response.data);
                    alert('장바구니 이동 실패했습니다(' + error.response.data.code + ')');
                }
                // 로그인이 되어있지 않을경우
                else if (!store.state.userInfo){
                    alert('로그인이 필요한 서비스입니다.');
                    router.push('/login');
                }
            });
        },

        /**
         * 상세페이지에서 주문페이지로 이동
         * 
         * @param {*} context
         * @param {*} item
        */
        detailedUpdate(context, item) {
            const detailedUpdateData = item;
            const data = new FormData(document.querySelector('#bagForm'));

            // FormData를 객체로 변환
            const formDataObject = Object.fromEntries(data.entries());

            // 숫자로 변환할 필드의 키를 배열로 지정
            const numericFields = ['ba_count', 'p_id']; // 예시로 필요에 따라 필드 추가

            // 숫자 타입으로 변환된 객체 생성
            const detailedData = { ...detailedUpdateData }; // detailedUpdateData는 이미 있는 객체로 가정

            // FormDataObject의 각 항목을 순회하면서 숫자 타입으로 변환
            for (let key in formDataObject) {
                if (numericFields.includes(key)) {
                    detailedData[key] = Number(formDataObject[key]); // 숫자로 변환하여 저장
                } else {
                    detailedData[key] = formDataObject[key]; // 숫자로 변환할 필요 없는 경우 그대로 저장
                }
            } 
            context.commit('setdetailedUpdate', detailedData);
            localStorage.setItem('orderProductData', JSON.stringify(detailedData));

            router.push('/order');
            // router.replace('/order');
        },
        // 추천 카테고리
        typeChkList(constext) {
            const url = '/api/typechklist';
            axios.get(url)
            .then(response => {
                // console.log('추천카테고리', response.data);

                constext.commit('listTypeChk', response.data);
            })
            .catch(error => {
                // console.log(error.response.data);
                alert('선택한 상품이 없습니다.(' + error.response.data.code + ')' )
            });  
        },


        // // ----------------------- 민서 끝 ---------------------------
        // ----------------------- 호경 시작 -------------------------
        /**
         * 계절 추천 데이터 획득
         * 
         * @param {*} context 
         */
        getSeasonData(context) {
            const url = '/api/season';
            
            axios.get(url)
            .then(response => {
                context.commit('setSeasonListData', response.data.data);
                context.commit('setSeason', response.data.season);
            })
            .catch(error => {
                console.log(error.response);
                alert('계절 별 추천 데이터 습득에 실패했습니다.(' + error.response.data.code + ')');
            });
        },

        /**
         * 리뷰 데이터 획득
         * 
         * @param {*} context 
         */
        getReviewistData(context) {
            const url = '/api/reviewlist';
            
            axios.get(url)
            .then(response => {
                context.commit('setReviewListData', response.data.data);
            })
            .catch(error => {
                console.log(error.response);
                alert('리뷰 데이터 습득에 실패했습니다.(' + error.response.data.code + ')');
            });
        },

        /**
         * 공지사항 리스트 획득
         * 
         * @param {*} context 
         */
        getNoticeData(context, page) {
            const param = page == 1 ? '' : '?page=' + page;
            const url = '/api/noticelist' + param;
            
            axios.get(url)
            .then(response => {
                context.commit('setNoticeData', response.data.data);
            })
            .catch(error => {
                console.log(error.response);
                alert('공지사항 습득에 실패했습니다.(' + error.response.data.code + ')');
            });
        },

        /**
         * 공지사항 상세페이지 값 획득
         * 
         * @param {*} context
         */
        getNoticeDetailData(context, id) {
            const url = '/api/notice?id=' + id;
            console.log(url);
            axios.get(url)
            .then(response => {
                console.log('공지사항 데이터', response.data);
                context.commit('setNoticeDetailData', response.data.data);
            })
            .catch(error => {
                console.log(error.response.data);
                alert('공지사항 불러오기 실패했습니다.(' + error.response.data.code + ')');
            });
        },

        /**
         * 상품문의 상세페이지 값 획득
         * 
         * @param {*} context 
         */
        getQnaProductDetailData(context, id) {
            const url = '/api/qnaproductdetail/' + id;
            
            axios.get(url)
            .then(response => {
                console.log(response.data);
                context.commit('setQnaProductDetailData', response.data.data);
            })
            .catch(error => {
                console.log(error.response);
                alert('상품문의내역 습득에 실패했습니다.(' + error.response.data.code + ')');
            });
        },

        /**
         * 1:1문의내역 상세페이지 획득
         * 
         * @param {*} context 
         */
        getQnaOneByOneDetailData(context, id) {
            const url = '/api/qnaonebyonedetail/' + id;
            
            axios.get(url)
            .then(response => {
                console.log(response.data);
                context.commit('setQnaOneByOneDetailData', response.data.data);
            })
            .catch(error => {
                console.log(error.response);
                alert('1:1문의내역 습득에 실패했습니다.(' + error.response.data.code + ')');
            });
        },

        /**
         * 상품문의 작성
         * 
         * @param {*} context
         */
        qnaProductCreate(context) {
            const url = '/api/qnaproductcreate';
            const data = new FormData(document.querySelector('#qnaProductForm'));

            console.log(url);
            axios.post(url, data)
            .then(response => {
                if(context.state.qnaProductDetailData.length > 1) {
                    context.commit('setUnshiftQnaProductData', response.data.data);
                    context.commit('getProductAskData', context.state.productAskData.current_page);
                }
                
                console.log(response.data);
                router.replace('/info');
            })
            .catch(error => {
                console.log(error.response);
                alert('글 작성에 실패했습니다.(' + error.response.data.code + ')');
            });
        },
        
        /**
         * 1:1 문의 작성
         * 
         * @param {*} context
         */
        qnaOnebyOneCreate(context) {
            const url = '/api/qnaonebyonecreate';
            const data = new FormData(document.querySelector('#qnaOneByOneForm'));

            axios.post(url, data)
            .then(response => {
                if(context.state.qnaOneByOneDetailData.length > 1) {
                    context.commit('setUnshiftQnaOneByOneData', response.data.data);
                    context.commit('getAskData', context.state.askSetData.current_page);
                }
                router.replace('/info');
            })
            .catch(error => {
                console.log(error.response);
                alert('글 작성에 실패했습니다.(' + error.response.data.code + ')');
            });
        },

        /**
         * 전통주 설명 획득
         * 
         * @param {*} context 
         */
        getTraditionalLiquorData(context) {
            const url = '/api/traditionalliquor';
            
            axios.get(url)
            .then(response => {
                console.log(response.data);
                context.commit('setTraditionalLiquorData', response.data.data);
            })
            .catch(error => {
                console.log(error.response);
                alert('전통주 설명 습득에 실패했습니다.(' + error.response.data.code + ')');
            });
        },
        // ----------------------- 호경 끝 ---------------------------

        // --------------------------------------------------------------------- 관리자 페이지 -------------------------------------------------------------------------
        // ----------------------- 보원 시작 ---------------------------
        // ----------------------- 보원 끝 ---------------------------

        // ----------------------- 성환 시작 ---------------------------
        // ----------------------- 성환 끝 ---------------------------

        // ----------------------- 민서 시작 ---------------------------
        // ----------------------- 민서 끝 ---------------------------

        // ----------------------- 호경 시작 ---------------------------
        /**
         * 관리자 로그인 처리
         * 
         * @param {*} context 
         */
        adminLogin(context) {
            const url = '/api/admin/login';
            const form = document.querySelector('#admin_login_form');
            const data = new FormData(form);
            axios.post(url, data)
            .then(responseData => {
                // localStorage.setItem('userInfo', JSON.stringify(responseData.data.data));
                // context.commit('setUserInfo', responseData.data.data);
                // context.commit('setAuthFlg', true);
                localStorage.setItem('adminInfo', JSON.stringify(responseData.data.data));
                // context.commit('setAdminInfo', responseData.data.data);
                context.commit('setAdminLoginFlg', true);
                router.replace('/admin/main');
            })
            .catch(responseData => {
                alert('로그인을 실패했습니다.');
                form.reset();
            });
        },

        /**
         * 관리자 로그아웃 처리
         * 
         * @param {*} context 
         */
        adminLogout(context) {
            const url = '/api/admin/logout';
            axios.post(url)
            .then(responseData => {
            })
            .catch(error => {
                alert('로그아웃 (' + error.responseData.data.code + ')');
            })
            .finally(() => {
                localStorage.clear();
                context.commit('setAdminLoginFlg', null);
                router.replace('/admin');
            });
        },

        /**
         * 월별 유저 통계 획득
         * 
         * @param {*} context 
         */
        async getUserTatisticsData(context) {
            const url = '/api/admin/user/statistics';
            
            try {
                const response = await axios.get(url);
    
                const now = new Date();
                // console.log('가공전:', response.data.data)
                let tatisticsData = [];
                // 빈 값이 있을 경에는 0 추가
                for(let i = 1; i <= 12; i++) {
                    const month = now.getFullYear() + '-' + i.toString().padStart(2, '0');
                    const arr_new_users = response.data.data.filter(item => {
                        return item.month == month;
                    });
                    tatisticsData.push({
                        month: month
                        ,new_users: arr_new_users.length > 0 ? arr_new_users[0].new_users : 0
                        ,withdraw_users: arr_new_users.length > 0 ? arr_new_users[0].withdraw_users : 0
                    });
                }
                console.log('가공후:', tatisticsData)
                context.commit('setUserTatisticsData', tatisticsData);
                return response;
            } catch (error) {
                alert('유저 통계 습득에 실패했습니다.(' + error.response.data.code + ')');
            }

            // axios.get(url)
            // .then(response => {
            //     //  // 데이터 형식 변경
            //     // const formattedData = response.data.data.map(item => ({
            //     //     month: item.month, // 월은 그대로 유지
            //     //     new_users: parseInt(item.new_users), // new_users를 숫자로 변환
            //     //     withdraw_users: parseInt(item.withdraw_users) // withdraw_users를 숫자로 변환
            //     // }));

            //     const now = new Date();
            //     let tatisticsData = [];
            //     for(let i = 1; i <= 12; i++) {
            //         const month = now.getFullYear() + '-' + i.toString().padStart(2, '0');
            //         const arr_new_users = response.data.data.filter(item => {
            //            return item.month == month;
            //         });
            //         tatisticsData.push({
            //             month: month
            //             ,new_users: arr_new_users.length > 0 ? arr_new_users[0].new_users : 0
            //             ,withdraw_users: arr_new_users.length > 0 ? arr_new_users[0].withdraw_users : 0
            //         });
            //         console.log(tatisticsData);
            //     }

            //     // context.commit('setUserTatisticsData', response.data.data);
            //     context.commit('setUserTatisticsData', tatisticsData);
            // })
            // .catch(error => {
            //     alert('유저 통계 습득에 실패했습니다.(' + error.response.data.code + ')');
            // });
        },

        /**
         * 유저 연령대 통계 획득
         * 
         * @param {*} context 
         */
        async getUserAgeRangeData(context) {
            const url = '/api/admin/user/age/range';

            try {
                const response = await axios.get(url);
                // console.log('가공전:', response.data.data)
                context.commit('setUserAgeRangeData', response.data.data);

                return response; // 성공적으로 데이터를 가져왔을 경우 응답 반환
            } catch (error) {
                alert('유저 연령대 통계 습득에 실패했습니다.(' + error.response.data.code + ')');
            }
            
            // axios.get(url)
            // .then(response => {
            //     context.commit('setUserAgeRangeData', response.data.data);
            // })
            // .catch(error => {
            //     alert('유저 통계 습득에 실패했습니다.(' + error.response.data.code + ')');
            // });
        },

        /**
         * 매출 통계 획득
         * 
         * @param {*} context 
         */
        async getSalesStatisticsData(context) {
            const url = '/api/admin/sales/statistics';

            try {
                const response = await axios.get(url);

                // 현재 월의 일 수를 계산하는 함수 (2월, 30일, 31일 따라 for문을 반복하기위함)
                function getDaysInMonth(year, month) {
                    return new Date(year, month + 1, 0).getDate();
                }
        
                const now = new Date();
                console.log('가공전:', response.data.data)
                let totalSalesData = {daily : [], weekly : [], month : [], year : []};
                // 일
                const daysInMonth = getDaysInMonth(now.getFullYear(), now.getMonth());
                for(let i = 1; i <= daysInMonth; i++) {
                    const daily = now.getFullYear() + '-' + (now.getMonth() + 1).toString().padStart(2, '0') + '-' + i.toString().padStart(2, '0');
                    const arr_daily_sales = response.data.data.daily.filter(item => {
                        return item.daily == daily;
                    });
                    totalSalesData.daily.push({
                        daily: daily
                        ,daily_sales: arr_daily_sales.length > 0 ? arr_daily_sales[0].daily_sales : 0
                    });
                }
                // 주
                for(let i = 1; i <= 52; i++) {
                    const weekly = now.getFullYear() + '-' + i.toString().padStart(2, '0');
                    const arr_weekly_sales = response.data.data.weekly.filter(item => {
                        return item.year + '-' + item.weekly.toString().padStart(2, '0') == weekly;
                    });
                    totalSalesData.weekly.push({
                        weekly: weekly + '주차'
                        ,weekly_sales: arr_weekly_sales.length > 0 ? arr_weekly_sales[0].weekly_sales : 0
                    });
                }
                // 달
                for(let i = 1; i <= 12; i++) {
                    const month = now.getFullYear() + '-' + i.toString().padStart(2, '0');
                    const arr_month_sales = response.data.data.month.filter(item => {
                        return item.year + '-' + item.month.toString().padStart(2, '0')== month;
                    });
                    totalSalesData.month.push({
                        month: month
                        ,monthly_sales: arr_month_sales.length > 0 ? arr_month_sales[0].monthly_sales : 0
                    });
                }
                // 년
                for(let i = 4; i >= 0; i--) {
                    const year = now.getFullYear()-i;
                    const arr_year_sales = response.data.data.year.filter(item => {
                        return item.year == year;
                    });
                    totalSalesData.year.push({
                        year: year
                        ,yearly_sales: arr_year_sales.length > 0 ? arr_year_sales[0].yearly_sales : 0
                    });
                }
                    console.log('가공후:', totalSalesData)
                    context.commit('setSalesStatisticsData', totalSalesData);
                    return response;
                } catch (error) {
                    alert('전체 매출 습득에 실패했습니다.(' + error.response.data.code + ')');
                }
            // axios.get(url)
            // .then(response => {
            //     context.commit('setSalesStatisticsData', response.data.data);
            //     console.log('매출: ', response.data.data)
            // })
            // .catch(error => {
            //     alert('매출 습득에 실패했습니다.(' + error.response.data.code + ')');
            // });
        },

        // /**
        //  * 매출 통계 획득
        //  * 
        //  * @param {*} context 
        //  */
        // getSalesStatisticsData(context) {
        //     const url = '/api/admin/sales/statistics';
            
        //     axios.get(url)
        //     .then(response => {
        //         console.log('매출: ', response.data.data)
        //         context.commit('setSalesStatisticsData', response.data.data);
        //     })
        //     .catch(error => {
        //         console.log(error.response);
        //         alert('전체 매출 습득에 실패했습니다.(' + error.response.data.code + ')');
        //     });
        // },

        /**
         * 관리자 페이지 유저 전체 획득
         * 
         * @param {*} context 
         */
        getAdminUsersData(context, page) {
            const param = page == 1 ? '' : '?page=' + page;
            const url = '/api/admin/user' + param;
            
            axios.get(url)
            .then(response => {
                console.log(response.data);
                context.commit('setAdminUsersData', response.data.data);
            })
            .catch(error => {
                console.log(error.response);
                alert('전체 유저 목록 습득에 실패했습니다.(' + error.response.data.code + ')');
            });
        },

        /**
         * 유저 목록에서 유저 수정페이지로 이동
         * 
         * @param {*} context
         * @param {*} item
        */
        adminUserToUpdate(context, item) {
            const updateData = item;

            context.commit('setAdminUserToUpdate', updateData);
            localStorage.setItem('adminUserToUpdate', JSON.stringify(updateData));

            router.push('/admin/user/update');
        },

        /**
         * 유저 정보 수정 페이지에서 수정 완료
         * 
         * @param {*} context
        */
        userUpdateSubmit(context, id) {
            const url = '/api/admin/user/update/' + id;
            const data = new FormData(document.querySelector('#adminUserUpdateForm'));

            axios.post(url, data)
            .then(response => {

                context.commit('setAdminUserToUpdate', response.data.data);
                localStorage.setItem('adminUserToUpdate', JSON.stringify(response.data.data));

                if(confirm('유저 정보를 수정 완료하였습니다. \n확인을 누르면 리스트로 돌아갑니다.')){
                    router.push('/admin/user');
                }
            })
            .catch(error => {
                alert('공지사항 수정에 실패하였습니다.(' + error.response.data.code + ')' )
            });
        }, 

        /**
         * 관리자 페이지 상품 전체 획득
         * 
         * @param {*} context 
         */
        getAdminProductsData(context, page) {
            const param = page == 1 ? '' : '?page=' + page;
            const url = '/api/admin/product' + param;
            
            axios.get(url)
            .then(response => {
                console.log(response.data);
                context.commit('setAdminProductsData', response.data.data);
            })
            .catch(error => {
                console.log(error.response);
                alert('전체 상품 목록 습득에 실패했습니다.(' + error.response.data.code + ')');
            });
        },

        /**
         * 상품 추가
         * 
         * @param {*} context
         */
        adminProductCreate(context) {
            const url = '/api/admin/product/create';
            const data = new FormData(document.querySelector('#adminProductCreateForm'));

            axios.post(url, data)
            .then(response => {
                if(context.state.adminProductData.length > 1) {
                    context.commit('setUnshiftAdminProductData', response.data.data);
                    context.commit('getAdminProductsData', context.state.adminProductData.current_page);
                }
                
                console.log(response.data); 
                router.replace('/admin/product');
            })
            .catch(error => {
                console.log(error.response);
                alert('글 작성에 실패했습니다.(' + error.response.data.code + ')');
            });
        },

        /**
         * 상품 목록에서 상품 수정페이지로 이동
         * 
         * @param {*} context
         * @param {*} item
        */
        adminProductToUpdate(context, item) {
            const updateData = item;

            context.commit('setAdminProductToUpdate', updateData);
            localStorage.setItem('adminProductToUpdate', JSON.stringify(updateData));

            router.push('/admin/product/update');
        },

        /**
        * 상품 수정 페이지에서 수정 완료
        * 
        * @param {*} context
        */
            productUpdateSubmit(context) {
            const url = '/api/admin/product/update';
            const data = new FormData(document.querySelector('#adminProducUpdateForm'));

            axios.post(url, data)
            .then(response => {

                context.commit('setAdminProductToUpdate', response.data.data);
                localStorage.setItem('adminProductToUpdate', JSON.stringify(response.data.data));

                if(confirm('공지사항 수정을 완료하였습니다. \n확인을 누르면 리스트로 돌아갑니다.')){
                    router.push('/admin/product');
                }
            })
            .catch(error => {
                alert('상품 수정에 실패하였습니다.(' + error.response.data.code + ')' )
            });
        },

        /**
         * 상품 삭제
         * 
         * @param {*} context
         */
        adminProductDeleted(context, id) {
            const url = '/api/admin/product/delete/' + id;
            if (confirm('확인을 누르면 상품이 삭제됩니다.')) {
                axios.delete(url)
                .then(responseData => {
                    context.dispatch('getAdminProductsData', lastItemPaginate(context.state.adminProductData));
                })
                .catch(error => {
                    alert('삭제에 실패했습니다.(' + error.responseData.data.code + ')' )
                });
            }
        },

        /**
         * 관리자 페이지 주문 전체 획득
         * 
         * @param {*} context 
         */
        getAdminOrdersData(context, page) {
            const param = page == 1 ? '' : '?page=' + page;
            const url = '/api/admin/order' + param;
            
            axios.get(url)
            .then(response => {
                console.log(response.data);
                context.commit('setAdminOrdersData', response.data.data);
            })
            .catch(error => {
                console.log(error.response);
                alert('전체 주문 목록 습득에 실패했습니다.(' + error.response.data.code + ')');
            });
        },

        /**
         * 관리자 페이지 교환 및 반품 전체 획득
         * 
         * @param {*} context 
         */
        getAdminExchangesData(context, page) {
            const param = page == 1 ? '' : '?page=' + page;
            const url = '/api/admin/exchange' + param;
            
            axios.get(url)
            .then(response => {
                console.log(response.data);
                context.commit('setAdminExchangesData', response.data.data);
            })
            .catch(error => {
                console.log(error.response);
                alert('전체 교환 및 반품 목록 습득에 실패했습니다.(' + error.response.data.code + ')');
            });
        },

        /**
         * 관리자 페이지 1:1문의 전체 획득
         * 
         * @param {*} context 
         */
        getAdminOneByOnesData(context, page) {
            const param = page == 1 ? '' : '?page=' + page;
            const url = '/api/admin/onebyone' + param;
            
            axios.get(url)
            .then(response => {
                console.log(response.data);
                context.commit('setAdminOneByOnesData', response.data.data);
            })
            .catch(error => {
                console.log(error.response);
                alert('전체 1:1문의 목록 습득에 실패했습니다.(' + error.response.data.code + ')');
            });
        },

        /**
         * 1:1문의 리스트에서 1:1문의 답변페이지로 이동
         * 
         * @param {*} context
         * @param {*} item
        */
        adminOneByOneToUpdate(context, item) {
            const UpdateData = item;

            context.commit('setadminOneByOneToUpdate', UpdateData);
            localStorage.setItem('adminOneByOneToUpdate', JSON.stringify(UpdateData));

            router.push('/admin/onebyone/update');
        },

        /**
         * 1:1문의 답변 페이지에서 답변 완료
         * 
         * @param {*} context
        */
        oneByOneUpdate(context) {
            const url = '/api/admin/onebyone/update';
            const data = new FormData(document.querySelector('#adminOneByOneUpdateForm'));

            axios.post(url, data)
            .then(response => {

                context.commit('setadminOneByOneToUpdate', response.data.data);
                localStorage.setItem('adminOneByOneToUpdate', JSON.stringify(response.data.data));

                if(confirm('1:1문의 답변을 완료하였습니다. \n확인을 누르면 리스트로 돌아갑니다.')){
                    router.push('/admin/onebyone');
                }
            })
            .catch(error => {
                alert('1:1문의 작성에 실패하였습니다.(' + error.response.data.code + ')' )
            });
        }, 

        /**
         * 관리자 페이지 상품 문의 전체 획득
         * 
         * @param {*} context 
         */
        getAdminProductQnasData(context, page) {
            const param = page == 1 ? '' : '?page=' + page;
            const url = '/api/admin/productqna' + param;
            
            axios.get(url)
            .then(response => {
                console.log(response.data);
                context.commit('setAdminProductQnasData', response.data.data);
            })
            .catch(error => {
                console.log(error.response);
                alert('전체 상품 문의 목록 습득에 실패했습니다.(' + error.response.data.code + ')');
            });
        },

        /**
         * 상품문의 리스트에서 상품문의 답변페이지로 이동
         * 
         * @param {*} context
         * @param {*} item
        */
        adminProductQnaToUpdate(context, item) {
            const UpdateData = item;

            context.commit('setadminProductQnaToUpdate', UpdateData);
            localStorage.setItem('adminProductQnaToUpdate', JSON.stringify(UpdateData));

            router.push('/admin/productqna/update');
        },

        /**
         * 상품문의 답변 페이지에서 답변 완료
         * 
         * @param {*} context
        */
        productQnaUpdateSubmit(context) {
            const url = '/api/admin/productqna/update';
            const data = new FormData(document.querySelector('#adminProductQnaUpdateForm'));

            axios.post(url, data)
            .then(response => {

                context.commit('setadminProductQnaToUpdate', response.data.data);
                localStorage.setItem('adminProductQnaToUpdate', JSON.stringify(response.data.data));

                if(confirm('상품문의 작성 완료하였습니다. \n확인을 누르면 리스트로 돌아갑니다.')){
                    router.push('/admin/productqna');
                }
            })
            .catch(error => {
                alert('상품문의 작성 실패하였습니다.(' + error.response.data.code + ')' )
            });
        },

        /**
         * 관리자 페이지 공지사항 전체 획득
         * 
         * @param {*} context 
         */
        getAdminNoticeData(context, page) {
            const param = page == 1 ? '' : '?page=' + page;
            const url = '/api/admin/noticelist' + param;
            
            axios.get(url)
            .then(response => {
                console.log(response.data);
                context.commit('setAdminNoticesData', response.data.data);
            })
            .catch(error => {
                console.log(error.response);
                alert('전체 공지사항 목록 습득에 실패했습니다.(' + error.response.data.code + ')');
            });
        },

        /**
         * 공지사항 작성
         * 
         * @param {*} context
         */
        adminNoticeCreate(context) {
            const url = '/api/admin/notice/create';
            const data = new FormData(document.querySelector('#adminNoticeCreateForm'));

            axios.post(url, data)
            .then(response => {
                if(context.state.adminNoticeData.length > 1) {
                    context.commit('setUnshiftAdminNoticeData', response.data.data);
                    context.commit('getAdminNoticeData', context.state.adminNoticeData.current_page);
                }
                
                console.log(response.data); 
                router.replace('/admin/notice');

            })
            .catch(error => {
                console.log(error.response);
                alert('공지사항 작성에 실패했습니다.(' + error.response.data.code + ')');
            });
        },
        
        /**
         * 공지사항 리스트에서 공지사항 수정페이지로 이동
         * 
         * @param {*} context
         * @param {*} item
        */
        adminNoticeToUpdate(context, item) {
            const updateData = item;

            context.commit('setAdminNoticeToUpdate', updateData);
            localStorage.setItem('adminNoticeToUpdate', JSON.stringify(updateData));

            router.push('/admin/notice/update');
        },

        /**
         * 공지사항 수정 페이지에서 수정 완료
         * 
         * @param {*} context
        */
        noticeUpdateSubmit(context) {
            const url = '/api/admin/notice/update';
            const data = new FormData(document.querySelector('#adminNoticeUpdateForm'));

            axios.post(url, data)
            .then(response => {

                context.commit('setAdminNoticeToUpdate', response.data.data);
                localStorage.setItem('adminNoticeToUpdate', JSON.stringify(response.data.data));

                if(confirm('공지사항 수정을 완료하였습니다. \n확인을 누르면 리스트로 돌아갑니다.')){
                    router.push('/admin/notice');
                }
            })
            .catch(error => {
                alert('공지사항 수정에 실패하였습니다.(' + error.response.data.code + ')' )
            });
        }, 

        /**
         * 공지사항 삭제
         * 
         * @param {*} context
         */
        adminNoticeDeleted(context, no_id) {
            const url = '/api/admin/notice/delete/' + no_id;
            if (confirm('확인을 누르면 작성한 공지사항이 삭제됩니다.')) {
                axios.delete(url)
                .then(responseData => {
                    context.dispatch('getAdminNoticeData', lastItemPaginate(context.state.adminNoticeData));
                })
                .catch(error => {
                    alert('삭제에 실패했습니다.(' + error.responseData.data.code + ')' )
                });
            }
        },

        /**
         * 관리자 페이지 접수 완료 -> 상품회수중
         * 
         * @param {*} context 
         */
        getTakeOverData(context, ex_id) {
            const url = '/api/admin/take/over/' + ex_id;

            axios.post(url)
            .then(response => {
                const copyAdminExchangeData = {...context.state.adminExchangeData};
                copyAdminExchangeData.data.forEach( (item, key) => {
                    if(item.ex_id == response.data.data.ex_id) {
                        copyAdminExchangeData.data[key] = response.data.data;
                    }
                });
                context.commit('setAdminExchangesData', copyAdminExchangeData);
            })
            .catch(error => {
                console.log(error.response);
                alert('접수하기 실패했습니다.(' + error.response.data.code + ')');
            });
        },

        /**
         * 관리자 페이지 상품회수중 -> 결제 취소
         * 
         * @param {*} context 
         */
        getPayCancelData(context, ex_id) {
            const url = '/api/admin/pay/cancel/' + ex_id;

            axios.post(url)
            .then(response => {
                const copyAdminExchangeData = {...context.state.adminExchangeData};
                copyAdminExchangeData.data.forEach( (item, key) => {
                    if(item.ex_id == response.data.data.ex_id) {
                        copyAdminExchangeData.data[key] = response.data.data;
                    }
                });
                context.commit('setAdminExchangesData', copyAdminExchangeData);
            })
            .catch(error => {
                console.log(error.response);
                alert('결제취소 실패했습니다.(' + error.response.data.code + ')');
            });
        },

        // ----------------------- 호경 끝 ---------------------------

    }
})

// 페이지에 데이터가 1개일때 삭제하면 마지막 페이지 -1 로 돌아가는 함수
function lastItemPaginate(data) {
    let page;
    if (data.data.length == 1 && data.current_page != 1) {
        page = data.current_page - 1;
    } else {
        page = data.current_page;
    }
    return page;
}

export default store;
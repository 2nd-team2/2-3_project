import axios from 'axios';
import { createStore } from 'vuex';
import router from './router';

const store = createStore({
    state() {
        return {
            // ----------------------- 보원 시작 -------------------------
            // 장바구니 상품 담을 리스트
            bagsProductData: [],
            // ----------------------- 보원 끝 ---------------------------
            // ----------------------- 성환 시작 -------------------------
            // ----------------------- 성환 끝 ---------------------------
            authFlg: document.cookie.indexOf('auth=') >= 0 ? true : false,
            // ----------------------- 민서 시작 -------------------------
            detailedData: [],
            // ----------------------- 민서 끝 ---------------------------
            // ----------------------- 호경 시작 -------------------------
            // 공지사항 게시물 리스트
            noticeData: [],
            // 공지사항 디테일 정보
            noticeDetail: {},
            // 상품문의 게시물 리스트
            qnaProductListData: [],
            // 1 : 1 문의 게시물 리스트
            qnaOneByOneListData: [],
            // ----------------------- 호경 끝 ---------------------------
        }

    },
    mutations: {
        // ----------------------- 보원 시작 -------------------------
        
        // state.장바구니에 추가 될 리스트
        bagsSetProductData(state, data) {
            state.bagsProductData = data;
        },
        // ----------------------- 보원 끝 ---------------------------
        // ----------------------- 성환 시작 -------------------------
        // 인증 플래그 저장
        setAuthFlg(state, flg) {
            state.authFlg = flg;
        },
        //유저 정보 저장
        setUserInfo(state, userInfo) {
            state.userInfo = userInfo;
        },
        // ----------------------- 성환 끝 ---------------------------
        // ----------------------- 민서 시작 -------------------------
        detailedNumData(state, data) {
            state.detailedData = data;
        },
        // ----------------------- 민서 끝 ---------------------------
        // ----------------------- 호경 시작 -------------------------
        // 공지사항 게시물 리스트
        setNoticeData(state, data) {
            state.noticeData = data;
        },
        // 공지사항 디테일 저장
        setNoticeDetailData(state, data) {
            state.noticeDetail = data;
        },
        // 상품문의내역 게시물 리스트
        setQnaProductListData(state, data) {
            state.qnaProductListData = data;
        },
        // 상품문의내역 작성 게시글 가장 앞에 추가
        setUnshiftQnaProductData(state, data) {
            state.qnaProductListData.unshift(data);
        },
        // 1 : 1 문의내역 게시물 리스트
        setQnaOneByOneListData(state, data) {
            state.qnaOneByOneListData = data;
        },
        // 1:1문의내역 작성 게시글 가장 앞에 추가
        setUnshiftQnaOneByOneData(state, data) {
            state.qnaOneByOneListData.unshift(data);
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
                console.log(response.data); // TODO : 삭제

                // 데이터베이스->서버를 통해 받은 데이터를 bagsProductData에 저장
                context.commit('bagsSetProductData', response.data.data);
            })
            .catch(error => {
                console.log(error.response); //  TODO : 삭제
                alert('장바구니에 담긴 상품이 없습니다.(' + error.response.data.code + ')' )
            });
        },

        // ----------------------- 보원 끝 ---------------------------
        // ----------------------- 성환 시작 -------------------------

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
            .then(response => {
                localStorage.setItem('userInfo', JSON.stringify(response.data.data));
                context.commit('setUserInfo', response.data.data);
                context.commit('setAuthFlg', true);
                router.replace('/');
            })
            .catch(error => {
                alert('로그인에 실패 (' + error.response.data.code + ')');
            });
        },
        logout(context) {
            const url = '/api/logout';

            axios.post(url)
            .then(response => {
                console.log(response.data); // TODO
            })
            .catch(error => {
                console.log(error.response); // TODO
                alert('로그아웃 (' + error.response.data.code + ')');
            })
            .finally(() => {
                localStorage.clear();

                context.commit('setAuthFlg', false);
                context.commit('setUserInfo', null);

                router.replace('/login');
            });
        },
        // 회원가입
        regist(context) {
            const url = 'api/regist';
            const data = new FormData(document.querySelector('#regist'));

            axios.post(url, data)
            .then(response => {
                console.log(response.data); // TODO
                router.replace('login');
            })
            .catch(error => {
                console.log(error.response.data); // TODO
                alert('회원가입 실패 (' + error.response.data.code + ')');
            });

        },
        // ----------------------- 성환 끝 ---------------------------
        // ----------------------- 민서 시작 -------------------------
        /**
         * 수량 획득
         * 
         * @param {*} constext 
         */
        postDetailedData(constext) {
            const url = '/api/detailed';
            axios.post(url)
            .then(response => {
                console.log(response.data); // TODO
                constext.commit('detailedNumData', response.data.data);
            })
            .catch(error => {
                console.log(error.response); // TODO
                alert('수량 획득에 실패했습니다.(' + error.response.data.code + ')');
            });
        },
        // ----------------------- 민서 끝 ---------------------------
        // ----------------------- 호경 시작 -------------------------
        /**
         * 공지사항 획득
         * 
         * @param {*} context 
         */
        getNoticeData(context) {
            const url = '/api/noticelist';
            
            axios.get(url)
            .then(response => {
                console.log(response.data); // TODO
                context.commit('setNoticeData', response.data.data);
            })
            .catch(error => {
                console.log(error.response); // TODO
                alert('공지사항 습득에 실패했습니다.(' + error.response.data.code + ')');
            });
        },
        /**
         * 상품문의내역 획득
         * 
         * @param {*} context 
         */
        getQnaProductListData(context) {
            const url = '/api/qnaproductlist';
            
            axios.get(url)
            .then(response => {
                console.log(response.data); // TODO
                context.commit('setQnaProductListData', response.data.data);
            })
            .catch(error => {
                console.log(error.response); // TODO
                alert('상품문의내역 습득에 실패했습니다.(' + error.response.data.code + ')');
            });
        },

        /**
         * 상품문의 작성
         * 
         * @param {*} context
         */
        qnaProductCreate(context) {
            const url = '/api/qnaproduct';
            const data = new FormData(document.querySelector('#qnaProductForm'));

            axios.post(url, data)
            .then(response => {
                if(context.state.qnaProductListData.length > 1) {
                    context.commit('setUnshiftQnaProductData', response.data.data);
                }
                
                console.log(response.data); // TODO
                router.replace('/qnaproductlist');
            })
            .catch(error => {
                console.log(error.response); // TODO
                alert('글 작성에 실패했습니다.(' + error.response.data.code + ')');
            });
        },

        /**
         * 1:1문의내역 획득
         * 
         * @param {*} context 
         */
        getQnaOneByOnetData(context) {
            const url = '/api/qnaonebyonelist';
            
            axios.get(url)
            .then(response => {
                console.log(response.data); // TODO
                context.commit('setQnaOneByOneListData', response.data.data);
            })
            .catch(error => {
                console.log(error.response); // TODO
                alert('1:1문의내역 습득에 실패했습니다.(' + error.response.data.code + ')');
            });
        },

        /**
         * 1:1 문의 작성
         * 
         * @param {*} context
         */
        qnaOnebyOneCreate(context) {
            const url = '/api/qnaonebyone';
            const data = new FormData(document.querySelector('#qnaOneByOneForm'));

            axios.post(url, data)
            .then(response => {
                if(context.state.qnaOneByOneListData.length > 1) {
                    context.commit('setUnshiftQnaOneByOneData', response.data.data);
                }
                
                console.log(response.data); // TODO
                router.replace('/qnaonebyonelist');
            })
            .catch(error => {
                console.log(error.response); // TODO
                alert('글 작성에 실패했습니다.(' + error.response.data.code + ')');
            });
        },
        // ----------------------- 호경 끝 ---------------------------

    }
})

export default store;
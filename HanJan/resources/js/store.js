import axios from 'axios';
import { createStore } from 'vuex';
import router from './router';

const store = createStore({
    state() {
        return {
            // ----------------------- 보원 시작 -------------------------
            // 장바구니 상품 담을 리스트
            bagsProductData: [],
            // 리뷰 담을 리스트
            reviewData: [],
            // 리뷰관리 > 리뷰수정으로 데이터 넘기기
            reviewUpdateData :[],
            // ----------------------- 보원 끝 ---------------------------
            // ----------------------- 성환 시작 -------------------------
            authFlg: document.cookie.indexOf('auth=') >= 0 ? true : false,
            userInfo: localStorage.getItem('userInfo') ? JSON.parse(localStorage.getItem('userInfo')) : null,
            // ----------------------- 성환 끝 ---------------------------
            // ----------------------- 민서 시작 -------------------------
            // 상품 정보
            productDetail: {},
            // 상품 게시물 리스트
            listData: [],
            // ----------------------- 민서 끝 ---------------------------
            // ----------------------- 호경 시작 -------------------------
            // 공지사항 게시물 리스트
            noticeData: [],
            // // 공지사항 게시물 리스트 6개
            // noticeDataSix: [],
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
        // state.리뷰에 추가 될 리스트
        reviewSetData(state, data) {
            state.reviewData = data;
        },
        // 리뷰관리에서 수정 페이지로 넘어갈때 데이터 전달
        reviewUpdateData(state, data) {
            state.reviewUpdateData = data;
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
        
        // 상품리스트
        listInfoData(state, data) {
            state.listData = data;
        },
        // 상품리스트 데이터 보내기
        setProductDetailData(state, data) {
            state.productDetail = data;
        },
        // ----------------------- 민서 끝 ---------------------------
        // ----------------------- 호경 시작 -------------------------
        // 공지사항 게시물 리스트
        setNoticeData(state, data) {
            state.noticeData = data;
        },
        // // 공지사항 게시물 리스트 6개
        // setNoticeDataSix(state, data) {
        //     state.noticeDataSix = data;
        // },
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
                alert('장바구니 상품 획득에 실패했습니다.(' + error.response.data.code + ')' )
            });
        },
        
        /**
         * 장바구니에 목록 삭제
         * 
         * @param {*} context
         * @param {*} ba_id
        */
        bagsDelete(context, ba_id) {
            const url = '/api/bagsDelete/' + ba_id;
            
            axios.delete(url)
            .then(response => {
                console.log(response.data); // TODO : 삭제
            })
            .catch(error => {
                console.log(error.response); //  TODO : 삭제
                alert('장바구니 삭제에 실패했습니다.(' + error.response.data.code + ')' )
            });

        },
        
        
        
        /**
         * 리뷰관리에 최초 게시글 획득
         * 
         * @param {*} context
        */
        reviewGet(context) {
           const url = '/api/review';
           
           axios.get(url)
           .then(response => {
               console.log(response.data); // TODO : 삭제
               
               // 데이터베이스->서버를 통해 받은 데이터를 reviewtData에 저장
               context.commit('reviewSetData', response.data.data);
            })
            .catch(error => {
                console.log(error.response); //  TODO : 삭제
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
            const reviewUpdateData = context.commit('reviewUpdateData', item);
            router.replace('/reviewupdate');
        },

        /**
         * 리뷰수정 완료
         * 
         * @param {*} context
        */
        reviewUpdateSubmit(context, re_id) {
            const url = '/api/reviewUpdateSubmit' + re_id;
            
            axios.get(url)
            .then(response => {
                console.log(response.data); // TODO : 삭제
                
                // 데이터베이스->서버를 통해 받은 데이터를 reviewtData에 저장
                context.commit('reviewSetData', response.data.data);
                })
                .catch(error => {
                    console.log(error.response); //  TODO : 삭제
                    alert('리뷰 획득에 실패하였습니다.(' + error.response.data.code + ')' )
                });
        }, 

        /**
         * 리뷰관리에서 리뷰 삭제
         * 
         * @param {*} context
         * @param {*} re_id
        */
        reviewDelete(context, re_id) {
            const url = '/api/reviewDelete/' + re_id;
            
            if (confirm('확인을 누르면 작성한 리뷰가 삭제됩니다.')) {
                axios.delete(url)
                .then(response => {
                    console.log(response.data); // TODO : 삭제
                })
                .catch(error => {
                    console.log(error.response); //  TODO : 삭제
                    alert('리뷰 삭제에 실패했습니다.(' + error.response.data.code + ')' )
                });

            } else {
                console.log('confirm false');
            }



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
            const url = '/api/regist';
            const data = new FormData(document.querySelector('#regist_form'));

            axios.post(url, data)
            .then(response => {
                router.replace('login');
            })
            .catch(error => {
                console.log(error.response.data.code);
            });

        },
        // 이메일 중복체크
        chkEmailOn(context, emailText) {
            const url = '/api/regist/' + emailText;
            axios.get(url)
            .then(response => {
                if (response.data.exists) {
                    alert('이미 사용 중인 이메일입니다.');
                } else {
                    alert('사용 가능한 이메일입니다.');
                }
            })
            .catch(error => {
                console.error('이메일 확인 중 오류 발생:', error);
                emailError.value = '이메일 중복 확인 중 오류가 발생했습니다.';
            });
        },

        // 회원정보 수정
        userUpdate(context) {
            const url = '/api/userUpdate';
            const data = new FormData(document.querySelector('#update_form'));
            axios.post(url, data)
            .then(response => {
                router.replace('info');
            })
            .catch(error => {
                console.log(error.response.data.code);
            });
        },

        //회원 탈퇴
        userDelete(context) {
            const url = '/api/userDelete';
            const data = new FormData(document.querySelector('#update_form'));
            axios.delete(url, data)
            .then(response => {
                localStorage.clear();

                context.commit('setAuthFlg', false);
                context.commit('setUserInfo', null);
                router.replace('/');
            })
            .catch(error => {
                console.log(error.response.data.code);
            });
        },
        
        
        // ----------------------- 성환 끝 ---------------------------
        // ----------------------- 민서 시작 -------------------------
        /**
         * 상품상세페이지 값 획득
         * 
         * @param {*} context
         */
        setProductDetailData(context) {
            const url = '/api/detailed';

            axios.get(url)
            .then(response => {
                console.log(response.data); // TODO : 삭제

                // 데이터베이스->서버를 통해 받은 데이터를 valuedData 저장
                context.commit('detailedNumData', response.data.data);
            })
            .catch(error => {
                console.log(error.response.data); //  TODO : 삭제
                alert('장바구니에 담긴 상품이 없습니다.(' + error.response.data.code + ')' )
            });
        },

        /**
         * 상품획득
         * 
         * @param {*} context
         */
        getList(context) {
            const url = '/api/list';

            axios.get(url)
            .then(response => {
                console.log(response.data); // TODO : 삭제

                // 데이터베이스->서버를 통해 받은 데이터를 listData 저장
                context.commit('listInfoData', response.data.data);
            })
            .catch(error => {
                console.log(error.response.data); //  TODO : 삭제
                alert('선택한 상품이 없습니다.(' + error.response.data.code + ')' )
            });
        },

        /**
         * 상품정보 획득 상세페이지로 데이터 보내기
         * 
         * @param {*} constext 
         */
        // setProductDetailData(constext) {
        //     const url = '/api/list';
        //     const data = new FormData(document.querySelector('#listPostForm'));

        //     axios.post(url, data)
        //     .then(response => {
        //         console.log(response.data); // TODO
        //         constext.commit('detailedNumData', response.data.data);
        //     })
        //     .catch(error => {
        //         console.log(error.response); // TODO
        //         alert('수량 획득에 실패했습니다.(' + error.response.data.code + ')');
        //     });
        // },
        // ----------------------- 민서 끝 ---------------------------
        // ----------------------- 호경 시작 -------------------------
        /**
         * 공지사항 획득
         * 
         * @param {*} context 
         */
        getNoticeData(context, page) {
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
        // /**
        //  * 공지사항 6개 획득
        //  * 
        //  * @param {*} context 
        //  */
        // getNoticeDataSix(context) {
        //     const url = '/api/noticelist';
            
        //     axios.get(url)
        //     .then(response => {
        //         console.log(response.data); // TODO
        //         context.commit('setNoticeDataSix', response.data.data);
        //     })
        //     .catch(error => {
        //         console.log(error.response); // TODO
        //         alert('공지사항 습득에 실패했습니다.(' + error.response.data.code + ')');
        //     });
        // },
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
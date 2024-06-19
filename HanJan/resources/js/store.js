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
            // 리뷰관리 > 리뷰수정으로 데이터 넘기기(로컬스토리지에 저장하기 - 새로고침 누를시 없어지는 걸 방지)
            // reviewUpdateData :[],
            reviewToUpdate: localStorage.getItem('reviewToUpdate') ? JSON.parse(localStorage.getItem('reviewToUpdate')) : null,

            
            // ----------------------- 보원 끝 ---------------------------
            // ----------------------- 성환 시작 -------------------------
            authFlg: document.cookie.indexOf('auth=') >= 0 ? true : false,
            userInfo: localStorage.getItem('userInfo') ? JSON.parse(localStorage.getItem('userInfo')) : null,
            infoData: [],
            // ----------------------- 성환 끝 ---------------------------
            // ----------------------- 민서 시작 -------------------------
            // 상품 정보
            productDetail: {},
            // 베스트 정보
            bastData: [],
            // 상품 게시물 리스트
            listData: [],
            // 리뷰 게시물 리스트
            reviewDetail: [],
            // 디테일->장바구니 데이터 보내기
            CountData: [],
            // ----------------------- 민서 끝 ---------------------------
            // ----------------------- 호경 시작 -------------------------
            // 리뷰 게시물 리스트
            reviewListData: [],
            // 공지사항 게시물 리스트
            noticeData: localStorage.getItem('noticeData') ? JSON.parse(localStorage.getItem('noticeData')) : {current_page: '1'},
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
        reviewToUpdate(state, data) {
            state.reviewToUpdate = data;
            localStorage.setItem('reviewToUpdate', JSON.stringify(data));
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
        // 마이페이지 상품목록
        infoSetData(state, data) {
            state.infoData = data;
        },
        // 상품문의목록
        productAskSetData(state, data) {
            state.productAskData = data;
        },
        // 상품문의 삭제
        productAskDelete(state, data) {
            state.productAskDelete = data;
        },
        // 1:1문의 목록
        askSetData(state, data) {
            state.askSetData = data;
        },
        // 1:1문의 목록 삭제
        askSetDelete(state, data) {
            state.askSetDelete = data;
        },
        // ----------------------- 성환 끝 ---------------------------
        // ----------------------- 민서 시작 -------------------------
        
        // 상품리스트
        listInfoData(state, data) {
            state.listData = data;
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
        // ----------------------- 민서 끝 ---------------------------
        // ----------------------- 호경 시작 -------------------------
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
                // 데이터베이스->서버를 통해 받은 데이터를 bagsProductData에 저장
                context.commit('bagsSetProductData', response.data.data);
            })
            .catch(error => {
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
            // localStorage.setItem('reviewToUpdate', JSON.stringify(reviewUpdateData));

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
            
            if (confirm('확인을 누르면 작성한 리뷰가 삭제됩니다.')) {
                axios.delete(url)
                .then(response => {
                    console.log(response.data); // TODO : 삭제
                })
                .catch(error => {
                    alert('리뷰 삭제에 실패했습니다.(' + error.response.data.code + ')' )
                });

            } else {
                console.log('confirm false');
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

                router.replace('/info');
            })
            .catch(error => {
                console.log(error.response); //  TODO : 삭제
                alert('리뷰 작성에 실패하였습니다.(' + error.response.data.code + ')' )
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

                alert('리뷰 수정을 완료하였습니다.');
            })
            .catch(error => {
                alert('리뷰 수정에 실패하였습니다.(' + error.response.data.code + ')' )
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

        // 회원 탈퇴
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

        // 수정 전 비밀번호 재확인
        confirm(context, password) {
            const url = '/api/confirm';
            axios.post(url, { password: password })
            .then(response => {
                if (response.data.exists) {
                    router.replace('/update');
                } else {
                    alert('비밀번호가 일치하지 않습니다.');
                }
            })
            .catch();
        },

        // 마이페이지에서 주문목록 불러오기
        infoData(context) {
            const url = '/api/info';
            
            axios.get(url)
            .then(response => {
                context.commit('infoSetData', response.data.data);
             })
             .catch(error => {
                 alert('주문목록 불러오기 실패.(' + error.response.data.code + ')' )
             });
         }, 

        // 상품 문의목록 불러오기
        productAskData(context) {
            const url = '/api/productAsk';
            axios.get(url)
            .then(response => {
                context.commit('productAskSetData', response.data.data);
                console.log(response.data.data);
             })
             .catch(error => {
                 alert('문의목록 불러오기 실패.(' + error.response.data.code + ')' )
             });
         }, 

        //  상품 문의 삭제
        productAskDelete(context, qnp_id) {
            const url = '/api/productAskDelete/' + qnp_id;
            if (confirm('확인을 누르면 작성한 상품 문의가 삭제됩니다.')) {
                axios.delete(url)
                .then(response => {
                    router.replace('/info');
                    console.log(response.data); // TODO : 삭제
                })
                .catch(error => {
                    alert('삭제에 실패했습니다.(' + error.response.data.code + ')' )
                });

            } else {
                console.log('confirm false');
            }
        },

        // 1:1 문의목록 불러오기
        askData(context) {
            const url = '/api/askData';
            axios.get(url)
            .then(response => {
                context.commit('askSetData', response.data.data);
                console.log(response.data.data);
             })
             .catch(error => {
                 alert('문의목록 불러오기 실패.(' + error.response.data.code + ')' )
             });
         }, 
        
         //  1:1 문의 삭제
        askDelete(context, qn_id) {
            const url = '/api/askDelete/' + qn_id;
            if (confirm('확인을 누르면 작성한 1:1 문의가 삭제됩니다.')) {
                axios.delete(url)
                .then(response => {
                    router.replace('/info');
                    console.log(response.data); // TODO : 삭제
                })
                .catch(error => {
                    alert('삭제에 실패했습니다.(' + error.response.data.code + ')' )
                });

            } else {
                console.log('confirm false');
            }
        },

        // 구매확정
        completeBtn(context, id) {
            const url = '/api/complete/' + id;

            axios.post(url)
            .then(response => {
                console.log(response.data.data); // TODO : 삭제
                alert('구매 확정 완료')
            })
            .catch(error => {
                alert('실패했습니다.(' + error.response.data.code + ')' )
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
            console.log(url);
            axios.get(url)
            .then(response => {
                console.log('디테일 데이터', response.data); // TODO
                context.commit('detailedNumData', response.data.data);
            })
            .catch(error => {
                console.log(error.response.data); // TODO
                alert('상세정보 불러오기 실패했습니다.(' + error.response.data.code + ')');
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
                console.log(response.data);

                // 데이터베이스->서버를 통해 받은 데이터를 listData 저장
                context.commit('listInfoData', response.data.data);
            })
            .catch(error => {
                console.log(error.response.data); //  TODO : 삭제
                alert('선택한 상품이 없습니다.(' + error.response.data.code + ')' )
            });
        },
        /**
         * 베스트 상품 불러오기
         * 
         * @param {*} context
         */
        productBastDetail(context) {
            const url = '/api/listBast';

            axios.get(url)
            .then(response => {
                console.log('베스트 상품 데이터',response.data);
                // 데이터베이스->서버를 통해 받은 데이터를 bastData 저장
                context.commit('listBastData', response.data.data);
            })
            .catch(error => {
                console.log(error.response.data);
                alert('선택한 상품이 없습니다.(' + error.response.data.code + ')' )
            });
        },

        // /**
        //  * 리뷰 데이터 불러오기
        //  * 
        //  * @param {*} constext 
        //  */
        setProductReviewData(constext) {
            const url = '/api/detailed';

            axios.get(url)
            .then(response => {
                console.log('리뷰 데이터', response.data); // TODO
                // 데이터베이스->서버를 통해 받은 데이터를 reviewDetail 저장
                constext.commit('detailedReviewData', response.data.data);
            })
            .catch(error => {
                console.log(error.response.data); // TODO
                alert('리뷰데이터 불러오기 실패했습니다.(' + error.response.data.code + ')');
            });
        },

        // /**
        //  * 아이디 / 수량 데이터 보내기 (디테일->장바구니)
        //  * 
        //  * @param {*} constext 
        //  */
        detailedToCount(constext) {
            const url = '/api/detailedToCount';
            const data = new FormData(document.querySelector('#bagForm'));

            axios.post(url, data)
            .then(response => {
                console.log('수량데이터', response.data); // TODO
                // 데이터베이스->서버를 통해 받은 데이터를 CountData 저장
                constext.commit('detailedCountData', response.data.data);
            })
            .catch(error => {
                console.log(error.response.data); // TODO
                alert('리뷰데이터 불러오기 실패했습니다.(' + error.response.data.code + ')');
            });
        },
        // // ----------------------- 민서 끝 ---------------------------
        // ----------------------- 호경 시작 -------------------------
        /**
         * 리뷰 데이터 획득
         * 
         * @param {*} context 
         */
        getReviewistData(context) {
            const url = '/api/reviewlist';
            
            axios.get(url)
            .then(response => {
                console.log(response.data); // TODO
                context.commit('setReviewListData', response.data.data);
            })
            .catch(error => {
                console.log(error.response); // TODO
                alert('상품문의내역 습득에 실패했습니다.(' + error.response.data.code + ')');
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
                console.log(response.data); // TODO
                context.commit('setNoticeData', response.data.data);
            })
            .catch(error => {
                console.log(error.response); // TODO
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
                console.log('공지사항 데이터', response.data); // TODO
                context.commit('setNoticeDetailData', response.data.data);
            })
            .catch(error => {
                console.log(error.response.data); // TODO
                alert('공지사항 불러오기 실패했습니다.(' + error.response.data.code + ')');
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
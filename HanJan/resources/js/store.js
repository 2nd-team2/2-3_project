import axios from 'axios';
import { createStore } from 'vuex';
import router from './router';

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
            
            // ----------------------- 보원 끝 ---------------------------
            // ----------------------- 성환 시작 -------------------------
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
            // 리뷰 게시물 리스트
            reviewDetail: [],
            // 디테일->장바구니 데이터 보내기
            CountData: [],
            // 리스트페이지 메인 이미지
            currentImage: '',
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

            // // 장바구니에서 받은 데이터와 주문페이지에서 입력한 데이터 가공 처리
            // const orderItems = store.state.orderProductData.map(item => {
            //     const OrderItem = { ...orderComplete, ...item };
                
            //     return OrderItem;
            // });

            const data = JSON.stringify({ data: orderItems}); // 키값을 포함하여 서버에 전달
            console.log(data); // TODO : 삭제
            const url = '/api/orderTrans';

            axios.post(url, data)
            .then(response => {
                console.log(response.data);
                router.push('/ordercomplete');         
            })
            .catch(error => {
                alert('결제에 실패하였습니다.(' + error.response.data.code + ')' )
            });

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
                alert('로그아웃 (' + error.responseData.data.code + ')');
            })
            .finally(() => {
                localStorage.clear();
                context.commit('setAuthFlg', null);
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
                router.replace('login');
                alert('회원가입이 완료되었습니다.');
            })
            .catch(error => {
                alert('회원가입을 실패했습니다.');
            });
        },

        // 이메일 중복체크
        chkEmailOn(context, emailText) {
            if (!emailText) {
                alert('이메일을 입력해 주세요.');
                return;
            }
            const url = '/api/regist/' + emailText;
            axios.get(url)
            .then(responseData => {
                if (responseData.data.code === '2') {
                    alert('이미 사용 중인 이메일입니다.');
                } else if(responseData.data.code === '1') {
                    alert('유효하지 않은 이메일입니다. ');
                } else {
                    alert('사용 가능한 이메일입니다.');
                }
            })
            .catch(error => {
                error.value = '이메일 중복 확인 중 오류가 발생했습니다.';
            });
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
            if (confirm('정말 탈퇴 하시겠습니까?')) {
                axios.delete(url, data)
                .then(responseData => {
                    localStorage.clear();
                    context.commit('setAuthFlg', null);
                    context.commit('setUserInfo', null);
                    store.dispatch('getReviewistData');
                    
                    router.replace('/');
                });
            }
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
            if (confirm('확인을 누르면 구매한 상품이 삭제됩니다.')) {
                axios.delete(url)
                .then(responseData => {
                    context.dispatch('getInfoData', lastItemPaginate(context.state.infoData));
                })
                .catch(error => {
                    alert('삭제에 실패했습니다.(' + error.response.data.code + ')' )
                });
            }
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
            if (confirm('확인을 누르면 작성한 상품 문의가 삭제됩니다.')) {
                axios.delete(url)
                .then(responseData => {
                    context.dispatch('getProductAskData', lastItemPaginate(context.state.productAskData));
                })
                .catch(error => {
                    alert('삭제에 실패했습니다.(' + error.responseData.data.code + ')' )
                });
            }
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
            if (confirm('확인을 누르면 작성한 1:1 문의가 삭제됩니다.')) {
                axios.delete(url)
                .then(responseData => {
                    context.dispatch('getAskData', lastItemPaginate(context.state.askSetData));
                })
                .catch(error => {
                    alert('삭제에 실패했습니다.(' + error.responseData.data.code + ')' )
                });
            }
        },

        // 구매확정
        completeBtn(context, orp_id) {
            const url = '/api/complete/' + orp_id;
            if (confirm('확인을 누르면 구매가 확정됩니다.')) {
                axios.post(url)
                .then(responseData => {
                    context.dispatch('getInfoData', context.state.infoData.current_page);
                })
                .catch(error => {
                    alert('실패했습니다.(' + error.responseData.data.code + ')' )
                });
            }
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
                // console.log(response.data);

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
                if(confirm('확인을 클릭시 장바구니로 이동 됩니다.')) {
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
                console.log(response.data);
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
                console.log(response.data);
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
                console.log(response.data);
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
                
                console.log(response.data); 
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
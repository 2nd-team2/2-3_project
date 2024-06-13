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
            // ----------------------- 민서 시작 -------------------------
            detailedData: [],
            // ----------------------- 민서 끝 ---------------------------
            // ----------------------- 호경 시작 -------------------------
            noticeData: [],
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
        // ----------------------- 성환 끝 ---------------------------
        // ----------------------- 민서 시작 -------------------------
        detailedNumData(state, data) {
            state.detailedData = data;
        },
        // ----------------------- 민서 끝 ---------------------------
        // ----------------------- 호경 시작 -------------------------
        // 공지사항 삽입
        setNoticeData(state, data) {
            state.noticeData = data;
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
         * 최초 공지사항 획득
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
        // ----------------------- 호경 끝 ---------------------------

    }
})

export default store;
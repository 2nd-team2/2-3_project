import axios from 'axios';
import { createStore } from 'vuex';

const store = createStore({
    state() {
        // ----------------------- 보원 시작 -------------------------
        // ----------------------- 보원 끝 ---------------------------
        // ----------------------- 성환 시작 -------------------------
        // ----------------------- 성환 끝 ---------------------------
        // ----------------------- 민서 시작 -------------------------
        // ----------------------- 민서 끝 ---------------------------
        // ----------------------- 호경 시작 -------------------------
        // ----------------------- 호경 끝 ---------------------------
    },
    mutations: {
        // ----------------------- 보원 시작 -------------------------
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
        // ----------------------- 민서 끝 ---------------------------
        // ----------------------- 호경 시작 -------------------------
        // ----------------------- 호경 끝 ---------------------------
    },actions: {
        // ----------------------- 보원 시작 -------------------------
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
                console.log(response.data); // TODO
                localStorage.setItem('userInfo', JSON.stringify(response.data.data));
                context.commit('setUserInfo', response.data.data);
                context.commit('setAuthFlg', true);

                router.replace('/');
            })
            .catch(error => {
                console.log(error.response); // TODO
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
                alert('문제가 발생해 강제로그아웃 (' + error.response.data.code + ')');
            })
            .finally(() => {
                localStorage.clear();

                context.commit('setAuthFlg', false);
                context.commit('setUserInfo', null);

                router.replace('/login');
            });
        },

        // ----------------------- 성환 끝 ---------------------------
        // ----------------------- 민서 시작 -------------------------
        // ----------------------- 민서 끝 ---------------------------
        // ----------------------- 호경 시작 -------------------------
        // ----------------------- 호경 끝 ---------------------------

    }
})

export default store;
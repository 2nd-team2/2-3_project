<template>
    <main>
        <form id="login_form">
            <div class="leftInfo">
                <h2>로그인 / 회원가입</h2>
                <div class="inputGroup1">
                    <img :src="otterImg" class="face" @click="toggleImg('otterImg')">
                    <input type="text" name="email" class="login_input" placeholder="아이디">
                </div>
                <div class="inputGroup2">
                    <img :src="otterImg2" class="face" @click="toggleImg('otterImg2')">
                    <input type="password" name="password" id="password" class="login_input" placeholder="비밀번호" autocomplete="off">
                </div>
                <button type="button" class="loginBtn" @click="login">로그인</button>
                <button type="button" class="registBtn" @click="$router.push('agree')">회원가입</button>
                <a href="/api/kakao" class="kakaoBtn"><img src="/img/kakao_login_large_wide.png" class="kakaoBtn_img"></a>
                <!-- <a href="/api/kakao" class="kakaoBtn" @click.prevent="handleLinkClick"><img src="/img/kakao_login_large_wide.png" class="kakaoBtn_img"></a> -->
                <!-- <a @click="responseData" type="button" class="kakaoBtn"><img src="/img/kakao_login_large_wide.png" class="kakaoBtn_img"></a> -->
                <img class="rightPoto" src="/img/IE002927310_STD.png"></img>
            </div>
        </form>
    </main>
</template>

<script setup>
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

function login() {
  store.dispatch('login');
}

function resetForm() {
  const form = document.querySelector('#login_form');
  form.reset();
}


const otterImg = ref('/img/drunkOtter.png');
const otterImg2 = ref('/img/drunkOtter.png');
const alternateImg = '/img/drunkOtter3.png';

function toggleImg(imgRef) {
  if (imgRef === 'otterImg') {
    otterImg.value = otterImg.value === '/img/drunkOtter.png' ? alternateImg : '/img/drunkOtter.png';
  } else if (imgRef === 'otterImg2') {
    otterImg2.value = otterImg2.value === '/img/drunkOtter.png' ? alternateImg : '/img/drunkOtter.png';
  }
}

// 페이지가 로드될 때마다 폼을 초기화
onMounted(() => {
  resetForm();
});


// // 카카오톡 로그인
// function responseData() {
//     axios.get('/api/kakao')
// .then(responseData => {
//     console.log(responseData);
//     context.commit('setUserInfo', responseData.data.data);
//     localStorage.setItem('userInfo', JSON.stringify(responseData.data.data));
// })
// .catch(error => {
//     alert('1234.(' + error.response.data.code + ')');
// })
// }


// const userData = ref(null);
// const handleLinkClick = async () => {
//     try {
//       const response = await axios.get('/api/kakao');
//       userData.value = response.data;
//       store.commit('setUserData', response.data); // Vuex store에 데이터를 저장
//     } catch (error) {
//       console.error('데이터를 가져오는 중 오류 발생:', error);
//     }
// };
</script>

<style scoped src="../css/login.css">
</style>

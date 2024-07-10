<template>
    <main>
        <form id="login_form">
            <div class="leftInfo">
                <h2>로그인 / 회원가입</h2>
                <div class="inputGroup1">
                    <img :src="otterImg" class="face" @click="toggleImg('otterImg')">
                    <input type="text" name="email" class="login_input" placeholder="아이디" v-model="id">
                </div>
                <div class="inputGroup2">
                    <img :src="otterImg2" class="face" @click="toggleImg('otterImg2')">
                    <input type="password" name="password" id="password" class="login_input" placeholder="비밀번호" autocomplete="off" v-model="password">
                </div>
                <button type="button" class="loginBtn" @click="login">로그인</button>
                <button type="button" class="registBtn" @click="$router.push('agree')">회원가입</button>
                <a href="/api/kakao" class="kakaoBtn"><img src="/img/kakao_login_large_wide.png" class="kakaoBtn_img"></a>
                <img class="rightPoto" :src="OriginalAlcohol" @click="toggleAlcoholImg('OriginalAlcohol')">
            </div>
            <transition name="down">
              <div class="agree_box modal_second_overlay" v-show="showCompleteModal">
                  <div class="modal_second_window">
                      <div class="second_content">
                          <p>로그인 실패</p>
                          <br>
                          <img @click="closeSubmitModal" src="/img/complete.png" class="complete_btn">
                      </div>
                  </div>
              </div>
            </transition>
        </form>
    </main>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

const showCompleteModal = ref(false);
const id = ref('');
const password = ref('');

function login() {
  if(!id.value.trim() || !password.value.trim()) {
    showCompleteModal.value = true;
  } else {
    store.dispatch('login');
  }
}

function closeSubmitModal() {
  showCompleteModal.value = false;
}

function resetForm() {
  const form = document.querySelector('#login_form');
  form.reset();
}


const otterImg = ref('/img/drunkOtter.png');
const otterImg2 = ref('/img/drunkOtter.png');
const alternateImg = '/img/drunkOtter3.png';

const OriginalAlcohol = ref('/img/IE002927310_STD.png');
const KoreanAlcohol = '/img/KoreanAlcohol.png';

function toggleImg(imgRef) {
  if (imgRef === 'otterImg') {
    otterImg.value = otterImg.value === '/img/drunkOtter.png' ? alternateImg : '/img/drunkOtter.png';
  } else if (imgRef === 'otterImg2') {
    otterImg2.value = otterImg2.value === '/img/drunkOtter.png' ? alternateImg : '/img/drunkOtter.png';
  }
}

function toggleAlcoholImg() {
  OriginalAlcohol.value = OriginalAlcohol.value === '/img/IE002927310_STD.png' ? KoreanAlcohol : '/img/IE002927310_STD.png';
}


// 페이지가 로드될 때마다 폼을 초기화
onMounted(() => {
  resetForm();
});

</script>

<style scoped src="../css/login.css">
</style>
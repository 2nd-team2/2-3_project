<template>
    <main>
        <div class="container">
            <div class="regist">
                <h2>회원가입</h2>
                <ul class="regist_step">
                    <li>01 약관동의</li>
                    <li>></li>
                    <li>02 정보입력</li>
                    <li>></li>
                    <li>03 가입완료</li>
                </ul>
            </div>
            <form id="regist_form" @submit.prevent="validateForm">
                <div class="info_header">
                    <p class="info_header_title">기본정보</p>
                    <p class="note">* 표시는 반드시 입력하셔야 하는 항목입니다.</p>
                </div>
                <hr>
                <div v-if="$store.state.kakaoInfo" class="email_box info_item_box">
                    <label class="info_item_label" for="email">이메일</label>
                    <div class="info_item_input">
                        <p class="info_item_err_msg error">카카오 계정의 이메일 입니다. 변경 불가</p>
                        <input class="input_width" type="text" name="email" id="email" readonly :value="$store.state.kakaoInfo">
                    </div>
                </div>
                <div v-else class="email_box info_item_box">
                    <label class="info_item_label" for="email">이메일</label>
                    <div class="info_item_input">
                        <p class="info_item_err_msg error">{{ emailError }}</p>
                        <input v-if="$store.state.emailVerify" class="input_width" type="text" name="email" id="email" @input="chkEmail" v-model="emailText" placeholder="이메일 형식 예시) hanjan@hanjan.com">
                        <input v-else class="input_width" type="text" name="email" id="email" readonly @input="chkEmail" v-model="emailText">
                    </div>
                    <div class="verify info_verifyItem_input">

                        <div v-if="$store.state.emailVerify">
                            <p class="info_item_err_msg error">{{ codeError }}</p>
                            <button  type="button" class="info_item_btn form_btn email_chk_btn verifyButton" @click="emailVerifyChk">이메일 검증</button>
                        </div>

                        <form v-else class="verifyCode" id="verifyCode">
                            <div v-if="$store.state.emailCode">
                                <div v-if="timer > 0" class="timer">
                                    <div>남은 시간 : {{ timerText }}</div>
                                </div>
                                <p class="info_item_err_msg error">{{ codeError }}</p>
                                <input type="text" name="verifyCode" class="verifyinput" placeholder="검증 코드를 입려해 주세요.">
                                <button type="button" class="info_item_btn form_btn email_chk_btn" @click="$store.dispatch('codeChk')">코드 확인</button>
                            </div>
                            <div v-else>
                                <button type="button" class="form_btn email_chk_btn">검증 완료</button>
                            </div>
                        </form>
                    </div>
                </div>
                <hr>
                <div class="info_item_box">
                    <label class="info_item_label" for="password">비밀번호</label>
                    <div class="info_item_input">
                        <p class="info_item_err_msg">{{ passwordError }}</p>
                        <input class="input_width" type="password" v-model="password" name="password" id="password" @input="chkPassword" placeholder="대소문자, 특수문자(!@#$%^&*) 포함 8~20자 사이로 설정해 주세요.">
                    </div>
                </div>
                <hr>
                <div class="info_item_box">
                    <label class="info_item_label" for="password_chk">비밀번호 확인</label>
                    <div class="info_item_input">
                        <p class="info_item_err_msg">{{ passwordChkError }}</p>
                        <input class="input_width" type="password" v-model="passwordChk" name="password_chk" id="password_chk" @input="chkPasswordChk">
                    </div>
                </div>
                <hr>
                <div class="info_item_box">
                    <label class="info_item_label" for="name">이름</label>
                    <div class="info_item_input">
                        <p class="info_item_err_msg">{{ nameError }}</p>
                        <input class="input_width" type="text" name="name" id="name" v-model="name" @input="chkName" placeholder="영어 대소문자, 한글로 10자 이내 설정해 주세요.">
                    </div>
                </div>
                
                <hr>
                <div class="info_item_box">
                    <label class="info_item_label" for="phone">휴대전화번호</label>
                    <div class="info_item_input">
                        <p class="info_item_err_msg">{{ phoneError }}</p>
                        <input class="input_width" placeholder="-를 제외한 숫자만 입력해주세요" type="text" name="tel" id="tel" v-model="phone" @input="chkPhone">
                    </div>
                </div>
                <hr>
                <div class="info_item_box address">
                    <label class="info_item_label address_text" for="address">주소</label>
                    <div class="info_item_input">
                        <p class="info_item_err">{{ addressError }}</p>
                        <input class="input_width top_input" type="text" name="addr" id="address" v-model="address" @input="chkAddress" readonly @click="kakaoPostcode" placeholder="주소 검색을 클릭하여 작성해 주세요.">
                        <input class="postcode" type="text" readonly v-model="postcode" name="post">
                        <label class="address_detail_label" for="address">상세주소</label>
                        <input class="input_width address_detail" type="text" name="det_addr" id="address_detail" v-model="detailAddress">
                        <button type="button" class="info_item_btn form_btn_address" @click="kakaoPostcode" id="postcode">주소검색</button>
                    </div>
                </div>
                <hr>
                <div class="info_item_box">
                    <label class="info_item_label" for="birth">생년월일</label>
                    <div class="info_item_input">
                        <p class="info_item_err_msg">{{ birthError }}</p>
                        <input class="input_width" type="date" name="birth" id="birth" v-model="birth" @input="chkBirth">
                    </div>
                </div>
                <hr>
                <br>
                <div class="buttons twobuttons">
                    <button type="button" class="info_item_btn form_btn" @click="$router.push('/')">취소</button>
                    <button type="submit" class="info_item_btn form_btn">확인</button>
                </div>
                <transition name="down">
                    <div class="agree_box modal_second_overlay" v-show="showSubmitModal">
                        <div class="modal_second_window">
                            <div class="second_content">
                                <p>필수 입력사항을 확인해주세요.</p>
                                <br>
                                <img @click="closeSubmitModal" src="/img/complete.png" class="complete_btn">
                            </div>
                        </div>
                    </div>
                </transition>
                <transition name="down">
                    <div class="agree_box modal_second_overlay" v-show="showCompleteModal">
                        <div class="modal_second_window">
                            <div class="second_content">
                                <p>회원가입 완료!</p>
                            </div>
                        </div>
                    </div>
                </transition>
                <transition name="down">
                    <div class="agree_box modal_second_overlay" v-show="showEmailChkModal">
                        <div class="modal_second_window">
                            <div class="second_content">
                                <p>이메일을 입력해주세요.</p>
                                <br>
                                <img @click="closeEmailChkModal" src="/img/complete.png" class="complete_btn">
                            </div>
                        </div>
                    </div>
                </transition>
            </form>
        </div>
    </main>
</template>
<script setup>
import { onMounted, ref, computed, onBeforeUnmount } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

// 실시간 유효성 체크
const emailText = ref('');
const password = ref('');
const passwordChk = ref('');
const phone = ref('');
const address = ref('');
const detailAddress = ref('');
const postcode = ref('');
const birth = ref('');
const name = ref('');

const emailError = ref('');
const codeError = ref('');
const passwordError = ref('');
const passwordChkError = ref('');
const nameError = ref('');
const phoneError = ref('');
const addressError = ref('');

const birthError = ref('');

function chkEmail() {
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailPattern.test(emailText.value)) {
    emailError.value = '이메일 주소가 형식에 맞지 않습니다.';
  } else {
    emailError.value = '';
  }
}

function chkCode() {
  if (store.state.emailVerify || store.state.emailCode) {
    codeError.value = '이메일 검증을 완료해 주세요.';
  } else {
    codeError.value = '';
  }
}

function chkPassword() {
    // const passwordPattern = /^(?=.*[!@#$%^&*])[가-힣a-zA-Z!@#$%^&*]{8,20}$/;
    const passwordPattern = /^[가-힣a-zA-Z0-9!@#$%^&*]{1,20}$/;
    if (!passwordPattern.test(password.value)) {
    // if (password.value.length < 8 || password.value.length > 20) {
        passwordError.value = '비밀번호 형식에 맞지 습니다.';
    } else {
        passwordError.value = '';
    }
}

function chkPasswordChk() {
  if (password.value !== passwordChk.value) {
    passwordChkError.value = '비밀번호가 일치하지 않습니다.';
  } else {
    passwordChkError.value = '';
  }
}

function chkName() {
  const namePattern = /^[가-힣a-zA-Z]+$/;
  if (!namePattern.test(name.value) || name.value.length > 10) {
    nameError.value = '이름은 영어 대소문자와 한글로 10자 이내로 설정해 주세요.';
  } else {
    nameError.value = '';
  }
}

function chkPhone() {
  const phonePattern = /^\d{10,11}$/;
  if (!phonePattern.test(phone.value)) {
    phoneError.value = '전화번호는 숫자 10,11자로 설정해 주세요.';
  } else {
    phoneError.value = '';
  }
}

function chkAddress() {
  if (address.value === '') {
    addressError.value = '주소 형식이 맞지 않습니다.';
  } else {
    addressError.value = '';
  }
}

function chkBirth() {
  if (!birth.value) {
    birthError.value = '생년월일을 입력해 주세요.';
    return;
  }
  const birthDate = new Date(birth.value);
  const today = new Date();
  let age = today.getFullYear() - birthDate.getFullYear();
  const monthDifference = today.getMonth() - birthDate.getMonth();
  if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
    age--;
  }
  if (age < 19) {
    birthError.value = '만 19세 이상만 가입이 가능합니다.';
  } else {
    birthError.value = '';
  }
}

function validateForm() {
    let valid = true;
    
    // chkEmail();
    // if (emailError.value) valid = false; 

    if (store.state.kakaoInfo === null ) {
        chkEmail();
        if (emailError.value) {valid = false}; 
             
        chkCode();
        if (codeError.value) {valid = false};
    }

    chkPassword();
    if (passwordError.value) {valid = false};

    chkPasswordChk();
    if (passwordChkError.value) {valid = false};

    chkName();
    if (nameError.value) {valid = false};

    chkPhone();
    if (phoneError.value) {valid = false};

    chkAddress();
    if (addressError.value) {valid = false};

    chkBirth();
    if (birthError.value) {valid = false};

    if (valid) {
      store.dispatch('regist');
      showCompleteModal.value = true;
    } else {
      showSubmitModal.value = true;
    }
}

const showSubmitModal = ref(false);
const showCompleteModal = ref(false);
const showEmailChkModal = ref(false);

function closeSubmitModal() {
    showSubmitModal.value = false;
}

function closeEmailChkModal() {
    showEmailChkModal.value = false;
}


// 검증 타이머
let timer = ref(0);
let interval = null;

const timerText = computed(() => {
  const minutes = Math.floor(timer.value / 60);
  const seconds = timer.value % 60;
  return `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
});

function startTimer() {
  timer.value = 304; // 5분 = 300초
  interval = setInterval(() => {
    if (timer.value > 0) {
      timer.value--;
    } else {
      clearInterval(interval);
    }
  }, 1000);
}

function stopTimer() {
  clearInterval(interval);
}

onBeforeUnmount(() => {
  stopTimer();
});


// 이메일 인증 처리
let isCheckingEmail = ref(false);

const emailVerifyChk = async () => {
    if (isCheckingEmail.value) {
        alert('이미 이메일 검증이 진행 중입니다. 잠시만 기다려 주세요.');
        return; // 여러 번 클릭 방지
    }
    if (!emailText.value) {
        showEmailChkModal.value = true;
        return;
    }
    
    isCheckingEmail = true; // 이메일 확인 진행 중임을 표시

    if(confirm('확인을 누르면 이메일 검증을 시작합니다.')) {
        alert('잠시만 기다려 주세요.')
        try {
            await store.dispatch('chkEmailOn', emailText.value)
            .then(
                startTimer() // 타이머 시작
            );
        } catch (error) {
            console.error('이메일 인증 처리 중 오류가 발생했습니다:', error);
        } finally {
            isCheckingEmail = false; // 확인 완료 후 플래그 리셋
        }

    }

};


// 새로 고침 후 이메일 로드
onMounted(() => {
    const savedEmail = localStorage.getItem('email');
    const emailVerify = localStorage.getItem('emailVerify');
    const emailCode = localStorage.getItem('emailCode');

    if (savedEmail !== 'null') {
        emailText.value = savedEmail;
    }
    if (emailVerify !== null) {
        store.commit('setEmailVerify', emailVerify === 'true');
    }
    if (emailCode !== null) {
        store.commit('setEmailCode', emailCode === 'true');
    }
});

// 카카오 주소 API
function kakaoPostcode() {
    new daum.Postcode({
        oncomplete: function(data) {
            // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

            // 각 주소의 노출 규칙에 따라 주소를 조합한다.
            // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
            var addr = ''; // 주소 변수
            var extraAddr = ''; // 참고항목 변수

            //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
            if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                addr = data.roadAddress;
            } else { // 사용자가 지번 주소를 선택했을 경우(J)
                addr = data.jibunAddress;
            }

            // 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
            if(data.userSelectedType === 'R'){
                // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                    extraAddr += data.bname;
                }
                // 건물명이 있고, 공동주택일 경우 추가한다.
                if(data.buildingName !== '' && data.apartment === 'Y'){
                    extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                }
                // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                if(extraAddr !== ''){
                    extraAddr = ' (' + extraAddr + ')';
                }
            
            }

            // 우편번호와 주소 정보를 해당 필드에 넣는다.
            postcode.value = data.zonecode;
            // 주소 필드에 삽입
            address.value = addr;
            // 에러 메시지 초기화
            addressError.value = '';
            // 커서를 상세주소 필드로 이동한다.
            document.querySelector('#address_detail').focus();
        }
    }).open();
}

</script>
<style scoped src="../css/regist.css">
</style>
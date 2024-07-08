<template>
    <div class="admin">
        <form id="adminUserUpdateForm" @submit.prevent="validateForm">
            <h2 class="admin_title">유저 정보 수정</h2>
            <div class="admin_user_input_box">
                <input type="hidden" name="id" :value="$store.state.adminUserToUpdate.id">
                <label for="name" class="admin_user_info0">유저 이름</label>
                <p class="admin_error">{{ nameError }}</p>
                <input @input="chkName" type="text" name="name" id="name" autocomplete='off' v-model="name" class="admin_user_info1">
                <label for="email" class="admin_user_info2">이메일</label>
                <p class="admin_error">{{ emailError }}</p>
                <input @input="chkEmail" type="email" name="email" id="email" autocomplete='off' v-model="email" class="admin_user_info3">
                <label for="tel" class="admin_user_info4">휴대전화</label>
                <p class="admin_error">{{ phoneError }}</p>
                <input @input="chkPhone" type="text" name="tel" id="tel" autocomplete='off' placeholder="-를 제외한 숫자만 입력해주세요" v-model="tel" class="admin_user_info5">
                <label for="addr" class="admin_user_info6">주소</label>
                <p class="admin_error">{{ addressError }}</p>
                <input @input="chkAddress" readonly type="text" name="addr" id="addr" autocomplete='off' v-model="address" @click="kakaoPostcode" class="admin_user_info7">
                <label for="det_addr" class="admin_user_info8">상세 주소</label>
                <input type="text" name="det_addr" id="det_addr" autocomplete='off' v-model="detAddr" class="admin_user_info9">
                <label for="post" class="admin_user_info10">우편번호</label>
                <input readonly type="text" name="post" id="post" autocomplete='off' v-model="post" class="admin_user_info11">
                <button type="button" @click="kakaoPostcode" id="postcode" class="admin_btn admin_user_info7">주소검색</button>
                <label for="birth" class="admin_user_info12">생년월일</label>
                <p class="admin_error">{{ birthError }}</p>
                <input @input="chkBirth" type="date" name="birth" id="birth" autocomplete='off' v-model="birth" class="admin_user_info13 admin_user_date">
            </div>

            <div class="admin_hr"></div>
            <div class="admin_btn_box">
                <button type="button" @click="$router.back()" class="admin_btn">취소하기</button>
                <button type="button" @click="$store.dispatch('userUpdateSubmit')" class="admin_btn">수정하기</button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

// 실시간 유효성 체크
const name = ref(store.state.adminUserToUpdate.name);
const email = ref(store.state.adminUserToUpdate.email);
const tel = ref(store.state.adminUserToUpdate.tel);
const address = ref(store.state.adminUserToUpdate.addr);
const detAddr = ref(store.state.adminUserToUpdate.det_addr);
const post = ref(store.state.adminUserToUpdate.post);
const birth = ref(store.state.adminUserToUpdate.birth);

const emailError = ref('');
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

function chkName() {
  const namePattern = /^[가-힣a-zA-Z]+$/;
  if (!namePattern.test(name.value) || name.value.length > 10) {
    nameError.value = '이름은 영어 대소문자와 한글로 10자 이내로 설정해주세요.';
  } else {
    nameError.value = '';
  }
}

function chkPhone() {
  const phonePattern = /^\d{10,11}$/;
  if (!phonePattern.test(tel.value)) {
    phoneError.value = '전화번호는 숫자 10,11자로 설정 해주세요.';
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
    birthError.value = '생년월일을 입력해주세요.';
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

    if (!store.state.kakaoInfo) {
        chkEmail();
        if (emailError.value) valid = false;
    }

    chkPasswordChk();
    if (passwordChkError.value) valid = false;

    chkName();
    if (nameError.value) valid = false;

    chkPhone();
    if (phoneError.value) valid = false;

    chkAddress();
    if (addressError.value) valid = false;

    chkBirth();
    if (birthError.value) valid = false;

    if (valid) {
      store.dispatch('regist');
    } else {
      alert('회원가입에 실패했습니다.');
    }
}

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
            post.value = data.zonecode;
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

<style>

</style>
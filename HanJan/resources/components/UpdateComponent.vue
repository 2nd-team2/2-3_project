<template>
    <main>
        <div class="container">
            <div class="regist">
                <h2>회원정보 수정</h2>
            </div>
            <form id="update_form" @submit.prevent="validateForm">
                <div class="info_header">
                    <p class="info_header_title">기본정보</p>
                    <p class="note">* 표시는 반드시 입력하셔야 하는 항목입니다.</p>
                </div>
                <hr>
                <div class="info_item_box">
                    <label class="info_item_label" for="email">이메일</label>
                    <div class="info_item_input">
                        <span class="bold_span">{{ $store.state.userInfo.email }}</span>
                    </div>
                </div>
                <hr>
                <div class="info_item_box vital">
                    <label class="info_item_label" for="password">비밀번호</label>
                    <div class="info_item_input">
                        <p id="passwordError" class="info_item_err_msg">{{ passwordError }}</p>
                        <input type="password" v-model="password" name="password" id="password" @input="chkPassword">
                    </div>
                </div>
                <hr>
                <div class="info_item_box vital">
                    <label class="info_item_label" for="password_chk">비밀번호 확인</label>
                    <div class="info_item_input">
                        <p class="info_item_err_msg">{{ passwordChkError }}</p>
                        <input type="password" v-model="passwordChk" name="password_chk" id="password_chk" @input="chkPasswordChk">
                    </div>
                </div>
                <hr>
                <div class="info_item_box">
                    <label class="info_item_label" for="name">이름</label>
                    <div class="info_item_input">
                        <p class="info_item_err_msg"></p>
                        <span class="bold_span">
                          {{ $store.state.userInfo.name }}
                        </span>
                    </div>
                </div>
                <hr>
                <div class="info_item_box vital">
                    <label class="info_item_label" for="phone">휴대전화번호</label>
                    <div class="info_item_input">
                        <p class="info_item_err_msg">{{ phoneError }}</p>
                        <input placeholder="-를 제외한 숫자만 입력해주세요" type="text" name="tel" v-model="phone" id="phone" @input="chkPhone">
                    </div>
                </div>
                <hr>
                <div class="info_item_box address vital">
                    <label class="info_item_label address_text" for="address">주소</label>
                    <div class="info_item_input">
                        <p class="info_item_err_msg">{{ addressError }}</p>
                        <input type="text" name="addr" id="address" class="top_input" v-model="address" readonly @click="kakaoPostcode">
                        <input type="text" readonly v-model="postcode" class="postcode" name="post">
                        <label class="address_detail_label" for="address">상세주소</label>
                        <input type="text" class="address_detail" name="det_addr" id="address_detail" v-model="detailAddress">
                        <button type="button" class="info_item_btn form_btn_address" @click="kakaoPostcode" id="postcode">주소검색</button>
                    </div>
                </div>
                <hr>
                <div class="info_item_box">
                    <label class="info_item_label" for="birth">생년월일</label>
                    <div class="info_item_input">
                        <span class="bold_span">{{ $store.state.userInfo.birth }}</span>
                    </div>
                </div>
                <hr>
                <br>
                <div class="buttons twobuttons">
                    <button type="reset" class="info_item_btn form_btn" @click="$router.back()">취소</button>
                    <button type="submit" class="info_item_btn form_btn">확인</button>
                    <button type="button" class="info_item_btn form_btn" @click="$store.dispatch('userDelete')">탈퇴</button>
                </div>
            </form>
        </div>
    </main>
</template>

<script setup>
import { ref } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

const password = ref('');
const passwordChk = ref('');
const phone = ref(store.state.userInfo.tel);
const address = ref(store.state.userInfo.addr);
const detailAddress = ref(store.state.userInfo.det_addr);
const postcode = ref(store.state.userInfo.post);

const passwordError = ref('');
const passwordChkError = ref('');
const phoneError = ref('');

function chkPassword() {
  if (!password.value || password.value.length < 8 || password.value.length > 20) {
    passwordError.value = '비밀번호는 8 ~ 20자 사이로 설정 해주세요.';
  } else if (/\s/.test(password.value)) {
    passwordError.value = '비밀번호에는 공백을 포함할 수 없습니다.';
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

function chkPhone() {
  const phonePattern = /^\d{10,11}$/;
  if (!phonePattern.test(phone.value)) {
    phoneError.value = '전화번호는 숫자 10,11자로 설정 해주세요.';
  } else {
    phoneError.value = '';
  }
}

function validateForm() {
  let valid = true;

  chkPassword();
  if (passwordError.value) valid = false;

  chkPasswordChk();
  if (passwordChkError.value) valid = false;

  chkPhone();
  if (phoneError.value) valid = false;

  if (valid) {
    store.dispatch('userUpdate');
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
                // 법정동명이 있을 경우 추가한다. (법정리는 제외)
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
                // 조합된 참고항목을 해당 필드에 넣는다.
                // document.getElementById("sample6_extraAddress").value = extraAddr;
            
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

<style scoped src="../css/update.css">
</style>
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
            <form id="regist_form">
                <div class="info_header">
                    <p class="info_header_title">기본정보</p>
                    <p class="note">* 표시는 반드시 입력하셔야 하는 항목입니다.</p>
                </div>
                <hr>
                <div class="info_item_box">
                    <label class="info_item_label" for="email">이메일</label>
                    <div class="info_item_input">
                        <p class="info_item_err_msg error"></p>
                        <input type="email" name="email" id="email" >
                    </div>
                    <button type="button" class="email_chk_btn">이메일 중복확인</button>
                </div>
                <hr>
                <div class="info_item_box">
                    <label class="info_item_label" for="password">비밀번호</label>
                    <div class="info_item_input">
                        <p class="info_item_err_msg">{{ errorMsgPassword }}</p>
                        <input type="text" name="password" id="password" @change="chkPassword">
                    </div>
                </div>
                <hr>
                <div class="info_item_box">
                    <label class="info_item_label" for="password_chk">비밀번호 확인</label>
                    <div class="info_item_input">
                        <p class="info_item_err_msg">비밀번호가 일치하지 않습니다.</p>
                        <input type="text" name="password_chk" id="password_chk">
                    </div>
                </div>
                <hr>
                <div class="info_item_box">
                    <label class="info_item_label" for="phone">휴대전화번호</label>
                    <div class="info_item_input">
                        <p class="info_item_err_msg">전화번호 형식에 맞지 않습니다.</p>
                        <input type="text" name="phone" id="phone">
                    </div>
                </div>
                <hr>
                <div class="info_item_box address">
                    <label class="info_item_label address_text" for="address">주소</label>
                    <div class="info_item_input">
                        <p class="info_item_err_msg">주소 형식이 맞지 않습니다.</p>
                        <input type="text" name="address" id="address" class="top_input">
                        <label class="info_item_label" for="address">상세주소</label>
                        <input type="text" name="address_detail" id="address_detail">
                    </div>
                    <button type="submit" class="info_item_btn form_btn_address">주소검색</button>
                </div>
                <hr>
                <div class="info_item_box">
                    <label class="info_item_label" for="birth">생년월일</label>
                    <div class="info_item_input">
                        <p class="info_item_err_msg">만 19세 이상만 가입이 가능합니다.</p>
                        <input type="date" name="birth" id="birth">
                    </div>
                </div>
                <hr>
                <br>
                <div class="buttons twobuttons">
                    <button type="reset" class="info_item_btn form_btn">취소</button>
                    <button type="submit" class="info_item_btn form_btn">확인</button>
                </div>
            </form>
        </div>
    </main>
</template>
<script setup>



const errorMsgPassword = ref('');

function chkPassword(e) {
    if (e.target.value.length < 8) {
        errorMsgPassword.value = '비밀번호가 형식에 맞지 않습니다.';
    } else {
        errorMsgPassword.value = '';
    }
}






// document.getElementById('username').addEventListener('input', function() {
//             var username = this.value;
//             var usernameError = document.getElementById('usernameError');
//             if (username === '' || username.length < 4 || username.length > 10) {
//                 usernameError.textContent = 'Username must be between 4 and 10 characters';
//                 this.classList.remove('valid');
//                 this.classList.add('error');
//             } else {
//                 usernameError.textContent = '';
//                 this.classList.remove('error');
//                 this.classList.add('valid');
//             }
//         });
//         document.getElementById('email').addEventListener('input', function() {
//             var email = this.value;
//             var emailError = document.getElementById('emailError');
//             var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
//             if (!emailPattern.test(email)) {
//                 emailError.textContent = '이메일 주소가 형식에 맞지않습니다.';
//                 this.classList.remove('valid');
//                 this.classList.add('error');
//             } else {
//                 emailError.textContent = '';
//                 this.classList.remove('error');
//                 this.classList.add('valid');
//             }
//         });
//         document.getElementById('myForm').addEventListener('submit', function(event) {
//             var username = document.getElementById('username').value;
//             var email = document.getElementById('email').value;
//             var usernameError = document.getElementById('usernameError');
//             var emailError = document.getElementById('emailError');
//             var valid = true;
//             if (username === '' || username.length < 4 || username.length > 10) {
//                 usernameError.textContent = 'Username must be between 4 and 10 characters';
//                 valid = false;
//             }
//             var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
//             if (!emailPattern.test(email)) {
//                 emailError.textContent = 'Invalid email address';
//                 valid = false;
//             }
//             if (!valid) {
//                 event.preventDefault();
//             }
//         });
</script>
<style>
    @import url('../css/regist.css');
</style>
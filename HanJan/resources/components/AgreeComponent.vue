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
                <div class="main">
                    <div class="agree_item">
                        <p class="agree">약관동의</p>
                    </div>
                    <hr>
                    <div class="agree_item">
                        <label for="agree" class="chk_box">
                            <input type="checkbox" v-model="agree1Checked" @change="checkAllAgreements">
                            <span class="red_span">(필수)</span>
                            <span class="middle_span">이용약관 </span>
                            <button type="button" id="first_btn_modal" class="text_btn">전체보기 ></button>
                            <div class="agree_box">
                                <textarea name="" id="first_modal_text" readonly>가나다라마바사가나다라마바사가나다라마바사가나다라마바사가나다라마바사가나다라마바사가나다라마바사가나다라마바사가나다라마바사
                                </textarea>
                            </div>
                        </label>
                    </div>
                    <div class="agree_item">
                        <label for="agree" class="chk_box">
                            <input type="checkbox" v-model="agree2Checked" @change="checkAllAgreements">
                            <span class="red_span">(필수)</span>
                            <span class="middle_span">개인정보 수집 및 이용 </span>
                            <button type="button" id="second_btn_modal" class="text_btn">전체보기 ></button>
                            <!-- 모달창 -->
                            <div class="agree_box modal_overlay" id="modal" v-show="showModal">
                                <div class="modal_window">
                                    <div class="close_area" @click="modalOff">x</div>
                                    <div class="content">
                                        <p>{{ modalContent }}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- 모달창 -->
                            <textarea name="" id="second_modal_text" readonly>11가나다라마바사가나다라마바사가나다라마바사가나다라마바사가나다라마바사가나다라마바사가나다라마바사가나다라마바사가나다라마바사가나다라마바사가나다라마바사가나다라마바사가나다라마바사가나다라마바사가나다라마바사가나다라마바사가나다라마바사가나다라마바사가나다라마바사가나다라마바사가나다라마바사가나다라마바사가나다라마바사가나다라마바사가나다라마바사가나다라마바사가나다라마바사가나다라마바사가나다라마바사가나다라마바사가나다라마바사가나다라마바사가나다라마바사가나다라마바사가나다라마바사가나다라마바사
                            </textarea>
                        </label>
                    </div>
                    <div class="agree_item">
                        <label for="agree" class="chk_box">
                            <input type="checkbox" v-model="agree3Checked" id="selectall" @click="toggleAllCheckbox" class="selectall" @change="checkAllAgreements" > 술마켓의 모든 약관을 확인하고 전체 동의합니다.
                            <span class="gray_span">(전체동의, 선택항목도 포함됩니다.)</span>
                        </label>
                    </div>
                </div>
                <div class="buttons twobuttons">
                    <button type="button" class="info_item_btn form_btn" @click="$router.push('/')">취소</button>
                    <button type="submit" class="info_item_btn form_btn" @click=Submit>회원가입</button>
                </div>
            </form>
        </div>
    </main>

</template>

<script setup>
// 모달창
import { ref, onMounted } from 'vue';
import router from '../js/router';

const showModal = ref(false);
const modalContent = ref('');

const modalOn = (content) => {
    modalContent.value = content;
    showModal.value = true;
}

const modalOff = () => {
    showModal.value = false;
}

onMounted(() => {
    const btnModalTerms = document.getElementById("first_btn_modal");
    const btnModal = document.getElementById("second_btn_modal");

    btnModal.addEventListener("click", () => {
        const termsText = document.getElementById("second_modal_text").value;
        modalOn(termsText);
    });

    btnModalTerms.addEventListener("click", () => {
        const privacyText = document.getElementById("first_modal_text").value;
        modalOn(privacyText);
    });
});

// 체크박스 체크시에만 regist로 이동

const agree1Checked = ref(false);
const agree2Checked = ref(false);
const agree3Checked = ref(false);
const allAgreed = ref(false);

function checkAllAgreements() {
    if (agree1Checked.value && agree2Checked.value) {
        agree3Checked.value = true;
        allAgreed.value = true;
    } else {
        agree3Checked.value = false;
        allAgreed.value = false;
    }
}

// 전체 체크박스 체크/해제
function toggleAllCheckbox() {
    agree3Checked.value = !agree3Checked.value;
    if(agree3Checked.value) {
        agree1Checked.value = true;
        agree2Checked.value = true;
    } else {
        agree1Checked.value = false;
        agree2Checked.value = false;
    }
}

function Submit() {
    if (!agree3Checked.value) {
        alert('필수 약관에 모두 동의해주세요.');
        const form = document.querySelector('#regist_form');
        form.reset();
    } else {
        // 여기에서 회원가입 처리를 합니다.
        router.push('/regist');
    }
}
</script>

<style scoped src="../css/agree.css">
    /* @import url('../css/agree.css'); */
</style>

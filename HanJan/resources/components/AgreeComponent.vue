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
                        <label for="agree1" class="chk_box">
                            <input id="agree1" type="checkbox" v-model="agree1Checked" @change="checkAllAgreements">
                            <span class="red_span">(필수)</span>
                            <span class="middle_span">이용약관 </span>
                            <button type="button" id="first_btn_modal" class="text_btn">전체보기 ></button>
                            <div class="agree_box">
                                <textarea name="" id="first_modal_text" readonly>제 1장 총칙

제 1조 (목적)
본 약관은 회원(이하 "회원"이라 합니다)이 한잔(이하 "회사"라 합니다)이 제공하는 모든 서비스(이하 "서비스"라 합니다)를 이용함에 있어 회사와 회원의 권리, 의무 및 책임사항을 규정함을 목적으로 합니다.

제 2조 (약관의 효력과 변경)

본 약관은 서비스 화면에 게시하거나 기타 방법으로 회원에게 공지함으로써 효력이 발생합니다.
회사는 합리적인 사유가 있을 경우, 본 약관을 변경할 수 있으며, 변경된 약관은 전항과 같은 방법으로 공지함으로써 효력이 발생합니다.
제 3조 (약관 외 준칙)
본 약관에 명시되지 않은 사항에 대해서는 관계 법령 및 상관례에 따릅니다.

제 4조 (약관의 해석)
본 약관의 해석 및 적용에 관하여는 관계 법령 및 상관례에 따릅니다.

제 5조 (용어의 정의)
본 약관에서 사용하는 용어의 정의는 다음과 같습니다.

"서비스"란 회사가 제공하는 모든 서비스를 의미합니다.
"회원"이라 함은 본 약관에 따라 회사와 이용계약을 체결하고, 회사가 제공하는 서비스를 이용하는 자를 의미합니다.
제 2장 회원가입 및 탈퇴

제 6조 (회원가입)

회원으로 가입하고자 하는 자는 회사가 정한 가입 양식에 따라 회원정보를 기입한 후 본 약관에 동의함으로써 가입 절차를 완료합니다.
회사는 다음 각 호에 해당하는 경우 회원 가입을 거부할 수 있습니다.
가. 회원정보를 허위로 기재한 경우
나. 타인의 명의를 사용하여 가입한 경우
다. 회사가 정한 회원 가입 요건을 충족하지 못한 경우
제 7조 (회원정보의 변경)

회원은 서비스 내 설정 메뉴를 통해 언제든지 자신의 회원정보를 열람하고 수정할 수 있습니다.
회원은 회원정보의 변경이 필요한 경우 즉시 변경하거나, 회사에 요청하여 변경할 수 있습니다.
제 8조 (회원의 탈퇴 및 자격 상실)

회원은 언제든지 서비스 내 설정 메뉴를 통해 회원 탈퇴를 요청할 수 있습니다.
회사는 회원이 다음 각 호에 해당하는 경우, 사전 통지 없이 회원 자격을 상실시킬 수 있습니다.
가. 본 약관을 위반하여 서비스를 이용한 경우
나. 타인의 서비스 이용을 방해하거나 정보를 도용한 경우
다. 기타 회사가 정한 이용 조건에 위반한 경우
                                </textarea>
                            </div>
                        </label>
                    </div>
                    <div class="agree_item">
                        <label for="agree2" class="chk_box">
                            <input type="checkbox" v-model="agree2Checked" @change="checkAllAgreements">
                            <span class="red_span">(필수)</span>
                            <span class="middle_span">개인정보 수집 및 이용 </span>
                            <button type="button" id="second_btn_modal" class="text_btn">전체보기 ></button>
                            <!-- 모달창 -->
                            <transition name="fade">
                            <div class="agree_box modal_overlay" id="modal" v-show="showModal">
                                <div class="modal_window">
                                    <div class="close_area" @click="modalOff"></div>
                                    <div class="content">
                                        <p>{{ modalContent }}</p>
                                    </div>
                                </div>
                            </div>
                            </transition>
                            <!-- 모달창 -->
                            <textarea name="" id="second_modal_text" readonly>회사는 회원의 개인정보를 다음의 목적으로 수집 및 이용합니다.

1. 회원 가입 및 관리
2. 서비스 제공 및 운영
3. 마케팅 및 광고에의 활용
회원은 회사가 제공하는 서비스를 이용함으로써 위 목적에 동의하는 것으로 간주됩니다.
                            </textarea>
                        </label>
                    </div>
                    <div class="agree_item" v-show="!showModal">
                        <label for="selectall" class="chk_box">
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

const modalOff = () => {
    showModal.value = false;
}

</script>

<style scoped src="../css/agree.css">
    /* @import url('../css/agree.css'); */
</style>

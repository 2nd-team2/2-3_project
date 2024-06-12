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
                            <input type="checkbox">
                            <span class="red_span">(필수)</span>
                            <span class="middle_span">이용약관</span>
                            <span class="red_a">전체보기 ></span>
                            <div class="agree_box">
                                <textarea name="" id=""  readonly>동의</textarea>
                            </div>
                        </label>
                    </div>
                    <div class="agree_item">
                        <label for="agree" class="chk_box">
                            <input type="checkbox">
                            <span class="red_span">(필수)</span>
                            <span class="middle_span">개인정보 수집 및 이용</span>
                            <span class="red_a">전체보기 ></span>
                            <div class="agree_box">
                                <textarea name="" id=""  readonly>동의</textarea>
                            </div>
                        </label>
                    </div>
                    <div class="agree_item">
                        <label for="agree" class="chk_box">
                            <input type="checkbox"> 술마켓의 모든 약관을 확인하고 전체 동의합니다.
                            <span class="gray_span">(전체동의, 선택항목도 포함됩니다.)</span>
                        </label>
                    </div>
                </div>
                <div class="buttons twobuttons">
                    <button type="reset" class="info_item_btn form_btn">취소</button>
                    <button type="submit" class="info_item_btn form_btn">회원가입</button>
                </div>
            </form>
        </div>
    </main>
</template>

<script setup>
</script>

<style>
    @import url('../css/agree.css');
</style>

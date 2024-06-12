<template>
    <main>
        <div class="main">
            <div class="userChkTest">
                **회원님의 정보를 안전하게 보호하기 위해 비밀번호를 다시 한번 확인합니다.
                <br>
                비밀번호는 타인에게 노출되지 않도록 항시 주의해 주세요.
            </div>
            <br>
            <div class="userInfo">
                <ul>
                    <li>
                        <span class="list_marker list_left">·</span>아이디
                        <span class="user_id"></span>
                    </li>
                    <li>
                        <span class="list_marker">·</span>비밀번호 
                        <input type="text">
                    </li>
                </ul>
                <div class="buttons twobuttons">
                    <button type="reset" class="info_item_btn form_btn">취소</button>
                    <button type="submit" class="info_item_btn form_btn">확인</button>
                </div>
            </div>
        </div>
    </main>
</template>

<script setup>
</script>

<style>
    @import url('../css/confirm.css');
</style>
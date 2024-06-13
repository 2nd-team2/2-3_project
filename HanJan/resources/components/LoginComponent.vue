<template>
    <main>
        <form id="login_form">
            <div class="leftInfo">
                <h2>로그인 / 회원가입</h2>
                <div class="inputGroup1">
                    <img src="/img/drunkOtter.png" class="face">
                    <input type="text" name="email" class="login_input" placeholder="아이디">
                </div>
                <div class="inputGroup2">
                    <img src="/img/drunkOtter.png" class="face">
                    <input type="password" name="password" id="password" class="login_input" placeholder="비밀번호">
                </div>
                <button type="button" class="loginBtn" @click="$store.dispatch('login')">로그인</button>
                <button type="button" class="registBtn" @click="$router.push('regist')">회원가입</button>
                <button type="button" class="kakaoBtn"><img src="/img/kakao_login_large_wide.png" class="kakaoBtn_img"></button>
                <img class="rightPoto" src="/img/IE002927310_STD.png"></img>
            </div>
        </form>
    </main>
</template>

<script setup>
</script>

<style scoped src="../css/login.css">
</style>

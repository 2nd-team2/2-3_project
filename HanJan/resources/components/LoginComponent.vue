<template>
    <main>
        <div>
            <h2>
                로그인 / 회원가입
            </h2>
        </div>
        <div class="leftInfo">
            <form action="">
                <br>
            <div class="inputGroup">
                <img src="/img/drunkOtter.png" class="face">
                <input type="text" id="account" placeholder="아이디">
            </div>
            <div class="inputGroup">
                <img src="/img/drunkOtter.png" class="face">
                <input type="password" id="password" placeholder="비밀번호">
            </div>
            <br>
            <div class="button">
                <button class="loginBtn" id="button">로그인</button>
                <button class="registBtn" id="button">회원가입</button>
                <button class="kakaoBtn"></button>
            </div>
            </form>
        </div>
        <div class="rightPoto">
            <div class="textInPoto">
                "이거 가입하면 한잔과 함께가는 거다"
                <br>
                내 머릿속의 데이터(2024)
            </div>
        </div>
    </main>
</template>

<script setup>
</script>

<style scoped src="../css/login.css">
</style>

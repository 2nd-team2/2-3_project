<template>
    <div>로그인 </div>
    
    <!-- <main>
        <form id="login_form">
            <div class="leftInfo">
                <h2>로그인</h2>
                <div class="inputGroup1">
                    <img :src="otterImg" class="face" @click="toggleImg('otterImg')">
                    <input type="text" name="email" class="login_input" placeholder="아이디">
                </div>
                <div class="inputGroup2">
                    <img :src="otterImg2" class="face" @click="toggleImg('otterImg2')">
                    <input type="password" name="password" id="password" class="login_input" placeholder="비밀번호" autocomplete="off">
                </div>
                <button type="button" class="loginBtn" @click="login">로그인</button>
            </div>
        </form>
    </main>  -->
</template>

<script setup>
// import { ref } from 'vue';
//     const otterImg = ref('/img/drunkOtter.png');
//     const otterImg2 = ref('/img/drunkOtter.png');
//     const alternateImg = '/img/drunkOtter3.png';

//     function toggleImg(imgRef) {
//     if (imgRef === 'otterImg') {
//         otterImg.value = otterImg.value === '/img/drunkOtter.png' ? alternateImg : '/img/drunkOtter.png';
//     } else if (imgRef === 'otterImg2') {
//         otterImg2.value = otterImg2.value === '/img/drunkOtter.png' ? alternateImg : '/img/drunkOtter.png';
//     }
//     }
</script>

<style>

</style>
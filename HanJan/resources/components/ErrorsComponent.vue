<template>
    <main>
        <div class="errors_container">
            <h2 class="errors_title">페이지를 찾을 수가 없어요</h2>
        </div>
        <div class="erros_box">
            <img src="/img/errors_img.png" class="errors_img">
            <router-link to="/" class="errors_link">메인으로</router-link>
            <button @click="$router.back()" class="errors_back">이전으로</button>
        </div>
    </main>
</template>

<script setup>
</script>

<style scoped src="../css/error.css">
</style>
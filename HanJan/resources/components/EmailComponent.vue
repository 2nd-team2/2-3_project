<template>
    <div>이메일 검증이 완료 되었습니다.</div>
    <div>회원가입 페이지에서 <span style="color: red;">새로고침</span> 후 계속 진행해 주세요.</div>
</template>
  
<script setup>
import { onBeforeMount } from 'vue';
import { useStore } from 'vuex'


const store = useStore();

onBeforeMount(() => {
    const token = route.params.token;

    console.log(token);
    store.dispatch('verifyToken', token)
});
</script>
<style>
    
</style>

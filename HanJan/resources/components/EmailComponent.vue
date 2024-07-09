<template>
    <div>이메일 인증 진행중... </div>
    
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

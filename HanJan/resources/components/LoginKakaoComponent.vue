<template>
    <div>카카오 로그인 처리 중...</div>
</template>
  
<script setup>
    import { onBeforeMount } from 'vue';
    import { useRouter, useRoute } from 'vue-router';
    import { useStore } from 'vuex'
    
    const router = useRouter();
    const route = useRoute();
    const store = useStore();
    
    onBeforeMount(() => {
        try {
        const responseData = JSON.parse(decodeURIComponent(route.query.data));

        console.log(responseData);
        // 로그인 성공 시 사용자 정보를 로컬 스토리지에 저장
        store.commit('kakaoInfo', responseData.data);
        console.log('카카오 로그인 email 획득 성공');
   
        if (responseData.code === '1') {
            // 로그인처리
            store.dispatch('kakaoLogin', responseData.data);
            
            console.log('카카오 로그인 성공');
            router.push('/'); // 메인 페이지로 이동
        } else if (responseData.code === '0') {
            // 첫 로그인 시 이메일 정보를 로컬 스토리지에 저장하고 회원가입 페이지로 이동
            store.commit('kakaoInfo', responseData.data.email);
            console.log('카카오 첫 로그인 성공 > 회원 가입 페이지 이동')

            router.push('/regist');
        }
        } catch (error) {
            console.error('카카오 로그인 처리 중 오류 발생:', error);
            router.push('/login'); // 로그인 페이지로 이동
        }
    });
</script>
<style>
    
</style>

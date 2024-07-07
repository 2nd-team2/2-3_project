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
            console.log('카카오 로그인 email 획득 성공');
    
            if (responseData.code === '1') {
                // 로그인처리
                store.dispatch('kakaoLogin', responseData.data);
                
                console.log('카카오 로그인 성공');
                
                // 이동 처리는 stroe.js에서 관리하는게 좋음 (store.js로 이동)
                // // 비동기 처리 때문에 시간을 두고 페이지 이동
                // setTimeout(()=>{
                //     router.replace('/'); // 메인 페이지로 이동
                // },2000)

            } else if (responseData.code === '0') {

                // 첫 로그인 시 이메일 정보를 저장하기
                store.commit('kakaoInfo', responseData.data.email);
                localStorage.setItem('kakaoInfo', JSON.stringify(responseData.data.email));
                console.log('카카오 첫 로그인 성공 > 회원 가입 페이지 이동')

                // 저장한 이름, 이메일을 가지고 회원가입 페이지로 넘어가기
                router.replace('/regist');
            }
        } catch (error) {
            console.error('카카오 로그인 처리 중 오류 발생:', error);
            router.replace('/login'); // 로그인 페이지로 이동
        }
    });
</script>
<style>
    
</style>

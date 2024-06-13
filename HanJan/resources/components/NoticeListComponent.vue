<template>
    <main>
        <h2 class="noticelist_title">공지사항</h2>
        <div class="notice_list_container">
            <div class="notice_list_num">번호</div>
            <div class="notice_list_title">제목</div>
            <div class="notice_list_date">작성일</div>
        </div>
        <div v-for="notice in $store.state.noticeData" :key="notice.no_id" class="notice_list_container notice_paddingtop">
            <div class="notice_list_num">{{ notice.no_id }}</div>
            <div @click="noticeDetail(notice)" class="notice_list_titlename">
                {{ notice.no_title }}
            </div>
            <div class="notice_list_date">{{ notice.created_at }}</div>
        </div>

        <!-- 페이지네이션 -->
        <div class="list_num_item">
            <a href="" class="before">〈 이전</a>
            <a href="" class="num_none">1</a>
            <a href="" class="num_none">2</a>
            <a href="" class="num">3</a>
            <a href="" class="num_none">4</a>
            <a href="" class="num_none">5</a>
            <a href="" class="nuxt">다음 〉</a>
        </div>
    </main>
</template>

<script setup>
    import { onBeforeMount, ref } from 'vue';
    import { useStore } from 'vuex';
    import router from '../js/router';

    const store = useStore();
    const noticeData = ref({});
    onBeforeMount(() => {
        if(store.state.noticeData.length < 1) {
            store.dispatch('getNoticeData');
        }
        noticeData.value = store.state.noticeData;
    })

    function noticeDetail(item) {
        store.commit('setNoticeDetailData', item);
        router.push('/notice');
    }
</script>

<style>
    @import url('../css/notice.css');
</style>
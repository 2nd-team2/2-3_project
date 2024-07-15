<template>
    <main>
        <div class="notice_container">
            <h2 class="notice_title">공지사항</h2>
            <router-link to="/noticelist" class="move_notice_list">목록</router-link>
            <div class="notice_line"></div>
            <div class="notice_name">제목</div>
            <div class="notice_item">{{ $store.state.noticeDetail.no_title }}</div>
            <!-- <div class="notice_item_content">{{ $store.state.noticeDetail.no_content }}</div> -->
            <div class="notice_item_content" v-html="formattedContent"></div>
            
            <div class="notice_item_date">{{ $store.state.noticeDetail.created_at }}</div>
        </div>
    </main>
</template>

<script setup>
import { computed } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

// 데이터에서 content 가져오기
const noticeContent = computed(() => store.state.noticeDetail.no_content);

// 줄바꿈을 <br> 태그로 변환하여 HTML로 표시
const formattedContent = computed(() => {
    if (noticeContent.value) {
        return noticeContent.value.replace(/\n/g, '<br>');
    }
    return '';
});
</script>

<style>
    @import url('../css/notice.css');
</style>

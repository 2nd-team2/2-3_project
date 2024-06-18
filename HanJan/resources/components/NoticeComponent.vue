<template>
    <main>
        <div class="notice_container">
            <h2 class="notice_title">공지사항</h2>
            <router-link to="/noticelist" class="move_notice_list">목록</router-link>
            <div class="notice_line"></div>
            <div class="notice_name">제목</div>
            <div class="notice_item">{{ $store.state.noticeDetail.no_title }}</div>
            <div class="notice_item_content">{{ $store.state.noticeDetail.no_content }}</div>
            <div class="notice_item_date">{{ $store.state.noticeDetail.created_at }}</div>
        </div>
    </main>
</template>

<script setup>
</script>

<style>
    @import url('../css/notice.css');
</style>
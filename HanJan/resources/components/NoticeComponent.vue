<template>
    <main>
        <div class="notice_container">
            <h2 class="notice_title">공지사항</h2>
            <router-link to="/noticelist" class="move_notice_list">
                <a>목록</a>
            </router-link>
            <div class="notice_line"></div>
            <div class="notice_name">제목</div>
            <div class="notice_item">{{ $store.state.noticeDetail.no_title }}</div>
            <div class="notice_item_content">{{ $store.state.noticeDetail.no_content }}</div>
            <div class="notice_item_date">{{ $store.state.noticeDetail.created_at }}</div>
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
</script>

<style>
    @import url('../css/notice.css');
</style>
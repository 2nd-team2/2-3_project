<template>
    <main>
        <h2 class="noticelist_title">공지사항</h2>
        <div class="notice_list_container">
            <div class="notice_list_num">번호</div>
            <div class="notice_list_title">제목</div>
            <div class="notice_list_date">작성일</div>
        </div>
        <div class="notice_list_container notice_paddingtop">
            <div class="notice_list_num">1</div>
            <router-link to="/notice" class="notice_list_titlename">
                <a>공지사항입니다.</a>
            </router-link>
            <div class="notice_list_date">2024-06-13</div>
        </div>
        <div class="notice_list_container notice_paddingtop">
            <div class="notice_list_num">1</div>
            <router-link to="/notice" class="notice_list_titlename">
                <a>공지사항입니다.</a>
            </router-link>
            <div class="notice_list_date">2024-06-13</div>
        </div>
        <div class="notice_list_container notice_paddingtop">
            <div class="notice_list_num">1212</div>
            <router-link to="/notice" class="notice_list_titlename">
                <a>공지사항입니다.공지사항입니다.공지사항입니다.공지사항입니다.공지사항입니다.공지사항입니다.공지사항입니다.공지사항입니다.</a>
            </router-link>
            <div class="notice_list_date">2024-06-13</div>
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
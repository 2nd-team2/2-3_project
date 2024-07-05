<template>
    <div class="admin">
        <h2 class="admin_title">공지사항 관리</h2>
        <div class="admin_notice_list_container">
            <div class="admin_notice_list_num">번호</div>
            <div class="admin_notice_list_title">제목</div>
            <div class="admin_notice_list_date">작성일</div>
        </div>
        <div v-for="notice in $store.state.noticeData.data" :key="notice.no_id" class="admin_notice_list_container admin_paddingtop">
            <div class="admin_notice_list_num">{{ notice.no_id }}</div>
            <div class="admin_notice_list_titlename">
                {{ notice.no_title }}
            </div>
            <div class="admin_notice_list_date">{{ notice.created_at }}</div>
            <button class="admin_btn">수정</button>
            <button class="admin_btn">삭제</button>
        </div>
    
        <!-- 페이지네이션 -->
        <div class="admin_list_num_item">
            <a href="#" class="before" @click.prevent="prevPage()">〈 이전</a>
            <a
                v-for="page in pages"
                :key="page"
                href="#"
                :class="{'admin_num': page === $store.state.noticeData.current_page, 'admin_num_none': page !== $store.state.noticeData.current_page}"
                @click.prevent="goToPage(page)"
                >{{ page }}
            </a>
            <a href="#" class="next" @click.prevent="nextPage()">다음 〉</a>
        </div>
    </div>
</template>

<script setup>
    import { onBeforeMount } from 'vue';
    import { useStore } from 'vuex';
    import { computed } from 'vue';

    const store = useStore();

    // notice list 가져오기
    onBeforeMount(() => {
        if(store.state.noticeData.current_page == 1) {
            store.dispatch('getNoticeData', 1);
        }
    })

    // 페이지네이션
    // 페이지 번호 배열 계산
    const pages = computed(() => {
        const pageArray = [];
        // 페이지네이션 5개
        const maxPagesToShow = 5;

        // let startPage = store.state.noticeData.current_page - 2;
        let startPage = store.state.noticeData.last_page <5 ? 1 : store.state.noticeData.current_page - 2;
        if(startPage < 1) {
            startPage = 1;
        }
        const endPage = startPage + maxPagesToShow - 1;

        // 시작페이지 구하기
        const pagingStart = startPage <= (store.state.noticeData.last_page - maxPagesToShow + 1) || ((store.state.noticeData.last_page - maxPagesToShow + 1) < 1) ? startPage : (store.state.noticeData.last_page - maxPagesToShow + 1);
        
        // 마지막 페이지 구하기
        const pagingEnd = endPage > store.state.noticeData.last_page ? store.state.noticeData.last_page : endPage;

        for (let i = pagingStart; i <= pagingEnd; i++) {
            pageArray.push(i)
        }
        return pageArray
    })

    // 특정 페이지로 이동
    function goToPage(page) {
        store.dispatch('getNoticeData', page);
    }

    // 이전 페이지로 이동
    function prevPage() {
        if (store.state.noticeData.current_page > 1) {
            goToPage(store.state.noticeData.current_page - 1);
        }
    }

    // 다음 페이지로 이동
    function nextPage() {
        if (store.state.noticeData.current_page < store.state.noticeData.last_page) {
            goToPage(store.state.noticeData.current_page + 1);
        }
    }

</script>

<style>

</style>
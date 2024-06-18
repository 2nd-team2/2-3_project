<template>
    <main>
        <h2 class="noticelist_title">공지사항</h2>
        <div class="notice_list_container">
            <div class="notice_list_num">번호</div>
            <div class="notice_list_title">제목</div>
            <div class="notice_list_date">작성일</div>
        </div>
        <div v-for="notice in $store.state.noticeData.data" :key="notice.no_id" class="notice_list_container notice_paddingtop">
            <div class="notice_list_num">{{ notice.no_id }}</div>
            <div @click="noticeDetail(notice.no_id)" class="notice_list_titlename">
                {{ notice.no_title }}
            </div>
            <div class="notice_list_date">{{ notice.created_at }}</div>
        </div>

        <!-- 페이지네이션 -->
        <div class="list_num_item">
            <a href="#" class="before" @click.prevent="prevPage()">〈 이전</a>
            <a
                v-for="page in pages"
                :key="page"
                href="#"
                :class="{'num': page === $store.state.noticeData.current_page, 'num_none': page !== $store.state.noticeData.current_page}"
                @click.prevent="goToPage(page)"
                >{{ page }}
            </a>
            <a href="#" class="next" @click.prevent="nextPage()">다음 〉</a>
        </div>
    </main>
</template>

<script setup>
    import { onBeforeMount } from 'vue';
    import { useStore } from 'vuex';
    import router from '../js/router';
    import { computed } from 'vue';

    const store = useStore();

    // notice list 가져오기
    onBeforeMount(() => {
        if(store.state.noticeData.current_page == 1) {
            store.dispatch('getNoticeData', 1);
        }
    })

    // notice페이지 이동
    function noticeDetail(id) {
        router.push('/notice?id=' + id);
    }
    

    // 페이지네이션

    // 게시물 데이터 가져오기
    const posts = computed(() => store.state.noticeData)

    // 페이지 번호 배열 계산
    const pages = computed(() => {
        const pageArray = [];
        // 페이지네이션 5개
        const maxPagesToShow = 5;

        let startPage = posts.value.current_page - 2;
        if(startPage < 1) {
            startPage = 1;
        }
        const endPage = startPage + maxPagesToShow - 1;

        // 시작페이지 구하기
        const pagingStart = startPage <= (posts.value.last_page - maxPagesToShow + 1) ? startPage : (posts.value.last_page - maxPagesToShow + 1);
        
        // 마지막 페이지 구하기
        const pagingEnd = endPage > posts.value.last_page ? posts.value.last_page : endPage;

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
        if (posts.value.current_page > 1) {
            goToPage(posts.value.current_page - 1);
        }
    }

    // 다음 페이지로 이동
    function nextPage() {
        if (posts.value.current_page < posts.value.last_page) {
            goToPage(posts.value.current_page + 1);
        }
    }
</script>

<style  scoped src="../css/notice.css">
</style>
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
            <div @click="noticeDetail(notice)" class="notice_list_titlename">
                {{ notice.no_title }}
            </div>
            <div class="notice_list_date">{{ notice.created_at }}</div>
        </div>

        <!-- 페이지네이션 -->
        <div class="list_num_item">
            <a href="#" class="before" @click.prevent="prevPage">〈 이전</a>
            <a
                v-for="page in pages"
                :key="page"
                href="#"
                :class="{'num': page === currentPage, 'num_none': page !== currentPage}"
                @click.prevent="goToPage(page)"
                >{{ page }}
            </a>
            <a href="#" class="nuxt" @click.prevent="nextPage">다음 〉</a>
        </div>
        <!-- <div class="posts">
            <div v-for="post in paginatedPosts" :key="post.id" class="post-item">
                {{ post.title }}
            </div>
        </div> -->
    </main>
</template>

<script setup>
    import { onBeforeMount } from 'vue';
    import { useStore } from 'vuex';
    import router from '../js/router';
    import { ref, computed } from 'vue';

    const store = useStore();

    onBeforeMount(() => {
        if(store.state.noticeData.length < 1) {
            store.dispatch('getNoticeData');
        }
    })

    function noticeDetail(item) {
        store.com
        mit('setNoticeDetailData', item);
        router.push('/notice');
    }

    // 페이지네이션

    // 게시물 6개 출력
    const itemsPerPage = 6
    // 시작페이지 설정
    const currentPage = ref(1)

    // 게시물 데이터 가져오기
    const posts = computed(() => store.state.noticeData)

    // 총 페이지 수 계산
    // const totalPages = computed(() => Math.ceil(posts.value.data.length / itemsPerPage))
    // const totalPages = computed(() => posts.value ? Math.ceil(posts.value.total / itemsPerPage) : 0);

    // 페이지 번호 배열 계산
    const pages = computed(() => {
        const pageArray = []
        // 페이지네이션 5개
        const maxPagesToShow = 5;

        const startPage = (posts.value.current_page - 2) < 1 ? 1 : posts.value.current_page;
        const endPage = startPage + maxPagesToShow - 1;

        // 시작페이지 구하기
        const pagingStart = startPage <= (posts.value.last_page - maxPagesToShow - 1) ? startPage : (posts.value.last_page - maxPagesToShow - 1);
        // let startPage = Math.max(currentPage.value - Math.floor(maxPagesToShow / 2), 1);
        
        // 마지막 페이지 구하기
        const pagingEnd = endPage > posts.value.last_page ? posts.value.last_page : endPage;
        // let endPage = startPage + maxPagesToShow - 1

        // if (endPage > totalPages.value) {
        //     endPage = totalPages.value
        //     startPage = Math.max(endPage - maxPagesToShow + 1, 1)
        // }
        // if (endPage > totalPages.value) {
        //     endPage = totalPages.value;
        //     startPage = Math.max(1, totalPages.value - maxPagesToShow + 1);
        // }

        for (let i = pagingStart; i <= pagingEnd; i++) {
            pageArray.push(i)
        }
        console.log('페이지네이션', posts.value, '시작페이지:',startPage, '페이징시작:', pagingStart, '엔드페이지:',endPage, '엔드페이징:',pagingEnd, '페이징어레이:',pageArray);
        return pageArray
    })

    // 현재 페이지의 게시물 계산

    const paginatedPosts = computed(() => {
        const start = (currentPage.value - 1) * itemsPerPage
        const end = start + itemsPerPage
        return posts.value.data.slice(start, end)
    })

    // 특정 페이지로 이동
    function goToPage(page) {
        // currentPage.value = page
        store.dispatch('getNoticeData', page);
    }

    // 이전 페이지로 이동
    function prevPage() {
        if (currentPage.value > 1) {
            currentPage.value--
        }
        // if (currentPage.value > 1) {
        //     goToPage(currentPage.value - 1);
        // }
    }

    // 다음 페이지로 이동
    function nextPage() {
        if (currentPage.value < totalPages.value) {
            currentPage.value++
        }
        // if (currentPage.value < totalPages.value) {
        //     goToPage(currentPage.value + 1);
        // }
    }
</script>

<style  scoped src="../css/notice.css">
</style>
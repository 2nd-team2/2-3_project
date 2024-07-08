<template>
    <div class="admin">
        <div class="admin_title_box">
            <h2 class="admin_title2">공지사항 관리</h2>
            <router-link to="/admin/notice/create" class="admin_create_btn">글 작성</router-link>
        </div>
        <div class="admin_notice_list_container">
            <div class="admin_notice_list_name admin_weight">작성자</div>
            <div class="admin_notice_list_title admin_weight">제목</div>
            <div class="admin_notice_list_content admin_weight">내용</div>
            <div class="admin_notice_list_date admin_weight">작성일</div>
            <div class="admin_notice_list_updated admin_weight">수정일</div>
            <div class="admin_notice_list_deleted admin_weight">삭제일</div>
        </div>
        <div v-for="notice in $store.state.adminNoticeData.data" :key="notice.no_id" class="admin_notice_list_container admin_paddingtop">
            <div class="admin_notice_list_name">{{ notice.account }}</div>
            <div class="admin_notice_list_title">{{ notice.no_title }}</div>
            <div class="admin_notice_list_content">{{ notice.no_content }}</div>
            <div class="admin_notice_list_date">{{ notice.created_at }}</div>
            <div class="admin_notice_list_updated">{{ notice.updated_at }}</div>
            <div class="admin_notice_list_deleted">{{ notice.deleted_at }}</div>
            <button type="button" v-if="notice.deleted_at == null" @click="noticeUpdate(notice)" class="admin_btn">수정하기</button>
            <button type="button" v-if="notice.deleted_at == null" @click="$store.dispatch('adminNoticeDeleted', notice.no_id)" class="admin_btn">삭제하기</button>
        </div>
    
        <!-- 페이지네이션 -->
        <div class="admin_list_num_item">
            <a href="#" class="before" @click.prevent="prevPage()">〈 이전</a>
            <a
                v-for="page in pages"
                :key="page"
                href="#"
                :class="{'admin_num': page === $store.state.adminNoticeData.current_page, 'admin_num_none': page !== $store.state.adminNoticeData.current_page}"
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
        if(store.state.adminNoticeData.current_page == 1) {
            store.dispatch('getAdminNoticeData', 1);
        }
    })

    // 페이지네이션
    // 페이지 번호 배열 계산
    const pages = computed(() => {
        const pageArray = [];
        // 페이지네이션 5개
        const maxPagesToShow = 5;

        // let startPage = store.state.adminNoticeData.current_page - 2;
        let startPage = store.state.adminNoticeData.last_page <5 ? 1 : store.state.adminNoticeData.current_page - 2;
        if(startPage < 1) {
            startPage = 1;
        }
        const endPage = startPage + maxPagesToShow - 1;

        // 시작페이지 구하기
        const pagingStart = startPage <= (store.state.adminNoticeData.last_page - maxPagesToShow + 1) || ((store.state.adminNoticeData.last_page - maxPagesToShow + 1) < 1) ? startPage : (store.state.adminNoticeData.last_page - maxPagesToShow + 1);
        
        // 마지막 페이지 구하기
        const pagingEnd = endPage > store.state.adminNoticeData.last_page ? store.state.adminNoticeData.last_page : endPage;

        for (let i = pagingStart; i <= pagingEnd; i++) {
            pageArray.push(i)
        }
        return pageArray
    })

    // 특정 페이지로 이동
    function goToPage(page) {
        store.dispatch('getAdminNoticeData', page);
    }

    // 이전 페이지로 이동
    function prevPage() {
        if (store.state.adminNoticeData.current_page > 1) {
            goToPage(store.state.adminNoticeData.current_page - 1);
        }
    }

    // 다음 페이지로 이동
    function nextPage() {
        if (store.state.adminNoticeData.current_page < store.state.adminNoticeData.last_page) {
            goToPage(store.state.adminNoticeData.current_page + 1);
        }
    }

    // 공지사항 수정 페이지로 정보 넘기기
    function noticeUpdate(item) {
        store.dispatch('adminNoticeToUpdate', item);
    }

</script>

<style>

</style>
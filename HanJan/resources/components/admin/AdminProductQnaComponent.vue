<template>
    <div class="admin">
        <h2 class="admin_title">상품 문의 관리</h2>
        <div class="admin_productqna_list_container">
            <div class="admin_productqna_list_name admin_weight">유저 이름</div>
            <div class="admin_productqna_list_content admin_weight">문의 내용</div>
            <div class="admin_productqna_list_answer admin_weight">답변 내용</div>
            <div class="admin_productqna_list_date admin_weight">작성일</div>
            <div class="admin_productqna_list_updated admin_weight">수정일</div>
            <div class="admin_productqna_list_deleted admin_weight">삭제일</div>
        </div>
        <div v-for="productqna in $store.state.adminProductQnaData.data" :key="productqna.qnp_id" class="admin_productqna_list_container admin_paddingtop">
            <div class="admin_productqna_list_name">{{ productqna.name }}</div>
            <div class="admin_productqna_list_content">{{ productqna.qnp_content }}</div>
            <div class="admin_productqna_list_answer">{{ productqna.qnp_answer }}</div>
            <div class="admin_productqna_list_date">{{ productqna.created_at }}</div>
            <div class="admin_productqna_list_updated">{{ productqna.updated_at }}</div>
            <div class="admin_productqna_list_deleted">{{ productqna.deleted_at }}</div>
            <button v-if="productqna.deleted_at == null" @click="productqnaUpdate(productqna)" class="admin_btn">답변하기</button>
        </div>
    
        <!-- 페이지네이션 -->
        <div class="admin_list_num_item">
            <a href="#" class="before" @click.prevent="prevPage()">〈 이전</a>
            <a
                v-for="page in pages"
                :key="page"
                href="#"
                :class="{'admin_num': page === $store.state.adminProductQnaData.current_page, 'admin_num_none': page !== $store.state.adminProductQnaData.current_page}"
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

    onBeforeMount(() => {
        if(store.state.adminProductQnaData.current_page == 1) {
            store.dispatch('getAdminProductQnasData', 1);
        }
    })

    // 페이지네이션
    // 페이지 번호 배열 계산
    const pages = computed(() => {
        const pageArray = [];
        // 페이지네이션 5개
        const maxPagesToShow = 5;

        // let startPage = store.state.adminProductQnaData.current_page - 2;
        let startPage = store.state.adminProductQnaData.last_page <5 ? 1 : store.state.adminProductQnaData.current_page - 2;
        if(startPage < 1) {
            startPage = 1;
        }
        const endPage = startPage + maxPagesToShow - 1;

        // 시작페이지 구하기
        const pagingStart = startPage <= (store.state.adminProductQnaData.last_page - maxPagesToShow + 1) || ((store.state.adminProductQnaData.last_page - maxPagesToShow + 1) < 1) ? startPage : (store.state.adminProductQnaData.last_page - maxPagesToShow + 1);
        
        // 마지막 페이지 구하기
        const pagingEnd = endPage > store.state.adminProductQnaData.last_page ? store.state.adminProductQnaData.last_page : endPage;

        for (let i = pagingStart; i <= pagingEnd; i++) {
            pageArray.push(i)
        }
        return pageArray
    })

    // 특정 페이지로 이동
    function goToPage(page) {
        store.dispatch('getAdminProductQnasData', page);
    }

    // 이전 페이지로 이동
    function prevPage() {
        if (store.state.adminProductQnaData.current_page > 1) {
            goToPage(store.state.adminProductQnaData.current_page - 1);
        }
    }

    // 다음 페이지로 이동
    function nextPage() {
        if (store.state.adminProductQnaData.current_page < store.state.adminProductQnaData.last_page) {
            goToPage(store.state.adminProductQnaData.current_page + 1);
        }
    }

    // 상품문의 답변 페이지로 정보 넘기기
    function productqnaUpdate(item) {
        store.dispatch('adminProductQnaToUpdate', item);
    }

</script>

<style>

</style>
<template>
    <div class="admin">
        <h2 class="admin_title">주문 관리</h2>
        <div class="admin_order_list_container">
            <div class="admin_order_list_num admin_weight">주문 번호</div>
            <div class="admin_order_list_name admin_weight">구매자 이름</div>
            <div class="admin_order_list_tell admin_weight">구매자 전화번호</div>
            <div class="admin_order_list_recipient_name admin_weight">수령인 이름</div>
            <div class="admin_order_list_recipient_tell admin_weight">수령인 번호</div>
            <div class="admin_order_list_recipient_adds admin_weight">수령인 주소</div>
            <div class="admin_order_list_recipient_post admin_weight">수령인 우편번호</div>
            <div class="admin_order_list_amount admin_weight">주문 금액</div>
            <div class="admin_order_list_date admin_weight">주문일</div>
        </div>
        <div  v-for="order in $store.state.adminOrderData.data" :key="order.or_id" class="admin_order_list_container admin_paddingtop">
            <div class="admin_order_list_num">{{ order.or_id }}</div>
            <div class="admin_order_list_name">{{ order.or_buy_name }}</div>
            <div class="admin_order_list_tell">{{ order.or_buy_tel }}</div>
            <div class="admin_order_list_recipient_name">{{ order.or_get_name }}</div>
            <div class="admin_order_list_recipient_tell">{{ order.or_get_tel }}</div>
            <div class="admin_order_list_recipient_adds">{{ order.or_get_addr + order.or_get_det_addr }}</div>
            <div class="admin_order_list_recipient_post">{{ order.or_get_post }}</div>
            <div class="admin_order_list_amount ">{{ order.or_sum + '원' }}</div>
            <div class="admin_order_list_date">{{ order.created_at }}</div>
        </div>

        <!-- 페이지네이션 -->
        <div class="admin_list_num_item">
            <a href="#" class="before" @click.prevent="prevPage()">〈 이전</a>
            <a
                v-for="page in pages"
                :key="page"
                href="#"
                :class="{'admin_num': page === $store.state.adminOrderData.current_page, 'admin_num_none': page !== $store.state.adminOrderData.current_page}"
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
        if(store.state.adminOrderData.current_page == 1) {
            store.dispatch('getAdminOrdersData', 1);
        }
    })

    // 페이지네이션
    // 페이지 번호 배열 계산
    const pages = computed(() => {
        const pageArray = [];
        // 페이지네이션 5개
        const maxPagesToShow = 5;

        // let startPage = store.state.adminOrderData.current_page - 2;
        let startPage = store.state.adminOrderData.last_page <5 ? 1 : store.state.adminOrderData.current_page - 2;
        if(startPage < 1) {
            startPage = 1;
        }
        const endPage = startPage + maxPagesToShow - 1;

        // 시작페이지 구하기
        const pagingStart = startPage <= (store.state.adminOrderData.last_page - maxPagesToShow + 1) || ((store.state.adminOrderData.last_page - maxPagesToShow + 1) < 1) ? startPage : (store.state.adminOrderData.last_page - maxPagesToShow + 1);
        
        // 마지막 페이지 구하기
        const pagingEnd = endPage > store.state.adminOrderData.last_page ? store.state.adminOrderData.last_page : endPage;

        for (let i = pagingStart; i <= pagingEnd; i++) {
            pageArray.push(i)
        }
        return pageArray
    })

    // 특정 페이지로 이동
    function goToPage(page) {
        store.dispatch('getAdminOrdersData', page);
    }

    // 이전 페이지로 이동
    function prevPage() {
        if (store.state.adminOrderData.current_page > 1) {
            goToPage(store.state.adminOrderData.current_page - 1);
        }
    }

    // 다음 페이지로 이동
    function nextPage() {
        if (store.state.adminOrderData.current_page < store.state.adminOrderData.last_page) {
            goToPage(store.state.adminOrderData.current_page + 1);
        }
    }
</script>

<style>

</style>
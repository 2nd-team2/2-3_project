<template>
    <div class="admin">
        <h2 class="admin_title">교환 및 반품 관리</h2>
        <div class="admin_exchange_list_container">
            <div class="admin_exchange_list_name admin_weight">신청인</div>
            <div class="admin_exchange_list_tell admin_weight">신청인 번호</div>
            <div class="admin_exchange_list_adds admin_weight">신청인 주소</div>
            <div class="admin_exchange_list_post admin_weight">신청인 우편번호</div>
            <div class="admin_exchange_list_reason_etc admin_weight">상세사유</div>
            <div class="admin_exchange_list_reason admin_weight">사유</div>
            <div class="admin_exchange_list_flg admin_weight">진행상황</div>
            <div class="admin_exchange_list_date admin_weight">신청일</div>
            <div class="admin_exchange_list_or_num admin_weight">주문 번호</div>
            <div class="admin_exchange_list_or_amount admin_weight">주문 금액</div>
            <div class="admin_exchange_list_or_date admin_weight">주문일</div>
            <div class="admin_exchange_list_or_date admin_weight"></div>
        </div>

        <div v-for="exchange in $store.state.adminExchangeData.data" :key="key" class="admin_exchange_list_container admin_paddingtop">
            <div class="admin_exchange_list_name">{{ exchange.ex_name }}</div>
            <div class="admin_exchange_list_tell">{{ exchange.ex_tel }}</div>
            <div class="admin_exchange_list_adds">{{ exchange.ex_addr + exchange.ex_det_addr }}</div>
            <div class="admin_exchange_list_post">{{ exchange.ex_post }}</div>
            <div class="admin_exchange_list_reason_etc">{{ exchange.ex_reason_etc }}</div>
            <div class="admin_exchange_list_reason">{{ exchange.ex_reason }}</div>
            <div class="admin_exchange_list_flg">{{ exchange.ex_flg }}</div>
            <div class="admin_exchange_list_date">{{ exchange.created_at }}</div>
            <div class="admin_exchange_list_or_num">{{ exchange.or_id }}</div>
            <div class="admin_exchange_list_or_amount">{{ exchange.or_sum }}</div>
            <div class="admin_exchange_list_or_date">{{ exchange.or_created_at }}</div>
            <button type="button" v-if="exchange.ex_flg === '신청완료'" class="admin_btn">접수받기</button>
            <button type="button" v-if="exchange.ex_flg === '상품회수중'" class="admin_btn">결제취소</button>
        </div>

        <!-- 페이지네이션 -->
        <div class="admin_list_num_item">
            <a href="#" class="before" @click.prevent="prevPage()">〈 이전</a>
            <a
                v-for="page in pages"
                :key="page"
                href="#"
                :class="{'admin_num': page === $store.state.adminExchangeData.current_page, 'admin_num_none': page !== $store.state.adminExchangeData.current_page}"
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
        if(store.state.adminExchangeData.current_page == 1) {
            store.dispatch('getAdminExchangesData', 1);
        }
    })

    // 페이지네이션
    // 페이지 번호 배열 계산
    const pages = computed(() => {
        const pageArray = [];
        // 페이지네이션 5개
        const maxPagesToShow = 5;

        // let startPage = store.state.adminExchangeData.current_page - 2;
        let startPage = store.state.adminExchangeData.last_page <5 ? 1 : store.state.adminExchangeData.current_page - 2;
        if(startPage < 1) {
            startPage = 1;
        }
        const endPage = startPage + maxPagesToShow - 1;

        // 시작페이지 구하기
        const pagingStart = startPage <= (store.state.adminExchangeData.last_page - maxPagesToShow + 1) || ((store.state.adminExchangeData.last_page - maxPagesToShow + 1) < 1) ? startPage : (store.state.adminExchangeData.last_page - maxPagesToShow + 1);
        
        // 마지막 페이지 구하기
        const pagingEnd = endPage > store.state.adminExchangeData.last_page ? store.state.adminExchangeData.last_page : endPage;

        for (let i = pagingStart; i <= pagingEnd; i++) {
            pageArray.push(i)
        }
        return pageArray
    })

    // 특정 페이지로 이동
    function goToPage(page) {
        store.dispatch('getAdminExchangesData', page);
    }

    // 이전 페이지로 이동
    function prevPage() {
        if (store.state.adminExchangeData.current_page > 1) {
            goToPage(store.state.adminExchangeData.current_page - 1);
        }
    }

    // 다음 페이지로 이동
    function nextPage() {
        if (store.state.adminExchangeData.current_page < store.state.adminExchangeData.last_page) {
            goToPage(store.state.adminExchangeData.current_page + 1);
        }
    }
</script>

<style>

</style>
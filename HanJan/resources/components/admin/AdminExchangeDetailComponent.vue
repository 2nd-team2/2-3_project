<template>
    <div class="admin">
        <h2 class="admin_title">교환 및 반품 상세</h2>
        <div class="ex_detail">
            <div class="ex_detail_title">신청인</div>
            <div class="admin_ex_list_name">{{ $store.state.adminExchageDetail.ex_name }}</div>
            <div class="ex_detail_title">신청인 전화번호</div>
            <div class="admin_ex_list_tell">{{ $store.state.adminExchageDetail.ex_tel }}</div>
            <div class="ex_detail_title">신청인 주소</div>
            <div class="admin_ex_list_adds">{{ $store.state.adminExchageDetail.ex_addr + $store.state.adminExchageDetail.ex_det_addr }}</div>
            <div class="ex_detail_title">신청인 우편주소</div>
            <div class="admin_ex_list_post">{{ $store.state.adminExchageDetail.ex_post }}</div>
            <div class="ex_detail_title">사유</div>
            <div class="admin_ex_list_reason">{{ $store.state.adminExchageDetail.ex_reason }}</div>
            <div class="ex_detail_title">상세사유</div>
            <div class="admin_ex_list_reason_etc">{{ $store.state.adminExchageDetail.ex_reason_etc }}</div>
            <div class="ex_detail_title">진행상황</div>
            <div class="admin_ex_list_flg">{{ $store.state.adminExchageDetail.ex_flg }}</div>
            <div class="ex_detail_title">신청일</div>
            <div class="admin_ex_list_date">{{ $store.state.adminExchageDetail.created_at }}</div>
            <div class="ex_detail_title">주문 번호</div>
            <div class="admin_ex_list_or_num">{{ $store.state.adminExchageDetail.or_id }}</div>
            <div class="ex_detail_title">주문 금액</div>
            <div class="admin_ex_list_or_amount">{{ formatPrice($store.state.adminExchageDetail.orp_count * $store.state.adminExchageDetail.price) }}</div>
            <div class="ex_detail_title">주문일</div>
            <div class="admin_ex_list_or_date">{{ $store.state.adminExchageDetail.orpCre }}</div>
        </div>
            
        <div class="admin_hr"></div>
        <div class="admin_btn_box">
            <button type="button" @click="$router.back()" class="admin_btn">목록</button>
        </div>
    </div>
</template>

<script setup>
    // 금액 천단위 포맷 (,000)
    function formatPrice(price) {
            return price.toLocaleString('ko-KR');
    }
</script>

<style>

</style>
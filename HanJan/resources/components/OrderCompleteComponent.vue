<template>
    <main>
        <div class="header_top">
            <ul class="header_step">
                <h2>결제 완료</h2>
                <li>01 장바구니</li>
                <li>></li>
                <li>02 정보입력</li>
                <li>></li>
                <li class="li_yellow">03 결제완료</li>
            </ul>
        </div>
        <div class="ord_com">
            <div class="ord_com_box">
                <h2>
                    주문이 완료 되었습니다.
                </h2>
                <router-link to="/list?type=99&page=1" class="bag_cancel">
                    계속 쇼핑하기
                </router-link>
            </div>
        </div>
    </main>
</template>

<script setup>
</script>

<style scoped src="../css/ordercom.css">
</style>
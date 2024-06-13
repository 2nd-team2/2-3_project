<template>
    <main>
        <div class="container">
            <div class="order_list">
                <div class="order_list_header">
                    <h1>주문목록</h1>
                    <div>
                        <button class="keep_shoping_btn black_button" @click="$router.push('/')">계속 쇼핑하기</button>
                        <button class="shoping_btn review_manage_btn black_button">리뷰관리</button>
                        <button class="user_update_btn black_button">회원정보 수정</button>
                    </div>
                </div>
                <div class="order_list_main">
                    <div class="order_item">
                        <div class="item_left_list_text">
                            <div class="order_date">
                                <span class="title_span">2024-06-02 주문 / 구매확정 </span>
                                <span class="yellow_span">06-07(금)</span>
                            </div>
                            <span class="order_delete"></span>
                            <div class="order_img"></div>
                            <p class="order_name">한잔 꿈의 대화 13도 375ml</p>
                            <p class="order_price">금액 : 24,000원 / 1개</p>
                            <span class="button_a">구매확정</span>
                        </div>
                        <div class="item_right">
                            <span class="button_a">상품문의하기</span>
                            <span class="button_a">교환, 반품 신청</span>
                            <span class="button_a">리뷰 작성하기</span>
                        </div>
                    </div>
                    <div class="list_num_item">
                        <span class="before">〈 이전</span>
                        <span class="num_none">1</span>
                        <span class="num_none">2</span>
                        <span class="num">3</span>
                        <span class="num_none">4</span>
                        <span class="num_none">5</span>
                        <span class="nuxt">다음 〉</span>
                    </div>
                </div>
            </div>
            <div class="inquiry_list">
                <div class="inquiry_list_header">
                    <h1>문의내역</h1>
                    <div>
                        <button class="keep_shoping_btn black_button">1:1 문의하기</button>
                    </div>
                </div>
                <div class="inquiry_list_main">
                    <div class="inquiry_item">
                        <div class="inquiry_item_left_list_text">
                            <div>
                                <span class="title_span">상품문의</span>
                            </div>
                            <div class="inquiry_img"></div>
                            <p class="inquiry_name">한잔 꿈의 대화 13도 375ml / 1개</p>
                            <p class="inquiry_date">2024-06-07</p>
                        </div>
                        <div class="inquiry_item_right_list">
                            <span class="inquiry_delete"></span>
                            <button class="keep_shoping_btn black_button">답변완료</button>
                        </div>
                    </div>
                    <div class="inquiry_item">
                        <div class="inquiry_item_left_list_text">
                            <div class="inquiry_text">
                                <span class="title_span">1:1 문의</span>
                            </div>
                            <div class="inquiry_div">
                            </div>
                            <p class="inquiry_name">개인 문의 제목</p>
                            <p class="one_date">2024-06-07</p>
                        </div>
                        <div class="inquiry_item_right_list">
                            <span class="inquiry_delete"></span>
                            <button class="in_progress black_button">답변진행중</button>
                        </div>
                    </div>
                </div>
                <div class="list_num_item">
                    <span class="before">〈 이전</span>
                    <span class="num_none">1</span>
                    <span class="num_none">2</span>
                    <span class="num">3</span>
                    <span class="num_none">4</span>
                    <span class="num_none">5</span>
                    <span class="nuxt">다음 〉</span>
                </div>
            </div>
        </div>
    </main>
    <!-- move top -->
    <a href="#" class="move_top">
        <img src="/img/up.png" class="move_top_img">
    </a>
</template>
<script setup>

</script>
<style scoped src="../css/info.css">
</style>
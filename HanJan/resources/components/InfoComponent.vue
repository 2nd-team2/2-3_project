<template>
    <main>
        <div class="container">
            <div class="order_list">
                <div class="order_list_header">
                    <h1>주문목록</h1>
                    <div>
                        <button class="keep_shoping_btn black_button" @click="$router.push('/list')">계속 쇼핑하기</button>
                        <button class="shoping_btn review_manage_btn black_button" @click="$router.push('/review')">리뷰관리</button>
                        <button class="user_update_btn black_button" @click="$router.push('/confirm')">회원정보 수정</button>
                    </div>
                </div>
                <div class="order_list_main">
                    <div class="order_item" v-for="(item, key) in $store.state.infoData" :key="key">
                        <div class="item_left_list_text">
                            <div class="order_date">
                                <span class="title_span">{{ item.created_at + ' / ' + '구매확정 ' }}</span>
                                <span class="yellow_span">06-07(금)</span>
                            </div>
                            <button class="order_delete"></button>
                            <div class="order_img" :src="item.img"></div>
                            <p class="order_name">{{ item.name + ' ' + item.ml +'ml' }}</p>
                            <p class="order_price">{{ '금액 : ' + item.price + '원 / 1개' }}</p>
                            <button class="button_a">구매확정</button>
                        </div>
                        <div class="item_right">
                            <button @click="$router.push('/qnaproduct')" class="button_a">상품문의하기</button> 
                            <button @click="$router.push('/exchange')" class="button_a">교환, 반품 신청</button>
                            <button @click="$router.push('/reviewcreate')" class="button_a">리뷰 작성하기</button>
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
                    <router-link to="/qnaonebyone" class="keep_shoping_btn black_button">
                        1:1 문의하기
                    </router-link>
                </div>
                <div class="inquiry_list_main">
                    <div class="inquiry_item" v-for="(item, key) in $store.state.askData" :key="key">
                        <div class="inquiry_item_left_list_text">
                            <div>
                                <span class="title_span">상품문의</span>
                            </div>
                            <div class="inquiry_img"></div>
                            <p class="inquiry_name">{{ item.qnp_content }}</p>
                            <p class="inquiry_date">{{ item.created_at }}</p>
                        </div>
                        <div class="inquiry_item_right_list">
                            <button class="inquiry_delete"></button>
                            <div class="keep_shoping_btn qna_answer">답변완료</div>
                        </div>
                    </div>
                    <div class="inquiry_item" v-for="(item, key) in $store.state.askData" :key="key">
                        <div class="inquiry_item_left_list_text">
                            <div class="inquiry_text">
                                <span class="title_span">1:1 문의</span>
                            </div>
                            <div class="inquiry_div">
                            </div>
                            <p class="inquiry_name">{{ item.qn_content }}</p>
                            <p class="one_date">{{ item.created_at }}</p>
                        </div>
                        <div class="inquiry_item_right_list">
                            <span class="inquiry_delete"></span>
                            <div class="in_progress qna_answer">답변진행중</div>
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
import { onBeforeMount } from 'vue';
import { useStore } from 'vuex'

const store = useStore()

// 초기 데이터
onBeforeMount(() => {
    store.dispatch('infoData')
    store.dispatch('askData')
})
</script>
<style scoped src="../css/info.css">
</style>
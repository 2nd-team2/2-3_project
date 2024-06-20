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
                        <!-- <div>{{ item }}</div> -->
                        <div class="item_left_list_text">
                            <div class="order_date">
                                <span class="title_span">{{ item.orpDate }}</span>
                                <span class="title_span" v-if="item.co_flg === '1'"> / 구매확정 : </span>
                                <span class="yellow_span" v-if="item.co_flg === '1'">{{ item.completeOn }}</span>
                            </div>
                            <button class="order_delete" @click="$store.dispatch('orderItemDelete', item.itemId)" v-if="item.co_flg === '1'"></button>
                            <div class="order_img" :src="item.img"></div>
                            <p class="order_name">{{ item.name + ' ' + item.ml +'ml' }}</p>
                            <p class="order_price">{{ '금액 : ' + item.price + '원 / 1개' }}</p>
                            <button class="button_a" @click="$store.dispatch('completeBtn', item.id)" v-if="item.co_flg === '0' || item.co_flg === null">구매확정</button>
                        </div>
                        <div class="item_right">
                            <button @click="$router.push('/qnaproduct/', item.p_id)" class="button_a" v-if="item.co_flg === '0' || item.co_flg === null">상품문의하기</button> 
                            <button @click="$router.push('/exchange')" class="button_a" v-if="item.co_flg === '0' || item.co_flg === null">교환, 반품 신청</button>
                            <button @click="infoReviewCreate(item)" class="button_a" v-if="item.co_flg === '1'">리뷰 작성하기</button>
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
                <div class="inquiry_list_main" v-for="(item, key) in $store.state.productAskData" :key="key">
                    <!-- <div>{{ item }}</div> -->
                    <div class="inquiry_item" >
                        <div class="inquiry_item_left_list_text">
                            <div>
                                <span class="title_span">상품문의</span>
                            </div>
                            <!-- <div class="inquiry_img" :src="item.img"></div> -->
                            <p class="inquiry_name cursorBtn" @click="$router.push('/qnaproductlist/', item.qnp_id)">{{ item.qnp_content }}</p>
                            <p class="inquiry_date">{{ item.created_at }}</p>
                        </div>
                        <div class="inquiry_item_right_list">
                            <button type="submit" class="inquiry_delete" @click="$store.dispatch('productAskDelete', item.qnp_id)"></button>
                            <div class="keep_shoping_btn qna_answer" v-if="item.qnp_answer">답변완료</div>
                            <div class="keep_shoping_btn qna_answer" v-else>답변진행중</div>
                        </div>
                    </div>
                </div>
                <div class="inquiry_list_main" v-for="(item, key) in $store.state.askSetData" :key="key">
                    <!-- <div>{{ item }}</div> -->
                    <div class="inquiry_item">
                        <div class="inquiry_item_left_list_text">
                            <div class="inquiry_text">
                                <span class="title_span">1:1 문의</span>
                            </div>
                            <div class="inquiry_div">
                            </div>
                            <p class="inquiry_name cursorBtn" @click="$router.push('/qnaonebyonelist/', item.qn_id)">{{ item.qn_content }}</p>
                            <p class="one_date">{{ item.created_at }}</p>
                        </div>
                        <div class="inquiry_item_right_list">
                            <button type="submit" class="inquiry_delete" @click="$store.dispatch('askDelete', item.qn_id)"></button>
                            <div class="in_progress qna_answer" v-if="item.qn_answer">답변완료</div>
                            <div class="in_progress qna_answer" v-else>답변진행중</div>
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
import { useStore } from 'vuex';

const store = useStore();

// 초기 데이터
onBeforeMount(() => {
    store.dispatch('infoData');
    store.dispatch('productAskData');
    store.dispatch('askData');
})

// 리뷰 수정하기 페이지로 정보 넘기기
const infoReviewCreate = (item) => {
    store.dispatch('infoReviewCreate', item);
}
</script>
<style scoped src="../css/info.css">
</style>
<template>
    <main>
        <div class="container">
            <div class="order_list">
                <div class="order_list_header">
                    <h1>주문목록</h1>
                    <div>
                        <button class="keep_shoping_btn black_button" @click="$router.push('/list')">계속 쇼핑하기</button>
                        <button class="shoping_btn review_manage_btn black_button" @click="store.dispatch('reviewGet')">리뷰관리</button>
                        <button class="user_update_btn black_button" @click="$router.push('/confirm')">회원정보 수정</button>
                    </div>
                </div>
                <div class="order_list_main">
                    <div class="order_item" v-for="(item, key) in $store.state.infoData" :key="key" v-if="$store.state.infoData">
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
                            <p class="order_price">{{ '금액 : ' + item.price + '원 / ' + item.orp_count + '개' }}</p>
                            <button class="button_a" @click="$store.dispatch('completeBtn', item.id)" v-if="item.co_flg === '0' || item.co_flg === null">구매확정</button>
                        </div>
                        <div class="item_right">
                            <button  class="button_a" v-if="item.co_flg === '0' || item.co_flg === null">상품문의하기</button> 
                            <button @click="$router.push('/exchange')" class="button_a" v-if="item.co_flg === '0' || item.co_flg === null">교환, 반품 신청</button>
                            
                            <button @click="infoReviewCreate(item)" class="button_a" v-if="item.co_flg === '1'">리뷰 작성하기</button>
                        </div>
                    </div>
                    <h2 v-else>주문 상품이 없습니다.</h2>
                    <div class="list_num_item">
                        <span class="before">〈 이전</span>
                        <span class="num_none">1</span>
                        <span class="num_none">2</span>
                        <span class="num">3</span>
                        <span class="num_none">4</span>
                        <span class="num_none">5</span>
                        <span class="next">다음 〉</span>
                    </div>
                </div>
            </div>
            <div class="inquiry_list">
                <div class="inquiry_list_header">
                    <h1>상품문의 내역</h1>
                </div>
                <div class="inquiry_list_main" v-for="(item, key) in $store.state.productAskData" :key="key" v-if="$store.state.productAskData">
                    <!-- <div>{{ item }}</div> -->
                    <div class="inquiry_item" >
                        <div class="inquiry_item_left_list_text">
                            <div>
                                <span class="title_span">상품문의</span>
                            </div>
                            <!-- <div class="inquiry_img" :src="item.img"></div> -->
                            <p class="inquiry_name cursorBtn" @click=qnaProductDetail(item.qnp_id)>{{ item.qnp_content }}</p>
                            <p class="inquiry_date">{{ item.created_at }}</p>
                        </div>
                        <div class="inquiry_item_right_list">
                            <button type="submit" class="inquiry_delete" @click="$store.dispatch('productAskDelete', item.qnp_id)"></button>
                            <div class="keep_shoping_btn qna_answer" v-if="item.qnp_answer">답변완료</div>
                            <div class="keep_shoping_btn qna_answer" v-else>답변진행중</div>
                        </div>
                    </div>
                </div>
                <h2 v-else>상품문의 내역이 없습니다.</h2>
                <div class="list_num_item">
                    <span class="before">〈 이전</span>
                    <span class="num_none">1</span>
                    <span class="num_none">2</span>
                    <span class="num">3</span>
                    <span class="num_none">4</span>
                    <span class="num_none">5</span>
                    <span class="next">다음 〉</span>
                </div>
                <div class="inquiry_list_header">
                    <h1>1:1문의 내역</h1>
                    <router-link to="/qnaonebyone" class="keep_shoping_btn black_button">
                        1:1 문의하기
                    </router-link>
                </div>
                <div class="inquiry_list_main" v-for="(item, key) in $store.state.askSetData" :key="key" v-if="$store.state.askSetData">
                    <!-- <div>{{ item }}</div> -->
                    <div class="inquiry_item">
                        <div class="inquiry_item_left_list_text">
                            <div class="inquiry_text">
                                <span class="title_span">1:1 문의</span>
                            </div>
                            <div class="inquiry_div">
                            </div>
                            <p class="inquiry_name cursorBtn" @click=qnaOneByOneDetail(item.qn_id)>{{ item.qn_content }}</p>
                            <p class="one_date">{{ item.created_at }}</p>
                        </div>
                        <div class="inquiry_item_right_list">
                            <button type="submit" class="inquiry_delete" @click="$store.dispatch('askDelete', item.qn_id)"></button>
                            <div class="in_progress qna_answer" v-if="item.qn_answer">답변완료</div>
                            <div class="in_progress qna_answer" v-else>답변진행중</div>
                        </div>
                    </div>
                </div>
                <h2 v-else>상품문의 내역이 없습니다.</h2>
                <div class="list_num_item">
                    <span class="before">〈 이전</span>
                    <span class="num_none">1</span>
                    <span class="num_none">2</span>
                    <span class="num">3</span>
                    <span class="num_none">4</span>
                    <span class="num_none">5</span>
                    <span class="next">다음 〉</span>
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
import router from '../js/router';
const store = useStore();

// 초기 데이터
onBeforeMount(() => {
    store.dispatch('infoData');
    store.dispatch('productAskData');
    store.dispatch('askData');
})

// 리뷰 작성하기 페이지로 정보 넘기기
const infoReviewCreate = (item) => {
    store.dispatch('infoReviewCreate', item);
}
// 리뷰 관리 페이지로 정보 넘기기
// const infoReviewManage = (item) => {
//     store.dispatch('reviewGet', item);
// }
// 상품문의 디테일 페이지 이동
function qnaProductDetail(id) {
        router.push('/qnaproductdetail?id=' + id);
    }
// 1:1 문의 디테일 페이지 이동
function qnaOneByOneDetail(id) {
    router.push('/qnaonebyonedetail?id=' + id);
}



</script>
<style scoped src="../css/info.css">
</style>
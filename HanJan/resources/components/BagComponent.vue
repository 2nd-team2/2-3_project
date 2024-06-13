<template>
    <main>
        <h2 class="bag_title bag_title_grid">
            <div>
                <span>장바구니</span>
                <span class="bag_Sequence"><span class="bag_yellow">01장바구니</span>> 02정보입력 > 03결제완료</span>
            </div>
            <router-link to="/list" class="bag_cancel">
                <a>계속 쇼핑하기</a>
            </router-link>
        </h2>
            
        <form action="" class="">

            <div v-for="(item, key) in $store.state.bagsProductData" :key="key" class="bag_goods_item bag_grid bag_padding_bottom">
                <!-- 체크 박스 name, id 1씩 증가시키기 -->
                <input type="checkbox" :name="'product_chk_' + (key + 1)" :id="'product_chk_' + (key + 1)">
                <img class="bag_goods_img" src="/img/best.png">
                <div class="reviewC_item_grid">
                    <div class="bag_goods_title bag_padding_bottom"> {{ item.name }}</div>
                    <div class="bag_padding_bottom">
                        <div>배송비 : 착불</div>
                        <div class="bag_font">금액: {{ item.price }}원</div>
                    </div>
                    <div class="bag_count">

                        <!-- 각 상품의 수량 name, id 1씩 증가시키기 -->
                        <div @click="decInt" :disabled="count === 1" :id="'dec' + (key + 1)" class="bag_count_minus">-</div>
                        <!-- 텍스트 기록 못하게 하거나 넘버로 했을때 자체적으로 숫자 증감버튼 없애기 -->
                        <input type="text" v-model="count" :name="'count' + (key + 1)" :id="'count' + (key + 1)" @input="validateCount" class="quantity-input">
                        <div @click="incInt" :id="'inc' + (key + 1)" class="bag_count_plus">+</div>
                

                    </div>
                </div>
                <div class="bag_delete_flex">
                    <form action="" >
                        <button class="bag_delete" type="submit"></button>
                    </form>
                </div>
            </div>

            <div class="pagination">
                <div class="prev"><span> 〈 </span>이전</div>
                <div class="page-numbers"></div>
                <div class="next">다음<span> 〉 </span></div>
            </div>

            <hr>

            <div class="bag_margin_top bag_margin_bottom bag_total_border bag_total_grid">
                <div></div>
                <div class="bag_price_grid">
                    <div> 총 0 개의 상품금액</div>
                    <div class="bag_yellow bag_flex_end"> 0원</div>
                </div>
                <img src="/img/plus.png">
                <div>
                    <div>배송비</div>
                    <div class="bag_yellow bag_flex_end"> 0원</div>
                </div>
                <img src="/img/equal.png">
                <div>
                    <div>합계</div>
                    <div class="bag_yellow bag_flex_end">0원</div>
                </div>
            </div>
            <div class="bag_margin_top bag_btn_grid">
                <form action="">
                    <button type="submit" class="bag_cancel bag_border_none">전체삭제</button>
                </form>
                <div class="bag_flex_end">
                    <button type="submit" class="bag_cancel bag_border_none">결제하기</button>
                </div>
            </div>
        </form>
    </main>


    <!-- move top -->
    <a href="#" class="move_top">
        <img src="/img/up.png" class="move_top_img">
    </a>
</template>

<script setup>
import { onBeforeMount, ref } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

// 게시글 습득 관련
onBeforeMount(() => {
    if(store.state.bagsProductData.length < 1 ) {
        store.dispatch('bagsGetProductData');
    }
})

// 수량 증가 감소 버튼
const count = ref(1);

const decInt = () => {
  if (count.value > 1) {
    count.value--;
  }
};

const incInt = () => {
  count.value++;
};

const validateCount = () => {
  if (isNaN(count.value) || count.value < 1) {
    count.value = 1;
  }
};



</script>

<style scoped src="../css/bag.css">
</style>
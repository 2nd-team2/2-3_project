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
                <input @click="check(item.price)" type="checkbox" name="product_chk" :value="item.ba_id">
                <img class="bag_goods_img" src="/img/best.png">
                <div class="reviewC_item_grid">
                    <div class="bag_goods_title bag_padding_bottom"> {{ item.name }}</div>
                    <div class="bag_padding_bottom">
                        <div>배송비 : 착불</div>
                        <div class="bag_font">금액: {{ item.price }}원</div>
                    </div>

                    <div class="bag_count">
                        <div @click="decInt(item)" :disabled="item.ba_count.value === 1" id="dec" class="bag_count_minus">-</div>
                        <input type="number" v-model="item.ba_count" name="count" @input="validateCount(item)" class="quantity-input">
                        <div @click="incInt(item)" id="inc" class="bag_count_plus">+</div>
                    </div>

                </div>
                <div class="bag_delete_flex">
                    <button @click="$store.dispatch('bagsDelete', item.ba_id)" class="bag_delete" type="submit"></button>
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

const count = ref(1)

// 수량 증가 감소 버튼
const decInt = (item) => {
  if (item.ba_count > 1) {
    item.ba_count.value--;

    // TODO : 새로고침하기전에 DB에 저장해두기 - incInt도 같이하기 
    // store.dispatch('', item.ba_count);
  }
};

const incInt = (item) => {
    item.ba_count.value++;
};

// 1보다 작으면 1로 고정
const validateCount = (item) => {
  if ( item.ba_count.value < 1) {
    item.ba_count.value = 1;
  }
};


// 체크 했을때 상품의 가격 데이터를 들고옴
const check = (price) => {
    console.log(price);
}


</script>

<style scoped src="../css/bag.css">
</style>
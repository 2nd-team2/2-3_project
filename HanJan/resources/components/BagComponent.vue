<template>
    <main>
        <h2 class="bag_title bag_title_grid">
            <div>
                <span>장바구니</span>
                <span class="bag_Sequence"><span class="bag_yellow">01장바구니</span>> 02정보입력 > 03결제완료</span>
            </div>
            <router-link to="/list?type=99" class="bag_cancel">
                계속 쇼핑하기
            </router-link>
        </h2>
            
        <form id="bagsProductData">
            <div v-if="$store.state.bagsProductData && $store.state.bagsProductData.length > 0">
                <div v-for="(item, key) in $store.state.bagsProductData" :key="key" class="bag_goods_item bag_grid bag_padding_bottom">
                    <!-- click 이벤트를 먼저 하고 난뒤에 수량을 변경할 경우 -->
                    <input type="checkbox" @click="check(item)" v-model="item.checked" name="product_chk[]" :value="item.ba_id">
                    
                    <img class="bag_goods_img" src="/img/best.png">
    
                    <div class="reviewC_item_grid">
                        <div class="bag_goods_title bag_padding_bottom"> {{ item.name }}</div>
                        <div class="bag_padding_bottom">
                            <div>배송비 : 착불</div>
                            <div class="bag_font">금액: {{ item.price }}원</div>
                        </div>
    
                        <div class="bag_count">
                            <button type="button" @click="decInt(item)" :disabled="item.ba_count <= 1" class="bag_count_minus">-</button>
                            <input type="number" v-model="item.ba_count" name="count" @change="validateCount(item)" class="quantity-input">
                            <button type="button" @click="incInt(item)" :disabled="item.ba_count >= item.count" class="bag_count_plus">+</button>
                        </div>
    
                        <div>
                            <p>총 상품가격 : {{ item.price * item.ba_count }}원 </p>
                        </div>
                    </div>
    
                    <div class="bag_delete_flex">
                        <button @click="$store.dispatch('bagsDelete', item.ba_id)" class="bag_delete" type="submit"></button>
                    </div>
                </div>
            </div>
            <div v-else>
                장바구니에 상품이 없습니다.
            </div>

            <hr>

            <!-- TODO: CSS 수정 > 스크롤 내려도 옆에 계속 보이게 하다가 일정 높이 도착하면 멈추게 하기 -->
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
                <div>
                    <button @click="selectAll" type="button" class="bag_cancel bag_border_none bag_margin_right">전체 선택</button>
                    <!-- <button @click="selectAll" v-if="!checkAll" type="button" class="bag_cancel bag_border_none bag_margin_right">전체 선택</button> -->
                    <!-- <button @click="selectAll" v-else type="button" class="bag_cancel bag_border_none bag_margin_right">전체 해제</button> -->
                    <button @click="selectDelete" type="button" class="bag_cancel bag_border_none">선택 삭제</button>
                    <!-- <button @click="selectDelete" v-if="!checkAll" type="button" class="bag_cancel bag_border_none">선택 삭제</button>
                    <button @click="selectDelete" v-else type="button" class="bag_cancel bag_border_none">전체 삭제</button> -->
                </div>

                <div class="bag_flex_end">
                    <button @click="$router.push('/order')" type="button" class="bag_cancel bag_border_none">구매하기</button>
                    <!-- TODO : 가지고 있는 정보를 다 oreder 페이지로 넘기기 -->
                    <!-- <button @click="store.dispatch('')" type="button" class="bag_cancel bag_border_none">구매하기</button> -->
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
import { onBeforeMount, ref, watch } from 'vue';
import { useStore } from 'vuex';

const store = useStore();
// 게시글 습득 관련
onBeforeMount(() => {
    store.dispatch('bagsGetProductData')
    .then(() => {
        store.state.bagsProductData.forEach(item => {
            item.checked = false; // 초기 체크 상태 설정
        });
    });
})

// 수량 감소 버튼
const decInt = (item) => {
    item.ba_count--;

    store.dispatch('bagsCountMinus', item.ba_id);
};
// 수량 증가 버튼
const incInt = (item) => {
    item.ba_count++;

    store.dispatch('bagsCountPlus', item.ba_id);
};


// 전체 선택(전체 해제) 버튼
//     +) 전체 삭제, 선택 삭제 버튼 설정도 같이 진행
const checkAll = ref(false);

const selectAll = () => {
    checkAll.value = !checkAll.value;

    store.state.bagsProductData.forEach(item => {
        item.checked = checkAll.value;
    });

}


// 수량 최대 최소 고정
const validateCount = (item) => {
    // 1보다 작으면 1로 고정
    if ( item.ba_count < 1) {
        item.ba_count = 1;
        alert('최소 수량은 1개 입니다.')
    }
    // 최대 수량보다 많을시 최대수량으로 고정
    else if (item.ba_count > item.count) {
        item.ba_count = item.count;
        alert('남은 수량까지 선택할 수 있습니다. ( 남은 수량 : ' + item.count + ')')
    }
};



// 체크 했을때 상품의 가격 데이터를 들고옴
const check = () => {
    const flg = store.state.bagsProductData.every(item => {
        return item.checked;
    });
    console.log(flg);
    if(!flg) {
        checkAll.value = true;
    } else {
        checkAll.value = false;
    }
}

</script>

<style scoped src="../css/bag.css">
</style>
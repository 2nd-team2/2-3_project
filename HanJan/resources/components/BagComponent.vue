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
                <!-- click 이벤트를 먼저 하고 난뒤에 수량을 변경할 경우 -->
                <input @click="check(item)"  v-model="item.checked" type="checkbox" name="product_chk" :value="item.ba_id">

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

            <!-- TODO : 페이지네이션 없애고 모든 데이터 가져오기 -->
            <!-- <div class="pagination">
                <div class="prev"><span> 〈 </span>이전</div>
                <div class="page-numbers"></div>
                <div class="next">다음<span> 〉 </span></div>
            </div> -->

            <hr>

            <!-- TODO: CSS 수정 > 스크롤 내려도 옆에 계속 보이게 하다가 일정 높이 도착하면 멈추게 하기 -->
            <div class="bag_margin_top bag_margin_bottom bag_total_border bag_total_grid">
                <div></div>
                <div class="bag_price_grid">
                    <div> 총 {{ allChecked }} 개의 상품금액</div>
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

            <!-- TODO : 상단으로 올릴지 하단에 둘지 회의 -->
            <!-- TODO : 전체 선택 창 만들기 -->
            <!-- TODO : 전체 선택이 되어 있으면 선택삭제에서 전체삭제로 바꾸기 -->
            <div class="bag_margin_top bag_btn_grid">
                <form action="">
                    <button @click="allSelect" v-if="!allChecked" type="button" class="bag_cancel bag_border_none bag_margin_right">전체 선택</button>
                    <button @click="allSelect" v-else type="button" class="bag_cancel bag_border_none bag_margin_right">전체 해제</button>
                    <button @click="$store.dispatch('selectDelete')" v-if="!allChecked" type="button" class="bag_cancel bag_border_none">선택 삭제</button>
                    <button @click="$store.dispatch('allDelete')" v-else type="button" class="bag_cancel bag_border_none">전체 삭제</button>
                </form>
                <div class="bag_flex_end">
                    <button @click="$router.push('/order')" type="button" class="bag_cancel bag_border_none">구매하기</button>
                    <!-- TODO : 가지고 있는 정보를 다 oreder 페이지로 넘기기 -->
                    <!-- <button @click="store.dispatch('')" type="submit" class="bag_cancel bag_border_none">구매하기</button> -->
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
    store.dispatch('bagsGetProductData')
    .then(() => {
        store.state.bagsProductData.forEach(item => {
            item.checked = false; // 초기 체크 상태 설정
        });
    });
})


// 전체 선택 버튼 (전체 해제)
// +) 전체 삭제, 선택해제 버튼 설정도 같이 진행
const allChecked = ref(false);
// const allChecked = computed(() => store.state.allChecked);

const allSelect = () => {
    allChecked.value = !allChecked.value;

    store.state.bagsProductData.forEach(item => {
        item.checked = allChecked.value;
    });

}

// 선택 삭제 버튼
const selectDelete = async () => {
    const selectedItems = store.state.bagsProductData.filter(item => item.checked);
    const selectedIds = selectedItems.map(item => item.ba_id);

    try {
        await axios.post('/api/delete-selected', { ids: selectedIds });
        store.dispatch('bagsGetProductData'); // 데이터 갱신
    } catch (error) {
        console.error('Error deleting selected items:', error);
    }
};



// 수량 감소 버튼
const decInt = (item) => {
    item.ba_count--;

    store.dispatch('bagsCountminus', item.ba_id);
};
// 수량 증가 버튼
const incInt = (item) => {
    item.ba_count++;

    store.dispatch('bagsCountPlus', item.ba_id);
};

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
const check = (item) => {
    console.log(item.price * item.ba_count);


    // if (bagsChk === 1) {
    //     console.log (item.price * item.ba_count);

    // }
}


</script>

<style scoped src="../css/bag.css">
</style>
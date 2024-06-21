<template>
    <main>
        <h2 class="bag_title bag_title_grid">
            <div>
                <span>장바구니</span>
                <span class="bag_Sequence"><span class="bag_yellow">01장바구니</span>> 02정보입력 > 03결제완료</span>
            </div>
            <router-link to="/list?type=99&page=1" class="bag_cancel">
                계속 쇼핑하기
            </router-link>
        </h2>
            
        <form id="bagsProductData">
            <div v-if="$store.state.bagsProductData && $store.state.bagsProductData.length > 0">
                <div v-for="(item, key) in $store.state.bagsProductData" :key="key" class="bag_goods_item bag_grid bag_padding_bottom">
                    <input type="hidden" :value="item.p_id">
                    <input type="checkbox" @click="check(item)" v-model="item.checked" name="ba_id[]" :value="item.ba_id">
                    
                    <img class="bag_goods_img" :src="item.img">    
                    <div class="reviewC_item_grid">
                        <div class="bag_goods_title bag_padding_bottom"> {{ item.name }}</div>
                        <div class="bag_padding_bottom">
                            <div>배송비 : 착불</div>
                            <div class="bag_font">금액: {{ item.price }}원</div>
                        </div>    
                        <div class="bag_count">
                            <button type="button" @click="decInt(item)" :disabled="item.ba_count <= 1" class="bag_count_minus">-</button>
                            <input type="number" v-model="item.ba_count" name="ba_count[]" @change="validateCount(item)" class="quantity-input">
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
                    <div> 총 {{ totalPrice.count }} 개의 상품금액</div>
                    <div class="bag_yellow bag_flex_end"> {{ totalPrice.total }}원</div>
                </div>
                <img src="/img/plus.png">
                <div>
                    <div>배송비</div>
                    <div class="bag_yellow bag_flex_end"> {{ deliveryPrice }}원</div>
                </div>
                <img src="/img/equal.png">
                <div>
                    <div>합계</div>
                    <div class="bag_yellow bag_flex_end"> {{ deliveryPrice + totalPrice.total }}원</div>
                </div>
            </div>

            <div class="bag_margin_top bag_btn_grid">
                <div>
                    <button @click="toggleSelectAll" type="button" class="bag_cancel bag_border_none bag_margin_right">
                        {{ allSelected ? '전체 해제' : '전체 선택' }}
                    </button>
                    <button @click="bagsSelectDelete" type="button" class="bag_cancel bag_border_none bag_margin_right">
                        {{ allSelected ? '전체 삭제' : '선택 삭제' }}
                    </button>
                </div>

                <div class="bag_flex_end">
                    <!-- <button @click="$router.push('/order')" type="button" class="bag_cancel bag_border_none">구매하기</button> -->
                    <!-- TODO : 가지고 있는 정보를 다 oreder 페이지로 넘기기 -->
                    <button @click="bagsToOrder" type="button" class="bag_cancel bag_border_none">구매하기</button>
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
import { onBeforeMount, computed, ref } from 'vue';
import { useStore } from 'vuex';

const store = useStore();
// 장바구니 초기 게시글 습득 관련
onBeforeMount(() => {
    store.dispatch('bagsGetProductData')
    .then(() => {
        store.state.bagsProductData.forEach(item => {
            // 초기 체크 상태 설정
            item.checked = false; 
        });
    });
})

// 수량 감소 버튼
const decInt = (item) => {
    item.ba_count--;
    
    // DB에 저장해서 새로고침해도 수정한 값을 저장
    store.dispatch('bagsCountMinus', item.ba_id);
};
// 수량 증가 버튼
const incInt = (item) => {
    item.ba_count++;

    // DB에 저장해서 새로고침해도 수정한 값을 저장
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
    // TODO
    // DB에 저장해서 새로고침 해도 직접 입력한 값을 저장
    else {
        // store.dispatch('bagsCountChange', item.ba_count);
    }
};

// 전체 선택/해제 기능
const allSelected = computed({
    // getter
    get() {
        return store.state.bagsProductData.length > 0 &&
                store.state.bagsProductData.every(item => {
                return item.checked;
            });
    },
    // setter
    set(value) {
        store.state.bagsProductData.forEach(item => {
            return item.checked = value;
        });
    }
});
// 전체 선택/해제 버튼 및 전체/선책 삭제 클릭 핸들러
const toggleSelectAll = () => {
    allSelected.value = !allSelected.value;
}

// 배송비 (TODO : 일정 금액 이상일 경우 무료 + 각 상품 마다 배송비 저장할 컬럼 만들기(products 테이블) )
const deliveryPrice = ref(0);

// 체크된 항목들만 필터링 > (선택된 상품의 총 합계와 수량을 리턴해줌)
const totalPrice = computed(() => {
    const chkTotalItems = store.state.bagsProductData.filter(item => item.checked);
    
    // console.log(chkTotalItems); // TODO : 삭제

    let count = chkTotalItems.length;
    let total = 0;

    chkTotalItems.forEach(item => {
        total += (item.price * item.ba_count);
    })

    return {count, total};
});

// 체크된 상품의 ba_id와 ba_count만 가져오기 > 삭제 처리
const bagsSelectDelete = () => {
    const chkSelectItems = store.state.bagsProductData.filter(item => item.checked);
    
    if (chkSelectItems.length <= 0 ){
        alert('삭제할 상품을 선택해주세요.');
    } else {
        if(confirm('확인을 누르면 선택된 데이터가 삭제 됩니다.')) {
            const data = new FormData();
            
            chkSelectItems.forEach(item => {
                data.append('ba_id[]', item.ba_id);
                data.append('ba_count[]', item.ba_count);
            });
    
            // 삭제 처리
            store.dispatch('bagsSelectDelete', data);
        } else {
            console.log('confirm false');
        }
    }


}

// 체크 상품이 있을 경우만 order 페이지로 넘어가기
// 넘길때 필요 정보 같이 넘기기
const bagsToOrder = () => {
    const chkOrderItems = store.state.bagsProductData.filter(item => item.checked);

    if (chkOrderItems.length <= 0) {
        alert('구매할 상품을 선택해주세요.')
    } else {
        const data = new FormData();

        chkOrderItems.forEach(item => {
            data.append('p_id[]', item.p_id);
            data.append('ba_id[]', item.ba_id);
            data.append('ba_count[]', item.ba_count);
        });
        
        console.log(data);

        store.dispatch('bagsToOrder', data);
    }

}






// // 전체 선택(전체 해제) 버튼
// //     +) 전체 삭제, 선택 삭제 버튼 설정도 같이 진행
// const checkAll = ref(false);

// const selectAll = () => {
//     checkAll.value = !checkAll.value;

//     store.state.bagsProductData.forEach(item => {
//         item.checked = checkAll.value;
//     });

// }

// // 체크가 모두 되었을때 전체 선택으로 인식
// const check = () => {
//     const flg = store.state.bagsProductData.every(item => {
//         return item.checked;
//     });
//     console.log(flg);
//     if(!flg) {
//         checkAll.value = true;
//     } else {
//         checkAll.value = false;
//     }
// }

</script>

<style scoped src="../css/bag.css">
</style>
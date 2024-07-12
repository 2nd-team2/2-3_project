<template>
    <main>
        <div class="header_top">
            <ul class="header_step">
                <h2>장바구니</h2>
                <li class="li_yellow">01 장바구니</li>
                <li>></li>
                <li>02 정보입력</li>
                <li>></li>
                <li>03 결제완료</li>
            </ul>
            <router-link to="/list?type=99&page=1" class="bag_cancel">
                계속 쇼핑하기
            </router-link>
        </div>

        <div> {{ $store.state.bagsProductData }}</div>
        
        <form id="bagsProductData">
            <div class="bag_box">
                <div v-if="$store.state.bagsProductData && $store.state.bagsProductData.length > 0">
                    <div v-for="(item, key) in $store.state.bagsProductData" :key="key" class="bag_goods_item bag_grid bag_padding_bottom">
                        <input type="hidden" name="buy_type" value="bags">
                        <input type="hidden" name="p_id" :value="item.p_id">
                        <div>
                            <input type="checkbox" :id="item.p_id" v-model="item.checked" name="ba_id[]" :value="item.ba_id" class="checkbox_input">
                            <label :for="item.p_id" class="checkbox"></label>
                        </div>
                        <img class="bag_goods_img" :src="item.img">    
                        <div class="reviewC_item_grid">
                            <div class="bag_goods_title bag_padding_bottom"> {{ item.name }}</div>
                            <div>배송비 : 착불</div>
                            <div class="bag_font">금액: {{ formatPrice(item.price) }}원</div>
                            <div class="bag_count">
                                <button type="button" @click="decInt(item)" :disabled="item.ba_count <= 1" class="bag_count_minus">-</button>
                                <input type="number" v-model="item.ba_count" name="ba_count[]" @change="validateCount(item)" class="quantity-input">
                                <button type="button" @click="incInt(item)" :disabled="item.ba_count >= item.count" class="bag_count_plus">+</button>
                            </div>    
                            <div>총 상품가격 : {{ formatPrice(item.price * item.ba_count) }}원</div>
                        </div>
                        <div @click="deleteAsk(item.ba_id)" class="bag_delete"></div>
                    </div>
                </div>
                <div v-else>
                    <h2 class="bag_none_item_center">
                        장바구니에 상품이 없습니다.
                    </h2>
                </div>

                <div class="bag_total_box" v-if="$store.state.bagsProductData && $store.state.bagsProductData.length > 0">
                    <div class="bag_margin_top bag_margin_bottom bag_total_border bag_total_grid">
                        <div class="bag_price_grid">
                            <div class="total_text_right"> 총 {{ formatPrice(totalPrice.count) }} 개의 상품금액</div>
                            <div class="bag_yellow bag_flex_end"> {{ formatPrice(totalPrice.total) }}원</div>
                        </div>
                        <img src="/img/plus.png" class="plus_icon">
                        <div class="bag_total_item1">
                            <div class="total_text_right">배송비</div>
                            <div class="bag_yellow bag_flex_end"> {{ formatPrice(deliveryPrice) }}원</div>
                        </div>
                        <img src="/img/equal.png" class="equal_icon">
                        <div class="bag_total_item2">
                            <div class="total_text_right">합계</div>
                            <div class="bag_yellow bag_flex_end"> {{ formatPrice(deliveryPrice + totalPrice.total) }}원</div>
                        </div>
                    </div>
                    <div class="btn_box">
                        <button @click="toggleSelectAll" type="button" class="btn_all bag_cancel bag_border_none bag_margin_right">
                            {{ allSelected ? '전체 해제' : '전체 선택' }}
                        </button>
                        <button @click="bagsSelectDelete" type="button" class="btn_delete bag_cancel bag_border_none bag_margin_right">
                            {{ allSelected ? '전체 삭제' : '선택 삭제' }}
                        </button>
                        <div class="bag_flex_end">
                            <button @click="bagsToOrder" type="button" class="bag_cancel bag_border_none">구매하기</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bag_hr"></div>
            <transition name="down">
                <div class="agree_box modal_second_overlay" v-show="showAskDeleteModal">
                    <div class="modal_second_window">
                        <div class="second_content">
                            <p class="second_content">확인을 누르면 장바구니에서 삭제됩니다.</p>
                            <br>
                            <div>
                                <button type="button" @click="confirmAskDelete" class="modal_btn">확인</button>
                                <button type="button" @click="closeAskDeleteModal" class="modal_btn">취소</button>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
            <transition name="down">
                <div class="agree_box modal_second_overlay" v-show="showSelectDeleteModal">
                    <div class="modal_second_window">
                        <div class="second_content">
                            <p class="second_content">확인을 누르면 선택된 상품이 삭제됩니다.</p>
                            <br>
                            <div>
                                <button type="button" @click="confirmSelectDelete" class="modal_btn">확인</button>
                                <button type="button" @click="closeSelectDeleteModal" class="modal_btn">취소</button>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
            <transition name="down">
                <div class="agree_box modal_second_overlay" v-show="showNoBagModal">
                    <div class="modal_second_window">
                        <div class="second_content">
                            <p class="second_content">삭제할 상품을 선택해주세요.</p>
                            <br>
                            <img @click="closeBagModal" src="/img/complete.png" class="complete_btn">
                        </div>
                    </div>
                </div>
            </transition>
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

const showAskDeleteModal = ref(false);
const showSelectDeleteModal = ref(false);
const showNoBagModal = ref(false);
let deleteItemId = ref(null);

function deleteAsk(item) {
    showAskDeleteModal.value = true;
    deleteItemId.value = item;
}

function confirmAskDelete() {
    store.dispatch('bagsDelete', deleteItemId.value);
    showAskDeleteModal.value = false;
}

function closeAskDeleteModal() {
    showAskDeleteModal.value = false;
}

function closeBagModal() {
    showNoBagModal.value = false;
}

function confirmSelectDelete() {
    const data = {
            ba_id: chkSelectItems.map(item => item.ba_id),
            ba_count: chkSelectItems.map(item => item.ba_count)
        };

    console.log('전송할 데이터:', data); // 데이터가 정상적으로 출력되는지 확인

    // 삭제 처리
    store.dispatch('bagsSelectDelete', data);
    showSelectDeleteModal.value = false;
}

function closeSelectDeleteModal() {
    showSelectDeleteModal.value = false;
}
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
    else {
        store.dispatch('bagsCountChange', item);
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

// 배송비 (3차 TODO : 일정 금액 이상일 경우 무료 + 각 상품 마다 배송비 저장할 컬럼 만들기(products 테이블) )
const deliveryPrice = ref(0);

// 체크된 항목들만 필터링 > (선택된 상품의 총 합계와 수량을 리턴해줌)
const totalPrice = computed(() => {
    const chkTotalItems = store.state.bagsProductData.filter(item => item.checked);
    
    let count = chkTotalItems.length;
    let total = 0;

    console.log(deliveryPrice);

    chkTotalItems.forEach(item => {
        total += (item.price * item.ba_count);
    })

    return {count, total};
});
 
// 체크된 상품의 ba_id와 ba_count만 가져오기 > 삭제 처리
const bagsSelectDelete = () => {
    const chkSelectItems = store.state.bagsProductData.filter(item => item.checked);
    
    if (chkSelectItems.length <= 0 ){
        showNoBagModal.value = true;
    } else {
        showSelectDeleteModal.value = true
    }
}

// const bagsSelectDelete = () => {
//     const chkSelectItems = store.state.bagsProductData.filter(item => item.checked);
    
//     if (chkSelectItems.length <= 0 ){
//         alert('삭제할 상품을 선택해주세요.');
//     } else {
//         if(confirm('확인을 누르면 선택된 데이터가 삭제 됩니다.')) {
//             const data = {
//                 ba_id: chkSelectItems.map(item => item.ba_id),
//                 ba_count: chkSelectItems.map(item => item.ba_count)
//             }
//             // const data = new FormData();

//             // chkSelectItems.forEach(item => {
//             //     data.append('ba_id[]', item.ba_id);
//             //     data.append('ba_count[]', item.ba_count); // TODO : 경량화할때 확인 해보고 삭제하기
//             // });

//             console.log(data);
     
//             // 삭제 처리
//             store.dispatch('bagsSelectDelete', data);
//         }
//     }
// }

// 체크 상품이 있을 경우만 order 페이지로 넘어가기
const bagsToOrder = () => {
    const chkOrderItems = store.state.bagsProductData.filter(item => item.checked);

    if (chkOrderItems.length <= 0) {
        alert('구매할 상품을 선택해주세요.');
    } else {

        // 로컬에 저장하고 싶은 데이터 가공 처리
        const orderItems = chkOrderItems.map(item => ({
            p_id: item.p_id
            ,ba_id: item.ba_id
            ,ba_count: item.ba_count
            ,price: item.price
            ,buy_type: "bags"
            ,products_name: item.name
        }));
        console.log(orderItems);


        store.dispatch('bagsToOrder', orderItems);
    }
}

// 금액 천단위 포맷 (,000)
function formatPrice(price) {
        return price.toLocaleString('ko-KR');
    }




// // 폼데이터를 로컬에 저장하기 위해 데이터 변환 헬퍼함수 만들기
// const formDataToObject = (formData) => {
//     const obj = {};
//     formData.forEach((value, key) => {
//         // 동일한 키에 대한 여러 값을 처리 (즉, 배열)
//         if (obj[key]) {
//             if (!Array.isArray(obj[key])) {
//                 obj[key] = [obj[key]];
//             }
//             obj[key].push(value);
//         } else {
//             obj[key] = value;
//         }
//     });
//     return obj;
// }
// // 넘길때 필요 정보 같이 넘기기
// const bagsToOrder = () => {
//     const chkOrderItems = store.state.bagsProductData.filter(item => item.checked);

//     if (chkOrderItems.length <= 0) {
//         alert('구매할 상품을 선택해주세요.')
//     } else {

//         const data = new FormData();

//         chkOrderItems.forEach(item => {
//             data.append('p_id[]', item.p_id);
//             data.append('ba_id[]', item.ba_id); 
//             data.append('ba_count[]', item.ba_count);
//         });     

//         // FormData를 일반 객체롤 변환
//         const bagsToOrder = formDataToObject(data);

//         store.dispatch('bagsToOrder', bagsToOrder);
//     }

// }






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
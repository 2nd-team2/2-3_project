<template>
    <main>
        <form id="orderComplete" @submit.prevent="validateForm">
            <div></div>
            <div class="header">
                <div class="header_top">
                    <ul class="header_step">
                        <h2>구매자정보</h2>
                        <li>01 장바구니</li>
                        <li>></li>
                        <li class="li_yellow">02 정보입력</li>
                        <li>></li>
                        <li>03 결제완료</li>
                    </ul>
                    <div class="header_btn_box">
                        <button type="button" @click="$router.push('/list?type=99&page=1')" class="header_btn header_btn_margin">계속 쇼핑하기</button>
                        <button type="button" @click="$router.push('/bag')" class="header_btn">장바구니 보기</button>
                    </div>
                </div>
                <div class="header_bottom">
                    <div class="header_bottom_text">
                        <span>이름</span>
                    </div>
                    <div class="header_bottom_input">
                        <p class="info_item_err_msg">{{ buyNameError }}</p>
                        <input type="text" name="or_buy_name" id="or_buy_name" @input="buyChkName" v-model="buyName">
                    </div>
                    <div class="header_bottom_text">
                        <span>휴대폰번호</span>
                    </div>
                    <div class="header_bottom_input">
                        <p class="info_item_err_msg">{{ buyTelError }}</p>
                        <input type="text" name="or_buy_tel" id="or_buy_tel" @input="buyChkTel" v-model="buyTel">
                    </div>
                </div>
            </div>

            <div class="main">
                <div class="main_top">
                    <h2>받는 사람정보</h2>
                </div>
                <div class="main_bottom">
                    <div class="main_bottom_name">이름</div>
                    <p class="info_item_err_msg1">{{ getNameError }}</p>
                    <input type="text" name="or_get_name" id="or_get_name" @input="getChkName" v-model="getName" class="main_bottom_input1">
                    <div class="main_bottom_tell">휴대폰번호</div>
                    <p class="info_item_err_msg2 ">{{ getTelError }}</p>
                    <input type="text" name="or_get_tel" id="or_get_tel" @input="getChkTel" v-model="getTel" class="main_bottom_input2">
                    <label class="main_bottom_adds" for="address">주소</label>
                    <p class="info_item_err_msg3">{{ addressError }}</p>
                    <input type="text"  name="or_get_addr" id="address" @input="chkAddress" readonly @click="kakaoPostcode" class="main_bottom_input3" v-model="address" >
                    <input type="text" readonly v-model="postcode" class="main_bottom_input4" name="or_get_post">
                    <label class="main_bottom_de_adds" for="address">상세주소</label>
                    <input type="text" class="main_bottom_input5" name="or_get_det_addr" id="address_detail" v-model="detailAddress" >
                    <button type="button" class="main_bottom_btn" @click="kakaoPostcode" id="postcode">주소검색</button>
                </div>

                <input type="hidden" name ="or_sum" value="1">
                <div class="bag_margin_top bag_margin_bottom bag_total_border bag_total_grid">
                    <div></div>
                    <div class="bag_price_grid">
                        <div class="total_text_right"> 총 {{ totalPrice.count }} 개의 상품금액</div>
                        <div class="bag_yellow bag_flex_end"> {{ totalPrice.total }}원</div>
                    </div>
                    <img src="/img/plus.png">
                    <div>
                        <div class="total_text_right">배송비</div>
                        <div class="bag_yellow bag_flex_end"> {{ deliveryPrice }}원</div>
                    </div>
                    <img src="/img/equal.png">
                    <div>
                        <div class="total_text_right">합계</div>
                        <div class="bag_yellow bag_flex_end"> {{ totalPrice.total + deliveryPrice }}원</div>
                    </div>
                </div>

                <input type="hidden" name="or_sum" :value="totalPrice.total + deliveryPrice">
                <input type="hidden" name="orp_id" :value="$store.state.orderProductData.p_id">  
                <input type="hidden" name="orp_count" :value="$store.state.orderProductData.ba_count">
                <div class="btn_com_box">
                    <button type="button" @click="$store.dispatch('orderComplete', $store.state.orderProductData)" class="btn_ord_com">결제하기</button>
                </div>
            </div>
        </form>
    </main>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useStore } from 'vuex';

const store = useStore();


// 배송비 (TODO : 일정 금액 이상일 경우 무료 + 각 상품 마다 배송비 저장할 컬럼 만들기(products 테이블) )
const deliveryPrice = ref(0);
// 체크된 항목들만 필터링 > (선택된 상품의 총 합계와 수량을 리턴해줌)
const totalPrice = computed(() => {
    const Items = store.state.orderProductData;

    let count = Items.length;
    let total = 0;
    
    // 데이터가 있을 경우
    if (count > 0) {
        // 1개 보다 많은 경우
        if (count > 1) {
            Items.forEach(item => {
                total += (item.price * item.ba_count);
            });
        } 
        // 1개인 경우
        else {
            total += (Items[0].price * Items[0].ba_count);
        }
    }
    return {count, total};
});




// 실시간 유효성 체크
const buyName = ref(store.state.userInfo.name);
const buyTel = ref(store.state.userInfo.tel);
const getName = ref(store.state.userInfo.name);
const getTel = ref(store.state.userInfo.tel);
const address = ref(store.state.userInfo.addr);
const detailAddress = ref(store.state.userInfo.det_addr);
const postcode = ref(store.state.userInfo.post);

const buyNameError = ref('');
const buyTelError = ref('');
const getNameError = ref('');
const getTelError = ref('');
const addressError = ref('');


function buyChkName(e) {
  const namePattern = /^[가-힣a-zA-Z\s]+$/;
  
  if (!namePattern.test(e.target.value)) {
    buyNameError.value = '이름은 영어 대소문자와 한글로만 사용 가능합니다.';
  } else {
    buyNameError.value = '';
  }
}
function buyChkTel(e) {
  const telPattern = /^\d{10,11}$/;
  if (!telPattern.test(e.target.value)) {
    buyTelError.value = '전화번호는 숫자 10,11자로 설정 해주세요.';
  } else {
    buyTelError.value = '';
  }
}

function getChkName(eve) {
  const namePattern = /^[가-힣a-zA-Z\s]+$/;
  
  if (!namePattern.test(e.target.value)) {
    getNameError.value = '이름은 영어 대소문자와 한글로만 사용 가능합니다.';
  } else {
    getNameError.value = '';
  }
}
function getChkTel(e) {
  const telPattern = /^\d{10,11}$/;
  if (!telPattern.test(e.target.value)) {
    getTelError.value = '전화번호는 숫자 10,11자로 설정 해주세요.';
  } else {
    getTelError.value = '';
  }
}
function chkAddress(e) {
  if (e.target.value === '') {
    addressError.value = '주소 형식이 맞지 않습니다.';
  } else {
    addressError.value = '';
  }
}


function validateForm() {
  let valid = true;

  chkName({ target: { value: name.value } });
  if (nameError.value) valid = false;

  chktel({ target: { value: tel.value } });
  if (telError.value) valid = false;

  chkAddress({ target: { value: address.value } });
  if (addressError.value) valid = false;

}

// 카카오 주소 API
function kakaoPostcode() {
    new daum.Postcode({
        oncomplete: function(data) {
            // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

            // 각 주소의 노출 규칙에 따라 주소를 조합한다.
            // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
            var addr = ''; // 주소 변수
            var extraAddr = ''; // 참고항목 변수

            //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
            if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                addr = data.roadAddress;
            } else { // 사용자가 지번 주소를 선택했을 경우(J)
                addr = data.jibunAddress;
            }

            // 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
            if(data.userSelectedType === 'R'){
                // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                    extraAddr += data.bname;
                }
                // 건물명이 있고, 공동주택일 경우 추가한다.
                if(data.buildingName !== '' && data.apartment === 'Y'){
                    extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                }
                // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                if(extraAddr !== ''){
                    extraAddr = ' (' + extraAddr + ')';
                }
                // 조합된 참고항목을 해당 필드에 넣는다.
                // document.getElementById("sample6_extraAddress").value = extraAddr;
            
            } else {
                // document.getElementById("sample6_extraAddress").value = '';
            }

            // 우편번호와 주소 정보를 해당 필드에 넣는다.
            postcode.value = data.zonecode;
            // 주소 필드에 삽입
            address.value = addr;
            // 커서를 상세주소 필드로 이동한다.
            document.querySelector('#address_detail').focus();
        }
    }).open();
}


</script>

<style scoped src="../css/order.css">
</style>
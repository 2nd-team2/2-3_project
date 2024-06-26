<template>
    <main>
        <form id="exchage" @submit.prevent="validateForm">
            <div>
                <h2 class="ex_title">
                    교환 및 반품 신청
                </h2>
                <div class="ex_goods_item ex_grid">
                    <div class="ex_order_at"> {{ $store.state.exchangeProduct.orpCre }} 주문 / 구매확정 <span class="ex_yellow"> {{ $store.state.exchangeProduct.comCre }}</span></div>
                    <div class="ex_goods_grid">
                        <img class="ex_goods_img" :src="$store.state.exchangeProduct.img">
                        <div>
                            <div class="ex_goods_title ex_padding_bottom">{{ $store.state.exchangeProduct.name + ' ' +$store.state.exchangeProduct.ml + 'ml' }}</div>
                            <div class="ex_padding_bottom">
                                <div class="ex_font">금액: {{ $store.state.exchangeProduct.price }}원 / {{ $store.state.exchangeProduct.orpCount }}개</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <div>
                    <h2 class="ex_title">
                        교환 및 반품 사유
                    </h2>
                    <div class="ex_padding_bottom">어떤문제가 있나요?</div>
                </div>
                <div class="ex_padding_bottom ex_padding_left">
                    <!-- <div class="ex_content">단순변심</div>
                    <hr> -->
                    <input type="radio" name="ex_reason" id="ex_reason1" value="0">
                    <label for="ex_reason1" class="checkbox"> 상품이 마음에 들지 않음</label>
                    <br>
                    <input type="radio" name="ex_reason" id="ex_reason2" value="1">
                    <label for="ex_reason2" class="checkbox"> 다른 상품이 배송됨</label>
                    <br>
                    <input type="radio" name="ex_reason" id="ex_reason3" value="2">
                    <label for="ex_reason3" class="checkbox"> 상품의 구성품 / 부속품이 들어있지 않음</label>
                    <br>
                    <input type="radio" name="ex_reason" id="ex_reason4" value="3">
                    <label for="ex_reason4" class="checkbox"> 상품이 파손/결함 되어 배송됨</label>
                </div>
            </div>

            <div>
                <h2 class="ex_title ex_padding_top">
                    회수 정보
                </h2>
                <div class="main_bottom">
                    <div class="main_bottom_name">이름</div>
                    <p class="info_item_err_msg1">{{ nameError }}</p>
                    <input type="text" name="or_get_name" id="or_get_name" @input="chkName" v-model="name" class="main_bottom_input1">
                    <div class="main_bottom_tell">휴대폰번호</div>
                    <p class="info_item_err_msg2 ">{{ telError }}</p>
                    <input type="text" name="or_get_tel" id="or_get_tel" @input="chkTel" v-model="tel" class="main_bottom_input2">
                    <label class="main_bottom_adds" for="address">주소</label>
                    <p class="info_item_err_msg3">{{ addressError }}</p>
                    <input type="text"  name="ex_addr" id="address" @input="chkAddress" readonly @click="kakaoPostcode" class="main_bottom_input3" v-model="address" >
                    <input type="text" readonly v-model="postcode" class="main_bottom_input4" name="ex_post">
                    <label class="main_bottom_de_adds" for="address">상세주소</label>
                    <input type="text" class="main_bottom_input5" name="ex_det_addr" id="address_detail" v-model="detailAddress" >
                    <button type="button" class="main_bottom_btn" @click="kakaoPostcode" id="postcode">주소검색</button>
                </div>
            </div>

            <hr>

            <div class="ex_margin_top ex_margin_bottom ex_total_border ex_total_grid">
                <div></div>
                <div>
                    <div> 총 상품금액</div>
                    <div class="ex_yellow ex_flex_end"> {{ $store.state.exchangeProduct.price * $store.state.exchangeProduct.orpCount }}원</div>
                </div>
                <img src="/img/plus.png">
                <div>
                    <div>배송비</div>
                    <div class="ex_yellow ex_flex_end"> {{ deliveryPrice }}원</div>
                </div>
                <img src="/img/equal.png">
                <div>
                    <div>합계</div>
                    <div class="ex_yellow ex_flex_end"> {{ $store.state.exchangeProduct.price * $store.state.exchangeProduct.orpCount + deliveryPrice }}원</div>
                </div>
            </div>
            <input type="hidden" name="orp_id" :value="$store.state.exchangeProduct.orp_id">
            <input type="hidden" name="ex_flg" :value="$store.state.exchangeProduct.ex_flg">
            <input type="hidden" name="created_at" :value="$store.state.exchangeProduct.exCre">
            <div class="ex_margin_top ex_flex_end">
                <div>
                    <button @click="$router.push('/info')" type="button" class="ex_cancel ex_border_none ex_cancel_padding">취소</button>
                    <button @click="$store.dispatch('exchage')" type="button" class="ex_cancel ex_border_none">신청</button>
                </div>
            </div>
        </form>
    </main>

</template>

<script setup>
import { ref } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

// 배송비 (TODO : 일정 금액 이상일 경우 무료 + 각 상품 마다 배송비 저장할 컬럼 만들기(products 테이블) )
const deliveryPrice = ref(0);


// 실시간 유효성 체크
const name = ref(store.state.userInfo.name);
const tel = ref(store.state.userInfo.tel);
const address = ref(store.state.userInfo.addr);
const detailAddress = ref(store.state.userInfo.det_addr);
const postcode = ref(store.state.userInfo.post);

const nameError = ref('');
const telError = ref('');
const addressError = ref('');


function chkName(e) {
  const namePattern = /^[가-힣a-zA-Z\s]+$/;
  
  if (!namePattern.test(e.target.value)) {
    nameError.value = '이름은 영어 대소문자와 한글로만 사용 가능합니다.';
  } else {
    nameError.value = '';
  }
}
function chkTel(e) {
  const telPattern = /^\d{10,11}$/;
  if (!telPattern.test(e.target.value)) {
    telError.value = '전화번호는 숫자 10,11자로 설정 해주세요.';
  } else {
    telError.value = '';
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
<style scoped src="../css/exchange.css">
</style>
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
                    <p class="info_item_err_msg_name">{{ buyNameError }}</p>
                    <div class="header_bottom_name">이름</div>
                    <input type="text" name="or_buy_name" id="or_buy_name" @input="buyChkName" v-model="orderCompleteData.or_buy_name" class="header_bottom_name_input">
                    <p class="info_item_err_msg_tel">{{ buyTelError }}</p>
                    <div class="header_bottom_tel">휴대폰번호</div>
                    <input type="text" name="or_buy_tel" id="or_buy_tel" @input="buyChkTel" v-model="orderCompleteData.or_buy_tel" class="header_bottom_tel_input">
                </div>
            </div>

            <div class="main">
                <div class="main_top">
                    <h2>받는 사람정보</h2>
                </div>
                <div class="main_bottom">
                    <div class="main_bottom_name">이름</div>
                    <p class="info_item_err_msg1">{{ getNameError }}</p>
                    <input type="text" name="or_get_name" id="or_get_name" @input="getChkName" v-model="orderCompleteData.or_get_name" class="main_bottom_input1">
                    <div class="main_bottom_tell">휴대폰번호</div>
                    <p class="info_item_err_msg2 ">{{ getTelError }}</p>
                    <input type="text" name="or_get_tel" id="or_get_tel" @input="getChkTel" v-model="orderCompleteData.or_get_tel" class="main_bottom_input2">
                    <label class="main_bottom_adds" for="address">주소</label>
                    <p class="info_item_err_msg3">{{ addressError }}</p>
                    <input type="text" name="or_get_addr" id="address" @input="chkAddress" readonly @click="kakaoPostcode" class="main_bottom_input3" v-model="orderCompleteData.or_get_addr">
                    <input type="text" readonly v-model="orderCompleteData.or_get_post" class="main_bottom_input4" name="or_get_post">
                    <label class="main_bottom_de_adds" for="address">상세주소</label>
                    <input type="text" class="main_bottom_input5" name="or_get_det_addr" id="address_detail" v-model="orderCompleteData.or_get_det_addr">
                    <button type="button" class="main_bottom_btn" @click="kakaoPostcode" id="postcode">주소검색</button>
                </div>
                <input type="hidden" name ="or_sum" value="1">
                <div class="bag_margin_top bag_margin_bottom bag_total_border bag_total_grid">
                    <div></div>
                    <div class="bag_price_grid">
                        <div class="total_text_right"> 총 {{ totalPrice.count }} 개의 상품금액</div>
                        <div class="bag_yellow bag_flex_end"> {{ formatPrice(totalPrice.total) }}원</div>
                    </div>
                    <img src="/img/plus.png">
                    <div>
                        <div class="total_text_right">배송비</div>
                        <div class="bag_yellow bag_flex_end"> {{ formatPrice(deliveryPrice) }}원</div>
                    </div>
                    <img src="/img/equal.png">
                    <div>
                        <div class="total_text_right">합계</div>
                        <div class="bag_yellow bag_flex_end"> {{ formatPrice(totalPrice.total + deliveryPrice) }}원</div>
                    </div>
                </div>
                <input type="hidden" name="or_sum" v-model="or_sum">
                <input type="hidden" name="orp_id" :value="$store.state.orderProductData.p_id">  
                <input type="hidden" name="orp_count" :value="$store.state.orderProductData.ba_count">
                <div class="btn_com_box">
                    <button type="button"  @click="BeforekakaoPay" class="btn_ord_com">결제하기</button>
                </div>
            </div>
            <transition name="down">
                <div class="agree_box modal_second_overlay" v-show="showModal">
                    <div class="modal_second_window">
                        <div class="second_content">
                            <p>구매 하시겠습니까?</p>
                            <br>
                            <button type="button" @click="confirm" class="modal_btn">확인</button>
                            <button type="button" @click="closeModal" class="modal_btn">취소</button>
                        </div>
                    </div>
                </div>
            </transition>
            <transition name="down">
                <div class="agree_box modal_second_overlay" v-show="showFailModal">
                    <div class="modal_second_window">
                        <div class="second_content">
                            <p>결제를 취소하였습니다.</p>
                            <br>
                            <img @click="closeFailModal" src="/img/complete.png" class="complete_btn">
                        </div>
                    </div>
                </div>
            </transition>
        </form>
    </main>
</template>

<script setup>
import { ref, computed, reactive } from 'vue';
import { useStore } from 'vuex';

const store = useStore();
const showModal = ref(false);
const showFailModal = ref(false);


// axios 처리할 데이터 가공
const orderCompleteData = reactive({
    or_buy_name: store.state.userInfo.name,
    or_buy_tel: store.state.userInfo.tel,
    or_get_name: store.state.userInfo.name,
    or_get_tel: store.state.userInfo.tel,
    or_get_addr: store.state.userInfo.addr,
    or_get_post: store.state.userInfo.post,
    or_get_det_addr: store.state.userInfo.det_addr,
    or_sum: computed(() => totalPrice.value.total + deliveryPrice.value)
});

// ------------------------------------------------
// 구매자 정보
const price = store.state.orderProductData.price;
let productName;

if(!Array.isArray(store.state.orderProductData) && store.state.orderProductData !== null && typeof store.state.orderProductData === 'object') {
    productName = store.state.orderProductData.products_name
} else {
    productName =  store.state.orderProductData.length >1 ? store.state.orderProductData[0].products_name + ' 외 ' + (store.state.orderProductData.length - 1) + '개' : store.state.orderProductData[0].products_name
}

function BeforekakaoPay() {
    showModal.value = true;
}

function confirm() {
    const email = store.state.userInfo.email;
    const username = store.state.userInfo.name;
    const tel = store.state.userInfo.tel;
    const addr = store.state.userInfo.addr
    kakaoPay(email, addr, username, tel);
    showModal.value = false;
} 

function closeModal() {
    showModal.value = false;
}

function closeFailModal() {
    showFailModal.value = false;
}

var IMP = window.IMP;

var today = new Date();
var hours = today.getHours(); // 시
var minutes = today.getMinutes();  // 분
var seconds = today.getSeconds();  // 초
var milliseconds = today.getMilliseconds();
var makeMerchantUid = `${hours}` + `${minutes}` + `${seconds}` + `${milliseconds}`;

function kakaoPay(email, addr, username, tel) {
    if (localStorage.getItem("userInfo")) { // 로그인한 상태에서 결제 가능

        IMP.init("imp74725603"); // 고객사 식별코드
        IMP.request_pay({
            pg: 'html5_inicis.INIpayTest', // PG사 코드표에서 선택
            pay_method: 'card', // 결제 방식
            merchant_uid: "IMP" + makeMerchantUid, // 결제 고유 번호
            name: productName, // 제품명
            amount: 100,
            // amount: price, // 실제가격
            //구매자 정보 ↓
            buyer_name: `${orderCompleteData.or_get_name}`,
            buyer_tel : `${orderCompleteData.or_get_tel}`,
            buyer_email : `${email}`,
            buyer_addr : `${orderCompleteData.or_get_addr}`
        }, async function (rsp) { // callback
            if (rsp.success) { //결제 성공시
                store.dispatch('orderComplete', orderCompleteData);
                console.log(rsp);
                //결제 성공시 프로젝트 DB저장 요청

                if (response.status == 200) { // DB저장 성공시
                    // alert('결제 완료!')
                    // store.dispatch('orderComplete', orderCompleteData);
                } else { // 결제완료 후 DB저장 실패시
                    alert(`error:[${response.status}]\n결제요청이 승인된 경우 관리자에게 문의바랍니다.`);
                    // DB저장 실패시 status에 따라 추가적인 작업 가능성
                }
            } else if (rsp.success == false) { // 결제 실패시
                showFailModal.value = true;
            }
        });
    }
    else { // 비회원 결제 불가
        alert('로그인이 필요합니다!')
    }
}
// ------------------------------------------------

// 배송비 (TODO : 일정 금액 이상일 경우 무료 + 각 상품 마다 배송비 저장할 컬럼 만들기(products 테이블) )
const deliveryPrice = ref(0);

// 체크된 항목들만 필터링 > (선택된 상품의 총 합계와 수량을 리턴해줌)
const totalPrice = computed(() => {
    let Items = store.state.orderProductData;
    // 배열이 아니면 배열로 바꾸기
    if (!Array.isArray(Items) && Items !== null && typeof Items === 'object') {
        Items = [Items];
    }

    let count = 0;
    let total = 0;

    // 객체, 배열 판단
    // if (Array.isArray(Items)) {
        // 장바구니페이지(구매하기) -> 주문페이지 : 배열로 넘어옴
        count = Items.length;

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
    // } 
    // // 상세페이지(바로구매) -> 주문페이지 : 객체로 넘어옴
    // else if (Items && typeof Items === 'object') {
        
    //     count = 1;
    //     total += (Items.price * Items.ba_count);
    // }

    return {count, total};
});

// 결제하기 재확인 안내
// const orderComplete = (orderCompleteData) => {
//     if (confirm('확인을 누르면 결제가 진행됩니다.')) {
//         store.dispatch('orderComplete', orderCompleteData);
//     }
// }


// 실시간 유효성 체크
// const buyName = ref(store.state.userInfo.name);
// const buyTel = ref(store.state.userInfo.tel);
// const getName = ref(store.state.userInfo.name);
// const getTel = ref(store.state.userInfo.tel);
// const address = ref(store.state.userInfo.addr);
// const detailAddress = ref(store.state.userInfo.det_addr);
// const postcode = ref(store.state.userInfo.post);

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

function getChkName(e) {
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
            // postcode.value = data.zonecode;
            orderCompleteData.or_get_post = data.zonecode;
            // 주소 필드에 삽입
            // address.value = addr;
            orderCompleteData.or_get_addr = addr;
            // 커서를 상세주소 필드로 이동한다.
            document.querySelector('#address_detail').focus();
        }
    }).open();
}

// 금액 천단위 포맷 (,000)
function formatPrice(price) {
        return price.toLocaleString('ko-KR');
}

</script>

<style scoped src="../css/order.css">
</style>
<template>
    <div class="admin">
        <form id="adminProductCreateForm"  @submit.prevent="validateForm">
            <h2 class="admin_title">상품 추가</h2>
            <div class="admin_input_box">
                <label for="name" class="admin_prodcut_info0">상품 이름</label>
                <p class="admin_error">{{ nameError }}</p>
                <input @input="chkName" v-model="name" type="text" name="name" id="name" autocomplete='off' class="admin_prodcut_info1">
                <label for="price" class="admin_prodcut_info2">상품 가격</label>
                <p class="admin_error">{{ PriceError }}</p>
                <input @input="chkPrice" v-model="price" type="number" name="price" id="price" autocomplete='off' class="admin_prodcut_info3">
                <label for="count" class="admin_prodcut_info4">재고량</label>
                <p class="admin_error">{{ CountError }}</p>
                <input @input="chkCount" v-model="count" type="number" name="count" id="count" autocomplete='off' class="admin_prodcut_info5">
                <label for="ml" class="admin_prodcut_info6">용량</label>
                <p class="admin_error">{{ MlError }}</p>
                <input @input="chkMl" v-model="ml" type="number" name="ml" id="ml" autocomplete='off' placeholder="단위는 ml" class="admin_prodcut_info7">
                <label for="img" class="admin_prodcut_info8">상품 이미지</label>
                <input type="file" name="img" accept="image/*" id="img" autocomplete='off' class="admin_prodcut_info9">
                <label for="info" class="admin_prodcut_info10">상품 상세 정보</label>
                <input type="file" name="info" accept="image/*" id="info" autocomplete='off' class="admin_prodcut_info11">
                <div class="admin_type_container">
                    <p>주종</p>
                    <div class="admin_type_box">
                        <input type="radio" name="type" id="type0" value="0">
                        <label for="type0">탁주</label>
                    </div>
                    <div class="admin_type_box">
                        <input type="radio" name="type" id="type1" value="1">
                        <label for="type1">과실주</label>
                    </div>
                    <div class="admin_type_box">
                        <input type="radio" name="type" id="type2" value="2">
                        <label for="type2">증류주</label>
                    </div>
                </div>
                <div class="admin_season_container">
                    <P>추천 계절</P>
                    <div class="admin_season_box">
                        <input type="radio" name="season" id="season0" value="0">
                        <label for="season0">봄</label>
                    </div>
                    <div class="admin_season_box">
                        <input type="radio" name="season" id="season1" value="1">
                        <label for="season1">여름</label>
                    </div>
                    <div class="admin_season_box">
                        <input type="radio" name="season" id="season2" value="2">
                        <label for="season2">가을</label>
                    </div>
                    <div class="admin_season_box">
                        <input type="radio" name="season" id="season3" value="3">
                        <label for="season3">겨울</label>
                    </div>
                </div>
            </div>
            <div class="admin_hr"></div>
            <div class="admin_btn_box">
                <button type="button" @click="$router.back()" class="admin_btn">취소하기</button>
                <button type="submit" class="admin_btn">추가하기</button>
            </div>
        </form>
    </div>
</template>

<script setup>
    import { ref } from 'vue';
    import { useStore } from 'vuex';

    const store = useStore();

    // 실시간 유효성 체크
    const name = ref('');
    const price = ref('');
    const count = ref('');
    const ml = ref('');

    const nameError = ref('');
    const PriceError = ref('');
    const CountError = ref('');
    const MlError = ref('');

    function chkName() {
        const namePattern = /^[가-힣0-9%()\s]+$/;
        if (!namePattern.test(name.value) || name.value.length > 20) {
            nameError.value = '상품이름은 한글과 숫자로 공백 포함 20자 이내로 설정해주세요. (사용 가능한 특수문자 : %, ())';
        } else {
            nameError.value = '';
        }
    }

    function chkPrice() {
        const numberPattern = /^[0-9]+$/;
        if (!numberPattern.test(price.value) || price.value.length > 20) {
            PriceError.value = '20자 이내의 숫자만 입력가능합니다.';
        } else {
            PriceError.value = '';
        }
    }

    function chkCount() {
        const numberPattern = /^[0-9]+$/;
        if (!numberPattern.test(count.value) || count.value.length > 20) {
            CountError.value = '20자 이내의 숫자만 입력가능합니다.';
        } else {
            CountError.value = '';
        }
    }

    function chkMl() {
        const numberPattern = /^[0-9]+$/;
        if (!numberPattern.test(ml.value) || ml.value.length > 20) {
            MlError.value = '20자 이내의 숫자만 입력가능합니다.';
        } else {
            MlError.value = '';
        }
    }
    

    function validateForm() {
        let valid = true;
        chkName();
        if (nameError.value) valid = false;

        chkPrice();
        if (PriceError.value) valid = false;

        chkCount();
        if (CountError.value) valid = false;

        chkMl();
        if (MlError.value) valid = false;

        if (valid) {
        store.dispatch('adminProductCreate');
        } else {
        alert('상품 등록에 실패했습니다.');
        }
    }

    

</script>

<style>

</style>
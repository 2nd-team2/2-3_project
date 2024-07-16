<template>
    <div class="admin">
        <form id="adminProducUpdateForm" @submit.prevent="validateForm">
            <h2 class="admin_title">상품 수정</h2>
            <div class="admin_input_box">
                <input type="hidden" name="id" :value="$store.state.adminProductToUpdate.id">
                <label for="name" class="admin_prodcut_info0">상품 이름</label>
                <p class="admin_error">{{ nameError }}</p>
                <input @input="chkName" v-model="name" type="text" name="name" id="name" autocomplete='off'>
                <label for="price" class="admin_prodcut_info2">상품 가격</label>
                <p class="admin_error">{{ PriceError }}</p>
                <input @input="chkPrice" v-model="price" type="number" name="price" id="price" autocomplete='off'>
                <label for="count" class="admin_prodcut_info4">재고량</label>
                <p class="admin_error">{{ CountError }}</p>
                <input @input="chkCount" v-model="count" type="number" name="count" id="count" autocomplete='off'>
                <label for="ml" class="admin_prodcut_info6">용량</label>
                <p class="admin_error">{{ MlError }}</p>
                <input @input="chkMl" v-model="ml" type="number" name="ml" id="ml" autocomplete='off' placeholder="단위는 ml">
                <label for="img" class="admin_prodcut_info8">상품 이미지</label>
                <div class="admin_input_img_box">
                    <img :src="previewImg" class="admin_preview">
                    <input type="file" name="img" accept="image/*" id="img" autocomplete='off' @change="setFileImg">
                </div>
                <label for="info" class="admin_prodcut_info10">상품 상세 정보</label>
                <div class="admin_input_img_box">
                    <img :src="previewInfo" class="admin_preview">
                    <input type="file" name="info" accept="image/*" id="info" autocomplete='off' @change="setFileInfo">
                </div>
                <div class="admin_type_container">
                    <p class="admin_product_p">주종</p>
                    <div class="admin_type_box">
                        <input type="radio" name="type" id="type0" value="0" v-model="radioType">
                        <label for="type0">탁주</label>
                    </div>
                    <div class="admin_type_box">
                        <input type="radio" name="type" id="type1" value="1" v-model="radioType">
                        <label for="type1">과실주</label>
                    </div>
                    <div class="admin_type_box">
                        <input type="radio" name="type" id="type2" value="2" v-model="radioType">
                        <label for="type2">증류주</label>
                    </div>
                    <div class="admin_type_box">
                        <input type="radio" name="type" id="type2" value="3" v-model="radioType">
                        <label for="type2">약주, 청주</label>
                    </div>
                </div>
                <div class="admin_season_container">
                    <P class="admin_product_p">추천 계절</P>
                    <div class="admin_season_box">
                        <input type="radio" name="season" id="season0" value="0" v-model="radioSeason">
                        <label for="season0">봄</label>
                    </div>
                    <div class="admin_season_box">
                        <input type="radio" name="season" id="season1" value="1" v-model="radioSeason">
                        <label for="season1">여름</label>
                    </div>
                    <div class="admin_season_box">
                        <input type="radio" name="season" id="season2" value="2" v-model="radioSeason">
                        <label for="season2">가을</label>
                    </div>
                    <div class="admin_season_box">
                        <input type="radio" name="season" id="season3" value="3" v-model="radioSeason">
                        <label for="season3">겨울</label>
                    </div>
                </div>
            </div>
            <div class="admin_hr"></div>
            <div class="admin_btn_box">
                <button type="button" @click="$router.back()" class="admin_btn">취소하기</button>
                <button type="button" @click="$store.dispatch('productUpdateSubmit')" class="admin_btn">수정하기</button>
            </div>
        </form>
    </div>
</template>

<script setup>
    import { onBeforeMount, onBeforeUnmount } from 'vue'; 
    import { ref } from 'vue';
    import { useStore } from 'vuex';

    const store = useStore();

    // 실시간 유효성 체크
    const name = ref(store.state.adminProductToUpdate.name);
    const price = ref(store.state.adminProductToUpdate.price);
    const count = ref(store.state.adminProductToUpdate.count);
    const ml = ref(store.state.adminProductToUpdate.ml);

    const nameError = ref('');
    const PriceError = ref('');
    const CountError = ref('');
    const MlError = ref('');

    function chkName() {
        const namePattern = /^[0-9가-힣a-zA-Z\s.,:?!@#$%^&*]+$/;
        if (!namePattern.test(name.value) || name.value.length > 20) {
            nameError.value = '상품이름은 한글, 영어, 숫자, 특수문자(.,:?!@#$%^&*), 공백 포함 20자 이내로 설정가능합니다.';
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
        store.dispatch('productUpdateSubmit');
        } else {
        alert('상품 수정에 실패했습니다.');
        }
    }

    // 라디오 value
    const radioType = ref('');
    const radioSeason = ref('');
    onBeforeMount(() => {
        // console.log('onBeforeUnmount' + store.state.adminProductToUpdate.type);
        // 라디오
        if(store.state.adminProductToUpdate.type === '증류주') {
            radioType.value = '2'
        } else if(store.state.adminProductToUpdate.type === '과실주') {
            radioType.value = '1'
        } else if(store.state.adminProductToUpdate.type === '약주, 청주') {
            radioType.value = '3' 
        } else {
            radioType.value = '0'
        }

        // 계절
        if(store.state.adminProductToUpdate.season === '겨울') {
            radioSeason.value = '3'
        } else if(store.state.adminProductToUpdate.season === '가을') {
            radioSeason.value = '2'
        } else if(store.state.adminProductToUpdate.season === '여름') {
            radioSeason.value = '1'
        } else {
            radioSeason.value = '0'
        }
    });

    onBeforeUnmount(() => {
        const form = document.querySelector('#adminProducUpdateForm');
        form.reset();

    });

    const previewImg = ref(store.state.adminProductToUpdate.img);
    const previewInfo = ref(store.state.adminProductToUpdate.info);

    function setFileImg(e) {
        previewImg.value = URL.createObjectURL(e.target.files[0]);
    }

    function setFileInfo(e) {
        previewInfo.value = URL.createObjectURL(e.target.files[0]);
    }
</script>

<style>

</style>
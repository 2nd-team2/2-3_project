<template>
    <div class="admin">
        <form id="adminProducUpdateForm">
            <h2 class="admin_title">상품 수정</h2>
            <div class="admin_input_box">
                <input type="hidden" name="id" :value="$store.state.adminProductToUpdate.id">
                <label for="name">상품 이름</label>
                <input type="text" name="name" id="name" autocomplete='off' :value="$store.state.adminProductToUpdate.name">
                <label for="price">상품 가격</label>
                <input type="number" name="price" id="price" autocomplete='off' :value="$store.state.adminProductToUpdate.price">
                <label for="count">재고량</label>
                <input type="number" name="count" id="count" autocomplete='off' :value="$store.state.adminProductToUpdate.count">
                <label for="ml">용량</label>
                <input type="number" name="ml" id="ml" autocomplete='off' placeholder="단위는 ml" :value="$store.state.adminProductToUpdate.ml">
                <label for="img">상품 이미지</label>
                <input type="file" name="img" accept="image/*" id="img" autocomplete='off'>
                <label for="info">상품 상세 정보</label>
                <input type="file" name="info" accept="image/*" id="info" autocomplete='off'>
                <div class="admin_type_container">
                    <p class="admin_product_p">주종</p>
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
                    <P class="admin_product_p">추천 계절</P>
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
                <button type="button" @click="$store.dispatch('productUpdateSubmit')" class="admin_btn">수정하기</button>
            </div>
        </form>
    </div>
</template>

<script setup>

</script>

<style>

</style>
<template>
    <main>
        <h2 class="inquiry_title inquiry_title_grid">
            <span>상품문의하기</span>
        </h2>

        <div>
            <div class="inquiry_goods_item inquiry_grid">
                <div class="inquiry_goods_grid">
                    <img class="inquiry_goods_img" :src="$store.state.productAskCreateData.img">
                    <div class="inquiry_item_grid">
                        <div class="inquiry_goods_title">{{ $store.state.productAskCreateData.name + ' ' + $store.state.productAskCreateData.ml + 'ml' + ' / ' + $store.state.productAskCreateData.orp_count + '개' }}</div>
                        <div class="inquiry_required">{{ $store.state.productAskCreateData.orpDate }}</div>
                    </div>        
                </div>
            </div>
        </div>

        <form id="qnaProductForm">
            <input type="hidden" name="orp_id" :value="$store.state.productAskCreateData.orp_id">
            <div class="inquiry_padding_top">문의내용</div>
            <div class="inquiry_padding_top">
                <textarea name="qnp_content" placeholder="개인정보(주민번호, 연락처, 주소, 계좌번호, 카드번호 등)가 포함되지 않도록 유의해주세요."></textarea>
            </div>
            <div class="inquiry_required inquiry_privacy"> *개인정보(주민번호, 연락처, 주소, 계좌번호, 카드번호 등)가 포함되지 않도록 유의해주세요.</div>
            
            <hr>
            
            <div class="inquiry_padding_top inquiry_btn_right">
                <button @click="$router.back()" type="button" class="inquiry_submit_btn">취소</button>
                <button @click="$store.dispatch('qnaProductCreate')" type="button" class="inquiry_submit_btn">등록하기</button>
            </div>
        </form>
    </main>
</template>

<script setup>
</script>

<style scoped src="../css/inquiry.css">
</style>
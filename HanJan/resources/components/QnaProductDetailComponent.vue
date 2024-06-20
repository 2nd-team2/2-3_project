<template>
    <main>
        <h2 class="inquiry_title inquiry_title_grid">
            <span>상품문의내역</span>
        </h2>
        <div>
            <div class="inquiry_goods_item inquiry_grid">
                <div class="inquiry_goods_grid">
                    <img class="inquiry_goods_img" :src="$store.state.qnaProductDetailData.img">
                    <div class="inquiry_item_grid">
                        <div class="inquiry_goods_title">
                            {{ $store.state.qnaProductDetailData.name + ' ' + $store.state.qnaProductDetailData.ml + 'ml' + ' ' +  $store.state.qnaProductDetailData.orp_count + '개' }}
                        </div>
                        <div class="inquiry_required">{{ $store.state.qnaProductDetailData.complete }}</div>
                    </div>        
                </div>
            </div>
        </div>
        <div>
            <hr>
            <div class="inquiry_padding_top">문의내용</div>
            <div class="inquiry_padding_top">
                <textarea disabled>{{ $store.state.qnaProductDetailData.qnp_content }}</textarea>
            </div>
            <hr>
            <div class="inquiry_padding_top">답변</div>
            <div class="inquiry_padding_top">
                <textarea disabled>{{ $store.state.qnaProductDetailData.qnp_answer }}</textarea>
            </div>
                
            <hr>
        </div>

            <div class="inquiry_padding_top inquiry_btn_right">
                <button @click="$router.back()" class="inquiry_submit_btn">취소</button>
            </div>
    </main>
</template>

<script setup>
</script>

<style scoped src="../css/inquiry_check.css">
</style>
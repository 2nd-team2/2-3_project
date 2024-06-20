<template>
    <main>
        <h2 class="inquiry_title inquiry_title_grid">
            <span>상품문의내역</span>
        </h2>
        <div>
            <div class="inquiry_goods_item inquiry_grid">
                <div class="inquiry_goods_grid">
                    <img class="inquiry_goods_img" src="/img/best.png">
                    <div class="inquiry_item_grid">
                        <div class="inquiry_goods_title">한잔 꿈의 대화 13도 375ml / 1개</div>
                        <div class="inquiry_required">2024-06-02</div>
                    </div>        
                </div>
            </div>
        </div>
        <div v-for="qnaProductList in $store.state.qnaProductListData" :key="qnaProductList.u_id">
            <hr>
            <div class="inquiry_padding_top">문의내용</div>
            <div class="inquiry_padding_top">
                <textarea disabled>{{ qnaProductList.qnp_content }}</textarea>
            </div>
            <hr>
            <div class="inquiry_padding_top">답변</div>
            <div class="inquiry_padding_top">
                <textarea disabled>{{ qnaProductList.qnp_answer }}</textarea>
            </div>
                
            <hr>
        </div>

            <div class="inquiry_padding_top inquiry_btn_right">
                <button @click="inquiry_back" class="inquiry_submit_btn">취소</button>
            </div>
    </main>
</template>

<script setup>
    function inquiry_back() {
        history.back()
    }

    // 상품문의내역
    import { onBeforeMount } from 'vue';
    import { useStore } from 'vuex';

    const store = useStore();
    onBeforeMount(() => {
        if(store.state.qnaProductDetailData.length < 1) {
            store.dispatch('getQnaProductDetailData');
        }
    })
</script>

<style scoped src="../css/inquiry_check.css">
</style>
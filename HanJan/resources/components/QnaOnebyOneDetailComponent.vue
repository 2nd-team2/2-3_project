<template>
    <main>
        <h2 class="inquiry_title inquiry_title_grid">
            <span>1 : 1 문의내역</span>
        </h2>
        <div class="inquiry_padding_top">문의내용</div>
        <div class="inquiry_padding_top">
            <textarea disabled>{{ $store.state.qnaOneByOneDetailData.qn_content }}</textarea>
        </div>
        <hr>
        <div class="inquiry_padding_top">답변</div>
        <div class="inquiry_padding_top">
            <textarea disabled>{{ $store.state.qnaOneByOneDetailData.qn_answer }}</textarea>
        </div>
        <hr>
        <div class="inquiry_padding_top inquiry_btn_right">
            <button @click="$router.back()"  class="inquiry_submit_btn">취소</button>
        </div>
    </main>
</template>

<script setup>

</script>

<style scoped src="../css/inquiry_check.css">
</style>
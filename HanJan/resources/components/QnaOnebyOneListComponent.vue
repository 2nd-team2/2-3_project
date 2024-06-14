<template>
    <main>
        <h2 class="inquiry_title inquiry_title_grid">
            <span>1 : 1 문의내역</span>
        </h2>
        <div v-for="qnaOneByOneList in $store.state.qnaOneByOneListData" :key="qnaOneByOneList.u_id">
            <div class="inquiry_padding_top">문의내용</div>
            <div class="inquiry_padding_top">
                <textarea disabled>{{ qnaOneByOneList.qn_content }}</textarea>
            </div>
            <hr>
            <div class="inquiry_padding_top">답변</div>
            <div class="inquiry_padding_top">
                <textarea disabled>{{ qnaOneByOneList.qn_answer }}</textarea>
            </div>
            <hr>
        </div>
        <div class="inquiry_padding_top inquiry_btn_right">
            <button @click="inquiry_back"  class="inquiry_submit_btn">취소</button>
        </div>
    </main>
</template>

<script setup>
    function inquiry_back() {
        history.back()
    }

    // 1:1문의내역
    import { onBeforeMount } from 'vue';
    import { useStore } from 'vuex';

    const store = useStore();
    onBeforeMount(() => {
        if(store.state.qnaOneByOneListData.length < 1) {
            store.dispatch('getQnaOneByOnetData');
        }
    })
</script>

<style scoped src="../css/inquiry_check.css">
</style>
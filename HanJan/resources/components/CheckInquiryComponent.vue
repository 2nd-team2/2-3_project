<template>
    <main>
        <h2 class="inquiry_title inquiry_title_grid">
            <span>문의</span>
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

        <hr>
        
        <form action="">
            <div class="inquiry_padding_top">문의내용</div>
            <div class="inquiry_padding_top">
                <textarea disabled></textarea>
            </div>
        </form>

        <hr>

        <form action="">
            <div class="inquiry_padding_top">답변</div>
            <div class="inquiry_padding_top">
                <textarea disabled></textarea>
            </div>
            
            <hr>

            <div class="inquiry_padding_top inquiry_btn_right">
                <button @click="inquiry_back" class="inquiry_submit_btn">취소</button>
            </div>
        </form>
    </main>
</template>

<script setup>
    function inquiry_back() {
        history.back()
    }
</script>

<style scoped src="../css/inquiry_check.css">
</style>
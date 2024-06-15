<template>
    <main>
        <h2 class="review_title reviewC_title_grid">
            <span>리뷰수정</span>
            <a href="" class="reviewC_cancel">계속 쇼핑하기</a>
        </h2>

        <div>
            <div class="reviewC_padding_top">이 상품의 품질에 대해서 얼마나 만족하시나요?</div>
            <div class="review_goods_item reviewC_grid">
                <div class="reviewC_order_at">2024-06-02 주문 / 구매확정 <span class="reviewC_yellow">06-07</span></div>
                <div class="reviewC_goods_grid">
                    <img class="review_goods_img" src="/img/best.png">
                    <div class="reviewC_item_grid">
                        <div class="review_goods_title">한잔 꿈의 대화 13도 375ml / 1개</div>
                        <div class="reviewC_required"><span class="reviewC_required_red">*</span>(필수)</div>
                        <div class="star-rating">
                            <span class="star" data-value="1">&#9733;</span>
                            <span class="star" data-value="2">&#9733;</span>
                            <span class="star" data-value="3">&#9733;</span>
                            <span class="star" data-value="4">&#9733;</span>
                            <span class="star" data-value="5">&#9733;</span>
                        </div>        
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <form action="">
            <div class="reviewC_padding_top">상세리뷰</div>
            <div class="reviewC_padding_top">
                <textarea placeholder="다른 고객님에게 도움이 되도록 상품에 대한 솔직한 평가를 남겨주세요."></textarea>
            </div>
            <div class="reviewC_required reviewC_padding_top" >· 상품 품질과 관계 없는 내용은 비공개 처리될 수 있습니다.</div>
            <div class="reviewC_required reviewC_padding_bottom">· 작성된 리뷰는 삭제 전까지 ‘상품리뷰’에 공개되고, ‘내정보 > 리뷰관리’ 에서 수정 및 삭제가 가능합니다.</div>
            
            <hr>

            <div class="reviewC_padding_top reviewC_btn_right">
                <button type="submit" class="reviewC_submit_btn">등록하기</button>
            </div>
        </form>
    </main>
</template>

<script setup>
</script>

<style scoped src="../css/review.css">
</style>
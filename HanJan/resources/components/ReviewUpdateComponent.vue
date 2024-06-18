<template>
    <main>
        <h2 class="review_title reviewC_title_grid">
            <span>리뷰수정</span>
            <a href="" class="reviewC_cancel">계속 쇼핑하기</a>
        </h2>
        <!-- <div>test : {{ $store.state.reviewUpdateData }}</div> -->
        <div>test : {{ $store.state.reviewToUpdate }}</div>
        <div>
            <div class="reviewC_padding_top">이 상품의 품질에 대해서 얼마나 만족하시나요?</div>
            <div class="review_goods_item reviewC_grid">
                <div class="reviewC_order_at">2024-06-02 주문 / 구매확정 <span class="reviewC_yellow">06-07</span></div>
                <div class="reviewC_goods_grid">
                    <img class="review_goods_img" :src="$store.state.reviewToUpdate.img">
                    <div class="reviewC_item_grid">
                        <div class="review_goods_title">{{ $store.state.reviewToUpdate.name +' / '+ $store.state.reviewToUpdate.ml +'ml /' + '1' +'개'}}</div>
                        <div class="reviewC_required"><span class="reviewC_required_red">*</span>(필수)</div>
                        <!-- 별점 초기 값은 date 들고오기 -->
                        <div class="star-rating">
                            <span class="star" v-for="star in 5" :key="star" :class="{ checked: star <= selectedStar }" @click="selectStar(star)">
                                &#9733;
                            </span>
                            <span>{{ selectedStar }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <form id="reviewUpdateForm">
            <div class="reviewC_padding_top">상세리뷰</div>
            <input type="hidden" name="u_id" :value="$store.state.reviewToUpdate.u_id">
            <input type="hidden" name="p_id" :value="$store.state.reviewToUpdate.p_id">
            <input type="hidden" name="re_star" :value="selectedStar">

            <div class="reviewC_padding_top">
                <textarea name="re_content" placeholder="다른 고객님에게 도움이 되도록 상품에 대한 솔직한 평가를 남겨주세요.">{{ $store.state.reviewToUpdate.re_content }}</textarea>
            </div>
            <div class="reviewC_required reviewC_padding_top" >· 상품 품질과 관계 없는 내용은 비공개 처리될 수 있습니다.</div>
            <!-- TODO : 내 정보 > 글자 수정 할수 도 있음 -->
            <div class="reviewC_required reviewC_padding_bottom">· 작성된 리뷰는 삭제 전까지 ‘상품리뷰’에 공개되고, ‘내 정보 > 리뷰관리’ 에서 수정 및 삭제가 가능합니다.</div>
            
            <hr>

            <div class="reviewC_padding_top reviewC_btn_right">
                <button @click="$store.dispatch('reviewUpdateSubmit')" class="reviewC_submit_btn">등록하기</button>
            </div>
        </form>
    </main>
</template>

<script setup>
import { onBeforeUpdate, ref } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

onBeforeUpdate(() => {
    console.log(store.state.reviewToUpdate);

    return store.state.reviewToUpdate;
})

// 별 js
const selectedStar = ref(store.state.reviewToUpdate.re_star);

const selectStar = (star) => {
  selectedStar.value = star;
};



</script>

<style scoped src="../css/review.css">
</style>
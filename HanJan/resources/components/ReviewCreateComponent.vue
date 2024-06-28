<template>
    <main>
        <div class="review_title reviewC_title_grid">
            <h2>리뷰작성</h2>
            <router-link to="/info" class="reviewC_cancel">돌아가기</router-link>
        </div>
        <div>
            <div class="reviewC_padding_top">이 상품의 품질에 대해서 얼마나 만족하시나요?</div>
            <div class="review_goods_item reviewC_grid">
                <div class="reviewC_order_at">{{ formatDate($store.state.reviewToUpdate.orpDate) }} 주문 / 구매확정 <span class="reviewC_yellow">{{ formatDate($store.state.reviewToUpdate.completeOn) }}</span></div>
                <div class="reviewC_goods_grid">
                    <img class="review_goods_img" :src="$store.state.reviewToUpdate.img">
                    <div class="reviewC_item_grid">
                        <div class="review_goods_title">{{ $store.state.reviewToUpdate.name +' / '+ $store.state.reviewToUpdate.ml +'ml /' + '1' +'개'}}</div>
                        <div class="reviewC_required"><span class="reviewC_required_red">*</span>(필수)</div>
                        <div class="star-rating">
                            <span class="star" v-for="star in 5" :key="star" :class="{ checked: star <= selectedStar }" @click="selectStar(star)">
                                &#9733;
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <hr>
        
        <form id="reviewCreateForm">
            <input type="hidden" name="re_star" :value="selectedStar">
            <div class="reviewC_padding_top">상세리뷰</div>
            <input type="hidden" name="orp_id" :value="$store.state.reviewToUpdate.orp_id">          
            <div class="reviewC_padding_top">
                <textarea name="re_content" placeholder="다른 고객님에게 도움이 되도록 상품에 대한 솔직한 평가를 남겨주세요.(최대 : 500자)"></textarea>
            </div>
            <div class="reviewC_required reviewC_padding_top" >· 상품 품질과 관계 없는 내용은 비공개 처리될 수 있습니다.</div>
            <div class="reviewC_required reviewC_padding_bottom">· 작성된 리뷰는 삭제 전까지 ‘상품리뷰’에 공개되고, ‘내 술잔 > 리뷰관리’ 에서 수정 및 삭제가 가능합니다.</div>
            
            <hr>
            
            <div class="reviewC_padding_top reviewC_btn_right">
                <button type="button" @click="$store.dispatch('reviewCreateSubmit')" class="reviewC_submit_btn">등록하기</button>
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
const selectedStar = ref(0);

const selectStar = (star) => {
  selectedStar.value = star;
};

// 날짜 포맷 (YYYY-MM-DD)
function formatDate(dateString) {
        const date = new Date(dateString);
        const year = date.getFullYear();
        const month = (date.getMonth() + 1).toString().padStart(2, '0'); // 월은 0부터 시작하므로 +1, 두 자리로 맞춤
        const day = date.getDate().toString().padStart(2, '0'); // 두 자리로 맞춤
        return `${year}-${month}-${day}`; // 연-월-일 형식으로 반환
}

</script>

<style scoped src="../css/review.css">
</style>
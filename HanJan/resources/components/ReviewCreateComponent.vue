<template>
    <main>
        <h2 class="review_title reviewC_title_grid">
            <span>리뷰작성</span>
            <router-link to="/list?type=99&page=1" class="reviewC_cancel">
                계속 쇼핑하기
            </router-link >
        </h2>
        <div>test : {{ $store.state.reviewToUpdate }}</div>
        <div>test2 : {{ $store.state.productAskCreateData }}</div>
        <!-- 내 술잔 페이지에서 > 리뷰로 데이터 넘기는 방법 고민해보기 : 리뷰페이지에서 리뷰 수정이랑 동일하게 할건지 -->
        <!-- reviewToUpdate 대신 infoToReview 로 만들어서 사용하기 >> <div>test : {{ $store.state.infoToReview }}</div> -->
        <div>
            <div class="reviewC_padding_top">이 상품의 품질에 대해서 얼마나 만족하시나요?</div>
            <div class="review_goods_item reviewC_grid">
                <div class="reviewC_order_at">2024-06-02 주문 / 구매확정 <span class="reviewC_yellow">06-07</span></div>
                <div class="reviewC_goods_grid">
                    <img class="review_goods_img" :src="$store.state.productAskCreateData.img">
                    <div class="reviewC_item_grid">
                        <div class="review_goods_title">{{ $store.state.productAskCreateData.name +' / '+ $store.state.productAskCreateData.ml +'ml /' + '1' +'개'}}</div>
                        <div class="reviewC_required"><span class="reviewC_required_red">*</span>(필수)</div>
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

        <form id="reviewCreateForm">
            <div class="reviewC_padding_top">상세리뷰</div>
            <input type="hidden" name="re_id" :value="$store.state.reviewToUpdate.re_id">
            <!-- TODO  -->
            <!-- infoToReview를 받아오면 아래 re_id 와 p_id 같이 넘기고 컨트롤러 저장할떄 p_id 받아서 저장 -->
            <!-- <input type="hidden" name="re_id" :value="$store.state.infoToReview.re_id"> -->
            <!-- <input type="hidden" name="p_id" :value="$store.state.infoToReview.p_id"> -->
            <!-- <input type="hidden" name="re_star" :value="selectedStar"> -->
            
            <!-- 작성 완료하고 작성페이지에 남을거면 이름 ml img를 같이 넘겨주고 -->
            <!-- 작성 완료하고 리뷰관리 페이지로 갈거면 이름 ml img는 굳이 안넘겨줘도 될거 같음 -->
            <!-- <input type="hidden" name="name" :value="$store.state.infoToReview.name">
            <input type="hidden" name="ml" :value="$store.state.infoToReview.ml">
            <input type="hidden" name="img" :value="$store.state.infoToReview.img"> -->


            <div class="reviewC_padding_top">
                <textarea name="re_content" placeholder="다른 고객님에게 도움이 되도록 상품에 대한 솔직한 평가를 남겨주세요."></textarea>
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

</script>

<style scoped src="../css/review.css">
</style>
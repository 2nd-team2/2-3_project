<template>
    <main>
        <h2 class="review_title">
            리뷰관리
        </h2>

        <div class="review_goods_item" v-for="(item, key) in $store.state.reviewData" :key="key">
            <div class="review_grid">

                <img class="review_goods_img" :src="item.img">

                <div class="review_goods_info">
                    <div class="review_goods_title"> {{ item.name +' / '+ item.ml +'ml /' + '1' +'개'}}</div>
                    <div class="review_goods_info_grid_star">
                        <div class="star-rating">
                            <span class="star_gold">&#9733;</span>
                            <span class="star_gold">&#9733;</span>
                            <span class="star_gold">&#9733;</span>
                            <span class="star_gray">&#9733;</span>
                            <span class="star_gray">&#9733;</span>
                            <div class="review_create_at">{{ item.created_at }}</div>
                        </div>                   
                    </div>
                    <div>
                        <div class="review_content">
                            {{ item.re_content }}
                        </div>
                    </div>
                </div>

                <div class="vertical-hr"></div>

                <!-- TODO : 수정하기 > 수정하는 페이지 및 a 태그 -->
                <form action="" class="review_goods_info_grid_btn">
                    <button @click="$router.push('/reviewupdate')" type="button" class="review_btn">수정하기</button>
                    <button @click="$store.dispatch('reviewDelete', item.re_id)" class="review_btn">삭제하기</button>
                </form>
            </div>
        </div>

        <div class="pagination">
            <button class="prev"><span> 〈 </span>이전</button>
            <div class="page-numbers"></div>
            <button class="next">다음<span> 〉 </span></button>
        </div>
    </main>
</template>

<script setup>
import { onBeforeMount } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

// 리뷰 초기 데이터 가져오기
onBeforeMount(() => {
    store.dispatch('reviewGet')
})


</script>

<style scoped src="../css/review.css">
</style>
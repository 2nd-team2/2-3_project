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
                    <button @click="reviewUpdate(item)" button="button" class="review_btn">수정하기</button>
                    <button @click="reviewDelete(item.re_id)" class="review_btn">삭제하기</button>
                </form>
            </div>
        </div>
        <!-- TODO : 리뷰 관리는 더보기로 제안해보기 -->
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
import { useRouter } from 'vue-router';


const store = useStore();
const router = useRouter();

// 리뷰 초기 데이터 가져오기
onBeforeMount(() => {
    // TODO: 이미 데이터가 있으면 onBeforeMount 요청 안하게 수정하기
    store.dispatch('reviewGet')
})

// 리뷰 수정하기 페이지로 정보 넘기기
const reviewUpdate = (item) => {

    store.dispatch('reviewUpdate', item);

    // router.push({ path: '/reviewupdate', state: { item: item } });
    // console.log(item);
}

// 리뷰 삭제하기 기능
const reviewDelete = (re_id) => {
    store.dispatch('reviewDelete', re_id)
}


</script>

<style scoped src="../css/review.css">
</style>
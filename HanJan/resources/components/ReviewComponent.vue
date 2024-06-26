<template>
    <main>
        <h2 class="review_title reviewC_title_grid">
            <span>리뷰관리</span>
            <router-link to="/info" class="reviewC_cancel">
                돌아가기
            </router-link >
        </h2>

        <div class="review_goods_item" v-for="(item, key) in $store.state.reviewData.data" :key="key" v-if="$store.state.reviewData.data && $store.state.reviewData.data.length > 0">
            <div class="review_grid">

                <img class="review_goods_img" :src="item.img">

                <div class="review_goods_info">
                    <div class="review_goods_title"> {{ item.name +' '+ item.ml +'ml /' + item.orp_count +'개'}}</div>
                    <div class="review_goods_info_grid_star">
                        <div class="star-rating">
                            <span class="star" v-for="star in 5" :key="star" :class="{ checked: star <= item.re_star }">
                                &#9733;
                            </span>
                            <span>{{ item.re_star }}</span>

                        </div>                  
                    </div>
                    <div>
                        <div class="review_content">
                            {{ item.re_content }}
                        </div>
                    </div>
                </div>
                <div class="vertical-hr"></div>
                <div class="review_goods_info_grid_btn">
                    <button @click="reviewUpdate(item)" button="button" class="review_btn">수정하기</button>
                    <button @click="reviewDelete(item.re_id)" button="button" class="review_btn">삭제하기</button>
                </div>
            </div>
        </div>
        <div v-else>
            <h2 class="review_none_item_center">
                작성한 리뷰가 없습니다.
            </h2>
        </div>
        <!-- 페이지네이션 -->
        <div class="list_num_item" v-if="$store.state.reviewData.data && $store.state.reviewData.data.length > 0">
            <a href="#" class="before" @click.prevent="reviewPrevPage()">〈 이전</a>
            <a
                v-for="reviewPage in reviewPages"
                :key="reviewPage"
                href="#"
                :class="{'num': reviewPage === $store.state.reviewData.current_page, 'num_none': reviewPage !== $store.state.reviewData.current_page}"
                @click.prevent="reviewGoToPage(reviewPage)"
                >{{ reviewPage }}
            </a>
            <a href="#" class="next" @click.prevent="reviewNextPage()">다음 〉</a>
        </div>
    </main>
</template>

<script setup>
import { onBeforeMount, computed } from 'vue';
import { useStore } from 'vuex';

const store = useStore();


// 리뷰 초기 데이터 가져오기
onBeforeMount(() => {
    // TODO: 이미 데이터가 있으면 onBeforeMount 요청 안하게 수정하기

    // 리뷰 데이터 획득
    //store.dispatch('reviewGet', 1)

    if(store.state.reviewData.current_page == 1) {
        store.dispatch('reviewGet', 1);
    }

})

// 리뷰 수정하기 페이지로 정보 넘기기
const reviewUpdate = (item) => {
    store.dispatch('reviewUpdate', item);
}

// 리뷰 삭제하기 기능
const reviewDelete = (re_id) => {
    store.dispatch('reviewDelete', re_id)
}


// 리뷰 페이지네이션

// 페이지 번호 배열 계산
const reviewPages = computed(() => {
    const pageArray = [];
    // 페이지네이션 3개
    const maxPagesToShow = 5;

    let startPage = store.state.reviewData.current_page - 2;
    if(startPage < 1) {
        startPage = 1;
    }
    const endPage = startPage + maxPagesToShow - 1;

    // 시작페이지 구하기
    const pagingStart = startPage <= (store.state.reviewData.last_page - maxPagesToShow + 1) || ((store.state.reviewData.last_page - maxPagesToShow + 1) < 1) ? startPage : (store.state.reviewData.last_page - maxPagesToShow + 1);
    
    // 마지막 페이지 구하기
    const pagingEnd = endPage > store.state.reviewData.last_page ? store.state.reviewData.last_page : endPage;

    for (let i = pagingStart; i <= pagingEnd; i++) {
        pageArray.push(i)
    }
    return pageArray
})

// 특정 페이지로 이동
function reviewGoToPage(page) {
    store.dispatch('reviewGet', page);
}

// 이전 페이지로 이동
function reviewPrevPage() {
    if (store.state.reviewData.current_page > 1) {
        reviewGoToPage(store.state.reviewData.current_page - 1);
    }
}

// 다음 페이지로 이동
function reviewNextPage() {
    if (store.state.reviewData.current_page < store.state.reviewData.last_page) {
        reviewGoToPage(store.state.reviewData.current_page + 1);
    }
}

</script>

<style scoped src="../css/review.css">
</style>
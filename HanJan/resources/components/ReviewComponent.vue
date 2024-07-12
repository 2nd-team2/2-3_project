<template>
    <main>
        <div class="review_title reviewC_title_grid">
            <h2>리뷰관리</h2>
            <router-link to="/info" class="reviewC_cancel">내 술잔 가기</router-link >
        </div>

        <div class="review_goods_item review_item_grid" v-for="(item, key) in $store.state.reviewData.data" :key="key" v-if="$store.state.reviewData.data && $store.state.reviewData.data.length > 0">
            <div class="reviewC_order_at">{{ formatDate(item.orpCre) }} 주문 / 구매확정 <span class="reviewC_yellow">{{ formatDate(item.coCre) }}</span></div>
                <div class="review_goods_grid">
                    <img class="review_goods_img" :src="item.img">

                    <div class="review_item_grid">
                        <div class="review_goods_title"> {{ item.name +' '+ item.ml +'ml /' + item.orp_count +'개'}}</div>
                        <div class="star-rating">
                            <span class="star" v-for="star in 5" :key="star" :class="{ checked: star <= item.re_star }">&#9733;</span>
                        </div>                  
                        <div class="review_content">{{ item.re_content }}</div>
                    </div>
                    
                    <div class="vertical-hr"></div>
                    <div class="review_goods_info_grid_btn">
                        <button @click="reviewUpdate(item)" button="button" class="review_btn">수정하기</button>
                        <button @click="reviewDelete(item.re_id)" button="button" class="review_btn">삭제하기</button>
                    </div>
                </div>
            </div>



        <!-- <div class="review_goods_item" v-for="(item, key) in $store.state.reviewData.data" :key="key" v-if="$store.state.reviewData.data && $store.state.reviewData.data.length > 0">
            <div class="reviewC_order_at">{{ formatDate(item.orpCre) }} 주문 / 구매확정 <span class="reviewC_yellow">{{ formatDate(item.coCre) }}</span></div>
            <div class="review_grid">
                <img class="review_goods_img" :src="item.img">

                <div class="review_goods_info">
                    <div class="review_goods_title"> {{ item.name +' '+ item.ml +'ml /' + item.orp_count +'개'}}</div>
                    <div class="review_goods_info_grid_star">
                        <div class="star-rating">
                            <span class="star" v-for="star in 5" :key="star" :class="{ checked: star <= item.re_star }">&#9733;</span>
                        </div>                  
                    </div>
                    <div>
                        <div class="review_content">{{ item.re_content }}</div>
                    </div>
                </div>

                <div class="vertical-hr"></div>
                <div class="review_goods_info_grid_btn">
                    <button @click="reviewUpdate(item)" button="button" class="review_btn">수정하기</button>
                    <button @click="reviewDelete(item.re_id)" button="button" class="review_btn">삭제하기</button>
                </div>
            </div>
        </div> -->




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
        <transition name="down">
            <div class="agree_box modal_second_overlay" v-show="showAskDeleteModal">
                <div class="modal_second_window">
                    <div class="second_content">
                        <p class="second_content">확인을 누르면 작성한 리뷰가 삭제됩니다.<br> 리뷰 삭제 시 다시 작성할 수 없습니다.</p>
                        <br>
                        <div>
                            <button type="button" @click="confirmComplete" class="modal_btn">확인</button>
                            <button type="button" @click="closeAskDeleteModal" class="modal_btn">취소</button>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </main>
</template>

<script setup>
import { onBeforeMount, computed, ref } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

const showAskDeleteModal = ref(false);
let deleteItemId = ref(null);

// 리뷰 초기 데이터 가져오기
onBeforeMount(() => {

    // 리뷰 데이터 획득
    //store.dispatch('reviewGet', 1)
    if(store.state.reviewData.current_page == 1) {
        store.dispatch('reviewGet', 1);
    }

})

// 날짜 포맷 (YYYY-MM-DD)
function formatDate(dateString) {
        const date = new Date(dateString);
        const year = date.getFullYear();
        const month = (date.getMonth() + 1).toString().padStart(2, '0'); // 월은 0부터 시작하므로 +1, 두 자리로 맞춤
        const day = date.getDate().toString().padStart(2, '0'); // 두 자리로 맞춤
        return `${year}-${month}-${day}`; // 연-월-일 형식으로 반환
}


// 리뷰 수정하기 페이지로 정보 넘기기
const reviewUpdate = (item) => {
    store.dispatch('reviewUpdate', item);
}

// 리뷰 삭제하기 기능
const reviewDelete = (re_id) => {
    deleteItemId.value = re_id;
    showAskDeleteModal.value = true;
}

function confirmComplete() {
    showAskDeleteModal.value = false;
    store.dispatch('reviewDelete', deleteItemId.value)

    if(store.state.reviewData.current_page == 1) {
        store.dispatch('reviewGet', 1);
    }
}

function closeAskDeleteModal() {
    showAskDeleteModal.value = false;
}


// 리뷰 페이지네이션

// 페이지 번호 배열 계산
const reviewPages = computed(() => {
    const pageArray = [];
    // 페이지네이션 3개
    const maxPagesToShow = 5;

    // let startPage = store.state.reviewData.current_page - 2;
    let startPage = store.state.reviewData.last_page <5 ? 1 : store.state.reviewData.current_page - 2;
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
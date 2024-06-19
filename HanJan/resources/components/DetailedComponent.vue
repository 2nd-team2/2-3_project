<template>
    <main>
        <!-- <form class="" id="quantityForm"> -->
            <div class="detailed_haeder">
                <img :src="store.state.productDetail.img">
                <div class="detailed_haeder_item">
                    <p>적당한 산미와 쌀의 감칠맛</p>
                    <p class="detailed_haeder_title">{{ store.state.productDetail.name }}</p>
                    <p>판매가격 :</p>
                    <p class="detailed_haeder_price">{{ store.state.productDetail.price }}원</p>
                    <div class="detailed_haeder_review">
                        <img src="/img/detailed_star.png">
                        <p>5.0</p>
                        <p class="detailed_review">리뷰 999</p>
                    </div>
                    <p id="app">수량</p>
                    <div class="detailed_quantity" >
                        <button @click="count--" :disabled="count === 1" class="detailed_haeder_minus" type="button">-</button>
                        <input type="number" id="quantityDisplay" class="detailed_haeder_quantity" v-model="count"  min="0">
                        <button @click="count++" :disabled="count >= $store.state.productDetail.count " class="detailed_haeder_plus" type="button">+</button>
                    </div>
                    <div>
                        <p>총 상품가격</p>
                        <input type="number" class="detailed_haeder_num" :value="$store.state.productDetail.price*count">원
                    </div>
                        <div class="detailed_haeder_btn">
                            <router-link to="/bag">
                                <!-- 수량만 장바구니에 저장 -->
                                <form id="bagForm"> 
                                    <input type="hidden" name="ba_count" :value="count">
                                    <input type="hidden" name="p_id" :value="$store.state.productDetail.id">
                                    <!-- p_id & conut-->
                                    <button @click="$store.dispatch('detailedToCount')" type="button" @mouseover="openIconBag" @mouseleave="closeIconBag"  class="detailed_haeder_bag_a">
                                        <img src="/img/bag.png" class="detailed_haeder_bag_w" id="b_detailed">
                                        <img src="/img/bag_b.png" class="detailed_haeder_bag_b" id="bk_detailed">
                                        <div class="detailed_haeder_bag">장바구니</div>
                                    </button>
                                </form>
                            </router-link>
                            <router-link to="/order">
                                <button type="submit" class="detailed_haeder_bay" @click="quantit($store.state.productDetail.id)">구매하기</button>
                                <!-- TODO 구매하기 나중에 -->
                            </router-link>
                        </div>
                </div>
            </div>
        <!-- </form> -->
    <div class="detailed_content">
        <img :src="$store.state.productDetail.info">
    </div>
    <hr>
    <h1>리뷰</h1>
    <div class="detailed_footer_item" v-for="(item, key) in $store.state.reviewDetail" :key="key">
        <div class="detailed_footer">
            <p class="detailed_footer_name">{{ item.user_name }}</p>
            <p class="detailed_footer_title">{{ item.name }}</p>
            <div class="review_goods_info_grid_star">
                <!-- 별점 초기 값은 date 들고오기 -->
                <!-- 수정 -->
                <div class="star-rating">
                    <span class="star" v-for="star in 5" :key="star" :class="{ checked: star <= item.re_star }">
                        &#9733;
                    </span>
                    <span>{{ item.re_star }}</span>
                </div>                    
            </div>                   
            <p class="detailed_footer_date">{{ item.updated_at }}</p>
        </div>
        <p class="detailed_footer_content">{{ item.re_content }}</p>
    </div>
    <div class="list_num_item">
        더보기
    </div>
</main>

<!-- move top -->
<a href="#" class="move_top">
    <img src="/img/up.png" class="move_top_img">
</a>
</template>

<script setup>
    import { onBeforeMount, ref, watch } from 'vue';
    import { useStore } from 'vuex';
    const store = useStore();
    
    // const count = ref(1);

    // watch(count, (newVal) => {
    //     if (newVal > 173) {
    //         count.value = 1;
    //     }
    // });
    const count = ref(1);

    watch(count, () => {
        console.log(count.value, store.state.productDetail.count);
        if (count.value > store.state.productDetail.count) {
            // 물량 수 넘어가지 못하게
            count.value = 1;
        }if(0 == count.value ) {
            // 0으로 못 넘어간다
            count.value = 1;
        }
    });
    // 상품 id/count 보내주기
    function quantit(id) {
        router.push('/bag?id='+id);
    }

    // 아이콘 호버시 색 변환
    function openIconBag() {
        const g_iconbag = document.querySelector('#bk_detailed');
        const b_iconbag = document.querySelector('#b_detailed');

        g_iconbag.classList.remove('detailed_haeder_bag_b');
        b_iconbag.style.display = 'none';
    }
    function closeIconBag() {
        const g_iconbag = document.querySelector('#bk_detailed');
        const b_iconbag = document.querySelector('#b_detailed');

        g_iconbag.classList.add('detailed_haeder_bag_b');
        b_iconbag.style.display = 'block';
    }

    onBeforeMount(() => {
        store.dispatch('setProductReviewData');
    })

</script>

<style scoped src="../css/detailed.css">
</style>
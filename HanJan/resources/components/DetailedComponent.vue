<template>
    <main>
        <div class="detailed_haeder">
            <img :src="store.state.productDetail.img">
            <div class="detailed_haeder_item">
                <p class="detailed_haeder_title">{{ store.state.productDetail.name }}</p>
                <p>판매가격 :</p>
                <p class="detailed_haeder_price">{{ formatPrice(store.state.productDetail.price) }}원</p>
                <div class="detailed_haeder_review">
                    <img src="/img/detailed_star.png">
                    <p>{{ store.state.productDetail.star_avg }}</p>
                    <p class="detailed_review">리뷰{{ store.state.productDetail.total_star }}</p>
                </div>
                <p id="app">수량</p>
                <div class="detailed_quantity" >
                    <!-- <button @click="count--" :disabled="count === 1" class="detailed_haeder_minus" type="button">-</button>
                    <input type="number" id="quantityDisplay" class="detailed_haeder_quantity" v-model="count"  min="0">
                    <button @click="count++" :disabled="count >= $store.state.productDetail.count " class="detailed_haeder_plus" type="button">+</button> -->
                    <button type="button" @click="decInt()" :disabled="count <= 1" class="detailed_haeder_minus">-</button>
                    <input type="number" v-model="count" @change="validateCount()" class="detailed_haeder_quantity">
                    <button type="button" @click="incInt()" :disabled="count >= $store.state.productDetail.count" class="detailed_haeder_plus">+</button>

                </div>
                <div>
                    <p>총 상품가격</p>
                    <!-- <input type="number" class="detailed_haeder_num" :value="$store.state.productDetail.price*count" readonly >원 -->
                    <div class="detailed_haeder_num">{{ formatPrice (store.state.productDetail.price*count) }}</div> 원
                </div>
                <div class="detailed_haeder_btn">
                        <!-- 수량만 장바구니에 저장 -->
                        <form id="bagForm"> 
                            <input type="hidden" name="ba_count" :value="count">
                            <input type="hidden" name="p_id" :value="$store.state.productDetail.id">
                            <input type="hidden" name="buy_type" value="buy">
                            <!-- p_id & conut-->
                            <button @click="$store.dispatch('detailedToCount')" type="button" @mouseover="openIconBag" @mouseleave="closeIconBag"  class="detailed_haeder_bag_a">
                                <img src="/img/bag.png" class="detailed_haeder_bag_w" id="b_detailed">
                                <img src="/img/bag_b.png" class="detailed_haeder_bag_b" id="bk_detailed">
                                <div class="detailed_haeder_bag">장바구니</div>
                            </button>
                        </form>
                    <button type="button" class="detailed_haeder_bay" @click="$store.dispatch('detailedUpdate', $store.state.productDetail)">구매하기</button>
                </div>
            </div>
        </div>
    <div class="detailed_content">
        <img :src="$store.state.productDetail.info">
    </div>
    <hr>
    <h1>리뷰</h1>
    <div class="detailed_footer_item" v-for="(item, key) in $store.state.reviewDetail" :key="key">
        <div class="detailed_footer">
            <p class="detailed_footer_name">{{ item.user_name }}</p>
            <p class="detailed_footer_title">{{ item.name }}</p>
            <div class="detailed_footer_right">
                <div class="review_goods_info_grid_star">
                    <!-- 별점 초기 값은 date 들고오기 -->
                    <!-- 수정 -->
                    <div class="star-rating">
                        <span class="star" v-for="star in 5" :key="star" :class="{ checked: star <= item.re_star }">
                            &#9733;
                        </span>
                        <!-- <span>{{ item.re_star }}</span> -->
                    </div>                    
                </div>                   
                <p class="detailed_footer_date">{{ item.updated_at }}</p>
            </div>
        </div>
        <p class="detailed_footer_content">{{ item.re_content }}</p>
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
    const count = ref(1);

    // watch(count, () => {
    //     console.log(count.value, store.state.productDetail.count);
    //     if (count.value > store.state.productDetail.count) {
    //         // 물량 수 넘어가지 못하게
    //         count.value = 1;
    //     }if(0 == count.value ) {
    //         // 0으로 못 넘어간다
    //         count.value = 1;
    //     }
    // });

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

    // 수량 감소 버튼
    const decInt = () => {
        count.value--;
    };
    // 수량 증가 버튼
    const incInt = () => {
        count.value++;
    };
    // 수량 최대 최소 고정
    const validateCount = () => {
        // 1보다 작으면 1로 고정
        if ( count.value < 1) {
            count.value = 1;
            alert('최소 수량은 1개 입니다.')
        }
        // 최대 수량보다 많을시 최대수량으로 고정
        else if (count.value > store.state.productDetail.count) {
            count.value = store.state.productDetail.count;
            alert('남은 수량까지 선택할 수 있습니다. ( 남은 수량 : ' + store.state.productDetail.count + ')')
        } 
    };

    // onBeforeMount(() => {
    //     store.dispatch('setProductReviewData');
    // })

    // 금액 천단위 포맷 (,000)
    function formatPrice(price) {
        return price.toLocaleString('ko-KR');
    }

</script>

<style scoped src="../css/detailed.css">
</style>
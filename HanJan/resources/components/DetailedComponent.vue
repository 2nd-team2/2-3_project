<template>
    <main>
        <!-- <form class="" id="quantityForm"> -->
            <div class="detailed_haeder">
                <img :src="store.state.valuedData.img">
                <div class="detailed_haeder_item">
                    <p>적당한 산미와 쌀의 감칠맛</p>
                    <p class="detailed_haeder_title">{{ store.state.valuedData.name }}</p>
                    <p>판매가격 :</p>
                    <p class="detailed_haeder_price">{{ store.state.valuedData.price }}원</p>
                    <div class="detailed_haeder_review">
                        <img src="/img/detailed_star.png">
                        <p>5.0</p>
                        <p class="detailed_review">리뷰 999</p>
                    </div>
                    <p id="app">수량</p>
                    <div class="detailed_quantity" >
                        <button @click="count--" :disabled="count === 1" class="detailed_haeder_minus" type="button">-</button>
                        <input type="number" id="quantityDisplay" class="detailed_haeder_quantity" v-model="count"  min="0"></input>
                        <button @click="count++" :disabled="count >= $store.state.valuedData.count " class="detailed_haeder_plus" type="button">+</button>
                    </div>
                    <div>
                        <p>총 상품가격</p>
                        <input type="number" class="detailed_haeder_num" :value="$store.state.valuedData.price*count">원</input>
                    </div>
                    
                    <div class="detailed_haeder_btn">
                        <router-link to="/bag">
                            <button type="submit" @mouseover="openIconBag" @mouseleave="closeIconBag" @click="quantit" class="detailed_haeder_bag_a">
                                <img src="/img/bag.png" class="detailed_haeder_bag_w" id="b_detailed">
                                <img src="/img/bag_b.png" class="detailed_haeder_bag_b" id="bk_detailed">
                                <div class="detailed_haeder_bag">장바구니</div>
                            </button>
                        </router-link>
                        <router-link to="/order">
                            <button type="submit" @click="quantit" class="detailed_haeder_bay">구매하기</button>
                        </router-link>
                    </div>
                </div>
            </div>
        <!-- </form> -->
    <div class="detailed_content">
        <img :src="store.state.valuedData.img">
    </div>
    <hr>
    <h1>리뷰</h1>
    <div class="detailed_footer_item">
        <div class="detailed_footer">
            <p class="detailed_footer_name">{{ store.state.valuedData.user_name }}</p>
            <p class="detailed_footer_title">{{ store.state.valuedData.name }}</p>
            <div class="review_goods_info_grid_star">
                <div class="star-rating" :value="$store.state.valuedData.re_star">
                    <span class="star" data-value="1">&#9733;</span>
                    <span class="star" data-value="2">&#9733;</span>
                    <span class="star" data-value="3">&#9733;</span>
                    <span class="star" data-value="4">&#9733;</span>
                    <span class="star" data-value="5">&#9733;</span>
                </div>                     
            </div>                   
            <p class="detailed_footer_date">{{ store.state.valuedData.updated_at }}</p>
        </div>
        <p class="detailed_footer_content">{{ store.state.valuedData.re_content }}</p>
    </div>
    <div class="list_num_item">
        <a href="" class="before">〈 이전</a>
        <a href="" class="num_none">1</a>
        <a href="" class="num_none">2</a>
        <a href="" class="num">3</a>
        <a href="" class="num_none">4</a>
        <a href="" class="num_none">5</a>
        <a href="" class="nuxt">다음 〉</a>
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
        console.log(count.value, store.state.valuedData.count);
        if (count.value > store.state.valuedData.count) {
            count.value = 1;
        }
    });




    // // TODO : 두개 적용시
    const quantit = async() => {
        await zeroAlert();
        await store.dispatch('quantityData');
    };

    // 재고수량 0일때 alert 띄우기
    const zeroAlert = (event) => {
        if ( count <= 0 ) {
            alert('수량을 1 이상으로 선택해주세요.');
            event.preventDefault();
        }
    };

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
        store.dispatch('getValue');
    })

</script>

<style scoped src="../css/detailed.css">
</style>
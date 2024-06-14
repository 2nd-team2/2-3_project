<template>
    <main>
        <!-- <form class="" id="quantityForm"> -->
            <div class="detailed_haeder" v-for="(item, key) in $store.state.valuedData" :key="key">
                <img src="/img/best.png">
                <div class="detailed_haeder_item">
                    <p>적당한 산미와 쌀의 감칠맛</p>
                    <p class="detailed_haeder_title">꿈의 대화</p>
                    <p>판매가격 :</p>
                    <p class="detailed_haeder_price">24,000원</p>
                    <div class="detailed_haeder_review">
                        <img src="/img/detailed_star.png">
                        <p>5.0</p>
                        <p class="detailed_review">리뷰 999</p>
                    </div>
                    <p id="app">수량</p>
                    <div class="detailed_quantity" >
                        <button @click="decrement(count--)" :disabled="count === 1" class="detailed_haeder_minus" type="submit">-</button>
                        <input type="number" id="quantityDisplay" class="detailed_haeder_quantity" v-model="count"></input>
                        <button @click="increment(count++)" @change="handleInput" :disabled="count >=  173 " class="detailed_haeder_plus" type="submit">+</button>
                    </div>
                    <div>
                        <p>총 상품가격</p>
                        <input type="number" class="detailed_haeder_num" :value="item.price*count">원</input>
                    </div>
                    
                    <div class="detailed_haeder_btn">
                        <router-link to="/bag">
                            <button type="submit" @mouseover="openIconBag" @mouseleave="closeIconBag" @click="quantit(item)" class="detailed_haeder_bag_a">
                                <img src="/img/bag.png" class="detailed_haeder_bag_w" id="b_detailed">
                                <img src="/img/bag_b.png" class="detailed_haeder_bag_b" id="bk_detailed">
                                <div class="detailed_haeder_bag">장바구니</div>
                            </button>
                        </router-link>
                        <router-link to="/order">
                            <button type="submit" @click="quantit(item)" class="detailed_haeder_bay">구매하기</button>
                        </router-link>
                    </div>
                </div>
            </div>
        <!-- </form> -->
    <div class="detailed_content">
        <img src="/img/detailed_content.png">
    </div>
    <hr>
    <h1>리뷰</h1>
    <div class="detailed_footer_item">
        <div class="detailed_footer">
            <p class="detailed_footer_name">한술</p>
            <p class="detailed_footer_title">꿈의 대화</p>
            <div class="review_goods_info_grid_star">
                <div class="star-rating">
                    <span class="star" data-value="1">&#9733;</span>
                    <span class="star" data-value="2">&#9733;</span>
                    <span class="star" data-value="3">&#9733;</span>
                    <span class="star" data-value="4">&#9733;</span>
                    <span class="star" data-value="5">&#9733;</span>
                </div>                     
            </div>                   
            <p class="detailed_footer_date">2024-06-07</p>
        </div>
        <p class="detailed_footer_content">완전 산뜻해서 좋았어요</p>
    </div>
    <div class="detailed_footer_item">
        <div class="detailed_footer">
            <p class="detailed_footer_name">한술</p>
            <p class="detailed_footer_title">꿈의 대화</p>
            <div class="review_goods_info_grid_star">
                <div class="star-rating">
                    <span class="star" data-value="1">&#9733;</span>
                    <span class="star" data-value="2">&#9733;</span>
                    <span class="star" data-value="3">&#9733;</span>
                    <span class="star" data-value="4">&#9733;</span>
                    <span class="star" data-value="5">&#9733;</span>
                </div>                     
            </div> 
            <p class="detailed_footer_date">2024-06-07</p>
        </div>
        <p class="detailed_footer_content">완전 산뜻해서 좋았어요</p>
    </div>
    <div class="detailed_footer_item">
        <div class="detailed_footer">
            <p class="detailed_footer_name">한술</p>
            <p class="detailed_footer_title">꿈의 대화</p>
            <div class="review_goods_info_grid_star">
                <div class="star-rating">
                    <span class="star" data-value="1">&#9733;</span>
                    <span class="star" data-value="2">&#9733;</span>
                    <span class="star" data-value="3">&#9733;</span>
                    <span class="star" data-value="4">&#9733;</span>
                    <span class="star" data-value="5">&#9733;</span>
                </div>                     
            </div> 
            <p class="detailed_footer_date">2024-06-07</p>
        </div>
        <p class="detailed_footer_content">완전 산뜻해서 좋았어요</p>
    </div>
    <div class="detailed_footer_item">
        <div class="detailed_footer">
            <p class="detailed_footer_name">한술</p>
            <p class="detailed_footer_title">꿈의 대화</p>
            <div class="review_goods_info_grid_star">
                <div class="star-rating">
                    <span class="star" data-value="1">&#9733;</span>
                    <span class="star" data-value="2">&#9733;</span>
                    <span class="star" data-value="3">&#9733;</span>
                    <span class="star" data-value="4">&#9733;</span>
                    <span class="star" data-value="5">&#9733;</span>
                </div>                     
            </div> 
            <p class="detailed_footer_date">2024-06-07</p>
        </div>
        <p class="detailed_footer_content">완전 산뜻해서 좋았어요</p>
    </div>
    <div class="detailed_footer_item">
        <div class="detailed_footer">
            <p class="detailed_footer_name">한술</p>
            <p class="detailed_footer_title">꿈의 대화</p>
            <div class="review_goods_info_grid_star">
                <div class="star-rating">
                    <span class="star" data-value="1">&#9733;</span>
                    <span class="star" data-value="2">&#9733;</span>
                    <span class="star" data-value="3">&#9733;</span>
                    <span class="star" data-value="4">&#9733;</span>
                    <span class="star" data-value="5">&#9733;</span>
                </div>                     
            </div> 
            <p class="detailed_footer_date">2024-06-07</p>
        </div>
        <p class="detailed_footer_content">완전 산뜻해서 좋았어요</p>
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
    import { onBeforeMount, ref } from 'vue';
    import { useStore } from 'vuex';
    
    const count = ref(1);

    const handleInput = () => {
        console.log('현재 count 값:', count.value);
        if (count.value >= 173) {
            count.value = 0;
        }
    };



    const store = useStore();



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
        if(store.state.valuedData.length < 1) {
            store.dispatch('getValue');
        }
    })

</script>

<style scoped src="../css/detailed.css">
</style>
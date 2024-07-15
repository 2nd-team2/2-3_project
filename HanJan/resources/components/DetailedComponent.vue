<template>
    <main>
        <div class="detailed_haeder">
            <img :src="store.state.productDetail.img">
            <div class="detailed_haeder_item">
                <!-- 카카오 링크 공유 -->
                <div class="detaild_haeder_bnt">
                    <p class="detailed_haeder_title">{{ store.state.productDetail.name }}</p>
                    <div class="kakao_btn">
                        <img src="/img/kakao_share.png" @click="shareMessage()">
                    </div>
                </div>
                <p>판매가격 :</p>
                <p class="detailed_haeder_price">{{ formatPrice(store.state.productDetail.price) }}원</p>
                <div class="detailed_haeder_review">
                    <img src="/img/detailed_star.png">
                    <p>{{ store.state.productDetail.star_avg !== null ? store.state.productDetail.star_avg : 0 }}</p>
                    <a href="#detailed_review_list" >
                        <p class="detailed_review">리뷰 {{ store.state.productDetail.total_star !== null ? store.state.productDetail.total_star : 0 }}</p>
                    </a>
                </div>
                <p id="app">수량</p>
                <div class="detailed_quantity" >
                    <button type="button" @click="decInt()" :disabled="count <= 1" class="detailed_haeder_minus">-</button>
                    <input type="number" v-model="count" @change="validateCount()" class="detailed_haeder_quantity">
                    <button type="button" @click="incInt()" :disabled="count >= $store.state.productDetail.count" class="detailed_haeder_plus">+</button>
                </div>
                <div>
                    <p>총 상품가격</p>
                    <div class="detailed_haeder_num">{{ formatPrice (store.state.productDetail.price*count) }}</div> 원
                </div>
                <div class="detailed_haeder_btn">
                        <!-- 수량만 장바구니에 저장 -->
                        <form id="bagForm"> 
                            <input type="hidden" name="ba_count" :value ="count">
                            <input type="hidden" name="p_id" :value="$store.state.productDetail.id">
                            <input type="hidden" name="buy_type" value="buy">
                            <input type="hidden" name="products_name" :value="$store.state.productDetail.name">
                            <!-- p_id & conut-->
                            <!-- <button @click="$store.dispatch('detailedToCount')" type="button" @mouseover="openIconBag" @mouseleave="closeIconBag"  class="detailed_haeder_bag_a"> -->
                            <button @click="enterToBag" type="button" @mouseover="openIconBag" @mouseleave="closeIconBag"  class="detailed_haeder_bag_a">
                                <img src="/img/bag.png" class="detailed_haeder_bag_w" id="b_detailed">
                                <img src="/img/bag_b.png" class="detailed_haeder_bag_b" id="bk_detailed">
                                <div class="detailed_haeder_bag">장바구니</div>
                            </button>
                        </form>
                    <button type="button" class="detailed_haeder_bay" @click="$store.dispatch('detailedUpdate', $store.state.productDetail)">구매하기</button>
                </div>
            </div>
        </div>
    <!-- 상품정보  -->
    <div class="detailed_content">
        <img :src="$store.state.productDetail.info">
    </div>

    <!-- 상품정보 -->
    <div></div>

    <!-- 양조장 이야기 -->
    <router-link to="/story">
        <div class="detailed_title_story">
            <p>양조장 이야기가 궁금하다면?</p>
            <div class="detailed_img">
                <div class="datailed_title_img">
                    <p>한잔</p>
                    <button type="button" class="detailed_title_story_dt">더 알아보기 &#62;</button>
                </div>
            </div>
        </div>
    </router-link>

    <hr>
    <h1 id="detailed_review_list">리뷰</h1>
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
    <transition name="down">
        <div class="agree_box modal_second_overlay" v-show="showEnterBagModal">
            <div class="modal_second_window">
                <div class="second_content">
                    <p class="second_content">확인을 클릭시 장바구니로 이동 됩니다. 장바구니에 담은 총수량 : {{ count }} 개</p>
                    <br>
                    <div>
                        <button type="button" @click="completeModal" class="modal_btn">확인</button>
                        <button type="button" @click="closeModal" class="modal_btn">취소</button>
                    </div>
                </div>
            </div>
        </div>
    </transition>
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
    const showEnterBagModal = ref(false);

    function enterToBag() {
        showEnterBagModal.value = true;
    }

    function closeModal() {
        showEnterBagModal.value = false;
    }

    function completeModal() {
        store.dispatch('detailedToCount')
        showEnterBagModal.value = false;
    }

    function shareMessage() {
        // 현재 링크 가져오기
        let currentURL = window.location.href;

        // 카카오톡 공유하기 openApi 
        Kakao.init('207acd3374ae418155e14bcfe011298b');

        Kakao.Link.sendDefault({
            objectType: 'feed',
            content: {
                title: store.state.productDetail.name + ' ' + store.state.productDetail.ml + 'ml',
                description: '주종 : ' + store.state.productDetail.type + ' ' + store.state.productDetail.price + '원',
                imageUrl: 'https://ifh.cc/g/zFrKG7.png',
                link: {
                    mobileWebUrl: currentURL,
                    webUrl: currentURL,
                },
            },
            buttons: [
                {
                    title: '구매하기',
                    link: {
                        mobileWebUrl: currentURL,
                        webUrl: currentURL,
                    },
                },
                {
                    title: '한잔 둘러보기',
                    link: {
                        mobileWebUrl: 'https://112.222.157.156:6425/',
                        webUrl: 'https://112.222.157.156:6425/',
                    },
                },
            ],
            // 카카오톡 미설치 시 카카오톡 설치 경로이동
            installTalk: true,
        });
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
            alert('남은 수량까지 선택할 수 있습니다. ( 남은 수량 : ' + (store.state.productDetail.count) + ')')
        } 
    };

    // 금액 천단위 포맷 (,000)
    function formatPrice(price) {
        if (typeof price === 'number' && !isNaN(price)) {
            return price.toLocaleString('ko-KR');
        } else {
            return ''; // 혹은 다른 기본값 처리
        }
    }


</script>

<style scoped src="../css/detailed.css">
</style>
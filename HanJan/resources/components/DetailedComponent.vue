<template>
    <main>
    <form action="" method="get">
        <div class="detailed_haeder">
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
                <p>수량</p>
                <div class="detailed_quantity">
                    <button class="detailed_haeder_plus" type="submit">-</button>
                    <p>{{ quantity }}</p>
                    <button class="detailed_haeder_height" type="submit">+</button>
                </div>
                <p>총 상품가격</p>
                <p class="detailed_haeder_num">24,000원</p>
                <div class="detailed_haeder_btn">
                    <a @mouseover="openIconBag" @mouseleave="closeIconBag" class="detailed_haeder_bag_a" href="/bag">
                        <img src="/img/bag.png" class="detailed_haeder_bag_w" id="b_detailed">
                        <img src="/img/bag_b.png" class="detailed_haeder_bag_b" id="bk_detailed">
                        <div @click.prevent="zeroAlert" class="detailed_haeder_bag">장바구니</div>
                    </a>
                    <button type="submit" @click="zeroAlert" class="detailed_haeder_bay">구매하기</button>
                </div>
            </div>
        </div>
    </form>
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
// 재고수량 0일때 alert 띄우기
const quantity = 0; // 초기 수량
function zeroAlert(event) {
    event.preventDefault(); // 기본 동작(페이지 이동)을 막습니다.
        if( quantity = 0 ) {
            quantity;
        
        }else {
            alert('수량이 0이므로 확인 부탁드립니다.');
        }
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

    // 재고수량 0일때 alert 띄우기
    // let quantity = 0; // 초기 수량을 0으로 설정합니다.

    // function decreaseQuantity() {
    //     if (quantity > 0) {
    //         // quantity.value--; = quantity의 값을 1만큼 감소 자동으로 값 업데이트 해준다
    //         quantity --;
    //     } else {
    //         alert("수량이 0이므로 다시확인 부탁드립니다.");
    //     }
    // }
</script>

<style scoped src="../css/detailed.css">
</style>
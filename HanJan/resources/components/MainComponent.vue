<template>
    <!-- 스와이퍼 -->
    <swiper
        :spaceBetween="30"
        :centeredSlides="true"
        :autoplay="{
        delay: 2500,
        disableOnInteraction: false,
        }"
        :pagination="{
        clickable: true,
        }"
        :navigation="true"
        :modules="modules"
        class="mySwiper"
    >
        <swiper-slide>
            <div class="swiper_box">
                <img src="/img/swiper1.png" class="swiper_img">
                <div class="swiper_content">
                    <h1 class="swiper_title">11%</h1>
                    <h1 class="swiper_title2">싱싱한 감귤의 맛과 향,</h1>
                    <h1 class="swiper_title2 swiper_title_weight">니모메</h1>
                    <h2 class="swiper_title3">제주샘주가 정성껏 빛은 좋은술,</h2>
                    <h2 class="swiper_title3">니모메의 고유한 맛을 즐겨보세요.</h2>
                    <a href="" class="swiper_show">보러가기</a>
                </div>
            </div>
        </swiper-slide>
        <swiper-slide>
            <div class="swiper_box">
                <img src="/img/swiper2.png" class="swiper_img">
                <div class="swiper_content">
                    <h1 class="swiper_title">6%</h1>
                    <h1 class="swiper_title2">흑당 밀크티를 먹은 듯,</h1>
                    <h1 class="swiper_title2 swiper_title_weight">스파클링 오디 별산</h1>
                    <h2 class="swiper_title3">파이나 머핀처럼 손으로 간편하게</h2>
                    <h2 class="swiper_title3">집어 먹을 수 있는 빵과 즐겨보세요.</h2>
                    <a href="" class="swiper_show">보러가기</a>
                </div>
            </div>
        </swiper-slide>
        <swiper-slide>
            <div class="swiper_box">
                <img src="/img/swiper3.png" class="swiper_img">
                <div class="swiper_content">
                    <h1 class="swiper_title">6%</h1>
                    <h1 class="swiper_title2">시원한 청량감과 부드럽고 달콤한 맛</h1>
                    <h1 class="swiper_title2 swiper_title_weight">구름을 벗삼아</h1>
                    <h2 class="swiper_title3">유기농 햇찹쌀, 전통누룩, 천연 암반수</h2>
                    <h2 class="swiper_title3">매콤한 음식과 찰떡궁합</h2>
                    <a href="" class="swiper_show">보러가기</a>
                </div>
            </div>
        </swiper-slide>
        <swiper-slide>
            <div class="swiper_box">
                <img src="/img/swiper4.png" class="swiper_img">
                <div class="swiper_content">
                    <h1 class="swiper_title">16%</h1>
                    <h1 class="swiper_title2">짙은 달콤한 포도 주스향,</h1>
                    <h1 class="swiper_title2 swiper_title_weight">무주 구천동 산머루주</h1>
                    <h2 class="swiper_title3">풍미가 진하지 않고 가볍게</h2>
                    <h2 class="swiper_title3">즐길 수 있는 안주를 추천합니다.</h2>
                    <a href="" class="swiper_show">보러가기</a>
                </div>
            </div>
        </swiper-slide>
        <swiper-slide>
            <div class="swiper_box">
                <img src="/img/swiper5.png" class="swiper_img">
                <div class="swiper_content">
                    <h1 class="swiper_title">25%</h1>
                    <h1 class="swiper_title2">매실의 달콤한 풍미,</h1>
                    <h1 class="swiper_title2 swiper_title_weight">서울의 밤</h1>
                    <h2 class="swiper_title3">생선회나 샤브샤브처럼</h2>
                    <h2 class="swiper_title3">담백한 음식과 함께 하시길 추천합니다.</h2>
                    <a href="" class="swiper_show">보러가기</a>
                </div>
            </div>
        </swiper-slide>
    </swiper>

    <!-- 전통주 이야기 -->
    <div class="alcohol_story">
        <div class="alcohol_story_title">
            <h1>우리는 왜</h1>
            <h1>한국 전통술을 알리고자 하는가?</h1>
        </div>
        <img class="alcohol_story_img" src="/img/alcohol.png"></img>
        <img class="alcohol_story_img2" src="/img/hangari.png"></img>
        <div class="alcohol_story_content">
            <p>우리는 전통술의 발전을 통해 지역 경제를 활성화하고, 나아가 세계 10위의 경제대국에 걸맞는 한국 술의 문화 상품화에 작은 보탬이 되고자 합니다.</p>
        </div>
    </div>

    <!-- 날씨 추천 술 -->
    <div class="weather_alcohol">
        <h1 class="weather_alcohol_title">오늘의 날씨와 맞는 술은?</h1>
        <div class="weather_alcohol_box">
            <img src="/img/alcohol1.jpeg" class="weather_alcohol_img">
            <h1 class="weather_alcohol_num">01</h1>
            <h1 class="weather_alcohol_name">고도리 샤인머스캣 와인</h1>
            <div class="weather_alcohol_type">과실주 10.5%</div>
            <a href="" class="weather_alcohol_a">바로가기</a>
        </div>
        <div class="weather_alcohol_box2">
            <h1 class="weather_alcohol_num">01</h1>
            <h1 class="weather_alcohol_name">고도리 샤인머스캣 와인</h1>
            <div class="weather_alcohol_type">과실주 10.5%</div>
            <a href="" class="weather_alcohol_a">바로가기</a>
            <img src="/img/alcohol1.jpeg" class="weather_alcohol_img">
        </div>
        <div class="weather_alcohol_box">
            <img src="/img/alcohol1.jpeg" class="weather_alcohol_img">
            <h1 class="weather_alcohol_num">01</h1>
            <h1 class="weather_alcohol_name">고도리 샤인머스캣 와인</h1>
            <div class="weather_alcohol_type">과실주 10.5%</div>
            <a href="" class="weather_alcohol_a">바로가기</a>
        </div>
        <div class="weather_alcohol_box2 weather_none">
            <h1 class="weather_alcohol_num">01</h1>
            <h1 class="weather_alcohol_name">고도리 샤인머스캣 와인</h1>
            <div class="weather_alcohol_type">과실주 10.5%</div>
            <a href="" class="weather_alcohol_a">바로가기</a>
            <img src="/img/alcohol1.jpeg" class="weather_alcohol_img">
        </div>
        <div class="weather_alcohol_box">
            <img src="/img/alcohol1.jpeg" class="weather_alcohol_img">
            <h1 class="weather_alcohol_num">01</h1>
            <h1 class="weather_alcohol_name">고도리 샤인머스캣 와인</h1>
            <div class="weather_alcohol_type">과실주 10.5%</div>
            <a href="" class="weather_alcohol_a">바로가기</a>
        </div>
        <div class="weather_alcohol_box2">
            <h1 class="weather_alcohol_num">01</h1>
            <h1 class="weather_alcohol_name">고도리 샤인머스캣 와인</h1>
            <div class="weather_alcohol_type">과실주 10.5%</div>
            <a href="" class="weather_alcohol_a">바로가기</a>
            <img src="/img/alcohol1.jpeg" class="weather_alcohol_img">
        </div>
        <div class="weather_alcohol_box">
            <img src="/img/alcohol1.jpeg" class="weather_alcohol_img">
            <h1 class="weather_alcohol_num">01</h1>
            <h1 class="weather_alcohol_name">고도리 샤인머스캣 와인</h1>
            <div class="weather_alcohol_type">과실주 10.5%</div>
            <a href="" class="weather_alcohol_a">바로가기</a>
        </div>
        <div class="weather_alcohol_box2 weather_none">
            <h1 class="weather_alcohol_num">01</h1>
            <h1 class="weather_alcohol_name">고도리 샤인머스캣 와인</h1>
            <div class="weather_alcohol_type">과실주 10.5%</div>
            <a href="" class="weather_alcohol_a">바로가기</a>
            <img src="/img/alcohol1.jpeg" class="weather_alcohol_img">
        </div>
    </div>

    <!-- 리뷰 -->
    <div class="review_container">
        <h1 class="review">한잔 리뷰</h1>
        <div class="review_box">
            <img src="/img/alcohol2.jpeg" class="goods_img">
            <h1 class="review_title">리뷰 제목</h1>
            <p class="review_content">여자들이 좋아할 맛 그런데 저한테도 깔끔한 맛 정도</p>
            <a href="" class="review_a">
                <div class="goods_title">제주, 동백 제주, 동백 제주, 동백</div>
                <div class="goods_read">자세히 보기</div>
            </a>
        </div>
        <div class="review_box">
            <img src="/img/alcohol2.jpeg" class="goods_img">
            <h1 class="review_title">리뷰 제목</h1>
            <p class="review_content">여자들이 좋아할 맛 그런데 저한테도 깔끔한 맛 정도</p>
            <a href="" class="review_a">
                <div class="goods_title">제주, 동백</div>
                <div class="goods_read">자세히 보기</div>
            </a>
        </div>
        <div class="review_box">
            <img src="/img/alcohol2.jpeg" class="goods_img">
            <h1 class="review_title">리뷰 제목</h1>
            <div class="review_content">
                가나다라마바사아자차카타파하가나다라마바사아자차카타파하가나다라마바사아자차카타파하가나다라마바사아자차카타파하가나다라마바사아자차카타파하가나다라마바사아자차카타파하가나다라마바사아자차카타파하가나다라마바사아자차카타파하
            </div>
            <a href="" class="review_a">
                <div class="goods_title">제주, 동백</div>
                <div class="goods_read">자세히 보기</div>
            </a>
        </div>
        <div class="review_box review_none">
            <img src="/img/alcohol2.jpeg" class="goods_img">
            <h1 class="review_title">리뷰 제목</h1>
            <p class="review_content">여자들이 좋아할 맛 그런데 저한테도 깔끔한 맛 정도</p>
            <a href="" class="review_a">
                <div class="goods_title">제주, 동백</div>
                <div class="goods_read">자세히 보기</div>
            </a>
        </div>
    </div>

    <!-- 공지사항 -->
    <div class="notification_container">
        <a href="" class="notification">공지사항 +</a>
        <a href="" class="notification_a">
            <div class="notification_title">공지 제목</div>
            <div class="notification_date">2024-06-04</div>
        </a>
        <a href="" class="notification_a">
            <div class="notification_title">공지 제목</div>
            <div class="notification_date">2024-06-04</div>
        </a>
        <a href="" class="notification_a">
            <div class="notification_title">공지 제목</div>
            <div class="notification_date">2024-06-04</div>
        </a>
        <a href="" class="notification_a">
            <div class="notification_title">공지 제목</div>
            <div class="notification_date">2024-06-04</div>
        </a>
        <a href="" class="notification_a">
            <div class="notification_title">공지 제목</div>
            <div class="notification_date">2024-06-04</div>
        </a>
        <a href="" class="notification_a">
            <div class="notification_title">공지 제목</div>
            <div class="notification_date">2024-06-04</div>
        </a>
        <a href="" class="notification_a">
            <div class="notification_title">공지 제목</div>
            <div class="notification_date">2024-06-04</div>
        </a>
    </div>

    <!-- move top -->
    <a href="#" class="move_top">
        <img src="/img/up.png" class="move_top_img">
    </a>
</template>

<script setup>
    import { Swiper, SwiperSlide } from 'swiper/vue';
    import 'swiper/css';
    import 'swiper/css/pagination';
    import 'swiper/css/navigation';
    import { Autoplay, Pagination, Navigation } from 'swiper/modules';

    // 스와이퍼
    const modules = [Autoplay, Pagination, Navigation];
</script>

<style>
</style>
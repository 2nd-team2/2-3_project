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
                    <router-link to="/detailed?id=52" class="swiper_show">보러가기</router-link>
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
                    <router-link to="/detailed?id=56" class="swiper_show">보러가기</router-link>
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
                    <router-link to="/detailed?id=53" class="swiper_show">보러가기</router-link>
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
                    <router-link to="/detailed?id=54" class="swiper_show">보러가기</router-link>
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
                    <router-link to="/detailed?id=55" class="swiper_show">보러가기</router-link>
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
        <h1 class="weather_alcohol_title">{{ $store.state.seasonData[0].season}}</h1>
        <div v-for="(season, index) in seasonLimit" :key="index">
            <div @click="productDetail(season.id)" :class="{weather_alcohol_box: index % 2 === 0, weather_alcohol_box2: index % 2 === 1}">
                <img v-if="index % 2 === 0" :src="season.img" class="weather_alcohol_img">
                <h1 class="weather_alcohol_num">{{ '0' + (index + 1) }}</h1>
                <h1 class="weather_alcohol_name">{{ season.name }}</h1>
                <div class="weather_alcohol_type">{{ season.type + ' ' + season.ml + 'ml'}}</div>
                <div class="weather_alcohol_a">바로가기</div>
                <img v-if="index % 2 === 1" :src="season.img" class="weather_alcohol_img">
            </div>
        </div>
    </div>

    <!-- 리뷰 -->
    <div class="review_container">
        <h1 class="review">한잔 리뷰</h1>
        <div class="review_box" v-for="review in reviewLimit">
            <img :src="review.img" class="goods_img">
            <p class="review_content">{{ review.re_content }}</p>
            <div @click="productDetail(review.id)" class="review_a">
                <div class="goods_title">{{ review.name }}</div>
                <div class="goods_read">자세히 보기</div>
            </div>
        </div>
    </div>

    <!-- 공지사항 -->
    <div class="notification_container">
        <router-link to="/noticelist" class="notification">공지사항 +</router-link>
        <div v-for="notice in $store.state.noticeData.data" :key="notice.no_id" class="notification_a">
            <div @click="noticeDetail(notice.no_id)" class="notification_title">
                {{ notice.no_title }}
            </div>
            <div class="notification_date">{{ notice.created_at }}</div>
        </div>    
    </div>

    <!-- move top -->
    <a href="#" class="move_top">
        <img src="/img/up.png" class="move_top_img">
    </a>
</template>

<script setup>
    // 스와이퍼
    import { Swiper, SwiperSlide } from 'swiper/vue';
    import 'swiper/css';
    import 'swiper/css/pagination';
    import 'swiper/css/navigation';
    import { Autoplay, Pagination, Navigation } from 'swiper/modules';

    // 공지사항 
    import { onBeforeMount, ref, computed, onMounted } from 'vue';
    import { useStore } from 'vuex';
    import router from '../js/router';

    // 스와이퍼
    const modules = [Autoplay, Pagination, Navigation];

    // 공지사항 
    const store = useStore();
    onBeforeMount(() => {
        // 공지사항 리스트
        if(store.state.noticeData.current_page == 1) {
            store.dispatch('getNoticeData', 1);
        }
        // 리뷰 리스트
        if(store.state.reviewListData.length < 1) {
            store.dispatch('getReviewistData');
        }
        // 계절 별 추천
        if(store.state.seasonData.length < 1) {
            store.dispatch('getSeasonData');
        }
        
    })

    // 공지사항 디테일 페이지 이동
    function noticeDetail(id) {
        router.push('/notice?id=' + id);
    }

    // 상품 디테일 페이지 이동
    function productDetail(id) {
        router.push('/detailed?id='+ id);
    }

    // 모바일 버전 스크린 크기에 따른 데이터 갯수
    // 화면 크기에 따라 데이터를 제한하기 위한 reactive 변수
    const windowWidth = ref(window.innerWidth);

    // 화면 크기 변경을 감지하는 함수
    const updateWindowWidth = () => {
        windowWidth.value = window.innerWidth;
    };

    // 화면 크기에 따라 표시할 데이터를 계산하는 computed 속성
    // 계절 별 추천
    const seasonLimit = computed(() => {
        const data = store.state.seasonData;
        return windowWidth.value <= 770 ? data.slice(0, 6) : data;
    });

    // 리뷰
    const reviewLimit = computed(() => {
        const data = store.state.reviewListData;
        return windowWidth.value <= 770 ? data.slice(0, 3) : data;
    });

    // 컴포넌트가 마운트될 때 resize 이벤트 리스너를 추가
    onMounted(() => {
        window.addEventListener('resize', updateWindowWidth);
    });

    

</script>

<style>
</style>
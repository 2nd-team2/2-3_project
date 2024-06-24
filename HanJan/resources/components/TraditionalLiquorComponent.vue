<template>
    <main>
        <h2 class="tl_title">
            전통주 이야기
        </h2>
        <swiper
            :slidesPerView="1"
            :spaceBetween="30"
            :loop="true"
            :pagination="{
            clickable: true,
            }"
            :navigation="true"
            :modules="modules"
            class="mySwiper"
        >
            <swiper-slide>
                <div class="tl_box">
                    <img src="/img/list_img0.png" class="tl_type_img">
                    <div class="tl_type">탁주</div>
                    <p class="tl_type_content">
                        곡류(쌀, 밀, 보리 등) 원료에 국(누룩, 입국 등)과 물을 섞어 일정한 온도에서 발효시킨 술덧을 체 등으로 걸러 제조한 술이다.
                        '탁하게 빚은 술'이라고 하여 탁주, '방금 막 거른 술'이라고하여 막걸리라고도 한다.
                        탁주의 주원료는 멥쌀, 밀누룩 그리고 물이다. 멥쌀 고두밥을 찐 뒤에 이를 식혀서 물과 함께 빻은 누룩을 비벼 항아리에 담는다.
                        항아리를 25도 전후의 따뜻한 곳에 놓아두면 술이 발효되기 시작하여 빠르게는 4~5일 만에, 더디게는 7~8일 만에 완성된다.
                    </p>
                </div>
            </swiper-slide>
            <swiper-slide>
                <div class="tl_box">
                    <img src="/img/list_img1.png" class="tl_type_img">
                    <div class="tl_type">과실주</div>
                    <p class="tl_type_content">
                        과실을 발효시켜 만든 술을 말한다. 지역 대표 과실의 특성을 살려 만드는 경우가 많으며, 포도, 복분자, 머루, 사과, 복숭아, 딸기 등 다양한 과실이 사용된다.
                    </p>
                </div>
            </swiper-slide>
            <swiper-slide>
                <div class="tl_box">
                    <img src="/img/list_img2.png" class="tl_type_img">
                    <div class="tl_type">증류수</div>
                    <p class="tl_type_content">
                        막걸리, 약주, 청주와 같은 발효주를 증류하여 만든 술로, 주세법상의 증류식소주, 일반 증류주, 리큐르 등이 있다.
                        대표적인 한국 증류주인 소주는 '불로 익혀 만든 진한 술'이라는 뜻으로, 곡물을 발효시켜 증류한 술인 증류식 소주와 주정을 물에 희석하여 제조한 희석식 소주가 있다.
                    </p>
                </div>
            </swiper-slide>
        </swiper>
    </main>
</template>

<script setup>
    import { Swiper, SwiperSlide } from 'swiper/vue';
    import 'swiper/css';
    import 'swiper/css/pagination';
    import 'swiper/css/navigation';
    import { Navigation } from 'swiper/modules';
    const modules = [Navigation];
</script>

<style scoped src="../css/traditionalliquor.css">
</style>
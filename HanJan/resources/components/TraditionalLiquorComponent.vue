<template>
    <main>
        <h2 class="tl_title">
            전통주 이야기
        </h2>
        <div class="tl_none">
            {{ $store.state.TraditionalLiquorData }}
        </div>
        <swiper
            :slidesPerView="1"
            :spaceBetween="30"
            :loop="true"
            :initalSlide="0"
            :loopedSlides="1"
            :pagination="{
            clickable: true,
            }"
            :navigation="true"  
            :modules="modules"
            class="mySwiper"    
        >
            <!-- <swiper-slide>
                <div class="tl_box" >
                    <img :src="$store.state.TraditionalLiquorData.tl_img" class="tl_type_img">
                    <div class="tl_type">{{ $store.state.TraditionalLiquorData.tl_title }}</div>
                    <p class="tl_type_content">{{ $store.state.TraditionalLiquorData.tl_content }}</p>
                </div>
            </swiper-slide> -->
            <!-- <swiper-slide v-for="(tl, key) in $store.state.TraditionalLiquorData" :key="key">
                <div class="tl_box">
                    <img :src="tl.tl_img" class="tl_type_img">
                    <div class="tl_type">{{ tl.tl_title }}</div>
                    <p class="tl_type_content">{{ tl.tl_content }}</p>
                </div>
            </swiper-slide> -->
            <swiper-slide>
                <div class="tl_box">
                    <img :src="$store.state.TraditionalLiquorData[0].tl_img" class="tl_type_img">
                    <div class="tl_type">{{ $store.state.TraditionalLiquorData[0].tl_title }}</div>
                    <p class="tl_type_content">{{ $store.state.TraditionalLiquorData[0].tl_content }}</p>
                </div>
            </swiper-slide>
            <swiper-slide>
                <div class="tl_box">
                    <img :src="$store.state.TraditionalLiquorData[1].tl_img" class="tl_type_img">
                    <div class="tl_type">{{ $store.state.TraditionalLiquorData[1].tl_title }}</div>
                    <p class="tl_type_content">{{ $store.state.TraditionalLiquorData[1].tl_content }}</p>
                </div>
            </swiper-slide>
            <swiper-slide>
                <div class="tl_box">
                    <img :src="$store.state.TraditionalLiquorData[2].tl_img" class="tl_type_img">
                    <div class="tl_type">{{ $store.state.TraditionalLiquorData[2].tl_title }}</div>
                    <p class="tl_type_content">{{ $store.state.TraditionalLiquorData[2].tl_content }}</p>
                </div>
            </swiper-slide>
            <!-- <swiper-slide>
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
            </swiper-slide> -->
        </swiper>
    </main>
</template>

<script setup>
    import { Swiper, SwiperSlide } from 'swiper/vue';
    import 'swiper/css';
    import 'swiper/css/pagination';
    import 'swiper/css/navigation';
    import { Navigation } from 'swiper/modules';

    import { onBeforeMount } from 'vue';
    import { useStore } from 'vuex';

    const modules = [Navigation];

    const store = useStore();

    onBeforeMount(() => {
        if(store.state.TraditionalLiquorData.length < 1) {
            store.dispatch('getTraditionalLiquorData');
        }
    })
</script>

<style scoped src="../css/traditionalliquor.css">
</style>
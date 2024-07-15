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
            <swiper-slide>
                <div class="tl_box">
                    <img :src="$store.state.TraditionalLiquorData[3].tl_img" class="tl_type_img">
                    <div class="tl_type">{{ $store.state.TraditionalLiquorData[3].tl_title }}</div>
                    <p class="tl_type_content">{{ $store.state.TraditionalLiquorData[3].tl_content }}</p>
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
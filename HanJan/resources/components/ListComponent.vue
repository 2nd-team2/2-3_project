<template>
    <body>
        <div>
            <div class="list_main_img" style="background-image: url('/img/list_img03.png');"></div>
            <div class="list_menu">
                <router-link to="/list">
                    <button type="submit" class="list_menu_img">
                        <img src="/img/menu01.png" alt="탁주">
                        <p>탁주</p>
                    </button>
                </router-link>
                <div class="list_line"></div>
                <router-link to="/list">
                    <button type="submit" class="list_menu_img">
                        <img src="/img/menu02.png" alt="과실주">
                        <p>과실주</p>
                    </button>
                </router-link>
                <div class="list_line"></div>
                <router-link to="/list">
                    <button type="submit" class="list_menu_img">
                        <img src="/img/menu03.png" alt="중류주">
                        <p>증류주</p>
                    </button>
                </router-link>
            </div>
            <p class="list_best_title">한잔 베스트</p>
            <div class="list_best">
                <router-link to="/detailed">
                    <p class="list_best_rank">1</p>
                    <!-- <img :src="item.img"> -->
                    <div class="list_best_detail">
                        <p></p>
                        <strong>원</strong>
                    </div>
                </router-link>
                <router-link to="/detailed">
                    <p class="list_best_rank">2</p>
                    <!-- <img :src="item.img"> -->
                    <div class="list_best_detail">
                        <p></p>
                        <strong>원</strong>
                    </div>
                </router-link>
                <router-link to="/detailed">
                    <p class="list_best_rank">3</p>
                    <!-- <img :src="item.img"> -->
                    <div class="list_best_detail">
                        <p></p>
                        <strong>원</strong>
                    </div>
                </router-link>
                <router-link to="/detailed">
                    <p class="list_best_rank">4</p>
                    <!-- <img :src="item.img"> -->
                    <div class="list_best_detail">
                        <p></p>
                        <strong>원</strong>
                    </div>
                </router-link>
                <router-link to="/detailed">
                    <p class="list_best_rank">5</p>
                    <!-- <img :src="item.img"> -->
                    <div class="list_best_detail">
                        <p></p>
                        <strong>원</strong>
                    </div>
                </router-link>
            </div>
            <hr>
            <div class="list_content">
                <!-- 저장 -->
                <div class="list_best" v-for="(item, key) in $store.state.listData" :key="key">
                    <!-- 상세페이지 디테일로 이동하는 이벤트 넣어주기 -->
                    <div @click="productDetail(item.id)"> 
                        <img :src="item.img">
                        <div class="list_best_detail">
                            <p>{{ item.name }}</p>
                            <strong>{{ item.price }}원</strong>
                        </div>
                    </div>
                </div>
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
        </div>
        <!-- move top -->
        <a href="#" class="move_top">
            <img src="/img/up.png" class="move_top_img">
        </a>
    </body>
</template>

<script setup>
    import { onBeforeMount } from 'vue';
    import { useStore } from 'vuex';
    import router from '../js/router';

    const store = useStore();
    
    onBeforeMount(() => {
        // if(store.state.listData.length < 1) {
        //     store.dispatch('getList');
        // }
        store.dispatch('getList');
    })

    function productDetail(id) {
        // store.commit('detailedNumData', item);
        // store.dispatch('setProductDetailData', id);
        router.push('/detailed?id='+id);
    }
</script>

<style scoped src="../css/list.css">
</style>
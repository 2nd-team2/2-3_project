<template>
    <body>
        <div>
            <div class="list_main_img" :style="{ 'background-image': 'url(' + $store.state.currentImage + ')' }"></div>
            <div class="list_menu">
                <router-link to="/list?type=0&page=1" class="list_menu_img" @click="changeImage('/img/list_img01.png')" >
                    <img src="/img/menu01.png" alt="탁주">
                    <p>탁주</p>
                </router-link>
                <div class="list_line"></div>
                <router-link to="/list?type=1&page=1" class="list_menu_img" @click="changeImage('/img/list_img02.png')">
                    <img src="/img/menu02.png" alt="과실주">
                    <p>과실주</p>
                </router-link>
                <div class="list_line"></div>
                <router-link to="/list?type=2&page=1" class="list_menu_img" @click="changeImage('/img/list_img03.png')">
                    <img src="/img/menu03.png" alt="중류주">
                    <p>증류주</p>
                </router-link>
            </div>
            <p class="list_best_title">한잔 베스트</p>
            <!-- 저장 -->
            <div class="list_content">
                <div class="list_best" v-for="(item, index) in $store.state.bastData.slice(0, 5)" :key="item.id">
                    <p class="list_best_rank">{{ index + 1 }}</p>
                    <div @click="bastDetail(item.id)"> 
                        <img :src="item.img">
                        <div class="list_best_detail">
                            <p>{{ item.name }}</p>
                            <strong>{{ formatPrice(item.price) }}원</strong>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="list_content" id="stop">
                <!-- 저장 -->
                <div class="list_best" v-for="(item, key) in $store.state.listData.data" :key="key">
                    <div @click="productDetail(item.id)"> 
                        <img :src="item.img">
                        <div class="list_best_detail">
                            <p>{{ item.name }}</p>
                            <strong>{{ formatPrice(item.price) }}원</strong>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 페이지네이션 -->
            <div class="list_num_item">
                <a href="#" class="before" @click.prevent="prevPage()">〈 이전</a>
                <a
                    v-for="page in pages"
                    :key="page"
                    href="#"
                    :class="{'num': page === $store.state.listData.current_page, 'num_none': page !== $store.state.listData.current_page}"
                    @click.prevent="goToPage(page)">
                    {{ page }}
                </a>
                <a href="#" class="next" @click.prevent="nextPage()">다음 〉</a>
            </div>
        </div>
        <!-- move top -->
        <a href="#" class="move_top">
            <img src="/img/up.png" class="move_top_img">
        </a>
    </body>
</template>

<script setup>
    import { onBeforeMount, computed } from 'vue';
    import { useStore } from 'vuex';
    import router from '../js/router';
    import { onBeforeRouteUpdate } from 'vue-router';

    const store = useStore();
    
    onBeforeMount(() => {
        // if(store.state.listData.current_page == 1) {
        //     store.dispatch('getList', 1);
        // }
        store.dispatch('productBastDetail');
    });
    
    function bastDetail(id) {
        router.push('/detailed?id='+id);
    }
    function productDetail(id) {
        router.push('/detailed?id='+id);
    }

    onBeforeRouteUpdate((to, from) => {
        console.log('onBeforeRouteUpdate', to.query);
        store.commit('setCurrentImage', to.query.type);
        store.dispatch('getList', to.query);
    });

    // 페이지네이션

    // 게시물 데이터 가져오기
    // console.log('listData:',posts);

    // 페이지 번호 배열 계산
    const pages = computed(() => {
        const pageArray = [];
        // 페이지네이션 5개
        const maxPagesToShow = 5;

        let startPage = store.state.listData.current_page - 2;
        if(startPage < 1) {
            startPage = 1;
        }
        const endPage = startPage + maxPagesToShow - 1;

        // 시작페이지 구하기
        const pagingStart = (startPage <= (store.state.listData.last_page - maxPagesToShow + 1) || (store.state.listData.last_page - maxPagesToShow + 1) < 1) ? startPage : (store.state.listData.last_page - maxPagesToShow + 1);
        
        // 마지막 페이지 구하기
        const pagingEnd = endPage > store.state.listData.last_page ? store.state.listData.last_page : endPage;

        for (let i = pagingStart; i <= pagingEnd; i++) {
            pageArray.push(i)
        }
        return pageArray
    })

    // 특정 페이지로 이동
    function goToPage(page) {
        router.replace('/list?type='+ store.state.listData.type +'&page=' + page);
        // store.dispatch('getList', {'type': posts.value.type, 'page': page});
    }

    // 이전 페이지로 이동
    function prevPage() {
        if (store.state.listData.current_page > 1) {
            goToPage(store.state.listData.current_page - 1);
        }
    }

    // 다음 페이지로 이동
    function nextPage() {
        if (store.state.listData.current_page < store.state.listData.last_page) {
            goToPage(store.state.listData.current_page + 1);
        }
    }

    // 금액 천단위 포맷 (,000)
    function formatPrice(price) {
        return price.toLocaleString('ko-KR');
    }
</script>

<style scoped src="../css/list.css">
</style>
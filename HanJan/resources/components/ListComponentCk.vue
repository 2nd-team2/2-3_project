<template>
    <body>
        <div>
            <div class="list_main_img" :style="{ 'background-image': 'url(' + $store.state.currentImage + ')' }"></div>

            <!-- 검색 -->
            <!-- 검색했을때 타입을 가져와 추천카테고리에 5개만 불러오기 -->
            <form name="form" onsubmit="return false">
                <div class="list_search">
                    <input type="text" class="list_search_text" placeholder="검색어를 입력해주세요" v-model="data.search">
                    <div class="list_search_img" @click="search"><img src="/img/search.png"></div>
                    <!-- 추천카테고리 : 타입별 추천 리스트 불러오기 5개씩 -->
                </div>
                <ul class="list_proposal">
                    <span>인기 주류 :</span>
                    <li class="list_pro_mun" v-for="(item, key) in $store.state.typeChk.data" :key="key.id">
                        <div @click="productDetail(item.id)">{{ item.name }}</div>
                    </li>
                </ul>
            </form>
            
            <!-- 메뉴 -->
            <div class="list_menu">
                <router-link to="/listck?type=99&page=1" class="list_menu_img">
                    <img src="/img/otter2.png" alt="전체" class="list_menu_img99">
                    <p :class="{list_name_bk:isType99}">전체주류</p>
                </router-link>
                <div class="list_line"></div>
                <router-link to="/listck?type=0&page=1" class="list_menu_img">
                    <img src="/img/menu01.png" alt="탁주">
                    <p :class="{list_name_bk:isType0}">탁주</p>
                </router-link>
                <div class="list_line"></div>
                <router-link to="/listck?type=1&page=1" class="list_menu_img">
                    <img src="/img/menu02.png" alt="과실주">
                    <p :class="{list_name_bk:isType1}">과실주</p>
                </router-link>
                <div class="list_line"></div>
                <router-link to="/listck?type=2&page=1" class="list_menu_img">
                    <img src="/img/menu03.png" alt="중류주">
                    <p :class="{list_name_bk:isType2}">증류주</p>
                </router-link>
                <div class="list_line"></div>
                <router-link to="/listck?type=3&page=1" class="list_menu_img">
                    <img src="/img/menu04.png" alt="중류주">
                    <p :class="{list_name_bk:isType3}">약·청주</p>
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

            <h3 class="list_content_cut">총 {{ $store.state.searchListData.total }}개의 주류가 있습니다.</h3>
            <div class="list_content" id="stop">
                <!-- 저장 -->
                <div class="list_best" v-for="(item, key) in $store.state.searchListData.data" :key="key">
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
                    :class="{'num': page === $store.state.searchListData.current_page, 'num_none': page !== $store.state.searchListData.current_page}"
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
    import { onBeforeMount, computed, ref, reactive  } from 'vue';
    import { useStore } from 'vuex';
    import router from '../js/router';
    import { onBeforeRouteUpdate } from 'vue-router';

    const store = useStore();
    const isType0 = ref(false);
    const isType1 = ref(false);
    const isType2 = ref(false);
    const isType3 = ref(false);
    const isType99 = ref(false);
    
    const data = reactive({
        type: '99',
        page: '',
        search: localStorage.getItem('searchword'),
    });

    onBeforeMount(() => {
        // if(store.state.listData.current_page == 1) {
        //     store.dispatch('getList', 1);
        // }
        store.dispatch('productBastDetail');
        store.dispatch('typeChkList');
    });
    
    function bastDetail(id) {
        router.push('/detailed?id='+id);
    }
    function productDetail(id) {
        router.push('/detailed?id='+id);
    }

    onBeforeRouteUpdate((to, from) => {
        data.type = to.query.type;
        data.page = to.query.page;
        store.dispatch('searchList', data);
        // console.log('onBeforeRouteUpdate', to.query);
        store.commit('setCurrentImage', to.query.type);
        // store.dispatch('getList', to.query);

        if(to.query.type == '0') {
            isType0.value = true;
            isType1.value = false;
            isType2.value = false;
            isType3.value = false;
            isType99.value = false;
        } else if(to.query.type == '1') {
            isType0.value = false;
            isType1.value = true;
            isType2.value = false;
            isType3.value = false;
            isType99.value = false;
        } else if(to.query.type == '2') {
            isType0.value = false;
            isType1.value = false;
            isType2.value = true;
            isType3.value = false;
            isType99.value = false;
        } else if(to.query.type == '3') {
            isType0.value = false;
            isType1.value = false;
            isType2.value = false;
            isType3.value = true;
            isType99.value = false;
        } else if(to.query.type == '99') {
            isType0.value = false;
            isType1.value = false;
            isType2.value = false;
            isType3.value = false;
            isType99.value = true;
        }
        
    });
    
    
    // function changeImage () {
//         backgroundColor.value = 'rgba(250, 201, 29, 0.3)';
    // }

    // 페이지네이션

    // 게시물 데이터 가져오기
    // console.log('listData:',pages);

    // 페이지 번호 배열 계산
    const pages = computed(() => {
        const pageArray = [];
        // 페이지네이션 5개
        const maxPagesToShow = 5;

        // let startPage = store.state.listData.current_page - 2;
        let startPage = store.state.searchListData.last_page <5 ? 1 : store.state.searchListData.current_page - 2;
        if(startPage < 1) {
            startPage = 1;
        }
        const endPage = startPage + maxPagesToShow - 1;

        // 시작페이지 구하기
        const pagingStart = (startPage <= (store.state.searchListData.last_page - maxPagesToShow + 1) || (store.state.searchListData.last_page - maxPagesToShow + 1) < 1) ? startPage : (store.state.searchListData.last_page - maxPagesToShow + 1);
        
        // 마지막 페이지 구하기
        const pagingEnd = endPage > store.state.searchListData.last_page ? store.state.searchListData.last_page : endPage;

        for (let i = pagingStart; i <= pagingEnd; i++) {
            pageArray.push(i)
        }
        return pageArray
    })

    // 특정 페이지로 이동
    function goToPage(page) {
        data.page = page;
        store.dispatch('searchList', data);
        // router.replace('/listck?search=' + data.search + '&type=' + data.type +'&page=' + page);
        // store.dispatch('getList', {'type': posts.value.type, 'page': page});
    }

    // 이전 페이지로 이동
    function prevPage() {
        if (store.state.searchListData.current_page > 1) {
            goToPage(store.state.searchListData.current_page - 1);
        }
    }

    // 다음 페이지로 이동
    function nextPage() {
        if (store.state.searchListData.current_page < store.state.searchListData.last_page) {
            goToPage(store.state.searchListData.current_page + 1);
        }
    }

    // 금액 천단위 포맷 (,000)
    function formatPrice(price) {
        return price.toLocaleString('ko-KR');
    }
    
    // 검색추가
    function search() {
        // data.type = 99;
        data.page = 1;
        store.dispatch('searchList', data);
    }
    // 엔터키 막기
    document.addEventListener('keydown', function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
        };
    }, true);
</script>

<style scoped src="../css/list.css">
</style>
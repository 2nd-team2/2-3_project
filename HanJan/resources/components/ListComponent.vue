<template>
    <body>
        <div>
            <div class="list_main_img" :style="{ 'background-image': 'url(' + $store.state.currentImage + ')' }"></div>

            <!-- 검색 -->
            <form name="form" onsubmit="return false">
                <div class="list_search">
                    <input type="text" class="list_search_text" placeholder="검색어를 입력해주세요" v-model="data.search">
                    <div class="list_search_img" @click="search"><img src="/img/search.png"></div>
                </div>
            </form>
            
            <!-- 메뉴 -->
            <div class="list_menu">
                <router-link to="/list?type=99&page=1" class="list_menu_img">
                    <img src="/img/otter2.png" alt="전체" class="list_menu_img99">
                    <p :class="{list_name_bk:isType99}">전체주류</p>
                </router-link>
                <div class="list_line"></div>
                <router-link to="/list?type=0&page=1" class="list_menu_img">
                    <img src="/img/menu01.png" alt="탁주">
                    <p :class="{list_name_bk:isType0}">탁주</p>
                </router-link>
                <div class="list_line"></div>
                <router-link to="/list?type=1&page=1" class="list_menu_img">
                    <img src="/img/menu02.png" alt="과실주">
                    <p :class="{list_name_bk:isType1}">과실주</p>
                </router-link>
                <div class="list_line"></div>
                <router-link to="/list?type=2&page=1" class="list_menu_img">
                    <img src="/img/menu03.png" alt="중류주">
                    <p :class="{list_name_bk:isType2}">증류주</p>
                </router-link>
                <div class="list_line"></div>
                <router-link to="/list?type=3&page=1" class="list_menu_img">
                    <img src="/img/menu04.png" alt="중류주">
                    <p :class="{list_name_bk:isType3}">약·청주</p>
                </router-link>
            </div>

            <!-- 드롭다운 -->
            <!-- <input type="checkbox" name="test" id="" value="1" v-model="testChk">
            <span>1</span>
            <input type="checkbox" name="test" id="" value="2" v-model="testChk">
            <span>2</span>
            <input type="checkbox" name="test" id="" value="3" v-model="testChk">
            <span>3</span>
            <p>{{  testChk }}</p> -->
            <!-- <div id="list_app">
                <div class="list_menu-bar">
                    <div class="list_dropdown" v-for="(dropdown, index) in dropdowns" :key="index">
                        <button class="list_dropdown-toggle" @click="toggleDropdown(index)">{{ dropdown.label }}</button>
                        <div v-if="dropdown.isOpen" class="list_dropdown-menu" @click.stop>
                            <label v-for="option in dropdown.options" :key="option.value" class="list_dropdown-item">
                                <input type="checkbox" v-model="dropdown.selectedOptions" :value="option.value" />
                                {{ option.label }}
                            </label>
                        </div>
                    </div>
                </div>
                <div class="selected-options">
                    <div v-for="(option, index) in selectedKeywords" :key="index" class="selected-option">
                        {{ option.label }}
                        <button @click="removeOption(option.value)">×</button>
                    </div>
                </div>
            </div> -->

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

            <h3 class="list_content_cut">총 {{ $store.state.listData.total }}개의 주류가 있습니다.</h3>
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

    import { onBeforeMount, computed, ref, watch  } from 'vue';
    import { useStore } from 'vuex';
    import router from '../js/router';
    import { onBeforeRouteUpdate } from 'vue-router';
    const store = useStore();
    const isType0 = ref(false);
    const isType1 = ref(false);
    const isType2 = ref(false);
    const isType3 = ref(false);
    const isType99 = ref(false);
    
    const data = {
        type: '',
        page: '',
        search: '',
    };
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
        // console.log('onBeforeRouteUpdate', to.query);
        store.commit('setCurrentImage', to.query.type);
        store.dispatch('getList', to.query);

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
    // console.log('listData:',posts);

    // 페이지 번호 배열 계산
    const pages = computed(() => {
        const pageArray = [];
        // 페이지네이션 5개
        const maxPagesToShow = 5;

        // let startPage = store.state.listData.current_page - 2;
        let startPage = store.state.listData.last_page <5 ? 1 : store.state.listData.current_page - 2;
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

    // 드롭다운
    // const dropdowns = ref([
    //     {
    //         label: '주종',
    //         isOpen: false,
    //         selectedOptions: [],
    //         options: [
    //             { value: '1', label: '탁주' },
    //             { value: '2', label: '약 . 청주' },
    //             { value: '3', label: '과실주' },
    //             { value: '4', label: '증류주' },
    //             { value: '5', label: '기타주' },
    //         ],
    //     },
    //     {
    //         label: '도수',
    //         isOpen: false,
    //         selectedOptions: [],
    //         options: [
    //             { value: '0-10', label: '0%-10%' },
    //             { value: '10-20', label: '10%-20%' },
    //             { value: '20-30', label: '20%-30%' },
    //             { value: '30+', label: '30%이상' },
    //         ],
    //     },
    //     {
    //         label: '가격대',
    //         isOpen: false,
    //         selectedOptions: [],
    //         options: [
    //             { value: '0-10000', label: '10,000원 미만' },
    //             { value: '10000-50000', label: '10,000원 - 50,000원' },
    //             { value: '50000-100000', label: '50,000원 - 100,000원' },
    //             { value: '100000+', label: '100,000원 이상' },
    //         ],
    //     },
    // ]);

    // const toggleDropdown = (index) => {
    //     dropdowns.value[index].isOpen = !dropdowns.value[index].isOpen;
    //     dropdowns.value.forEach((dropdown, i) => {
    //         if (i !== index) {
    //             dropdown.isOpen = false;
    //         }
    //     });
    // };

    // const selectedKeywords = computed(() => {
    //     return dropdowns.value.flatMap(dropdown => {
    //         return dropdown.selectedOptions.map(value => {
    //             const option = dropdown.options.find(opt => opt.value === value);
    //             return {
    //                 value,
    //                 label: option.label
    //             };
    //         });
    //     });
    // });

    // const removeOption = (value) => {
    //     dropdowns.value.forEach(dropdown => {
    //         const index = dropdown.selectedOptions.indexOf(value);
    //         if (index !== -1) {
    //             dropdown.selectedOptions.splice(index, 1);
    //         }
    //     });
    // };

    // const applyFilters = () => {
    //     const filters = {};
    //     dropdowns.value.forEach(dropdown => {
    //         if (dropdown.selectedOptions.length) {
    //             filters[dropdown.label] = dropdown.selectedOptions;
    //         }
    //     });
    //     store.dispatch('fetchFilteredData', filters);
    // };

    // 검색추가
    function search() {
        data.type = 99;
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
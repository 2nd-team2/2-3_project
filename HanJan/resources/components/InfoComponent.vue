<template>
    <main>
        <div class="container">
            <div class="order_list">
                <div class="order_list_header">
                    <h1>주문목록</h1>
                    <div class="order_list_button">
                        <router-link to="/list?type=99&page=1" class="keep_shoping_btn black_button">계속 쇼핑하기</router-link>
                        <router-link to="/review" class="shoping_btn review_manage_btn black_button">리뷰관리</router-link>
                        <router-link to="/confirm" class="user_update_btn black_button">회원정보 수정</router-link>
                    </div>
                </div>
                <div class="order_list_main">
                    
                    <div class="order_item" v-for="(item, key) in $store.state.infoData.data" :key="key" v-if="$store.state.infoData.data && $store.state.infoData.data.length > 0">
                        <!-- <div>{{ item }}</div> -->
                        <!-- <div>{{ item }}</div> -->
                        <div class="item_left_list_text">
                            <div class="order_date">
                                <span class="title_span">{{ item.orpDate }}</span>
                                <span class="title_span" v-if="item.co_flg === '1'"> / 구매확정 : </span>
                                <span class="yellow_span" v-if="item.co_flg === '1'">{{ item.completeOn }}</span>
                            </div>
                            <button class="order_delete" @click="$store.dispatch('orderItemDelete', item.itemId)" v-if="item.co_flg === '1'"></button>
                            <img class="order_img" :src="item.img"></img>
                            <p class="order_name">{{ item.name + ' ' + item.ml +'ml' }}</p>
                            <p class="order_price">{{ '금액 : ' + item.price + '원 / ' + item.orp_count + '개' }}</p>
                            <button class="button_a" @click="$store.dispatch('completeBtn', item.id)" v-if="item.co_flg === '0' || item.co_flg === null">구매확정</button>
                        </div>
                        <div class="item_right">
                            <button @click="askProduct(item)" class="button_a" v-if="item.co_flg === '0' || item.co_flg === null">상품문의하기</button> 
                            <button @click="exchange(item)" class="button_a" v-if="item.co_flg === '0' || item.co_flg === null">교환, 반품 신청</button>
                            
                            <button @click="infoReviewCreate(item)" type="button" class="button_a" v-if="item.co_flg === '1'">리뷰 작성하기</button>
                        </div>
                    </div>
                    <div v-else>
                        <h2>
                            주문 상품이 없습니다.
                        </h2>
                    </div>
                    <!-- 페이지네이션 -->
                    <div class="list_num_item">
                        <a href="#" class="before" @click.prevent="prevPage()">〈 이전</a>
                        <a
                            v-for="page in pages"
                            :key="page"
                            href="#"
                            :class="{'num': page === $store.state.infoData.current_page, 'num_none': page !== $store.state.infoData.current_page}"
                            @click.prevent="goToPage(page)"
                            >{{ page }}
                        </a>
                        <a href="#" class="next" @click.prevent="nextPage()">다음 〉</a>
                    </div>
                </div>
            </div>
            <div class="inquiry_list">
                <div class="inquiry_list_header">
                    <h1>상품문의 내역</h1>
                </div>
                <div class="inquiry_list_main" v-for="(item, key) in $store.state.productAskData.data" :key="key" v-if="$store.state.productAskData.data && $store.state.productAskData.data.length > 0">
                    <!-- <div>{{ item }}</div> -->
                    <div class="inquiry_item" >
                        <div class="inquiry_item_left_list_text">
                            <div>
                                <span class="title_span">상품문의</span>
                            </div>
                            <!-- <div class="inquiry_img" :src="item.img"></div> -->
                            <p class="inquiry_name cursorBtn" @click=qnaProductDetail(item.qnp_id)>{{ item.qnp_content }}</p>
                            <p class="inquiry_date">{{ item.created_at }}</p>
                        </div>
                        <div class="inquiry_item_right_list">
                            <button type="submit" class="inquiry_delete" @click="$store.dispatch('productAskDelete', item.qnp_id)"></button>
                            <div class="keep_shoping_btn qna_answer_complete" v-if="item.qnp_answer">답변완료</div>
                            <div class="keep_shoping_btn qna_answer" v-else>답변진행중</div>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <h2>
                        상품문의 내역이 없습니다.
                    </h2>
                </div>
                <!-- 페이지네이션 -->
                <div class="list_num_item">
                    <a href="#" class="before" @click.prevent="productPrevPage()">〈 이전</a>
                    <a
                        v-for="productpage in productsPages"
                        :key="productpage"
                        href="#"
                        :class="{'num': productpage === $store.state.productAskData.current_page, 'num_none': productpage !== $store.state.productAskData.current_page}"
                        @click.prevent="productGoToPage(productpage)"
                        >{{ productpage }}
                    </a>
                    <a href="#" class="next" @click.prevent="productNextPage()">다음 〉</a>
                </div>
                <div class="inquiry_list_header">
                    <h1>1:1문의 내역</h1>
                    <router-link to="/qnaonebyonecreate" class="keep_shoping_btn black_button">
                        1:1 문의하기
                    </router-link>
                </div>
                <div class="inquiry_list_main" v-for="(item, key) in $store.state.askSetData.data" :key="key" v-if="$store.state.askSetData.data && $store.state.askSetData.data.length > 0">
                    <!-- <div>{{ item }}</div> -->
                    <div class="inquiry_item">
                        <div class="inquiry_item_left_list_text">
                            <div class="inquiry_text">
                                <span class="title_span">1:1 문의</span>
                            </div>
                            <div class="inquiry_div">
                            </div>
                            <p class="inquiry_name cursorBtn" @click=qnaOneByOneDetail(item.qn_id)>{{ item.qn_content }}</p>
                            <p class="one_date">{{ item.created_at }}</p>
                        </div>
                        <div class="inquiry_item_right_list">
                            <button type="submit" class="inquiry_delete" @click="$store.dispatch('askDelete', item.qn_id)"></button>
                            <div class="in_progress qna_answer" v-if="item.qn_answer">답변완료</div>
                            <div class="in_progress qna_answer" v-else>답변진행중</div>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <h2>
                        1:1문의 내역이 없습니다.
                    </h2>
                </div>
                <!-- 페이지네이션 -->
                <div class="list_num_item">
                    <a href="#" class="before" @click.prevent="oneByOnePrevPage()">〈 이전</a>
                    <a
                        v-for="oneByOnepage in oneByOnePages"
                        :key="oneByOnepage"
                        href="#"
                        :class="{'num': oneByOnepage === $store.state.askSetData.current_page, 'num_none': oneByOnepage !== $store.state.askSetData.current_page}"
                        @click.prevent="oneByOneGoToPage(oneByOnepage)"
                        >{{ oneByOnepage }}
                    </a>
                    <a href="#" class="next" @click.prevent="oneByOneNextPage()">다음 〉</a>
                </div>
            </div>
        </div>
    </main>
    <!-- move top -->
    <a href="#" class="move_top">
        <img src="/img/up.png" class="move_top_img">
    </a>
</template>

<script setup>
    import { onBeforeMount ,computed } from 'vue';
    import { useStore } from 'vuex';
    import router from '../js/router';

    const store = useStore();

    // 초기 데이터
    onBeforeMount(() => {
        // 상품문의 내역 데이터
        if(store.state.infoData.current_page == 1) {
            store.dispatch('getInfoData', 1);
        }

        // 상품문의 내역 데이터
        if(store.state.productAskData.current_page == 1) {
            store.dispatch('getProductAskData', 1);
        }

        // 1:1 문의 내역 데이터
        if(store.state.askSetData.current_page == 1) {
            store.dispatch('getAskData', 1);
        }
    })

    // 상품문의 하는 페이지 이동
    function askProduct(item) {
        store.commit('setProductAskCreateData', item);
        router.push('/qnaproductcreate');
    }

    // 리뷰 작성하기 페이지로 정보 넘기기
    function infoReviewCreate(item) {
        store.commit('setProductAskCreateData', item);
        router.push('/reviewcreate');
    }

    // const infoReviewCreate = (item) => {
    //     store.dispatch('infoReviewCreate', item);
    // }
    // 교환반품 이동
    const exchange = (orp_id) => {
        router.push('/exchange?id=' + orp_id);
    }
    // 상품문의 디테일 페이지 이동
    function qnaProductDetail(id) {
            router.push('/qnaproductdetail?id=' + id);
    }
    // 1:1 문의 디테일 페이지 이동
    function qnaOneByOneDetail(id) {
        router.push('/qnaonebyonedetail?id=' + id);
    }

    // 주문 목록 페이지네이션
    // 페이지 번호 배열 계산
    const pages = computed(() => {
        const pageArray = [];
        // 페이지네이션 5개
        const maxPagesToShow = 5;

        let startPage = store.state.infoData.current_page - 2;
        if(startPage < 1) {
            startPage = 1;
        }
        const endPage = startPage + maxPagesToShow - 1;

        // 시작페이지 구하기
        const pagingStart = startPage <= (store.state.infoData.last_page - maxPagesToShow + 1) || ((store.state.infoData.last_page - maxPagesToShow + 1) < 1) ? startPage : (store.state.infoData.last_page - maxPagesToShow + 1);
        
        // 마지막 페이지 구하기
        const pagingEnd = endPage > store.state.infoData.last_page ? store.state.infoData.last_page : endPage;

        for (let i = pagingStart; i <= pagingEnd; i++) {
            pageArray.push(i)
        }
        return pageArray
    })

    // 특정 페이지로 이동
    function goToPage(page) {
        store.dispatch('getInfoData', page);
    }

    // 이전 페이지로 이동
    function prevPage() {
        if (store.state.infoData.current_page > 1) {
            goToPage(store.state.infoData.current_page - 1);
        }
    }

    // 다음 페이지로 이동
    function nextPage() {
        if (store.state.infoData.current_page < store.state.infoData.last_page) {
            goToPage(store.state.infoData.current_page + 1);
        }
    }

    // 상품문의 페이지네이션

    // 게시물 데이터 가져오기
    // const products = computed(() => store.state.askSetData)
    // 페이지 번호 배열 계산
    const productsPages = computed(() => {
        const pageArray = [];
        // 페이지네이션 3개
        const maxPagesToShow = 5;

        let startPage = store.state.productAskData.current_page - 2;
        if(startPage < 1) {
            startPage = 1;
        }
        const endPage = startPage + maxPagesToShow - 1;

        // 시작페이지 구하기
        const pagingStart = startPage <= (store.state.productAskData.last_page - maxPagesToShow + 1) || ((store.state.productAskData.last_page - maxPagesToShow + 1) < 1) ? startPage : (store.state.productAskData.last_page - maxPagesToShow + 1);
        
        // 마지막 페이지 구하기
        const pagingEnd = endPage > store.state.productAskData.last_page ? store.state.productAskData.last_page : endPage;

        for (let i = pagingStart; i <= pagingEnd; i++) {
            pageArray.push(i)
        }
        return pageArray
    })

    // 특정 페이지로 이동
    function productGoToPage(page) {
        store.dispatch('getProductAskData', page);
    }

    // 이전 페이지로 이동
    function productPrevPage() {
        if (store.state.productAskData.current_page > 1) {
            productGoToPage(store.state.productAskData.current_page - 1);
        }
    }

    // 다음 페이지로 이동
    function productNextPage() {
        if (store.state.productAskData.current_page < store.state.productAskData.last_page) {
            productGoToPage(store.state.productAskData.current_page + 1);
        }
    }

    // 1:1문의 페이지네이션

    // 게시물 데이터 가져오기
    // const oneByOne = computed(() => store.state.askSetData)
    // 페이지 번호 배열 계산
    const oneByOnePages = computed(() => {
        const pageArray = [];
        // 페이지네이션 3개
        const maxPagesToShow = 5;

        let startPage = store.state.askSetData.current_page - 2;
        if(startPage < 1) {
            startPage = 1;
        }
        const endPage = startPage + maxPagesToShow - 1;

        // 시작페이지 구하기
        const pagingStart = startPage <= (store.state.askSetData.last_page - maxPagesToShow + 1) || ((store.state.askSetData.last_page - maxPagesToShow + 1) < 1) ? startPage : (store.state.askSetData.last_page - maxPagesToShow + 1);
        
        // 마지막 페이지 구하기
        const pagingEnd = endPage > store.state.askSetData.last_page ? store.state.askSetData.last_page : endPage;

        for (let i = pagingStart; i <= pagingEnd; i++) {
            pageArray.push(i)
        }
        return pageArray
    })

    // 특정 페이지로 이동
    function oneByOneGoToPage(page) {
        store.dispatch('getAskData', page);
    }

    // 이전 페이지로 이동
    function oneByOnePrevPage() {
        if (store.state.askSetData.current_page > 1) {
            oneByOneGoToPage(store.state.askSetData.current_page - 1);
        }
    }

    // 다음 페이지로 이동
    function oneByOneNextPage() {
        if (store.state.askSetData.current_page < store.state.askSetData.last_page) {
            oneByOneGoToPage(store.state.askSetData.current_page + 1);
        }
    }
</script>

<style scoped src="../css/info.css">
</style>
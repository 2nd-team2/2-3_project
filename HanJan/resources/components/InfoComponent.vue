<template>
    <main>
        <div class="container">
            <div class="order_list">
                <div class="order_list_header">
                    <h2>주문목록</h2>
                    <div class="order_list_button">
                        <router-link to="/list?type=99&page=1" class="keep_shoping_btn black_button">계속 쇼핑하기</router-link>
                        <router-link to="/review" class="shoping_btn review_manage_btn black_button">리뷰관리</router-link>
                        <router-link to="/confirm" class="user_update_btn black_button">회원정보 수정</router-link>
                    </div>
                </div>
                <div class="order_list_main">
                    <div class="order_item" v-for="(item, key) in $store.state.infoData.data" :key="key" v-if="$store.state.infoData.data && $store.state.infoData.data.length > 0">
                        <!-- <div>{{item }}</div> -->
                        <div class="item_left_list_text">
                            <span class="title_span">{{ formatDate(item.orpDate) }}
                                <span class="order_date">
                                    <span class="title_span" v-if="item.co_flg === '1'">/&emsp;구매확정 : </span>
                                    <span class="yellow_span" v-if="item.co_flg === '1'">{{ formatDate(item.completeOn) }}</span>
                                </span>                            
                            </span>
                            <div class="order_delete" @click=deleteUser(item.orp_id) v-if="item.co_flg === '1'"></div>
                            <img class="order_img" :src="item.img" @click="redirectToDetailedPage(item.p_id)">
                            <p class="order_name">{{ item.name + ' ' + item.ml +'ml' }}</p>
                            <p class="order_price">{{ '금액 : ' + formatPrice(item.price) + '원 / ' + item.orp_count + '개' }}</p>
                            <div class="button_a complete_btn" @click="$store.dispatch('completeBtn', item.orp_id)" v-if="item.co_flg === '0' || item.co_flg === null">구매확정</div>
                        </div>
                        <div class="item_right">
                            <div @click="askProduct(item)" class="button_a">상품문의하기</div>
                            <div>
                                <div @click="exchange(item.orp_id)" class="button_a" v-if="item.ex_flg === '0'">교환, 반품 신청</div>
                                <div class="button_b button_complete_color" v-else-if="item.ex_flg === '1'">교환, 반품 신청 완료</div>
                                <div class="button_b" v-else-if="item.ex_flg === '2'">상품 회수중</div>
                                <div class="button_b" v-else-if="item.ex_flg === '3'">교환, 반품 처리 완료</div>
                            </div>
                            <div @click="infoReviewCreate(item)" type="button" class="button_a" v-if="item.re_id === null && item.co_flg === '1'">리뷰 작성하기</div>
                            <div type="button" class="button_b button_complete_color" v-else-if="item.re_id">리뷰 작성 완료</div>
                        </div>
                        <transition name="down">
                        <div class="agree_box modal_second_overlay" v-show="showDeleteModal">
                            <div class="modal_second_window">
                                <div class="second_content">
                                    <p class="second_content">확인을 누르면 구매한 상품이 삭제됩니다.</p>
                                    <br>
                                    <div>
                                        <button type="button" @click="confirmDelete" class="modal_btn">확인</button>
                                        <button type="button" @click="closeDeleteModal" class="modal_btn">취소</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </transition>
                    </div>
                    <div v-else>
                        <h2 class="h2_center">
                            주문 상품이 없습니다.
                        </h2>
                    </div>
                    <!-- 페이지네이션 -->
                    <div class="list_num_item" v-if="$store.state.infoData.data && $store.state.infoData.data.length > 0">
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
                    <div v-else></div>
                </div>
            </div>
            <div class="inquiry_list">
                <div class="inquiry_list_header">
                    <h2>상품문의 내역</h2>
                </div>
                <div class="inquiry_list_main" v-for="(item, key) in $store.state.productAskData.data" :key="key" v-if="$store.state.productAskData.data && $store.state.productAskData.data.length > 0">
                    <div class="inquiry_item" >
                        <div class="inquiry_item_left_list_text">
                            <div>
                                <span class="title_span">상품문의</span>
                            </div>
                            <p class="inquiry_name cursorBtn" @click=qnaProductDetail(item.qnp_id)>{{ item.qnp_content }}</p>
                            <p class="inquiry_date">{{ item.created_at }}</p>
                        </div>
                        <div class="inquiry_item_right_list">
                            <div type="submit" class="inquiry_delete" @click=deleteProductAsk(item.qnp_id)></div>
                            <div class="keep_shoping_btn qna_answer_complete" v-if="item.qnp_answer">답변완료</div>
                            <div class="keep_shoping_btn qna_answer" v-else>답변진행중</div>
                        </div>
                    </div>
                    <transition name="down">
                        <div class="agree_box modal_second_overlay" v-show="showProductDeleteModal">
                            <div class="modal_second_window">
                                <div class="second_content">
                                    <p class="second_content">확인을 누르면 상품 문의 내역이 삭제됩니다.</p>
                                    <br>
                                    <div>
                                        <button type="button" @click="confirmProductDelete" class="modal_btn">확인</button>
                                        <button type="button" @click="closeProductDeleteModal" class="modal_btn">취소</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </transition>
                </div>
                <div v-else>
                    <h2 class="h2_center">
                        상품문의 내역이 없습니다.
                    </h2>
                </div>
                <!-- 페이지네이션 -->
                <div class="list_num_item" v-if="$store.state.productAskData.data && $store.state.productAskData.data.length > 0">
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
                <div v-else></div>
                <div class="inquiry_list_header">
                    <h2>1:1문의 내역</h2>
                    <router-link to="/qnaonebyonecreate" class="keep_shoping_btn black_button">
                        1:1 문의하기
                    </router-link>
                </div>
                <div class="inquiry_list_main" v-for="(item, key) in $store.state.askSetData.data" :key="key" v-if="$store.state.askSetData.data && $store.state.askSetData.data.length > 0">
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
                            <!-- <button type="submit" class="inquiry_delete" @click="$store.dispatch('askDelete', item.qn_id)"></button> -->
                            <button type="submit" class="inquiry_delete" @click=deleteAsk(item.qn_id)></button>
                            <div class="in_progress qna_answer_complete" v-if="item.qn_answer">답변완료</div>
                            <div class="in_progress qna_answer" v-else>답변진행중</div>
                        </div>
                    </div>
                    <transition name="down">
                        <div class="agree_box modal_second_overlay" v-show="showAskDeleteModal">
                            <div class="modal_second_window">
                                <div class="second_content">
                                    <p class="second_content">확인을 누르면 1:1 문의내역이 삭제됩니다.</p>
                                    <br>
                                    <div>
                                        <button type="button" @click="confirmAskDelete" class="modal_btn">확인</button>
                                        <button type="button" @click="closeAskDeleteModal" class="modal_btn">취소</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </transition>
                </div>
                <div v-else>
                    <h2 class="h2_center">
                        1:1문의 내역이 없습니다.
                    </h2>
                </div>
                <!-- 페이지네이션 -->
                <div class="list_num_item" v-if="$store.state.askSetData.data && $store.state.askSetData.data.length > 0">
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
                <div v-else></div>
            </div>
        </div>
    </main>
    <!-- move top -->
    <a href="#" class="move_top">
        <img src="/img/up.png" class="move_top_img">
    </a>
</template>

<script setup>
    import { onBeforeMount ,computed, ref } from 'vue';
    import { useStore } from 'vuex';
    import router from '../js/router';

    const store = useStore();
    const showDeleteModal = ref(false);
    const showProductDeleteModal = ref(false);
    const showAskDeleteModal = ref(false);
    let deleteItemId = ref(null);

    function deleteUser(item) {
        deleteItemId.value = item;
        showDeleteModal.value = true;
    }
    function deleteProductAsk(item) {
        deleteItemId.value = item;
        showProductDeleteModal.value = true;
    }
    function deleteAsk(item) {
        deleteItemId.value = item;
        showAskDeleteModal.value = true;
    }

    function closeDeleteModal() {
        showDeleteModal.value = false;
    }
    function closeProductDeleteModal() {
        showProductDeleteModal.value = false;
    }
    function closeAskDeleteModal() {
        showAskDeleteModal.value = false;
    }

    function confirmDelete() {
        store.dispatch('orderItemDelete', deleteItemId.value);
        showDeleteModal.value = false;
    }
    function confirmProductDelete() {
        store.dispatch('productAskDelete', deleteItemId.value);
        showProductDeleteModal.value = false;
    }
    function confirmAskDelete() {
        store.dispatch('askDelete', deleteItemId.value);
        showAskDeleteModal.value = false;
    }

    // 날짜 포맷 (YYYY-MM-DD)
    function formatDate(dateString) {
        const date = new Date(dateString);
        const year = date.getFullYear();
        const month = (date.getMonth() + 1).toString().padStart(2, '0'); // 월은 0부터 시작하므로 +1, 두 자리로 맞춤
        const day = date.getDate().toString().padStart(2, '0'); // 두 자리로 맞춤
        return `${year}-${month}-${day}`; // 연-월-일 형식으로 반환
    }
    // 금액 천단위 포맷 (,000)
    function formatPrice(price) {
        return price.toLocaleString('ko-KR');
    }

    // 초기 데이터
    onBeforeMount(() => {
        store.dispatch('getInfoData', store.state.infoData.current_page);


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
        store.commit('reviewToUpdate', item);
        router.push('/reviewcreate');
    }

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

        // let startPage = store.state.infoData.current_page - 2;
        let startPage = store.state.infoData.last_page <5 ? 1 : store.state.infoData.current_page - 2;
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

    // 페이지 번호 배열 계산
    const productsPages = computed(() => {
        const pageArray = [];
        // 페이지네이션 3개
        const maxPagesToShow = 5;

        // let startPage = store.state.productAskData.current_page - 2;
        let startPage = store.state.productAskData.last_page <5 ? 1 : store.state.productAskData.current_page - 2;
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

    // 페이지 번호 배열 계산
    const oneByOnePages = computed(() => {
        const pageArray = [];
        // 페이지네이션 3개
        const maxPagesToShow = 5;

        // let startPage = store.state.askSetData.current_page - 2;
        let startPage = store.state.askSetData.last_page <5 ? 1 : store.state.askSetData.current_page - 2;
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

    const redirectToDetailedPage = (id) => {
        router.push({ path: '/detailed', query: { id: id } });
    };
</script>

<style scoped src="../css/info.css">
</style>
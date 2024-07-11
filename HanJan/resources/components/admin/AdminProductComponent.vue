<template>
    <div class="admin">
        <div class="admin_title_box">
            <h2 class="admin_title2">상품 관리</h2>
            <router-link to="/admin/product/create" class="admin_create_btn">상품 추가</router-link>
        </div>
        <div class="admin_product_list_container">
            <div class="admin_product_list_num admin_weight">번호</div>
            <div class="admin_product_list_img admin_weight">이미지</div>
            <div class="admin_product_list_name admin_weight">상품 이름</div>
            <div class="admin_product_list_price admin_weight">가격</div>
            <div class="admin_product_list_count admin_weight">재고 갯수</div>
            <div class="admin_product_list_ml admin_weight">용량</div>
            <div class="admin_product_list_type admin_weight">주종</div>
            <div class="admin_product_list_season admin_weight">추천 계절</div>
            <div class="admin_product_list_create admin_weight">출시일</div>
            <div class="admin_product_list_update admin_weight">수정일</div>
            <div class="admin_product_list_delete admin_weight">삭제일</div>
        </div>
        <div v-for="product in $store.state.adminProductData.data" :key="product.id" class="admin_product_list_container admin_paddingtop">
            <div class="admin_product_list_num">{{ product.id }}</div>
            <img :src="product.img" class="admin_product_list_img1">
            <div class="admin_product_list_name">{{ product.name }}</div>
            <div class="admin_product_list_price">{{ formatPrice(product.price) }}</div>
            <div class="admin_product_list_count">{{ formatPrice(product.count) }}</div>
            <div class="admin_product_list_ml">{{ product.ml + 'ml' }}</div>
            <div class="admin_product_list_type">{{ product.type }}</div>
            <div class="admin_product_list_season">{{ product.season }}</div>
            <div class="admin_product_list_created">{{ product.created_at }}</div>
            <div class="admin_product_list_updated">{{ product.updated_at }}</div>
            <div class="admin_product_list_deleted">{{ product.deleted_at }}</div>
            <button v-if="product.deleted_at == null" type="button" @click="productUpdate(product)" class="admin_btn">수정하기</button>
            <button v-if="product.deleted_at == null" type="button" @click="productDelete(product.id)" class="admin_btn">삭제하기</button>
        </div>

        <!-- 페이지네이션 -->
        <div class="admin_list_num_item">
            <a href="#" class="before" @click.prevent="prevPage()">〈 이전</a>
            <a
                v-for="page in pages"
                :key="page"
                href="#"
                :class="{'admin_num': page === $store.state.adminProductData.current_page, 'admin_num_none': page !== $store.state.adminProductData.current_page}"
                @click.prevent="goToPage(page)"
                >{{ page }}
            </a>
            <a href="#" class="next" @click.prevent="nextPage()">다음 〉</a>
        </div>
    </div>
</template>

<script setup>
    import { onBeforeMount } from 'vue';
    import { useStore } from 'vuex';
    import { computed } from 'vue';

    const store = useStore();

    onBeforeMount(() => {
        if(store.state.adminProductData.current_page == 1) {
            store.dispatch('getAdminProductsData', 1);
        }
    })

    // 페이지네이션
    // 페이지 번호 배열 계산
    const pages = computed(() => {
        const pageArray = [];
        // 페이지네이션 5개
        const maxPagesToShow = 5;

        // let startPage = store.state.adminProductData.current_page - 2;
        let startPage = store.state.adminProductData.last_page <5 ? 1 : store.state.adminProductData.current_page - 2;
        if(startPage < 1) {
            startPage = 1;
        }
        const endPage = startPage + maxPagesToShow - 1;

        // 시작페이지 구하기
        const pagingStart = startPage <= (store.state.adminProductData.last_page - maxPagesToShow + 1) || ((store.state.adminProductData.last_page - maxPagesToShow + 1) < 1) ? startPage : (store.state.adminProductData.last_page - maxPagesToShow + 1);
        
        // 마지막 페이지 구하기
        const pagingEnd = endPage > store.state.adminProductData.last_page ? store.state.adminProductData.last_page : endPage;

        for (let i = pagingStart; i <= pagingEnd; i++) {
            pageArray.push(i)
        }
        return pageArray
    })

    // 특정 페이지로 이동
    function goToPage(page) {
        store.dispatch('getAdminProductsData', page);
    }

    // 이전 페이지로 이동
    function prevPage() {
        if (store.state.adminProductData.current_page > 1) {
            goToPage(store.state.adminProductData.current_page - 1);
        }
    }

    // 다음 페이지로 이동
    function nextPage() {
        if (store.state.adminProductData.current_page < store.state.adminProductData.last_page) {
            goToPage(store.state.adminProductData.current_page + 1);
        }
    }

    // 상품 수정 페이지로 정보 넘기기
    function productUpdate(item) {
        store.dispatch('adminProductToUpdate', item);
    }

    // 금액 천단위 포맷 (,000)
    function formatPrice(price) {
        return price.toLocaleString('ko-KR');
    }

    // 삭제 버튼
    function productDelete(id) {
        if(confirm('확인 클릭시 상품이 삭제됩니다.')) {
            store.dispatch('adminProductDeleted', id)
        }
    }

</script>

<style>

</style>
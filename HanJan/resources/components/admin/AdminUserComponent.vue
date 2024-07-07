<template>
    <div class="admin">
        <h2 class="admin_title">유저 관리</h2>
        <div class="admin_users_list_container">
            <div class="admin_users_list_num admin_weight">번호</div>
            <div class="admin_users_list_name admin_weight">이름</div>
            <div class="admin_users_list_email admin_weight">이메일</div>
            <div class="admin_users_list_tell admin_weight">휴대전화</div>
            <div class="admin_users_list_adds admin_weight">주소</div>
            <div class="admin_users_list_post admin_weight">우편번호</div>
            <div class="admin_users_list_birth admin_weight">생일</div>
            <div class="admin_users_list_created admin_weight">가입일</div>
            <div class="admin_users_list_updated admin_weight">수정일</div>
            <div class="admin_users_list_deleted admin_weight">탈퇴일</div>
        </div>
        <div v-for="user in $store.state.adminUserData.data" :key="user.id" class="admin_users_list_container admin_paddingtop">
            <div class="admin_users_list_num">{{ user.id }}</div>
            <div class="admin_users_list_name">{{ user.name }}</div>
            <div class="admin_users_list_email">{{ user.email }}</div>
            <div class="admin_users_list_tell">{{ user.tel }}</div>
            <div class="admin_users_list_adds">{{ user.addr + user.det_addr }}</div>
            <div class="admin_users_list_post">{{ user.post }}</div>
            <div class="admin_users_list_birth">{{ user.birth }}</div>
            <div class="admin_users_list_created">{{ user.created_at }}</div>
            <div class="admin_users_list_updated">{{ user.updated_at }}</div>
            <div class="admin_users_list_deleted">{{ user.deleted_at }}</div>
            <button v-if="user.deleted_at == null" @click="userUpdate(user)" type="button" class="admin_btn">수정하기</button>
        </div>

        <!-- 페이지네이션 -->
        <div class="admin_list_num_item">
            <a href="#" class="before" @click.prevent="prevPage()">〈 이전</a>
            <a
                v-for="page in pages"
                :key="page"
                href="#"
                :class="{'admin_num': page === $store.state.adminUserData.current_page, 'admin_num_none': page !== $store.state.adminUserData.current_page}"
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
        if(store.state.adminUserData.current_page == 1) {
            store.dispatch('getAdminUsersData', 1);
        }
    })

    // 페이지네이션
    // 페이지 번호 배열 계산
    const pages = computed(() => {
        const pageArray = [];
        // 페이지네이션 5개
        const maxPagesToShow = 5;

        // let startPage = store.state.adminUserData.current_page - 2;
        let startPage = store.state.adminUserData.last_page <5 ? 1 : store.state.adminUserData.current_page - 2;
        if(startPage < 1) {
            startPage = 1;
        }
        const endPage = startPage + maxPagesToShow - 1;

        // 시작페이지 구하기
        const pagingStart = startPage <= (store.state.adminUserData.last_page - maxPagesToShow + 1) || ((store.state.adminUserData.last_page - maxPagesToShow + 1) < 1) ? startPage : (store.state.adminUserData.last_page - maxPagesToShow + 1);
        
        // 마지막 페이지 구하기
        const pagingEnd = endPage > store.state.adminUserData.last_page ? store.state.adminUserData.last_page : endPage;

        for (let i = pagingStart; i <= pagingEnd; i++) {
            pageArray.push(i)
        }
        return pageArray
    })

    // 특정 페이지로 이동
    function goToPage(page) {
        store.dispatch('getAdminUsersData', page);
    }

    // 이전 페이지로 이동
    function prevPage() {
        if (store.state.adminUserData.current_page > 1) {
            goToPage(store.state.adminUserData.current_page - 1);
        }
    }

    // 다음 페이지로 이동
    function nextPage() {
        if (store.state.adminUserData.current_page < store.state.adminUserData.last_page) {
            goToPage(store.state.adminUserData.current_page + 1);
        }
    }

    // 공지사항 수정 페이지로 정보 넘기기
    function userUpdate(item) {
        store.dispatch('adminUserToUpdate', item);
    }

</script>

<style>
    
</style>
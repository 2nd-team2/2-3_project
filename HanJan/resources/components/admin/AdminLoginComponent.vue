<template>
    <form id="admin_login_form">
        <div class="admin_login_box">
            <div class="admin_login">
                <h2 class="admin_login_title">관리자 로그인</h2>
                <input type="text" name="account" class="admin_login_input" placeholder="아이디">
                <input type="password" name="password" id="password" class="admin_login_input" placeholder="비밀번호" autocomplete="off">
                <button type="button" class="admin_loginBtn" @click="adminLogin">로그인</button>
            </div>
        </div>
    </form>
</template>

<script setup>
import { useStore } from 'vuex';

const store = useStore();

function adminLogin() {
  store.dispatch('adminLogin');
}

</script>

<style>
    body {
        overflow: scroll;
        height: 100%;
    }
</style>
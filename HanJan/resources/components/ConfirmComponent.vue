<template>
    <main>
        <div class="main">
            <div class="userChkTest">
                {{ $store.state.userInfo.name }}회원님의 정보를 안전하게 보호하기 위해 비밀번호를 다시 한번 확인합니다.
                비밀번호는 타인에게 노출되지 않도록 항시 주의해 주세요.
            </div>
            <br>
            <div class="userInfo">
                <ul>
                    <li>
                        <span class="list_marker list_left">·</span>아이디
                        <span class="user_id">{{ $store.state.userInfo.email }}</span>
                    </li>
                    <li>
                        <span class="list_marker">·</span>비밀번호 
                        <input type="password" name="password" v-model="password">
                    </li>
                </ul>
                <div class="buttons twobuttons">
                    <button type="reset" class="info_item_btn form_btn" @click="$router.back()">취소</button>
                    <button type="submit" class="info_item_btn form_btn" @click="$store.dispatch('confirm', password)">확인</button>
                </div>
            </div>
        </div>
    </main>
</template>

<script setup>
</script>

<style scoped src="../css/confirm.css">
</style>
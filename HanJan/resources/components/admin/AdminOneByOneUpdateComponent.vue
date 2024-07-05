<template>
    <div class="admin">
        <form id="adminOneByOneUpdateForm">
            <h2 class="admin_title">1:1 문의 답변</h2>
                <input type="hidden" name="qn_id" :value="$store.state.adminOneByOneToUpdate.qn_id">
                <h3 class="admin_title_name">1:1 문의 내용</h3>
                <textarea name="qn_content" class="admin_item_name">{{ $store.state.adminOneByOneToUpdate.qn_content }}</textarea>
                <h3 class="admin_title_content">1:1 문의 답변 내용</h3>
                <textarea name="qn_answer" class="admin_item_content">{{ $store.state.adminOneByOneToUpdate.qn_answer }}</textarea>
            <div class="admin_hr"></div>
            <div class="admin_btn_box">
                <button type="button" @click="$router.back()" class="admin_btn">취소하기</button>
                <button type="button" @click="$store.dispatch('oneByOneUpdate')" class="admin_btn">답변하기</button>
            </div>
        </form>
    </div>
</template>

<script setup>

</script>

<style>

</style>
<template>
    <div class="admin">
        <form id="adminProductQnaUpdateForm">
            <h2 class="admin_title">상품문의 답변</h2>
                <input type="hidden" name="qnp_id" :value="$store.state.adminProductQnaToUpdate.qnp_id">
                <h3 class="admin_title_name">상품문의 내용</h3>
                <textarea name="qnp_content" class="admin_item_name" readonly>{{ $store.state.adminProductQnaToUpdate.qnp_content }}</textarea>
                <h3 class="admin_title_content">상품문의 답변 내용</h3>
                <textarea name="qnp_answer" class="admin_item_content">{{ $store.state.adminProductQnaToUpdate.qnp_answer }}</textarea>
            <div class="admin_hr"></div>
            <div class="admin_btn_box">
                <button type="button" @click="$router.back()" class="admin_btn">취소하기</button>
                <button type="button" @click="$store.dispatch('productQnaUpdateSubmit')" class="admin_btn">답변하기</button>
            </div>
        </form>
    </div>
</template>

<script setup>

</script>

<style>

</style>
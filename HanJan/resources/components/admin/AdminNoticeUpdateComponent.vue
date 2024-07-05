<template>
    <div class="admin">
        <form id="adminNoticeUpdateForm">
            <h2 class="admin_title">공지사항 수정</h2>
                <input type="hidden" name="no_id" :value="$store.state.adminNoticeToUpdate.no_id">
                <h3 class="admin_title_name">제목</h3>
                <textarea name="no_title" class="admin_item_name">{{ $store.state.adminNoticeToUpdate.no_title }}</textarea>
                <h3 class="admin_title_content">내용</h3>
                <textarea name="no_content" class="admin_item_content">{{ $store.state.adminNoticeToUpdate.no_content }}</textarea>
            <div class="admin_hr"></div>
            <div class="admin_btn_box">
                <button type="button" @click="$router.back()" class="admin_btn">취소하기</button>
                <button type="button" @click="$store.dispatch('noticeUpdateSubmit')" class="admin_btn">수정하기</button>
            </div>
        </form>
    </div>
</template>

<script setup>

</script>

<style>

</style>
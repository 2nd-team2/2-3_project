<template>
    <div class="admin">
        <form id="adminNoticeCreateForm">
            <h2 class="admin_title">공지사항 작성</h2>
                <div class="admin_box">
                    <h3 class="admin_title_name">제목</h3>
                    <textarea name="no_title" placeholder="영어, 숫자, 한글, 공백 포함 50자 이내로 작성해주세요." class="admin_item_name"></textarea>
                    <h3 class="admin_title_content">내용</h3>
                    <textarea name="no_content" placeholder="영어, 숫자, 한글, 공백 포함 1000자 이내로 작성해주세요." class="admin_item_content"></textarea>
                </div>
            <div class="admin_hr"></div>
            <div class="admin_btn_box">
                <button type="button" @click="$router.back()" class="admin_btn">취소하기</button>
                <button type="button" @click="$store.dispatch('adminNoticeCreate')" class="admin_btn">작성하기</button>
            </div>
        </form>
    </div>
</template>

<script setup>
    import { onBeforeUnmount } from 'vue'; 

    onBeforeUnmount(() => {
        const form = document.querySelector('#adminNoticeCreateForm');
        form.reset();
    });
</script>

<style>

</style>
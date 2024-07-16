<template>
    <div class="story_list">
        <img src="/img/story_list.png">
    </div>
    <div class="bk_btn" @click="goBack">뒤로가기</div>
</template>

<script setup>
    import { useRouter } from 'vue-router'

    const router = useRouter()

    const goBack = () => {
        router.back();
    }
</script>

<style scoped src="../css/story.css">
</style>
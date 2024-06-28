require('./bootstrap');

import { createApp } from 'vue';
import AppComponent from '../components/AppComponent.vue';
import store from './store';
import router from './router';

createApp({
    components: {
        AppComponent,
    }
})

.use(store)
.use(router)
.mount('#app');

// 전역 에러 핸들러 설정
app.config.errorHandler = (err, instance, info) => {
    console.error(err);
    router.push({ name: 'NotFound' });
};
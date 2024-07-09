<template>
    <div class="admin">
        <h2 class="admin_title">Dash Board</h2>
        <!-- {{ $store.state.userTatisticsData }}
        {{ $store.state.userAgeRangeData }} -->
        {{ $store.state.salesStatisticsData }}
        <h3>유저 통계</h3>
        <div class="admin_user_box">
            <canvas id="user_tatistics" class="user_tatistics"></canvas>
            <canvas id="user_age_range" class="user_age_range"></canvas>
        </div>
        <div class="admin_hr"></div>
        <h3>상품 통계</h3>
        <div class="admin_user_box">
            <canvas id="sales" class="sales"></canvas>
        </div>
        <div class="admin_graph"></div>
    </div>
</template>

<script setup>
    import { onMounted, onBeforeMount } from 'vue';
    import Chart from 'chart.js/auto';
    import { useStore } from 'vuex';

    const store = useStore();

    onBeforeMount(() => {
        // if(store.state.userTatisticsData.length < 1) {
        //     await store.dispatch('getUserTatisticsData');
        // }
        // if(store.state.userAgeRangeData.length < 1) {
        //     await store.dispatch('getUserAgeRangeData');
        // }
        // if (store.state.userTatisticsData.length < 1) {
        // store.dispatch('getUserTatisticsData').then(() => {
        //     // 데이터가 로드된 후 실행될 코드
        //     const transformedData = store.state.userTatisticsData.map(item => ({
        //         month: getMonthName(item.month),
        //         new_users: item.new_users,
        //         withdraw_users: parseInt(item.withdraw_users, 10) // 문자열을 숫자로 변환
        //     }));

        //     console.log('데이터 확인:', transformedData); // 변환된 데이터 확인

        //     // 여기서 transformedData를 다른 곳에서 사용하거나 저장할 수 있음
        // });
        if(store.state.salesStatisticsData.length < 1) {
            store.dispatch('getSalesStatisticsData');
        }
    
    })

    // const test = [
    //     { month: '2024-01', new_users: 30, withdraw_users: "10" },
    //     { month: '2024-02', new_users: 40, withdraw_users: 15 },
    //     { month: '2024-03', new_users: 35, withdraw_users: 12 },
    //     { month: '2024-04', new_users: 45, withdraw_users: 18 },
    //     { month: '2024-05', new_users: 55, withdraw_users: 20 },
    //     { month: '2024-06', new_users: 50, withdraw_users: 22 },
    //     { month: '2024-07', new_users: 60, withdraw_users: 25 },
    //     { month: '2024-08', new_users: 70, withdraw_users: 30 },
    //     { month: '2024-09', new_users: 65, withdraw_users: 28 },
    //     { month: '2024-10', new_users: 75, withdraw_users: 32 },
    //     { month: '2024-11', new_users: 80, withdraw_users: 35 },
    //     { month: '2024-12', new_users: 85, withdraw_users: 38 },
    // ];
    // const test2 = [
    //     { age_group: '20대', user_count: 50},
    //     { age_group: '30대', user_count: 20},
    //     { age_group: '40대', user_count: 10},
    //     { age_group: '50대', user_count: 5},
    //     { age_group: '60대 이상', user_count: 1},
    // ];

    // const data = ref(store.state.userTatisticsData);
    // const data2 = ref(test2);

    onMounted(async () => {
        if(store.state.userTatisticsData.length < 1) {
            await store.dispatch('getUserTatisticsData');
        }
        if(store.state.userAgeRangeData.length < 1) {
            await store.dispatch('getUserAgeRangeData');
        }
        // if(store.state.salesStatisticsData.length < 1) {
        //     await store.dispatch('getSalesStatisticsData');
        // }

        // 가입 탈퇴 통계
        const ctx = document.getElementById('user_tatistics');
        ctx.style.maxWidth = '1000px'
        ctx.style.maxHeight = '450px'
        console.log(store.state.userTatisticsData);
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: store.state.userTatisticsData.map(item => item.month),
                datasets: [
                    {
                    label: '신규 유저',
                    data: store.state.userTatisticsData.map(item => item.new_users),
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                    },
                    {
                    label: '탈퇴 회원',
                    data: store.state.userTatisticsData.map(item => item.withdraw_users),
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                    beginAtZero: true
                    }
                }
            }
        });

        // 유저 연령대별 수
        const ctx2 = document.getElementById('user_age_range');
        ctx2.style.maxWidth = '450px'
        ctx2.style.maxHeight = '450px'
        
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: store.state.userAgeRangeData.map(item => item.age_group),
                datasets: [
                    {
                    label: '',
                    data: store.state.userAgeRangeData.map(item => item.user_count),
                    backgroundColor: [
                        'rgba(255, 99, 102, 0.5)',   // 20대
                        'rgba(54, 162, 235, 0.5)',   // 30대
                        'rgba(255, 206, 86, 0.5)',   // 40대
                        'rgba(75, 192, 192, 0.5)',   // 50대
                        'rgba(153, 102, 255, 0.5)',  // 60대이상
                    ],
                    borderColor: [
                        'rgba(255, 99, 102, 1)',    // 20대
                        'rgba(54, 162, 235, 1)',    // 30대
                        'rgba(255, 206, 86, 1)',    // 40대
                        'rgba(75, 192, 192, 1)',    // 50대
                        'rgba(153, 102, 255, 1)',   // 60대이상
                    ],
                    borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
            }
        });

        // 매출
        const ctx3 = document.getElementById('sales');
        ctx3.style.maxWidth = '100%'
        ctx3.style.maxHeight = '450px'
        
        new Chart(ctx3, {
            type: 'line',
            data: {
                labels: store.state.salesStatisticsData.map(item => item.age_group),
                datasets: [
                    {
                    label: '',
                    data: store.state.salesStatisticsData.map(item => item.user_count),
                    backgroundColor: [
                        'rgba(255, 99, 102, 0.5)',   // 20대
                        'rgba(54, 162, 235, 0.5)',   // 30대
                        'rgba(255, 206, 86, 0.5)',   // 40대
                        'rgba(75, 192, 192, 0.5)',   // 50대
                        'rgba(153, 102, 255, 0.5)',  // 60대이상
                    ],
                    borderColor: [
                        'rgba(255, 99, 102, 1)',    // 20대
                        'rgba(54, 162, 235, 1)',    // 30대
                        'rgba(255, 206, 86, 1)',    // 40대
                        'rgba(75, 192, 192, 1)',    // 50대
                        'rgba(153, 102, 255, 1)',   // 60대이상
                    ],
                    borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
            }
        });
    });
</script>

<style>

</style>


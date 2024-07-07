<template>
    <div class="admin">
        <h2 class="admin_title">Dash Board</h2>
        {{ $store.state.newUserData }}
        <div class="admin_user_box">
            <!-- <div v-for="newUser in store.state.newUserData" :key="key" class="admin_user_new">
                <div>신규 유저</div>
                <div>{{ newUser.month }}</div>
                <div>{{ newUser.new_users }}</div>
            </div> -->
            <canvas id="myChart" class="myChart"></canvas>
            <div class="admin_user_all">
                <div>기존 유저</div>
                <div>50</div>
            </div>
            <div class="admin_user_delete">
                <div>탈퇴 유저</div>
                <div>50</div>
            </div>
            <div class="admin_user_avage">
                <div>유저 평균 연령</div>
            </div>
        </div>
        <div class="admin_graph"></div>
    </div>
</template>

<script setup>
    import { ref, onMounted } from 'vue';
    import Chart from 'chart.js/auto';

    const chartData = ref([]);

    // 데이터를 가져와서 차트를 그리기
    onMounted(() => {
        fetchData()
        .then(data => {
            chartData.value = data;
            drawChart();
        }).catch(error => {
            console.error('데이터를 가져오는 중 오류가 발생했습니다:', error);
        });
    });

    const fetchData = () => {
        return new Promise((resolve, reject) => {
            // 데이터를 비동기적으로 가져오는 코드 예시 (실제로는 Vuex나 API 호출 등으로 대체해야 함)
            const mockData = [
                { month: '2024-06', count: 12 },
                { month: '2024-07', count: 30 }
            ];
            resolve(mockData); // 이 부분을 Vuex나 실제 데이터 가져오는 로직으로 대체해야 함
        });
    };

    const drawChart = () => {
        const ctx = document.getElementById('myChart');
        if (ctx && chartData.value.length > 0) {
            const data = chartData.value;

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.map(row => row.month), // 월을 기준으로 레이블 설정
                    datasets: [{
                        label: 'Acquisitions by month', // 레이블 설정
                        data: data.map(row => row.count),
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    animation: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        } else {
            console.warn('차트를 그리기 위한 데이터가 없습니다.');
        }
    };
    // import { ref, onBeforeMount } from 'vue';
    // import { useStore } from 'vuex';
    // import Chart from 'chart.js/auto';

    // const store = useStore();
    // const chartData = ref([]);

    // // 컴포넌트가 마운트되기 전에 데이터를 가져오기
    // onBeforeMount(() => {
    //     fetchData();
    // });

    // const fetchData = () => {
    //     // 이미 데이터가 있는 경우 불필요한 요청을 방지하기 위해 조건을 추가합니다.
    //     if (store.state.newUserData.length > 0) {
    //         chartData.value = store.state.newUserData;
    //         drawChart();
    //     } else {
    //         store.dispatch('getNewUserData')
    //         .then(response => {
    //             chartData.value = response.data; // Vuex에서 가져온 데이터를 chartData에 저장
    //             drawChart();
    //         }).catch(error => {
    //             console.error('데이터를 가져오는 중 오류가 발생했습니다:', error);
    //         });
    //     }
    // };

    // const drawChart = () => {
    //     const ctx = document.getElementById('myChart');
    //     if (ctx && chartData.value.length > 0) {
    //         const data = chartData.value;

    //         new Chart(ctx, {
    //             type: 'bar',
    //             data: {
    //                 labels: data.map(row => row.month), // 월을 기준으로 레이블 설정
    //                 datasets: [{
    //                     label: '신규 가입자 수', // 레이블 설정
    //                     data: data.map(row => row.new_users),
    //                     backgroundColor: 'rgba(54, 162, 235, 0.2)',
    //                     borderColor: 'rgba(54, 162, 235, 1)',
    //                     borderWidth: 1
    //                 }]
    //             },
    //             options: {
    //                 animation: false,
    //                 plugins: {
    //                     legend: {
    //                         display: false
    //                     },
    //                     tooltip: {
    //                         enabled: false
    //                     }
    //                 },
    //                 scales: {
    //                     y: {
    //                         beginAtZero: true
    //                     }
    //                 }
    //             }
    //         });
    //     } else {
    //         console.warn('차트를 그리기 위한 데이터가 없습니다.');
    //     }
    // };
    // onBeforeMount(() => {
    //     if(store.state.newUserData.length < 1) {
    //         store.dispatch('getNewUserData');
    //     }
    // })

</script>

<style>

</style>


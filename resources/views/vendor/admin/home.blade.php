@component('admin::layouts.app')
<div class="w-50 text-center d-flex flex-column justify-content-center mx-auto" style="border-radius: 10px;background: #fccb90; background: -webkit-linear-gradient(to right, #4158D0, #C850C0); background: linear-gradient(to right, #4158D0, #C850C0); color: white; height: 100px;">
    <h2 class="font-weight-bold" style="padding-top:10px;">Total Users</h2>
    <h2 class="font-weight-bold p-16">{{ \App\Models\User::count() }}</h2>
</div>
<canvas id="myChart" height="35" width="100" style="display: block; box-sizing: border-box;"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        function fetchRegistrationCount() {
            fetch('/registration-count')
                .then(response => response.json())
                .then(data => {
                    updateChart(data.registrationCount);
                })
                .catch(error => {
                    console.error('Error fetching registration count:', error);
                });
        }

        function updateChart(registrationCount) {
            const currentMonthIndex = new Date().getMonth();
            const currentMonth = new Date().toLocaleString('default', { month: 'long' });
            const labels = [];
            const data = [];

            for (let i = 0; i <= currentMonthIndex; i++) {
                labels.push(new Date(2022, i, 1).toLocaleString('default', { month: 'long' }));
                if (i === currentMonthIndex) {
                    data.push(registrationCount);
                } else {
                    data.push(null);
                }
            }

            myChart.data.labels = labels;
            myChart.data.datasets[0].data = data;
            myChart.update();
        }

        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'User',
                    data: [],
                    fill: true,
                    borderColor: '#C850C0',
                    borderWidth: 5,
                    tension: 0.1
                }]
            },
            options: {
                scales: {
                    y: {
                        suggestedMin: 0,
                        suggestedMax: 100,
                        ticks: {
                            color: '#C850C0',
                            values: [1, 20, 40, 60, 80, 100],
                            stepSize: 20
                        }
                    },
                    x: {
                        ticks: {
                            color: '#C850C0'
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'User Count',
                        font: {
                            size: 20,
                            color: '#C850C0'
                        }
                    }
                },
                elements: {
                    line: {
                        borderWidth: 3,
                        borderColor: '#C850C0'
                    }
                },
                layout: {
                    padding: {
                        top: 20,
                        right: 20,
                        bottom: 20,
                        left: 20
                    }
                }
            }
        });

        fetchRegistrationCount();
        setInterval(fetchRegistrationCount, 60000);
    });
</script>


@endcomponent
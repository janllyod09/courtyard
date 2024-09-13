<div x-data="chartData()" x-init="initChart()" class="relative p-6 bg-gradient-to-br h-full from-indigo-100 to-white dark:from-gray-800 dark:to-gray-900 rounded-xl shadow-md">
    <h2 class="text-2xl font-semibold mb-4">Client Analytics</h2>
    <div class="mb-4">
        <span class="text-sm font-medium">Total Clients:</span>
        <span class="text-xl font-bold">{{ $totalUsers }}</span>
    </div>
    <div x-data="chartData()" x-init="initChart()" class="relative">
        <canvas id="myChart" width="400" height="200"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.0.6/dist/alpine.min.js" defer></script>
<script>
function chartData() {
    return {
        chart: null,
        hoveredMonth: null,
        hoveredCount: null,
        hoverPosition: { x: 0, y: 0 },
        chartData: @json($monthlyData),
        initChart() {
            const ctx = document.getElementById('myChart').getContext('2d');
            this.chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: this.chartData.map(item => item.month),
                    datasets: [{
                        label: 'Registered Clients',
                        data: this.chartData.map(item => item.count),
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1,
                        fill: true,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)'
                    }]
                },
                options: {
                    responsive: true,
                    onHover: (event, activeElements) => {
                        if (activeElements && activeElements.length) {
                            const dataIndex = activeElements[0].index;
                            this.hoveredMonth = this.chartData[dataIndex].month;
                            this.hoveredCount = this.chartData[dataIndex].count;
                            this.hoverPosition = { x: event.x, y: event.y };
                        } else {
                            this.hoveredMonth = null;
                            this.hoveredCount = null;
                        }
                    }
                }
            });
        }
    }
}
</script>
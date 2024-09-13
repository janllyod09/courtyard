<div x-data="quarterlyReportChartData()" x-init="initQuarterlyReportChart()" class="relative p-6 bg-gradient-to-br h-full from-indigo-100 to-white dark:from-gray-800 dark:to-gray-900 rounded-xl shadow-md">
    <h2 class="text-2xl font-semibold mb-4">Quarterly Emergency Drill Reports {{ $currentYear }}</h2>
    <div x-data="quarterlyReportChartData()" x-init="initQuarterlyReportChart()" class="relative flex justify-center">
        <div style="width: 200px; height: 200px">
            <canvas id="quarterlyReportChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.0.6/dist/alpine.min.js" defer></script>
<script>
function quarterlyReportChartData() {
    return {
        chart: null,
        hoveredQuarter: null,
        hoveredCount: null,
        hoverPosition: { x: 0, y: 0 },
        chartData: @json($quarterlyData),
        initQuarterlyReportChart() {
            const ctx = document.getElementById('quarterlyReportChart').getContext('2d');
            this.chart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: this.chartData.map(item => item.quarter),
                    datasets: [{
                        data: this.chartData.map(item => item.count),
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.8)',
                            'rgba(54, 162, 235, 0.8)',
                            'rgba(255, 206, 86, 0.8)',
                            'rgba(75, 192, 192, 0.8)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    aspectRatio: 1, 
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Quarterly Emergency Drill Report Submissions'
                        }
                    },
                    onHover: (event, activeElements) => {
                        if (activeElements && activeElements.length) {
                            const dataIndex = activeElements[0].index;
                            this.hoveredQuarter = this.chartData[dataIndex].quarter;
                            this.hoveredCount = this.chartData[dataIndex].count;
                            this.hoverPosition = { x: event.x, y: event.y };
                        } else {
                            this.hoveredQuarter = null;
                            this.hoveredCount = null;
                        }
                    }
                }
            });
        }
    }
}
</script>
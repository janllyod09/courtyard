<div x-data="monthlyReportChartData()" x-init="initMonthlyReportChart()" class="relative p-6 bg-gradient-to-br h-full from-indigo-100 to-white dark:from-gray-800 dark:to-gray-900 rounded-xl shadow-md">
    <div x-data="monthlyReportChartData()" x-init="initMonthlyReportChart()" class="relative">
        <h3 class="text-xl font-semibold mb-2">Monthly Safety and Health Report Submissions</h3>
        <canvas id="monthlyReportChart" width="400" height="200"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.0.6/dist/alpine.min.js" defer></script>
<script>
function monthlyReportChartData() {
    return {
        chart: null,
        hoveredMonth: null,
        hoveredCount: null,
        hoverPosition: { x: 0, y: 0 },
        chartData: @json($monthlyReportData),
        initMonthlyReportChart() {
            const ctx = document.getElementById('monthlyReportChart').getContext('2d');
            this.chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: this.chartData.map(item => item.month),
                    datasets: [{
                        label: 'Report Submissions',
                        data: this.chartData.map(item => item.count),
                        backgroundColor: 'rgba(75, 192, 192, 0.8)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
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

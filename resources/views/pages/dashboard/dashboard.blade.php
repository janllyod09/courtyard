<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <div id="clock" class="text-lg font-semibold mb-4 text-gray-400 dark:text-gray-500 h-10 text-center">
        </div>
        <x-dashboard.welcome-banner />

        <!-- Cards -->
        <div class="grid grid-cols-12 gap-6">
            <x-dashboard.dashboard-card-01 />
            <x-dashboard.dashboard-card-02 />
            <x-dashboard.dashboard-card-03 />
        </div>
    </div>
</x-app-layout>

<script>
    function updateClock() {
        const now = new Date();
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: true
        };
        const timeString = now.toLocaleString('en-US', options);
        document.getElementById('clock').textContent = timeString;
    }
    updateClock();
    setInterval(updateClock, 1000);
</script>

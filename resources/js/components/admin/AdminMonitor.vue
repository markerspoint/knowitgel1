<template>
    <div class="space-y-12">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div
                v-for="stat in analyticsSummary"
                :key="stat.label"
                class="bg-white/5 border border-white/10 rounded-3xl p-8 hover:bg-white/10 transition-all group relative overflow-hidden"
            >
                <div
                    class="absolute -right-6 -bottom-6 opacity-5 group-hover:opacity-10 transition-opacity transform rotate-12"
                >
                    <i :class="stat.icon" class="text-8xl text-red-500"></i>
                </div>
                <p
                    class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-4"
                >
                    {{ stat.label }}
                </p>
                <p class="text-4xl font-black text-white tracking-tighter mb-2">
                    {{ stat.value }}
                </p>
                <div class="flex items-center space-x-2">
                    <span
                        :class="[
                            'text-[10px] font-mono uppercase',
                            stat.trendColor,
                        ]"
                        >{{ stat.trend }}</span
                    >
                </div>
            </div>
        </div>

        <!-- Charts Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white/5 border border-white/10 rounded-3xl p-8">
                <h4
                    class="text-xs font-black text-white uppercase tracking-widest mb-8 flex items-center"
                >
                    <i class="fas fa-chart-line mr-3 text-red-500"></i>Daily
                    Traffic Synchronisation
                </h4>
                <div class="h-[300px] w-full">
                    <canvas ref="dailySessionsChart"></canvas>
                </div>
            </div>
            <div class="bg-white/5 border border-white/10 rounded-3xl p-8">
                <h4
                    class="text-xs font-black text-white uppercase tracking-widest mb-8 flex items-center"
                >
                    <i class="fas fa-chart-bar mr-3 text-red-500"></i>Monthly
                    Engagement Load
                </h4>
                <div class="h-[300px] w-full">
                    <canvas ref="monthlySessionsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Distribution Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white/5 border border-white/10 rounded-3xl p-8">
                <h4
                    class="text-xs font-black text-white uppercase tracking-widest mb-8 flex items-center"
                >
                    <i class="fas fa-circle-notch mr-3 text-red-500"></i>User
                    Role Metrics
                </h4>
                <div class="flex flex-col md:flex-row items-center gap-8">
                    <div class="h-[250px] w-full md:w-1/2">
                        <canvas ref="userStatsChart"></canvas>
                    </div>
                    <div class="flex-1 space-y-4">
                        <div
                            v-for="role in userRoleBreakdown"
                            :key="role.label"
                            class="flex items-center justify-between p-4 bg-white/5 rounded-2xl border border-white/5"
                        >
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-3 h-3 rounded-full"
                                    :class="role.color"
                                ></div>
                                <span
                                    class="text-xs font-bold text-gray-400 uppercase tracking-tight"
                                    >{{ role.label }}</span
                                >
                            </div>
                            <span
                                class="text-lg font-black text-white tracking-tighter"
                                >{{ role.value }}</span
                            >
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white/5 border border-white/10 rounded-3xl p-8">
                <h4
                    class="text-xs font-black text-white uppercase tracking-widest mb-8 flex items-center"
                >
                    <i class="fas fa-radar mr-3 text-red-500"></i>Network Status
                    Spectrum
                </h4>
                <div class="h-[320px] w-full">
                    <canvas ref="userStatusChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Chart from "chart.js/auto";

export default {
    name: "AdminMonitor",
    props: {
        analytics: { type: Object, required: true },
    },
    data() {
        return {
            dailyChart: null,
            monthlyChart: null,
            userStatsChart: null,
            userStatusChart: null,
        };
    },
    computed: {
        analyticsSummary() {
            return [
                {
                    label: "Network Entities",
                    value: this.analytics.totals.total_users,
                    trend: "+Syncing Active",
                    trendColor: "text-green-500",
                    icon: "fas fa-users",
                },
                {
                    label: "30D Onboarding",
                    value: this.analytics.totals.new_users_last_30_days,
                    trend: "Protocol Normal",
                    trendColor: "text-blue-500",
                    icon: "fas fa-user-plus",
                },
                {
                    label: "Archived Syncs",
                    value: this.analytics.totals.total_sessions,
                    trend: "Database Locked",
                    trendColor: "text-red-500",
                    icon: "fas fa-database",
                },
                {
                    label: "Global Capacity",
                    value: this.analytics.totals.total_score.toLocaleString(),
                    trend: "System Peak",
                    trendColor: "text-amber-500",
                    icon: "fas fa-bolt",
                },
            ];
        },
        userRoleBreakdown() {
            const stats = this.analytics.user_stats;
            return [
                {
                    label: "Regular Entities",
                    value: stats.regular_users || 0,
                    color: "bg-blue-500",
                },
                {
                    label: "Authority Links",
                    value: stats.admin_users || 0,
                    color: "bg-red-500",
                },
                {
                    label: "Latent Links",
                    value: stats.disabled_users || 0,
                    color: "bg-gray-700",
                },
            ];
        },
    },
    watch: {
        analytics: {
            handler() {
                this.$nextTick(() => this.renderCharts());
            },
            deep: true,
        },
    },
    mounted() {
        this.renderCharts();
    },
    beforeUnmount() {
        this.destroyCharts();
    },
    methods: {
        renderCharts() {
            const sharedOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: "#6a7280",
                            font: { family: "Space Grotesk", weight: "bold" },
                        },
                    },
                },
                scales: {
                    x: {
                        grid: { color: "rgba(255,255,255,0.05)" },
                        ticks: {
                            color: "#4b5563",
                            font: { family: "Space Grotesk" },
                        },
                    },
                    y: {
                        grid: { color: "rgba(255,255,255,0.05)" },
                        ticks: {
                            color: "#4b5563",
                            font: { family: "Space Grotesk" },
                        },
                    },
                },
            };

            // Daily Chart
            if (this.$refs.dailySessionsChart) {
                if (this.dailyChart) this.dailyChart.destroy();
                this.dailyChart = new Chart(this.$refs.dailySessionsChart, {
                    type: "line",
                    data: {
                        labels: this.analytics.daily_sessions_last_30_days.map(
                            (d) => d.date,
                        ),
                        datasets: [
                            {
                                label: "Pulse Rate",
                                data: this.analytics.daily_sessions_last_30_days.map(
                                    (d) => d.sessions,
                                ),
                                borderColor: "#ef4444",
                                backgroundColor: "rgba(239, 68, 68, 0.1)",
                                fill: true,
                                tension: 0.4,
                            },
                        ],
                    },
                    options: sharedOptions,
                });
            }

            // Monthly Chart
            if (this.$refs.monthlySessionsChart) {
                if (this.monthlyChart) this.monthlyChart.destroy();
                this.monthlyChart = new Chart(this.$refs.monthlySessionsChart, {
                    type: "bar",
                    data: {
                        labels: this.analytics.monthly_sessions_last_12_months.map(
                            (d) => d.label,
                        ),
                        datasets: [
                            {
                                label: "Data Volume",
                                data: this.analytics.monthly_sessions_last_12_months.map(
                                    (d) => d.sessions,
                                ),
                                backgroundColor: "#ef4444",
                                borderRadius: 10,
                            },
                        ],
                    },
                    options: sharedOptions,
                });
            }

            // User Stats Doughnut
            if (this.$refs.userStatsChart) {
                if (this.userStatsChart) this.userStatsChart.destroy();
                this.userStatsChart = new Chart(this.$refs.userStatsChart, {
                    type: "doughnut",
                    data: {
                        labels: ["Regular", "Authority", "Latent"],
                        datasets: [
                            {
                                data: [
                                    this.analytics.user_stats.regular_users,
                                    this.analytics.user_stats.admin_users,
                                    this.analytics.user_stats.disabled_users,
                                ],
                                backgroundColor: ["#3b82f6", "#ef4444", "#111"],
                                borderColor: "rgba(255,255,255,0.1)",
                                borderWidth: 2,
                            },
                        ],
                    },
                    options: {
                        ...sharedOptions,
                        scales: {
                            x: { display: false },
                            y: { display: false },
                        },
                    },
                });
            }

            // Radar Chart
            if (this.$refs.userStatusChart) {
                if (this.userStatusChart) this.userStatusChart.destroy();
                this.userStatusChart = new Chart(this.$refs.userStatusChart, {
                    type: "radar",
                    data: {
                        labels: [
                            "Active",
                            "Latent",
                            "Authority",
                            "Entities",
                            "Global",
                        ],
                        datasets: [
                            {
                                label: "Status Spectrum",
                                data: [
                                    this.analytics.user_stats.active_users,
                                    this.analytics.user_stats.disabled_users,
                                    this.analytics.user_stats.admin_users,
                                    this.analytics.user_stats.regular_users,
                                    this.analytics.user_stats.total_users,
                                ],
                                borderColor: "#ef4444",
                                backgroundColor: "rgba(239, 68, 68, 0.2)",
                            },
                        ],
                    },
                    options: {
                        ...sharedOptions,
                        scales: {
                            r: {
                                grid: { color: "rgba(255,255,255,0.1)" },
                                angleLines: { color: "rgba(255,255,255,0.1)" },
                                pointLabels: {
                                    color: "#6a7280",
                                    font: { family: "Space Grotesk" },
                                },
                                ticks: {
                                    display: false,
                                    backdropColor: "transparent",
                                },
                            },
                            x: { display: false },
                            y: { display: false },
                        },
                    },
                });
            }
        },
        destroyCharts() {
            [
                this.dailyChart,
                this.monthlyChart,
                this.userStatsChart,
                this.userStatusChart,
            ].forEach((c) => c?.destroy());
        },
    },
};
</script>

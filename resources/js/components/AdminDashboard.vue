<template>
    <div
        class="min-h-screen bg-[#111111] text-gray-300 font-sans selection:bg-red-500 selection:text-white relative overflow-hidden flex flex-col"
    >
        <!-- Background Decorations -->
        <div
            class="absolute top-1/4 left-1/4 w-96 h-96 bg-red-500/10 rounded-full blur-[120px] pointer-events-none"
        ></div>
        <div
            class="absolute bottom-1/4 right-1/4 w-64 h-64 bg-blue-500/10 rounded-full blur-[100px] pointer-events-none"
        ></div>

        <!-- Navigation -->
        <nav
            class="sticky top-0 w-full z-50 bg-[#111111]/80 backdrop-blur-md border-b border-white/5"
        >
            <div
                class="container mx-auto px-6 py-4 flex items-center justify-between"
            >
                <router-link
                    to="/admin/dashboard"
                    class="flex items-center space-x-3 group"
                >
                    <div
                        class="w-10 h-10 bg-red-500 rounded-lg flex items-center justify-center transform group-hover:rotate-12 transition-transform duration-300 shadow-[0_0_15px_rgba(239,68,68,0.3)]"
                    >
                        <i class="fas fa-terminal text-white text-xl"></i>
                    </div>
                    <span
                        class="text-xl font-bold tracking-tighter text-white group-hover:text-red-500 transition-colors uppercase"
                        >KNOWIT GEL1 ADMIN</span
                    >
                </router-link>

                <div class="flex items-center space-x-6">
                    <div class="relative group" @click.stop>
                        <button
                            @click="showProfileDropdown = !showProfileDropdown"
                            class="flex items-center space-x-3 p-1 rounded-xl hover:bg-white/5 transition-all outline-none"
                        >
                            <div class="text-right hidden sm:block">
                                <p
                                    class="text-xs font-black text-white uppercase tracking-tighter"
                                >
                                    {{ user?.fname }} {{ user?.lname }}
                                </p>
                                <p
                                    class="text-[10px] font-mono text-red-500 uppercase tracking-widest"
                                >
                                    Network Authority
                                </p>
                            </div>
                            <div
                                class="w-10 h-10 rounded-lg border border-white/10 flex items-center justify-center overflow-hidden bg-white/5 group-hover:border-red-500/50 transition-colors"
                            >
                                <img
                                    v-if="user && user.profile_picture"
                                    :src="'/' + user.profile_picture"
                                    alt="Profile"
                                    class="w-full h-full object-cover"
                                />
                                <div
                                    v-else
                                    class="w-full h-full flex items-center justify-center text-red-500 font-black text-sm"
                                >
                                    {{ user?.fname?.charAt(0)
                                    }}{{ user?.lname?.charAt(0) }}
                                </div>
                            </div>
                        </button>
                        <transition name="dropdown">
                            <div
                                v-show="showProfileDropdown"
                                class="absolute right-0 mt-3 w-56 bg-[#181818] border border-white/10 rounded-2xl shadow-2xl overflow-hidden z-50"
                            >
                                <div class="p-2">
                                    <router-link
                                        to="/admin/profile"
                                        class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-white/5 text-sm font-bold text-gray-400 hover:text-white transition-all"
                                    >
                                        <i class="fas fa-user-shield w-5"></i
                                        ><span>Admin Profile</span>
                                    </router-link>
                                    <router-link
                                        to="/admin/users"
                                        class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-white/5 text-sm font-bold text-gray-400 hover:text-white transition-all"
                                    >
                                        <i class="fas fa-users w-5"></i
                                        ><span>User Manager</span>
                                    </router-link>
                                    <router-link
                                        to="/admin/assessment"
                                        class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-white/5 text-sm font-bold text-gray-400 hover:text-white transition-all"
                                    >
                                        <i class="fas fa-tasks w-5"></i
                                        ><span>Assessment Logic</span>
                                    </router-link>
                                    <router-link
                                        to="/admin/settings"
                                        class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-white/5 text-sm font-bold text-gray-400 hover:text-white transition-all"
                                    >
                                        <i class="fas fa-cogs w-5"></i
                                        ><span>System Settings</span>
                                    </router-link>
                                </div>
                                <button
                                    @click="handleLogout"
                                    class="w-full flex items-center space-x-3 px-6 py-4 bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white text-xs font-black uppercase tracking-[0.2em] transition-all border-t border-white/5"
                                >
                                    <i class="fas fa-power-off"></i
                                    ><span>Terminate Session</span>
                                </button>
                            </div>
                        </transition>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Content Area -->
        <div class="flex-grow container mx-auto px-6 py-12 relative z-10">
            <!-- Alerts -->
            <transition name="fade">
                <div
                    v-if="message"
                    :class="[
                        'fixed top-24 right-6 z-[60] px-6 py-4 rounded-2xl border backdrop-blur-md shadow-2xl flex items-center space-x-4 reveal-section active',
                        messageType === 'success'
                            ? 'bg-green-500/10 border-green-500/20 text-green-400'
                            : 'bg-red-500/10 border-red-500/20 text-red-400',
                    ]"
                >
                    <div
                        class="w-8 h-8 rounded-lg flex items-center justify-center font-bold"
                        :class="
                            messageType === 'success'
                                ? 'bg-green-500/20'
                                : 'bg-red-500/20'
                        "
                    >
                        <i
                            :class="
                                messageType === 'success'
                                    ? 'fas fa-check-circle'
                                    : 'fas fa-exclamation-triangle'
                            "
                        ></i>
                    </div>
                    <span class="text-sm font-bold">{{ message }}</span>
                    <button @click="message = ''" class="hover:opacity-70">
                        &times;
                    </button>
                </div>
            </transition>

            <!-- Dashboard Header -->
            <div class="mb-12 reveal-section active">
                <h2
                    class="text-red-500 font-mono tracking-[0.3em] text-xs mb-3 uppercase"
                >
                    Command Center
                </h2>
                <h1
                    class="text-4xl md:text-5xl font-black text-white tracking-tighter uppercase mb-4"
                >
                    Control
                    <span
                        class="text-transparent bg-clip-text bg-linear-to-r from-red-500 to-red-600"
                        >Interface</span
                    >
                </h1>
                <div class="flex flex-wrap gap-3 mt-8">
                    <button
                        v-for="tab in tabConfigs"
                        :key="tab.id"
                        @click="activeTab = tab.id"
                        :class="[
                            'px-6 py-3 rounded-xl font-black uppercase tracking-widest text-xs transition-all border outline-none',
                            activeTab === tab.id
                                ? 'bg-red-500 text-white border-red-500 shadow-[0_0_20px_rgba(239,68,68,0.3)]'
                                : 'bg-white/5 text-gray-500 border-white/10 hover:bg-white/10 hover:text-white',
                        ]"
                    >
                        <i :class="tab.icon" class="mr-2"></i>{{ tab.label }}
                    </button>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="reveal-section active">
                <AdminMonitor
                    v-if="activeTab === 'overview'"
                    :analytics="analytics"
                />

                <CombatModules
                    v-else-if="activeTab === 'qa_fps'"
                    :games="games"
                    @refresh="fetchDashboardData"
                    @message="showMessage"
                />

                <VocabularyLink
                    v-else-if="activeTab === 'typergel1'"
                    :games="games"
                    @refresh="fetchDashboardData"
                    @message="showMessage"
                />

                <ArchiveHub
                    v-else-if="activeTab === 'studies'"
                    :lessons="lessons"
                    @refresh="fetchDashboardData"
                    @message="showMessage"
                />
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import AdminMonitor from "./admin/AdminMonitor.vue";
import CombatModules from "./admin/CombatModules.vue";
import VocabularyLink from "./admin/VocabularyLink.vue";
import ArchiveHub from "./admin/ArchiveHub.vue";

export default {
    name: "AdminDashboard",
    components: {
        AdminMonitor,
        CombatModules,
        VocabularyLink,
        ArchiveHub,
    },
    data() {
        return {
            user: null,
            showProfileDropdown: false,
            message: "",
            messageType: "success",
            games: [],
            lessons: [],
            activeTab: "overview",
            tabConfigs: [
                {
                    id: "overview",
                    label: "Monitor",
                    icon: "fas fa-tachometer-alt",
                },
                {
                    id: "qa_fps",
                    label: "Combat Modules",
                    icon: "fas fa-crosshairs",
                },
                {
                    id: "typergel1",
                    label: "Vocabulary Link",
                    icon: "fas fa-keyboard",
                },
                { id: "studies", label: "Archive Hub", icon: "fas fa-book" },
            ],
            analytics: {
                totals: {
                    total_users: 0,
                    new_users_last_30_days: 0,
                    total_sessions: 0,
                    total_score: 0,
                },
                user_stats: {
                    total_users: 0,
                    active_users: 0,
                    disabled_users: 0,
                    admin_users: 0,
                    regular_users: 0,
                },
                daily_sessions_last_30_days: [],
                monthly_sessions_last_12_months: [],
            },
        };
    },
    computed: {},
    async mounted() {
        console.log("[AdminDashboard] Component mounting...");
        try {
            await this.fetchUser();
            console.log("[AdminDashboard] User fetched:", this.user);
            await this.fetchDashboardData();
            console.log("[AdminDashboard] Dashboard data fetched");
            document.addEventListener("click", this.handleClickOutside);
            console.log("[AdminDashboard] Mount complete");
        } catch (error) {
            console.error("[AdminDashboard] Mount error:", error);
        }
    },
    beforeUnmount() {
        document.removeEventListener("click", this.handleClickOutside);
    },
    methods: {
        async fetchUser() {
            try {
                const response = await axios.get("/api/user");
                this.user = response.data.user;
            } catch (error) {
                this.$router.push("/login");
            }
        },
        async fetchDashboardData() {
            try {
                const response = await axios.get("/api/admin/dashboard-data");
                this.games = response.data.games || [];
                this.lessons = response.data.lessons || [];
                if (response.data.analytics) {
                    this.analytics.totals =
                        response.data.analytics.totals || this.analytics.totals;
                    this.analytics.user_stats =
                        response.data.analytics.user_stats ||
                        this.analytics.user_stats;
                    this.analytics.daily_sessions_last_30_days =
                        response.data.analytics.daily_sessions_last_30_days ||
                        [];
                    this.analytics.monthly_sessions_last_12_months =
                        response.data.analytics
                            .monthly_sessions_last_12_months || [];
                }
            } catch (error) {
                this.showMessage(
                    "System integrity fault during data sync.",
                    "error",
                );
            }
        },
        showMessage(msg, type) {
            this.message = msg;
            this.messageType = type;
            setTimeout(() => {
                this.message = "";
            }, 5000);
        },
        async handleLogout() {
            try {
                await axios.post("/api/logout");
                this.$router.push("/login");
            } catch (error) {
                this.$router.push("/login");
            }
        },
        handleClickOutside(event) {
            if (!event.target.closest(".relative"))
                this.showProfileDropdown = false;
        },
    },
};
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap");

.font-sans {
    font-family: "Space Grotesk", sans-serif;
}

.reveal-section {
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.6s cubic-bezier(0.2, 0.8, 0.2, 1);
}

.reveal-section.active {
    opacity: 1;
    transform: translateY(0);
}

.dropdown-enter-active,
.dropdown-leave-active {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.dropdown-enter-from,
.dropdown-leave-to {
    opacity: 0;
    transform: translateY(-10px);
}

.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(239, 68, 68, 0.2);
    border-radius: 10px;
}
</style>

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
                    to="/user/dashboard"
                    class="flex items-center space-x-3 group"
                >
                    <div
                        class="w-10 h-10 bg-red-500 rounded-lg flex items-center justify-center transform group-hover:rotate-12 transition-transform duration-300"
                    >
                        <i class="fas fa-microchip text-white text-xl"></i>
                    </div>
                    <span
                        class="text-xl font-bold tracking-tighter text-white group-hover:text-red-500 transition-colors uppercase"
                        >KNOWIT GEL1</span
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
                                    class="text-[10px] font-mono text-gray-500 uppercase tracking-widest"
                                >
                                    Active Link
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
                                        to="/user/dashboard"
                                        class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-white/5 text-sm font-bold text-gray-400 hover:text-white transition-all"
                                    >
                                        <i class="fas fa-th-large w-5"></i
                                        ><span>Dashboard Hub</span>
                                    </router-link>
                                    <router-link
                                        to="/user/profile"
                                        class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-white/5 text-sm font-bold text-gray-400 hover:text-white transition-all"
                                    >
                                        <i class="fas fa-user-circle w-5"></i
                                        ><span>Profile Meta</span>
                                    </router-link>
                                    <router-link
                                        to="/user/settings"
                                        class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-white/5 text-sm font-bold text-gray-400 hover:text-white transition-all"
                                    >
                                        <i class="fas fa-cog w-5"></i
                                        ><span>Parameters</span>
                                    </router-link>
                                </div>
                                <button
                                    @click="handleLogout"
                                    class="w-full flex items-center space-x-3 px-6 py-4 bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white text-xs font-black uppercase tracking-[0.2em] transition-all border-t border-white/5"
                                >
                                    <i class="fas fa-power-off"></i
                                    ><span>Terminate Link</span>
                                </button>
                            </div>
                        </transition>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Content -->
        <div class="flex-grow container mx-auto px-6 py-12 relative z-10">
            <!-- Header Section -->
            <div class="mb-12 reveal-section active">
                <h2
                    class="text-red-500 font-mono tracking-[0.3em] text-xs mb-3 uppercase"
                >
                    Neural Registry
                </h2>
                <h1
                    class="text-4xl md:text-5xl font-black text-white tracking-tighter uppercase mb-4"
                >
                    Archived
                    <span
                        class="text-transparent bg-clip-text bg-linear-to-r from-red-500 to-red-600"
                        >Syncs</span
                    >
                </h1>
                <p class="text-gray-500 max-w-xl font-medium">
                    Historical data of your interaction with the GEL1 network
                    and learning modules.
                </p>
            </div>

            <!-- Summary Stats Grid -->
            <div
                class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12 reveal-section active"
            >
                <!-- Total Sessions -->
                <div
                    class="bg-white/5 border border-white/10 rounded-3xl p-8 hover:bg-white/10 transition-all group overflow-hidden relative"
                >
                    <div
                        class="absolute -bottom-6 -right-6 opacity-5 group-hover:opacity-10 transition-opacity transform rotate-12"
                    >
                        <i class="fas fa-history text-8xl text-red-500"></i>
                    </div>
                    <div class="relative z-10">
                        <p
                            class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-6"
                        >
                            Total Sessions
                        </p>
                        <p
                            class="text-5xl font-black text-white tracking-tighter mb-2"
                        >
                            {{ stats.total_sessions }}
                        </p>
                        <p class="text-xs font-mono text-gray-600 uppercase">
                            Synchronized Instances
                        </p>
                    </div>
                </div>

                <!-- Total Score -->
                <div
                    class="bg-white/5 border border-white/10 rounded-3xl p-8 hover:bg-white/10 transition-all group overflow-hidden relative"
                >
                    <div
                        class="absolute -bottom-6 -right-6 opacity-5 group-hover:opacity-10 transition-opacity transform -rotate-12"
                    >
                        <i class="fas fa-trophy text-8xl text-red-500"></i>
                    </div>
                    <div class="relative z-10">
                        <p
                            class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-6"
                        >
                            Aggregate Aptitude
                        </p>
                        <p
                            class="text-5xl font-black text-white tracking-tighter mb-2"
                        >
                            {{ stats.total_score.toLocaleString() }}
                        </p>
                        <p class="text-xs font-mono text-gray-600 uppercase">
                            Cumulative Points
                        </p>
                    </div>
                </div>

                <!-- Game Breakdown -->
                <div
                    class="bg-white/5 border border-white/10 rounded-3xl p-8 hover:bg-white/10 transition-all group overflow-hidden relative"
                >
                    <div
                        class="absolute -bottom-6 -right-6 opacity-5 group-hover:opacity-10 transition-opacity"
                    >
                        <i class="fas fa-chart-bar text-8xl text-red-500"></i>
                    </div>
                    <div class="relative z-10 h-full flex flex-col">
                        <p
                            class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-6"
                        >
                            Sector Metrics
                        </p>
                        <div
                            class="space-y-4 overflow-y-auto max-h-32 custom-scrollbar"
                        >
                            <div
                                v-for="(item, key) in stats.per_game"
                                :key="key"
                                class="flex justify-between items-center bg-white/5 p-3 rounded-xl border border-white/5"
                            >
                                <div>
                                    <p
                                        class="text-xs font-bold text-white uppercase tracking-tight"
                                    >
                                        {{ gameLabel(key) }}
                                    </p>
                                    <p
                                        class="text-[8px] font-mono text-gray-600 uppercase"
                                    >
                                        {{ item.sessions }} Syncs
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p
                                        class="text-sm font-black text-red-500 tracking-tighter"
                                    >
                                        {{ item.total_score.toLocaleString() }}
                                    </p>
                                </div>
                            </div>
                            <div
                                v-if="!Object.keys(stats.per_game).length"
                                class="text-center py-4"
                            >
                                <p
                                    class="text-[10px] font-mono text-gray-700 uppercase"
                                >
                                    No sessions recorded
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- History Data Terminal -->
            <div
                class="bg-white/5 border border-white/10 rounded-3xl overflow-hidden shadow-2xl reveal-section active"
            >
                <div
                    class="p-6 border-b border-white/5 bg-white/[0.02] flex items-center justify-between"
                >
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-10 h-10 bg-red-500/10 rounded-lg flex items-center justify-center text-red-500"
                        >
                            <i class="fas fa-database text-xs"></i>
                        </div>
                        <span
                            class="text-xs font-black text-white uppercase tracking-widest"
                            >Protocol Log v1.0</span
                        >
                    </div>
                    <div class="flex items-center space-x-2">
                        <div
                            class="w-2 h-2 bg-green-500 rounded-full animate-pulse"
                        ></div>
                        <span
                            class="text-[10px] font-mono text-gray-600 uppercase"
                            >System Ready</span
                        >
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-white/5 border-b border-white/5">
                                <th
                                    class="px-8 py-5 text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]"
                                >
                                    Module / Sector
                                </th>
                                <th
                                    class="px-8 py-5 text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] text-center"
                                >
                                    Score Output
                                </th>
                                <th
                                    class="px-8 py-5 text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] text-right"
                                >
                                    Synchronization Time
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            <tr
                                v-for="entry in history"
                                :key="entry.id"
                                class="group hover:bg-white/[0.03] transition-colors"
                            >
                                <td class="px-8 py-6">
                                    <div class="flex items-center space-x-4">
                                        <div
                                            class="w-12 h-12 rounded-xl border border-white/10 bg-white/5 flex items-center justify-center text-gray-500 group-hover:text-red-500 group-hover:border-red-500/50 transition-all"
                                        >
                                            <i
                                                :class="
                                                    gameIcon(entry.game_type)
                                                "
                                            ></i>
                                        </div>
                                        <div>
                                            <p
                                                class="text-sm font-bold text-white uppercase tracking-tight"
                                            >
                                                {{ entry.game_label }}
                                            </p>
                                            <p
                                                class="text-[10px] font-mono text-gray-600 uppercase"
                                            >
                                                {{ entry.game_type }} sector
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <span
                                        class="inline-block px-4 py-2 bg-red-500/10 border border-red-500/20 rounded-xl text-red-500 font-black text-lg tracking-tighter"
                                    >
                                        {{ entry.score }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <p
                                        class="text-xs font-bold text-gray-400 mb-1"
                                    >
                                        {{ formatDateOnly(entry.played_at) }}
                                    </p>
                                    <p
                                        class="text-[10px] font-mono text-gray-700 uppercase"
                                    >
                                        {{
                                            formatTimeOnly(entry.played_at)
                                        }}
                                        UTC-0
                                    </p>
                                </td>
                            </tr>
                            <tr v-if="!history.length && !isLoading">
                                <td colspan="3" class="px-8 py-20 text-center">
                                    <div
                                        class="w-16 h-16 bg-white/5 rounded-2xl flex items-center justify-center mx-auto mb-6 opacity-20"
                                    >
                                        <i
                                            class="fas fa-folder-open text-4xl text-gray-500"
                                        ></i>
                                    </div>
                                    <p
                                        class="text-sm font-bold text-gray-600 uppercase tracking-widest"
                                    >
                                        No archival data found.
                                    </p>
                                    <p
                                        class="text-xs text-gray-700 mt-1 italic"
                                    >
                                        Initiate learning modules to generate
                                        logs.
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div
                    v-if="isLoading"
                    class="p-20 flex flex-col items-center justify-center"
                >
                    <div class="relative w-12 h-12 mb-4">
                        <div
                            class="absolute inset-0 border-2 border-red-500/20 rounded-full"
                        ></div>
                        <div
                            class="absolute inset-0 border-2 border-t-red-500 rounded-full animate-spin"
                        ></div>
                    </div>
                    <p
                        class="text-[10px] font-mono text-red-500 uppercase tracking-widest animate-pulse"
                    >
                        Scanning Archive Database...
                    </p>
                </div>
            </div>
        </div>

        <!-- Background Loader -->
        <div
            v-if="isLoading && !history.length"
            class="fixed inset-0 bg-[#0a0a0a]/95 z-[9999] flex flex-col justify-center items-center backdrop-blur-sm"
        >
            <div class="relative w-24 h-24 mb-8">
                <div
                    class="absolute inset-0 border-4 border-red-500/20 rounded-full"
                ></div>
                <div
                    class="absolute inset-0 border-4 border-t-red-500 rounded-full animate-spin"
                ></div>
                <i
                    class="fas fa-history text-red-500 text-2xl absolute inset-0 flex items-center justify-center animate-pulse"
                ></i>
            </div>
            <div
                class="text-red-500 text-xs font-mono tracking-[0.5em] uppercase"
            >
                Initialising Archive Link...
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "UserHistory",
    data() {
        return {
            user: null,
            history: [],
            stats: {
                total_score: 0,
                total_sessions: 0,
                per_game: {},
            },
            isLoading: false,
            showProfileDropdown: false,
        };
    },
    async mounted() {
        await this.fetchUser();
        await this.fetchHistory();
        document.addEventListener("click", this.handleClickOutside);
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
                console.error("Failed to fetch user:", error);
                this.$router.push("/login");
            }
        },
        async fetchHistory() {
            this.isLoading = true;
            try {
                const response = await axios.get("/api/user/history");
                if (response.data.status === "success") {
                    this.history = response.data.history || [];
                    this.stats = response.data.stats || this.stats;
                }
            } catch (error) {
                console.error("Failed to fetch history:", error);
            } finally {
                this.isLoading = false;
            }
        },
        gameLabel(type) {
            const map = {
                qa_fps: "Combat Sync",
                typergel1: "Neural Velocity",
                assessment: "Calibration",
                guess_part: "Hardware Ident",
                lesson: "Archive Study",
            };
            return map[type] || type;
        },
        gameIcon(type) {
            const map = {
                qa_fps: "fas fa-crosshairs",
                typergel1: "fas fa-keyboard",
                assessment: "fas fa-microchip",
                guess_part: "fas fa-memory",
                lesson: "fas fa-book-open",
            };
            return map[type] || "fas fa-gamepad";
        },
        formatDateOnly(value) {
            if (!value) return "";
            const date = new Date(value);
            return date.toLocaleDateString(undefined, {
                year: "numeric",
                month: "short",
                day: "numeric",
            });
        },
        formatTimeOnly(value) {
            if (!value) return "";
            const date = new Date(value);
            return date.toLocaleTimeString(undefined, {
                hour: "2-digit",
                minute: "2-digit",
            });
        },
        async handleLogout() {
            try {
                await axios.post("/api/logout");
                this.$router.push("/login");
            } catch (error) {
                console.error("Logout failed:", error);
                this.$router.push("/login");
            }
        },
        handleClickOutside(event) {
            const profileDropdown = event.target.closest(".relative");
            if (!profileDropdown) {
                this.showProfileDropdown = false;
            }
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

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: rgba(239, 68, 68, 0.4);
}
</style>

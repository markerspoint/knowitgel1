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
                <router-link to="/" class="flex items-center space-x-3 group">
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
                                    Learner Level 1
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
                        <!-- Dropdown -->
                        <transition name="dropdown">
                            <div
                                v-show="showProfileDropdown"
                                class="absolute right-0 mt-3 w-56 bg-[#181818] border border-white/10 rounded-2xl shadow-2xl overflow-hidden z-50"
                            >
                                <div
                                    class="p-4 border-b border-white/5 bg-white/5"
                                >
                                    <p
                                        class="text-xs font-black text-red-500 uppercase tracking-widest mb-1"
                                    >
                                        Terminal Session
                                    </p>
                                    <p
                                        class="text-[10px] font-mono text-gray-500 uppercase"
                                    >
                                        {{ user?.email }}
                                    </p>
                                </div>
                                <div class="p-2">
                                    <router-link
                                        to="/user/profile"
                                        class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-white/5 text-sm font-bold text-gray-400 hover:text-white transition-all"
                                    >
                                        <i class="fas fa-user-circle w-5"></i
                                        ><span>Profile Meta</span>
                                    </router-link>
                                    <router-link
                                        to="/leaderboard"
                                        class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-white/5 text-sm font-bold text-gray-400 hover:text-white transition-all"
                                    >
                                        <i
                                            class="fas fa-trophy w-5 text-yellow-500/50"
                                        ></i
                                        ><span>Global Rankings</span>
                                    </router-link>
                                    <router-link
                                        to="/user/history"
                                        class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-white/5 text-sm font-bold text-gray-400 hover:text-white transition-all"
                                    >
                                        <i class="fas fa-history w-5"></i
                                        ><span>Archived Syncs</span>
                                    </router-link>
                                    <router-link
                                        to="/user/settings"
                                        class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-white/5 text-sm font-bold text-gray-400 hover:text-white transition-all"
                                    >
                                        <i class="fas fa-sliders-h w-5"></i
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
            <!-- Welcome Header -->
            <div class="mb-16 reveal-section active">
                <h2
                    class="text-red-500 font-mono tracking-[0.3em] text-xs mb-3 uppercase"
                >
                    Learner Interface
                </h2>
                <h1
                    class="text-4xl md:text-6xl font-black text-white tracking-tighter uppercase mb-4"
                >
                    Welcome,
                    <span
                        class="text-transparent bg-clip-text bg-linear-to-r from-red-500 to-red-600"
                        >{{ user?.fname }}</span
                    >
                </h1>
                <p class="text-gray-500 max-w-xl font-medium">
                    Initialize your learning modules or review your current
                    aptitude metrics across the GEL1 network.
                </p>
            </div>

            <!-- Tech Status Banner -->
            <div v-if="gameAlertMessage" class="mb-12 reveal-section active">
                <div
                    class="bg-red-500/10 border border-red-500/20 rounded-2xl p-4 flex items-center justify-between backdrop-blur-md"
                >
                    <div class="flex items-center space-x-4">
                        <div
                            class="w-10 h-10 bg-red-500 rounded-lg flex items-center justify-center animate-pulse"
                        >
                            <i
                                class="fas fa-exclamation-triangle text-white"
                            ></i>
                        </div>
                        <p
                            class="text-sm font-bold text-red-400 tracking-tight"
                        >
                            {{ gameAlertMessage }}
                        </p>
                    </div>
                    <button
                        @click="gameAlertMessage = ''"
                        class="text-red-400 hover:text-white transition-colors"
                    >
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <!-- Stats Grid -->
            <div
                class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16 reveal-section active"
            >
                <div
                    v-for="(stat, i) in playerStats"
                    :key="i"
                    class="bg-white/5 border border-white/10 rounded-3xl p-8 hover:bg-white/10 transition-all group overflow-hidden relative"
                >
                    <div
                        class="absolute -bottom-6 -right-6 opacity-5 group-hover:opacity-10 transition-opacity transform rotate-12"
                    >
                        <i :class="stat.icon" class="text-8xl text-red-500"></i>
                    </div>
                    <div class="relative z-10">
                        <div class="flex items-center space-x-3 mb-6">
                            <div
                                class="w-10 h-10 rounded-xl bg-red-500/10 flex items-center justify-center text-red-500 group-hover:bg-red-500 group-hover:text-white transition-all"
                            >
                                <i :class="stat.icon"></i>
                            </div>
                            <span
                                class="text-xs font-black text-gray-500 uppercase tracking-widest"
                                >{{ stat.label }}</span
                            >
                        </div>
                        <p
                            class="text-5xl font-black text-white tracking-tighter mb-2"
                        >
                            {{ stat.value }}
                        </p>
                        <p class="text-xs font-mono text-gray-600 uppercase">
                            {{ stat.desc }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Learning Modules -->
            <div class="reveal-section active">
                <div class="flex items-center justify-between mb-8">
                    <h3
                        class="text-2xl font-black text-white uppercase tracking-tighter italic"
                    >
                        Available Modules
                    </h3>
                    <div class="h-px grow mx-6 bg-white/5"></div>
                    <span
                        class="text-xs font-mono text-gray-600 uppercase tracking-widest"
                        >Ready for Deployment</span
                    >
                </div>

                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
                >
                    <!-- Shooting Game Card -->
                    <div
                        @click="handleGameClick('qa_fps')"
                        :class="[
                            !gameSettings.qa_fps_enabled
                                ? 'opacity-50 grayscale cursor-not-allowed'
                                : 'cursor-pointer hover:-translate-y-2',
                        ]"
                        class="group bg-white/5 border border-white/10 rounded-3xl overflow-hidden transition-all shadow-2xl relative"
                    >
                        <div
                            class="aspect-video relative overflow-hidden bg-gray-900"
                        >
                            <div
                                class="absolute inset-0 bg-linear-to-t from-[#111] via-transparent to-transparent z-10"
                            ></div>
                            <img
                                src="/images/computer-parts-bg.png"
                                alt="QA FPS"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 opacity-40"
                                @error="$event.target.style.display = 'none'"
                            />
                            <div class="absolute top-4 left-4 z-20">
                                <span
                                    class="px-3 py-1 bg-red-500 text-white text-[10px] font-black uppercase rounded-lg shadow-lg"
                                    >Module I</span
                                >
                            </div>
                        </div>
                        <div class="p-8 relative z-20">
                            <h4
                                class="text-2xl font-black text-white uppercase tracking-tighter mb-2 group-hover:text-red-500 transition-colors"
                            >
                                Combat Sync: IT Basics
                            </h4>
                            <p
                                class="text-sm text-gray-500 leading-relaxed mb-6"
                            >
                                Precision shooter module focused on identifying
                                computer hardware architectures.
                            </p>
                            <div class="flex items-center justify-between">
                                <span
                                    class="text-xs font-mono text-gray-600 uppercase"
                                    >Q&A Shooting Game</span
                                >
                                <div
                                    class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center text-white group-hover:bg-red-500 group-hover:border-red-500 transition-all"
                                >
                                    <i class="fas fa-play text-xs ml-1"></i>
                                </div>
                            </div>
                        </div>
                        <div
                            v-if="!gameSettings.qa_fps_enabled"
                            class="absolute inset-0 z-30 bg-black/60 backdrop-blur-[2px] flex items-center justify-center p-6 text-center"
                        >
                            <p
                                class="text-xs font-black text-white uppercase tracking-widest bg-red-500 px-4 py-2 rounded-lg"
                            >
                                Offline by Admin
                            </p>
                        </div>
                    </div>

                    <!-- Typing Game Card -->
                    <div
                        @click="handleGameClick('typergel1')"
                        :class="[
                            !gameSettings.typergel1_enabled
                                ? 'opacity-50 grayscale cursor-not-allowed'
                                : 'cursor-pointer hover:-translate-y-2',
                        ]"
                        class="group bg-white/5 border border-white/10 rounded-3xl overflow-hidden transition-all shadow-2xl relative"
                    >
                        <div
                            class="aspect-video relative overflow-hidden bg-gray-900"
                        >
                            <div
                                class="absolute inset-0 bg-linear-to-t from-[#111] via-transparent to-transparent z-10"
                            ></div>
                            <img
                                src="/images/qa-game-bg.png"
                                alt="TyperGel1"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 opacity-40"
                                @error="$event.target.style.display = 'none'"
                            />
                            <div class="absolute top-4 left-4 z-20">
                                <span
                                    class="px-3 py-1 bg-blue-500 text-white text-[10px] font-black uppercase rounded-lg shadow-lg"
                                    >Module II</span
                                >
                            </div>
                        </div>
                        <div class="p-8 relative z-20">
                            <h4
                                class="text-2xl font-black text-white uppercase tracking-tighter mb-2 group-hover:text-red-500 transition-colors"
                            >
                                Neural Velocity
                            </h4>
                            <p
                                class="text-sm text-gray-500 leading-relaxed mb-6"
                            >
                                High-speed typing challenge designed to master
                                ICT terminology and concepts.
                            </p>
                            <div class="flex items-center justify-between">
                                <span
                                    class="text-xs font-mono text-gray-600 uppercase"
                                    >Typer Training</span
                                >
                                <div
                                    class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center text-white group-hover:bg-red-500 group-hover:border-red-500 transition-all"
                                >
                                    <i class="fas fa-keyboard text-xs"></i>
                                </div>
                            </div>
                        </div>
                        <div
                            v-if="!gameSettings.typergel1_enabled"
                            class="absolute inset-0 z-30 bg-black/60 backdrop-blur-[2px] flex items-center justify-center p-6 text-center"
                        >
                            <p
                                class="text-xs font-black text-white uppercase tracking-widest bg-red-500 px-4 py-2 rounded-lg"
                            >
                                Offline by Admin
                            </p>
                        </div>
                    </div>

                    <!-- Documentation Card -->
                    <div
                        @click="handleStudiesClick"
                        class="group bg-white/5 border border-white/10 rounded-3xl overflow-hidden transition-all shadow-2xl cursor-pointer hover:-translate-y-2 relative"
                    >
                        <div
                            class="aspect-video relative overflow-hidden bg-gray-900"
                        >
                            <div
                                class="absolute inset-0 bg-linear-to-t from-[#111] via-transparent to-transparent z-10"
                            ></div>
                            <img
                                src="/images/lesson-game-bg.png"
                                alt="Studies"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 opacity-40"
                                @error="$event.target.style.display = 'none'"
                            />
                            <div class="absolute top-4 left-4 z-20">
                                <span
                                    class="px-3 py-1 bg-purple-500 text-white text-[10px] font-black uppercase rounded-lg shadow-lg"
                                    >Archive</span
                                >
                            </div>
                        </div>
                        <div class="p-8 relative z-20">
                            <h4
                                class="text-2xl font-black text-white uppercase tracking-tighter mb-2 group-hover:text-red-500 transition-colors"
                            >
                                Knowledge Base
                            </h4>
                            <p
                                class="text-sm text-gray-500 leading-relaxed mb-6"
                            >
                                Access archived lessons, documentation, and
                                conceptual theory files.
                            </p>
                            <div class="flex items-center justify-between">
                                <span
                                    class="text-xs font-mono text-gray-600 uppercase"
                                    >Academic Repository</span
                                >
                                <div
                                    class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center text-white group-hover:bg-red-500 group-hover:border-red-500 transition-all"
                                >
                                    <i class="fas fa-book-open text-xs"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Interface Loader Overlay -->
        <div
            v-if="isLoading"
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
                    class="fas fa-user text-red-500 text-2xl absolute inset-0 flex items-center justify-center animate-pulse"
                ></i>
            </div>
            <div
                class="text-red-500 text-xs font-mono tracking-[0.5em] uppercase"
            >
                Authenticating Terminal...
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "UserDashboard",
    data() {
        return {
            user: null,
            games: [],
            stats: {
                total_score: 0,
                games_played: 0,
                assessment_score: 0,
            },
            gameSettings: {
                qa_fps_enabled: true,
                typergel1_enabled: true,
            },
            gameAlertMessage: "",
            showProfileDropdown: false,
            isLoading: true,
        };
    },
    computed: {
        playerStats() {
            return [
                {
                    label: "Network Points",
                    value: this.stats?.total_score || 0,
                    icon: "fas fa-trophy",
                    desc: "Cumulative Aptitude",
                },
                {
                    label: "Syncs Completed",
                    value: this.stats?.games_played || 0,
                    icon: "fas fa-shield-alt",
                    desc: "Active Sessions",
                },
                {
                    label: "Link Calibration",
                    value: this.stats?.assessment_score || 0,
                    icon: "fas fa-microchip",
                    desc: "Initial Baseline",
                },
            ];
        },
    },
    async mounted() {
        await this.fetchUser();
        await this.fetchDashboardData();
        await this.fetchGameSettings();
        document.addEventListener("click", this.handleClickOutside);
        this.isLoading = false;
    },
    beforeUnmount() {
        document.removeEventListener("click", this.handleClickOutside);
    },
    methods: {
        async fetchUser() {
            try {
                const response = await axios.get("/api/user");
                const user = response.data.user;

                if (user.is_disabled) {
                    try {
                        await axios.post("/api/logout");
                    } catch (logoutError) {
                        console.error("Logout error:", logoutError);
                    }
                    this.$router.push({
                        path: "/login",
                        query: { disabled: "true" },
                    });
                    return;
                }

                this.user = user;
            } catch (error) {
                console.error("Failed to fetch user:", error);
                this.$router.push("/login");
            }
        },
        async fetchDashboardData() {
            try {
                const response = await axios.get("/api/user/dashboard-data");
                this.games = response.data.games;
                this.stats = response.data.stats;
            } catch (error) {
                console.error("Failed to fetch dashboard data:", error);
            }
        },
        async fetchGameSettings() {
            try {
                const response = await axios.get("/api/user/game-settings");
                if (response.data.status === "success") {
                    this.gameSettings = response.data.settings;
                }
            } catch (error) {
                console.error("Failed to fetch game settings:", error);
            }
        },
        handleGameClick(gameType) {
            if (gameType === "qa_fps" && !this.gameSettings.qa_fps_enabled) {
                this.gameAlertMessage =
                    "Module Offline: Q&A FPS game is currently hardware-restricted by administration.";
                setTimeout(() => {
                    this.gameAlertMessage = "";
                }, 5000);
                return;
            }

            if (
                gameType === "typergel1" &&
                !this.gameSettings.typergel1_enabled
            ) {
                this.gameAlertMessage =
                    "Protocol Fault: TyperGel1 game is currently software-restricted by administration.";
                setTimeout(() => {
                    this.gameAlertMessage = "";
                }, 5000);
                return;
            }

            if (gameType === "qa_fps") {
                this.$router.push("/qa-fps");
            } else if (gameType === "typergel1") {
                this.$router.push("/typergel1");
            }
        },
        handleStudiesClick() {
            this.$router.push("/lessons");
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
            const dropdownContainer = event.target.closest(".relative");
            if (!dropdownContainer) {
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

::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #111;
}

::-webkit-scrollbar-thumb {
    background: #333;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #ef4444;
}
</style>

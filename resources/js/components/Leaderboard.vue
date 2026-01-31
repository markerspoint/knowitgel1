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
                                        to="/user/history"
                                        class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-white/5 text-sm font-bold text-gray-400 hover:text-white transition-all"
                                    >
                                        <i class="fas fa-history w-5"></i
                                        ><span>Archived Syncs</span>
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
                    Global Standing
                </h2>
                <h1
                    class="text-4xl md:text-5xl font-black text-white tracking-tighter uppercase mb-4"
                >
                    Network
                    <span
                        class="text-transparent bg-clip-text bg-linear-to-r from-red-500 to-red-600"
                        >Leaderboards</span
                    >
                </h1>
                <p class="text-gray-500 max-w-xl font-medium">
                    Comparative aptitude metrics across all synchronized
                    learners in the GEL1 network.
                </p>
            </div>

            <!-- Filter Section -->
            <div
                class="bg-white/5 border border-white/10 rounded-3xl p-6 mb-12 reveal-section active backdrop-blur-md"
            >
                <div
                    class="flex flex-col md:flex-row items-center justify-between gap-6"
                >
                    <div class="flex items-center space-x-4">
                        <div
                            class="w-12 h-12 bg-red-500/10 rounded-xl flex items-center justify-center text-red-500"
                        >
                            <i class="fas fa-filter text-xl"></i>
                        </div>
                        <div>
                            <p
                                class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-1"
                            >
                                Sector Filter
                            </p>
                            <h3
                                class="text-lg font-bold text-white uppercase tracking-tight"
                            >
                                Isolate Game Type
                            </h3>
                        </div>
                    </div>
                    <div class="relative w-full md:w-64 group">
                        <select
                            v-model="selectedGameType"
                            @change="fetchLeaderboard"
                            class="w-full appearance-none bg-white/5 border border-white/10 rounded-2xl py-4 px-6 text-white text-sm font-bold uppercase tracking-widest focus:outline-none focus:border-red-500/50 focus:bg-white/10 transition-all cursor-pointer"
                        >
                            <option value="all" class="bg-[#181818]">
                                Global Aggregated
                            </option>
                            <option value="qa_fps" class="bg-[#181818]">
                                Combat Sync (FPS)
                            </option>
                            <option value="typergel1" class="bg-[#181818]">
                                Neural Velocity
                            </option>
                            <option value="assessment" class="bg-[#181818]">
                                Initial Calibration
                            </option>
                        </select>
                        <div
                            class="absolute inset-y-0 right-5 flex items-center pointer-events-none text-red-500"
                        >
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current User Rank Card -->
            <transition name="fade">
                <div
                    v-if="currentUserRank"
                    class="mb-12 reveal-section active relative group"
                >
                    <div
                        class="absolute inset-0 bg-linear-to-r from-red-500/20 to-coral-500/20 rounded-3xl blur-xl opacity-50 group-hover:opacity-100 transition-opacity"
                    ></div>
                    <div
                        class="relative bg-linear-to-r from-red-600 to-red-500 rounded-3xl p-8 flex flex-col md:flex-row items-center justify-between shadow-2xl overflow-hidden"
                    >
                        <!-- Decorative Icon -->
                        <div
                            class="absolute -right-10 -bottom-10 opacity-10 pointer-events-none"
                        >
                            <i
                                class="fas fa-trophy text-[12rem] text-white"
                            ></i>
                        </div>

                        <div
                            class="flex items-center space-x-6 relative z-10 mb-6 md:mb-0"
                        >
                            <div
                                class="w-24 h-24 rounded-2xl border-4 border-white/20 shadow-2xl overflow-hidden bg-white/10"
                            >
                                <img
                                    v-if="currentUserRank.profile_picture"
                                    :src="'/' + currentUserRank.profile_picture"
                                    alt="Profile"
                                    class="w-full h-full object-cover"
                                />
                                <div
                                    v-else
                                    class="w-full h-full flex items-center justify-center text-white text-3xl font-black italic"
                                >
                                    {{ currentUserRank.fname?.charAt(0)
                                    }}{{ currentUserRank.lname?.charAt(0) }}
                                </div>
                            </div>
                            <div>
                                <p
                                    class="text-[10px] font-black text-white/70 uppercase tracking-[0.3em] mb-1"
                                >
                                    Your Network Standing
                                </p>
                                <h3
                                    class="text-4xl font-black text-white tracking-tighter uppercase mb-1"
                                >
                                    Position #{{ currentUserRank.rank }}
                                </h3>
                                <p
                                    class="text-white font-bold tracking-tight opacity-90"
                                >
                                    {{ currentUserRank.fname }}
                                    {{ currentUserRank.lname }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-12 relative z-10">
                            <div class="text-center">
                                <p
                                    class="text-[10px] font-black text-white/70 uppercase tracking-widest mb-1"
                                >
                                    Verified Score
                                </p>
                                <p
                                    class="text-4xl font-black text-white tracking-tighter"
                                >
                                    {{
                                        currentUserRank.total_score.toLocaleString()
                                    }}
                                </p>
                            </div>
                            <div
                                class="text-center border-l border-white/20 pl-12"
                            >
                                <p
                                    class="text-[10px] font-black text-white/70 uppercase tracking-widest mb-1"
                                >
                                    Active Syncs
                                </p>
                                <p
                                    class="text-4xl font-black text-white tracking-tighter"
                                >
                                    {{ currentUserRank.games_played }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>

            <!-- Leaderboard Data Terminal -->
            <div
                class="bg-white/5 border border-white/10 rounded-3xl overflow-hidden shadow-2xl reveal-section active relative"
            >
                <!-- Progress Bar Placeholder for top of table -->
                <div class="h-1 w-full bg-white/5">
                    <div class="h-full bg-red-500 w-1/3 animate-pulse"></div>
                </div>

                <div
                    class="p-8 border-b border-white/5 bg-white/[0.02] flex items-center justify-between"
                >
                    <div class="flex items-center space-x-4">
                        <div
                            class="w-10 h-10 bg-red-500/10 rounded-lg flex items-center justify-center text-red-500"
                        >
                            <i class="fas fa-list-ol text-xs"></i>
                        </div>
                        <span
                            class="text-xs font-black text-white uppercase tracking-[0.2em]"
                            >Global Rank Manifest v1.02</span
                        >
                    </div>
                    <span
                        class="text-[10px] font-mono text-gray-600 uppercase tracking-widest"
                        >Target: Top 100 Learners</span
                    >
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-white/5 border-b border-white/5">
                                <th
                                    class="px-8 py-5 text-[10px] font-black text-gray-500 uppercase tracking-[0.3em] w-24"
                                >
                                    Rank
                                </th>
                                <th
                                    class="px-8 py-5 text-[10px] font-black text-gray-500 uppercase tracking-[0.3em]"
                                >
                                    Identity Matrix
                                </th>
                                <th
                                    class="px-8 py-5 text-[10px] font-black text-gray-500 uppercase tracking-[0.3em] text-center"
                                >
                                    Output Score
                                </th>
                                <th
                                    class="px-8 py-5 text-[10px] font-black text-gray-500 uppercase tracking-[0.3em] text-right"
                                >
                                    Activity Syncs
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            <tr
                                v-for="(player, index) in leaderboard"
                                :key="player.id"
                                :class="[
                                    'group transition-all duration-300',
                                    currentUserRank &&
                                    player.id === currentUserRank.id
                                        ? 'bg-red-500/5'
                                        : 'hover:bg-white/[0.03]',
                                ]"
                            >
                                <!-- Rank Cell -->
                                <td class="px-8 py-6">
                                    <div class="flex items-center">
                                        <span
                                            v-if="player.rank <= 3"
                                            class="text-xl mr-3 group-hover:scale-125 transition-transform duration-300"
                                        >
                                            {{
                                                player.rank === 1
                                                    ? "🥇"
                                                    : player.rank === 2
                                                      ? "🥈"
                                                      : "🥉"
                                            }}
                                        </span>
                                        <span
                                            :class="[
                                                'text-lg font-black tracking-tighter',
                                                player.rank === 1
                                                    ? 'text-yellow-500'
                                                    : player.rank === 2
                                                      ? 'text-gray-400'
                                                      : player.rank === 3
                                                        ? 'text-amber-600'
                                                        : 'text-gray-600 group-hover:text-red-500',
                                            ]"
                                        >
                                            #{{ player.rank }}
                                        </span>
                                        <div
                                            v-if="
                                                currentUserRank &&
                                                player.id === currentUserRank.id
                                            "
                                            class="ml-4 w-2 h-2 bg-red-500 rounded-full animate-ping"
                                        ></div>
                                    </div>
                                </td>

                                <!-- Player Cell -->
                                <td class="px-8 py-6">
                                    <div class="flex items-center space-x-4">
                                        <div
                                            class="w-12 h-12 rounded-xl border border-white/10 overflow-hidden relative group-hover:border-red-500/50 transition-colors shadow-lg"
                                        >
                                            <img
                                                v-if="player.profile_picture"
                                                :src="
                                                    '/' + player.profile_picture
                                                "
                                                alt="Profile"
                                                class="w-full h-full object-cover"
                                            />
                                            <div
                                                v-else
                                                class="w-full h-full bg-white/5 flex items-center justify-center text-red-500 font-black text-sm italic"
                                            >
                                                {{ player.fname?.charAt(0)
                                                }}{{ player.lname?.charAt(0) }}
                                            </div>
                                        </div>
                                        <div>
                                            <p
                                                class="text-sm font-black text-white uppercase tracking-tight"
                                            >
                                                {{ player.fname }}
                                                {{ player.lname }}
                                            </p>
                                            <p
                                                class="text-[10px] font-mono text-gray-600 uppercase"
                                            >
                                                @{{ player.username }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <!-- Score Cell -->
                                <td class="px-8 py-6 text-center">
                                    <span
                                        :class="[
                                            'inline-block px-5 py-2 rounded-xl font-black text-lg tracking-tighter transition-all',
                                            player.rank <= 3
                                                ? 'bg-white/10 text-white border border-white/10'
                                                : 'text-red-500 bg-red-500/5',
                                        ]"
                                    >
                                        {{
                                            player.total_score.toLocaleString()
                                        }}
                                    </span>
                                </td>

                                <!-- Syncs Cell -->
                                <td class="px-8 py-6 text-right">
                                    <div class="flex flex-col items-end">
                                        <span
                                            class="text-sm font-black text-gray-400"
                                            >{{ player.games_played }}</span
                                        >
                                        <span
                                            class="text-[9px] font-mono text-gray-700 uppercase"
                                            >Successful Links</span
                                        >
                                    </div>
                                </td>
                            </tr>

                            <!-- Empty State -->
                            <tr v-if="leaderboard.length === 0 && !isLoading">
                                <td colspan="4" class="px-8 py-24 text-center">
                                    <div
                                        class="w-20 h-20 bg-white/5 rounded-3xl flex items-center justify-center mx-auto mb-6 opacity-20"
                                    >
                                        <i
                                            class="fas fa-satellite text-5xl text-gray-500"
                                        ></i>
                                    </div>
                                    <h4
                                        class="text-sm font-black text-gray-500 uppercase tracking-widest mb-2"
                                    >
                                        No Uplink Data Found
                                    </h4>
                                    <p class="text-xs text-gray-700 italic">
                                        Initiate network activities to calibrate
                                        the leaderboard.
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Table Loading Overlay -->
                <div
                    v-if="isLoading"
                    class="absolute inset-0 bg-black/40 backdrop-blur-[2px] z-20 flex items-center justify-center"
                >
                    <div class="flex flex-col items-center">
                        <div class="w-12 h-12 relative animate-spin mb-4">
                            <div
                                class="absolute inset-0 border-2 border-red-500/20 rounded-full"
                            ></div>
                            <div
                                class="absolute inset-0 border-2 border-t-red-500 rounded-full"
                            ></div>
                        </div>
                        <p
                            class="text-[10px] font-mono text-red-500 uppercase tracking-[0.3em]"
                        >
                            Calculating Global Standings...
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Interface Loader -->
        <div
            v-if="isLoading && !leaderboard.length"
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
                    class="fas fa-globe text-red-500 text-2xl absolute inset-0 flex items-center justify-center animate-pulse"
                ></i>
            </div>
            <div
                class="text-red-500 text-xs font-mono tracking-[0.5em] uppercase"
            >
                Synchronizing Global Rankings...
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Leaderboard",
    data() {
        return {
            user: null,
            leaderboard: [],
            currentUserRank: null,
            selectedGameType: "all",
            isLoading: false,
            showProfileDropdown: false,
        };
    },
    async mounted() {
        await this.fetchUser();
        await this.fetchLeaderboard();
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
            }
        },
        async fetchLeaderboard() {
            this.isLoading = true;
            try {
                const response = await axios.get("/api/user/leaderboard", {
                    params: {
                        game_type: this.selectedGameType,
                        limit: 100,
                    },
                });

                if (response.data.status === "success") {
                    this.leaderboard = response.data.leaderboard;
                    this.currentUserRank = response.data.current_user_rank;
                    // Smooth scroll to my rank if I am in the list and just changed the filter
                    if (this.currentUserRank && this.leaderboard.length > 50) {
                        // Logic could go here for auto-scroll if needed
                    }
                }
            } catch (error) {
                console.error("Failed to fetch leaderboard:", error);
            } finally {
                this.isLoading = false;
            }
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

.fade-enter-active,
.fade-leave-active {
    transition: all 0.6s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
    transform: scale(0.95);
}
</style>

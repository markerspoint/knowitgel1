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
        <div
            class="flex-grow container mx-auto px-6 py-12 relative z-10 max-w-6xl"
        >
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

            <!-- Settings Header -->
            <div class="mb-12 reveal-section active">
                <h2
                    class="text-red-500 font-mono tracking-[0.3em] text-xs mb-3 uppercase"
                >
                    Neural Configuration
                </h2>
                <h1
                    class="text-4xl md:text-5xl font-black text-white tracking-tighter uppercase mb-4"
                >
                    Core System
                    <span
                        class="text-transparent bg-clip-text bg-linear-to-r from-red-500 to-red-600"
                        >Parameters</span
                    >
                </h1>
                <p
                    class="text-gray-500 font-medium max-w-2xl uppercase text-[10px] tracking-widest"
                >
                    Adjust global environment variables and security protocols
                    for the KNOWIT GEL1 ecosystem.
                </p>
            </div>

            <div
                class="grid grid-cols-1 lg:grid-cols-2 gap-8 reveal-section active"
            >
                <!-- Security Protocols (Password) -->
                <div
                    class="bg-white/5 border border-white/10 rounded-[2.5rem] p-10 shadow-2xl"
                >
                    <div class="flex items-center space-x-4 mb-10">
                        <div
                            class="w-12 h-12 rounded-2xl bg-red-500/10 border border-red-500/20 flex items-center justify-center text-red-500"
                        >
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div>
                            <h3
                                class="text-lg font-black text-white uppercase tracking-widest"
                            >
                                Security Link
                            </h3>
                            <p
                                class="text-[10px] font-mono text-gray-500 uppercase tracking-widest"
                            >
                                Update Authorization Key
                            </p>
                        </div>
                    </div>

                    <form @submit.prevent="updatePassword" class="space-y-6">
                        <div class="space-y-1.5">
                            <label
                                class="text-[10px] font-black text-gray-500 uppercase tracking-widest"
                                >Current Access Key</label
                            >
                            <input
                                type="password"
                                v-model="passwordForm.current_password"
                                required
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-4 text-white focus:outline-none focus:border-red-500/50 transition-all font-bold"
                            />
                        </div>
                        <div class="space-y-1.5">
                            <label
                                class="text-[10px] font-black text-gray-500 uppercase tracking-widest"
                                >New Neural Key</label
                            >
                            <input
                                type="password"
                                v-model="passwordForm.new_password"
                                required
                                minlength="6"
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-4 text-white focus:outline-none focus:border-red-500/50 transition-all font-bold"
                            />
                        </div>
                        <div class="space-y-1.5">
                            <label
                                class="text-[10px] font-black text-gray-500 uppercase tracking-widest"
                                >Confirm New Key</label
                            >
                            <input
                                type="password"
                                v-model="passwordForm.new_password_confirmation"
                                required
                                minlength="6"
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-4 text-white focus:outline-none focus:border-red-500/50 transition-all font-bold"
                            />
                        </div>

                        <div class="pt-6">
                            <button
                                type="submit"
                                :disabled="isSavingPassword"
                                class="w-full py-4 bg-red-500 text-white font-black rounded-xl hover:bg-red-600 transition-all shadow-[0_15px_30px_rgba(239,68,68,0.2)] uppercase text-[10px] tracking-widest"
                            >
                                <span v-if="!isSavingPassword"
                                    >Apply Security Patch</span
                                >
                                <span v-else
                                    ><i
                                        class="fas fa-circle-notch fa-spin mr-2"
                                    ></i
                                    >Encrypting...</span
                                >
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Global Module Control (Game Settings) -->
                <div
                    class="bg-white/5 border border-white/10 rounded-[2.5rem] p-10 shadow-2xl flex flex-col"
                >
                    <div class="flex items-center space-x-4 mb-10">
                        <div
                            class="w-12 h-12 rounded-2xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-500"
                        >
                            <i class="fas fa-project-diagram"></i>
                        </div>
                        <div>
                            <h3
                                class="text-lg font-black text-white uppercase tracking-widest"
                            >
                                Module Registry
                            </h3>
                            <p
                                class="text-[10px] font-mono text-gray-500 uppercase tracking-widest"
                            >
                                Global Status Control
                            </p>
                        </div>
                    </div>

                    <div class="space-y-6 flex-grow">
                        <!-- QA FPS Toggle -->
                        <div
                            class="p-6 bg-white/2 border border-white/5 rounded-3xl hover:border-red-500/20 transition-all group"
                        >
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div
                                        class="w-12 h-12 rounded-2xl bg-red-500/10 flex items-center justify-center text-red-500 group-hover:scale-110 transition-transform"
                                    >
                                        <i
                                            class="fas fa-crosshairs text-xl"
                                        ></i>
                                    </div>
                                    <div>
                                        <h4
                                            class="text-sm font-black text-white uppercase tracking-tight"
                                        >
                                            Q&A Combat Logic
                                        </h4>
                                        <p
                                            class="text-[10px] text-gray-500 uppercase font-mono tracking-widest"
                                        >
                                            FPS Integration Module
                                        </p>
                                    </div>
                                </div>
                                <label
                                    class="relative inline-flex items-center cursor-pointer"
                                >
                                    <input
                                        type="checkbox"
                                        v-model="gameSettings.qa_fps_enabled"
                                        @change="updateGameSettings"
                                        :disabled="isSavingGameSettings"
                                        class="sr-only peer"
                                    />
                                    <div
                                        class="w-14 h-7 bg-white/10 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-1 after:left-1 after:bg-gray-400 after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-500 peer-checked:after:bg-white"
                                    ></div>
                                </label>
                            </div>
                            <p
                                class="mt-4 text-[10px] text-gray-600 font-medium leading-relaxed uppercase tracking-tighter"
                            >
                                Affects the availability of the 3D Combat
                                Assessment module across the network.
                            </p>
                        </div>

                        <!-- TyperGel Toggle -->
                        <div
                            class="p-6 bg-white/2 border border-white/5 rounded-3xl hover:border-blue-500/20 transition-all group"
                        >
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div
                                        class="w-12 h-12 rounded-2xl bg-blue-500/10 flex items-center justify-center text-blue-500 group-hover:scale-110 transition-transform"
                                    >
                                        <i class="fas fa-keyboard text-xl"></i>
                                    </div>
                                    <div>
                                        <h4
                                            class="text-sm font-black text-white uppercase tracking-tight"
                                        >
                                            TyperGel Core
                                        </h4>
                                        <p
                                            class="text-[10px] text-gray-500 uppercase font-mono tracking-widest"
                                        >
                                            Vocabulary Sync Engine
                                        </p>
                                    </div>
                                </div>
                                <label
                                    class="relative inline-flex items-center cursor-pointer"
                                >
                                    <input
                                        type="checkbox"
                                        v-model="gameSettings.typergel1_enabled"
                                        @change="updateGameSettings"
                                        :disabled="isSavingGameSettings"
                                        class="sr-only peer"
                                    />
                                    <div
                                        class="w-14 h-7 bg-white/10 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-1 after:left-1 after:bg-gray-400 after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-500 peer-checked:after:bg-white"
                                    ></div>
                                </label>
                            </div>
                            <p
                                class="mt-4 text-[10px] text-gray-600 font-medium leading-relaxed uppercase tracking-tighter"
                            >
                                Affects the availability of the Neural
                                Vocabulary assessment module.
                            </p>
                        </div>
                    </div>

                    <div
                        v-if="isSavingGameSettings"
                        class="mt-6 flex items-center justify-center space-x-3 text-gray-500"
                    >
                        <i class="fas fa-sync-alt fa-spin text-xs"></i>
                        <span
                            class="text-[10px] font-black uppercase tracking-widest"
                            >Updating Module Registry...</span
                        >
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Settings",
    data() {
        return {
            user: null,
            showProfileDropdown: false,
            isSavingPassword: false,
            isSavingGameSettings: false,
            message: "",
            messageType: "success",
            passwordForm: {
                current_password: "",
                new_password: "",
                new_password_confirmation: "",
            },
            gameSettings: { qa_fps_enabled: true, typergel1_enabled: true },
        };
    },
    async mounted() {
        await this.fetchUser();
        await this.fetchGameSettings();
        document.addEventListener("click", this.handleClickOutside);
    },
    beforeUnmount() {
        document.removeEventListener("click", this.handleClickOutside);
    },
    methods: {
        async fetchUser() {
            try {
                const response = await axios.get("/api/user");
                if (response.data.status === "success")
                    this.user = response.data.user;
            } catch (error) {
                this.$router.push("/login");
            }
        },
        async fetchGameSettings() {
            try {
                const response = await axios.get("/api/admin/settings/games");
                if (response.data.status === "success")
                    this.gameSettings = response.data.settings;
            } catch (error) {
                console.error("Settings fetch failure:", error);
            }
        },
        async updateGameSettings() {
            this.isSavingGameSettings = true;
            try {
                const response = await axios.post(
                    "/api/admin/settings/games",
                    this.gameSettings,
                );
                if (response.data.status === "success") {
                    this.gameSettings = response.data.settings;
                    this.showMessage(
                        "Module registry updated successfully.",
                        "success",
                    );
                }
            } catch (error) {
                this.showMessage(
                    "Module update rejected: Network error.",
                    "error",
                );
                await this.fetchGameSettings();
            } finally {
                this.isSavingGameSettings = false;
            }
        },
        async updatePassword() {
            this.isSavingPassword = true;
            try {
                const response = await axios.post(
                    "/api/admin/settings/password",
                    this.passwordForm,
                );
                if (response.data.status === "success") {
                    this.passwordForm = {
                        current_password: "",
                        new_password: "",
                        new_password_confirmation: "",
                    };
                    this.showMessage(
                        "Security patch successfully applied.",
                        "success",
                    );
                }
            } catch (error) {
                this.showMessage(
                    error.response?.data?.message ||
                        "Access key update failed.",
                    "error",
                );
            } finally {
                this.isSavingPassword = false;
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
</style>

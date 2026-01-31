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
                                    Global Link
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
            <!-- Status Feedback -->
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
                        class="w-8 h-8 rounded-lg flex items-center justify-center"
                        :class="
                            messageType === 'success'
                                ? 'bg-green-500/20'
                                : 'bg-red-500/20'
                        "
                    >
                        <i
                            :class="
                                messageType === 'success'
                                    ? 'fas fa-shield-check'
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

            <div class="mb-12 reveal-section active">
                <h2
                    class="text-red-500 font-mono tracking-[0.3em] text-xs mb-3 uppercase"
                >
                    Security Terminal
                </h2>
                <h1
                    class="text-4xl md:text-5xl font-black text-white tracking-tighter uppercase mb-4"
                >
                    Access
                    <span
                        class="text-transparent bg-clip-text bg-linear-to-r from-red-500 to-red-600"
                        >Parameters</span
                    >
                </h1>
                <p class="text-gray-500 max-w-xl font-medium">
                    Re-calibrate your authentication keys and security
                    preferences across the network.
                </p>
            </div>

            <div
                class="grid grid-cols-1 lg:grid-cols-2 gap-8 reveal-section active"
            >
                <!-- Change Password Card -->
                <div
                    class="bg-white/5 border border-white/10 rounded-3xl shadow-2xl overflow-hidden group"
                >
                    <div
                        class="p-8 border-b border-white/5 bg-white/[0.02] flex items-center space-x-4"
                    >
                        <div
                            class="w-12 h-12 bg-red-500/10 rounded-xl flex items-center justify-center text-red-500 group-hover:bg-red-500 group-hover:text-white transition-all"
                        >
                            <i class="fas fa-lock text-xl"></i>
                        </div>
                        <div>
                            <h3
                                class="text-xl font-bold text-white uppercase tracking-tight"
                            >
                                Cipher Rotation
                            </h3>
                            <p
                                class="text-xs font-mono text-gray-600 uppercase"
                            >
                                Status: Secure Layer Active
                            </p>
                        </div>
                    </div>

                    <div class="p-8 md:p-10">
                        <form
                            @submit.prevent="updatePassword"
                            class="space-y-6"
                        >
                            <div>
                                <label
                                    class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.3em] mb-3"
                                    >Current Encryption Key</label
                                >
                                <div class="relative group/input">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-600 group-focus-within/input:text-red-500 transition-colors"
                                    >
                                        <i class="fas fa-key text-xs"></i>
                                    </div>
                                    <input
                                        type="password"
                                        v-model="passwordForm.current_password"
                                        required
                                        class="w-full bg-white/5 border border-white/10 rounded-xl py-3.5 pl-12 pr-4 text-white placeholder-gray-700 focus:outline-none focus:border-red-500/50 focus:bg-white/10 transition-all font-medium"
                                        placeholder="Enter current password"
                                    />
                                </div>
                            </div>

                            <div class="h-px bg-white/5 my-2"></div>

                            <div>
                                <label
                                    class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.3em] mb-3"
                                    >New Encryption Key</label
                                >
                                <div class="relative group/input">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-600 group-focus-within/input:text-red-500 transition-colors"
                                    >
                                        <i
                                            class="fas fa-shield-alt text-xs"
                                        ></i>
                                    </div>
                                    <input
                                        type="password"
                                        v-model="passwordForm.new_password"
                                        required
                                        minlength="6"
                                        class="w-full bg-white/5 border border-white/10 rounded-xl py-3.5 pl-12 pr-4 text-white placeholder-gray-700 focus:outline-none focus:border-red-500/50 focus:bg-white/10 transition-all font-medium"
                                        placeholder="Min. 6 alphanumeric chars"
                                    />
                                </div>
                            </div>

                            <div>
                                <label
                                    class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.3em] mb-3"
                                    >Confirm Rotation</label
                                >
                                <div class="relative group/input">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-600 group-focus-within/input:text-red-500 transition-colors"
                                    >
                                        <i
                                            class="fas fa-check-circle text-xs"
                                        ></i>
                                    </div>
                                    <input
                                        type="password"
                                        v-model="
                                            passwordForm.new_password_confirmation
                                        "
                                        required
                                        minlength="6"
                                        class="w-full bg-white/5 border border-white/10 rounded-xl py-3.5 pl-12 pr-4 text-white placeholder-gray-700 focus:outline-none focus:border-red-500/50 focus:bg-white/10 transition-all font-medium"
                                        placeholder="Confirm new password"
                                    />
                                </div>
                            </div>

                            <button
                                type="submit"
                                :disabled="isSavingPassword"
                                class="w-full py-4 bg-red-500 text-white font-black rounded-xl hover:bg-red-600 transition-all shadow-[0_15px_30px_rgba(239,68,68,0.2)] hover:-translate-y-1 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed uppercase tracking-widest text-sm flex items-center justify-center"
                            >
                                <span v-if="isSavingPassword"
                                    ><i class="fas fa-sync-alt fa-spin mr-3"></i
                                    >Rotating Cipher...</span
                                >
                                <span v-else
                                    ><i class="fas fa-save mr-3"></i>Commit Key
                                    Change</span
                                >
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Preferences / Info Card -->
                <div
                    class="bg-white/5 border border-white/10 rounded-3xl shadow-2xl overflow-hidden group"
                >
                    <div
                        class="p-8 border-b border-white/5 bg-white/[0.02] flex items-center space-x-4"
                    >
                        <div
                            class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center text-blue-500 group-hover:bg-blue-500 group-hover:text-white transition-all"
                        >
                            <i class="fas fa-sliders-h text-xl"></i>
                        </div>
                        <div>
                            <h3
                                class="text-xl font-bold text-white uppercase tracking-tight"
                            >
                                Interface Hooks
                            </h3>
                            <p
                                class="text-xs font-mono text-gray-600 uppercase"
                            >
                                Configuration: Latent
                            </p>
                        </div>
                    </div>

                    <div class="p-8 md:p-10 space-y-8">
                        <div
                            class="p-6 bg-white/[0.02] border border-white/5 rounded-2xl"
                        >
                            <h5
                                class="text-sm font-black text-white uppercase tracking-widest mb-4 flex items-center"
                            >
                                <i
                                    class="fas fa-info-circle mr-3 text-red-500"
                                ></i
                                >Security Protocol
                            </h5>
                            <p
                                class="text-sm text-gray-500 leading-relaxed mb-4"
                            >
                                Password rotation requires current
                                authentication verification. Minimum entropy
                                requirements: 6 characters.
                            </p>
                            <div
                                class="flex items-center space-x-3 text-[10px] font-mono text-gray-600 uppercase"
                            >
                                <i class="fas fa-fingerprint text-red-500"></i>
                                <span>SHA-256 System Encryption Enabled</span>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <p
                                class="text-[10px] font-black text-gray-600 uppercase tracking-widest"
                            >
                                Future Integration Nodes
                            </p>
                            <div
                                v-for="node in [
                                    'Neural Notifications',
                                    'Visual Theme Override',
                                    'Global Difficulty Scale',
                                ]"
                                :key="node"
                                class="flex items-center justify-between p-4 bg-white/5 rounded-xl border border-white/5 group/node hover:border-white/10 transition-all cursor-not-allowed"
                            >
                                <span
                                    class="text-sm font-bold text-gray-500 group-hover/node:text-gray-400"
                                    >{{ node }}</span
                                >
                                <span
                                    class="text-[10px] font-mono text-gray-700 uppercase"
                                    >Locked</span
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Interface Loader -->
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
                    class="fas fa-shield-alt text-red-500 text-2xl absolute inset-0 flex items-center justify-center animate-pulse"
                ></i>
            </div>
            <div
                class="text-red-500 text-xs font-mono tracking-[0.5em] uppercase"
            >
                Accessing Secure Parameters...
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "UserSettings",
    data() {
        return {
            user: null,
            showProfileDropdown: false,
            isSavingPassword: false,
            isLoading: true,
            message: "",
            messageType: "success",
            passwordForm: {
                current_password: "",
                new_password: "",
                new_password_confirmation: "",
            },
        };
    },
    async mounted() {
        await this.fetchUser();
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
                this.user = response.data.user;
            } catch (error) {
                console.error("Failed to fetch user:", error);
                this.$router.push("/login");
            }
        },
        async updatePassword() {
            this.isSavingPassword = true;
            this.message = "";

            try {
                const response = await axios.post(
                    "/api/user/settings/password",
                    {
                        current_password: this.passwordForm.current_password,
                        new_password: this.passwordForm.new_password,
                        new_password_confirmation:
                            this.passwordForm.new_password_confirmation,
                    },
                );

                if (response.data.status === "success") {
                    this.passwordForm.current_password = "";
                    this.passwordForm.new_password = "";
                    this.passwordForm.new_password_confirmation = "";
                    this.showMessage(
                        "Access key successfully rotated in core registry.",
                        "success",
                    );
                }
            } catch (error) {
                const msg =
                    error.response?.data?.message ||
                    "Cipher rotation fault identified.";
                this.showMessage(msg, "error");
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
                console.error("Logout failed:", error);
                this.$router.push("/login");
            }
        },
        handleClickOutside(event) {
            const dropdown = event.target.closest(".relative");
            if (!dropdown) {
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
    transition: all 0.4s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
    transform: translateX(20px);
}
</style>

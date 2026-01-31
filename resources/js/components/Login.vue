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
            class="w-full z-50 bg-[#111111]/80 backdrop-blur-md border-b border-white/5"
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

                <router-link
                    to="/register"
                    class="px-6 py-2 bg-white/5 text-white text-sm font-bold rounded-md border border-white/10 hover:bg-white/10 transition-all uppercase tracking-widest"
                >
                    JOIN NOW
                </router-link>
            </div>
        </nav>

        <!-- Main Content -->
        <div
            class="flex-grow flex items-center justify-center p-6 relative z-10"
        >
            <div class="w-full max-w-md">
                <div class="reveal-section active">
                    <div
                        class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-8 md:p-10 shadow-2xl relative group overflow-hidden"
                    >
                        <!-- Decorative Icon -->
                        <div
                            class="absolute -top-10 -right-10 opacity-5 group-hover:opacity-10 transition-opacity"
                        >
                            <i
                                class="fas fa-sign-in-alt text-[12rem] text-red-500"
                            ></i>
                        </div>

                        <div class="text-center mb-10">
                            <h2
                                class="text-red-500 font-mono tracking-widest text-xs mb-3 uppercase"
                            >
                                Authentication
                            </h2>
                            <h1
                                class="text-3xl font-black text-white tracking-tighter uppercase"
                            >
                                Welcome Back
                            </h1>
                            <p class="text-gray-500 text-sm mt-2">
                                Initialize your learning interface
                            </p>
                        </div>

                        <div
                            v-if="error"
                            class="bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl mb-6 text-sm flex items-center"
                        >
                            <i class="fas fa-exclamation-triangle mr-3"></i>
                            {{ error }}
                        </div>

                        <form @submit.prevent="handleLogin" class="space-y-6">
                            <div>
                                <label
                                    class="block text-xs font-bold text-gray-500 uppercase tracking-[0.2em] mb-2"
                                    >Username</label
                                >
                                <div class="relative group/input">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-600 group-focus-within/input:text-red-500 transition-colors"
                                    >
                                        <i class="fas fa-user text-sm"></i>
                                    </div>
                                    <input
                                        type="text"
                                        class="w-full bg-white/5 border border-white/10 rounded-xl py-3 pl-12 pr-4 text-white placeholder-gray-600 focus:outline-none focus:border-red-500/50 focus:bg-white/10 transition-all font-medium"
                                        placeholder="Enter your username"
                                        v-model="form.username"
                                        required
                                    />
                                </div>
                            </div>

                            <div>
                                <label
                                    class="block text-xs font-bold text-gray-500 uppercase tracking-[0.2em] mb-2"
                                    >Password</label
                                >
                                <div class="relative group/input">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-600 group-focus-within/input:text-red-500 transition-colors"
                                    >
                                        <i class="fas fa-lock text-sm"></i>
                                    </div>
                                    <input
                                        type="password"
                                        class="w-full bg-white/5 border border-white/10 rounded-xl py-3 pl-12 pr-4 text-white placeholder-gray-600 focus:outline-none focus:border-red-500/50 focus:bg-white/10 transition-all font-medium"
                                        placeholder="••••••••"
                                        v-model="form.password"
                                        required
                                    />
                                </div>
                            </div>

                            <button
                                type="submit"
                                class="w-full bg-red-500 text-white font-black py-4 rounded-xl hover:bg-red-600 transition-all shadow-[0_10px_20px_rgba(239,68,68,0.2)] hover:shadow-[0_15px_30px_rgba(239,68,68,0.4)] hover:-translate-y-1 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed uppercase tracking-widest text-sm"
                                :disabled="loading"
                            >
                                {{
                                    loading
                                        ? "Synchronizing..."
                                        : "Authorize Login"
                                }}
                            </button>
                        </form>

                        <div
                            class="mt-10 pt-8 border-t border-white/5 text-center"
                        >
                            <p class="text-sm text-gray-500">
                                Don't have an access key?
                                <a
                                    href="#"
                                    @click.prevent="goToRegister"
                                    class="text-red-500 font-bold hover:text-red-400 transition-colors ml-1 border-b border-red-500/20 hover:border-red-500"
                                >
                                    Register Account
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Interface Loader -->
        <div
            v-if="loading"
            class="fixed inset-0 bg-[#0a0a0a]/95 z-[9999] flex flex-col justify-center items-center backdrop-blur-sm"
        >
            <div class="relative w-24 h-24 mb-8">
                <div
                    class="absolute inset-0 border-4 border-red-500/20 rounded-full"
                ></div>
                <div
                    class="absolute inset-0 border-4 border-t-red-500 rounded-full animate-spin"
                ></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <i
                        class="fas fa-microchip text-red-500 text-2xl animate-pulse"
                    ></i>
                </div>
            </div>
            <div
                class="text-red-500 text-xs font-mono tracking-[0.5em] uppercase animate-pulse"
            >
                INITIALIZING NEURAL LINK
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Login",
    data() {
        return {
            form: {
                username: "",
                password: "",
                login_type: "user",
            },
            error: "",
            loading: false,
        };
    },
    mounted() {
        if (this.$route.query.disabled === "true") {
            this.error =
                "Security Alert: Your access has been restricted by administration.";
        }
    },
    methods: {
        async handleLogin() {
            this.error = "";
            this.loading = true;

            try {
                const response = await axios.post("/api/login", this.form);

                if (response.data.status === "success") {
                    this.$router.push(response.data.data.redirect);
                } else {
                    this.error =
                        response.data.message ||
                        "Authentication override failed";
                    this.loading = false;
                }
            } catch (error) {
                if (error.response && error.response.data) {
                    this.error =
                        error.response.data.message ||
                        "Invalid credentials provided";
                } else {
                    this.error =
                        "System fault during authentication. Retry initialization.";
                }
                this.loading = false;
            }
        },
        goToRegister() {
            this.$router.push("/register");
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
</style>

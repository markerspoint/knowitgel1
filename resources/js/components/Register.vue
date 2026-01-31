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
                    to="/login"
                    class="px-6 py-2 bg-white/5 text-white text-sm font-bold rounded-md border border-white/10 hover:bg-white/10 transition-all uppercase tracking-widest"
                >
                    LOG IN
                </router-link>
            </div>
        </nav>

        <!-- Main Content -->
        <div
            class="flex-grow flex items-center justify-center p-6 relative z-10"
        >
            <div class="w-full max-w-2xl">
                <div class="reveal-section active">
                    <div
                        class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-8 md:p-10 shadow-2xl relative group overflow-hidden"
                    >
                        <!-- Decorative Icon -->
                        <div
                            class="absolute -top-10 -right-10 opacity-5 group-hover:opacity-10 transition-opacity"
                        >
                            <i
                                class="fas fa-user-plus text-[12rem] text-red-500"
                            ></i>
                        </div>

                        <div class="text-center mb-10">
                            <h2
                                class="text-red-500 font-mono tracking-widest text-xs mb-3 uppercase"
                            >
                                Registration
                            </h2>
                            <h1
                                class="text-3xl font-black text-white tracking-tighter uppercase"
                            >
                                Create Account
                            </h1>
                            <p class="text-gray-500 text-sm mt-2">
                                Join the next generation of digital masters
                            </p>
                        </div>

                        <div
                            v-if="error"
                            class="bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl mb-6 text-sm flex items-center justify-between"
                        >
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle mr-3"></i>
                                {{ error }}
                            </div>
                            <button @click="error = ''" class="text-lg">
                                &times;
                            </button>
                        </div>

                        <div
                            v-if="success"
                            class="bg-green-500/10 border border-green-500/20 text-green-400 px-4 py-3 rounded-xl mb-6 text-sm flex items-center justify-between"
                        >
                            <div class="flex items-center">
                                <i class="fas fa-check-circle mr-3"></i>
                                {{ success }}
                            </div>
                            <button @click="success = ''" class="text-lg">
                                &times;
                            </button>
                        </div>

                        <form
                            @submit.prevent="handleRegister"
                            class="space-y-6"
                        >
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label
                                        class="block text-xs font-bold text-gray-500 uppercase tracking-[0.2em] mb-2"
                                        >First Name</label
                                    >
                                    <input
                                        type="text"
                                        class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-white placeholder-gray-600 focus:outline-none focus:border-red-500/50 focus:bg-white/10 transition-all font-medium"
                                        placeholder="Juan"
                                        v-model="form.fname"
                                        required
                                    />
                                </div>

                                <div>
                                    <label
                                        class="block text-xs font-bold text-gray-500 uppercase tracking-[0.2em] mb-2"
                                        >Last Name</label
                                    >
                                    <input
                                        type="text"
                                        class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-white placeholder-gray-600 focus:outline-none focus:border-red-500/50 focus:bg-white/10 transition-all font-medium"
                                        placeholder="Dela Cruz"
                                        v-model="form.lname"
                                        required
                                    />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label
                                        class="block text-xs font-bold text-gray-500 uppercase tracking-[0.2em] mb-2"
                                        >Username</label
                                    >
                                    <input
                                        type="text"
                                        class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-white placeholder-gray-600 focus:outline-none focus:border-red-500/50 focus:bg-white/10 transition-all font-medium"
                                        placeholder="digitalmaster99"
                                        v-model="form.username"
                                        required
                                    />
                                </div>

                                <div>
                                    <label
                                        class="block text-xs font-bold text-gray-500 uppercase tracking-[0.2em] mb-2"
                                        >Email Address</label
                                    >
                                    <input
                                        type="email"
                                        class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-white placeholder-gray-600 focus:outline-none focus:border-red-500/50 focus:bg-white/10 transition-all font-medium"
                                        placeholder="juan@example.com"
                                        v-model="form.email"
                                        required
                                    />
                                </div>
                            </div>

                            <div>
                                <label
                                    class="block text-xs font-bold text-gray-500 uppercase tracking-[0.2em] mb-2"
                                    >Phone Number</label
                                >
                                <input
                                    type="tel"
                                    class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-white placeholder-gray-600 focus:outline-none focus:border-red-500/50 focus:bg-white/10 transition-all font-medium"
                                    placeholder="09123456789"
                                    v-model="form.number"
                                    required
                                />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label
                                        class="block text-xs font-bold text-gray-500 uppercase tracking-[0.2em] mb-2"
                                        >Password</label
                                    >
                                    <input
                                        type="password"
                                        class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-white placeholder-gray-600 focus:outline-none focus:border-red-500/50 focus:bg-white/10 transition-all font-medium"
                                        placeholder="••••••••"
                                        v-model="form.password"
                                        required
                                        minlength="6"
                                    />
                                </div>

                                <div>
                                    <label
                                        class="block text-xs font-bold text-gray-500 uppercase tracking-[0.2em] mb-2"
                                        >Confirm Identity</label
                                    >
                                    <input
                                        type="password"
                                        class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-white placeholder-gray-600 focus:outline-none focus:border-red-500/50 focus:bg-white/10 transition-all font-medium"
                                        placeholder="••••••••"
                                        v-model="form.password_confirmation"
                                        required
                                        minlength="6"
                                    />
                                </div>
                            </div>

                            <div class="pt-4">
                                <button
                                    type="submit"
                                    class="w-full bg-red-500 text-white font-black py-4 rounded-xl hover:bg-red-600 transition-all shadow-[0_10px_20px_rgba(239,68,68,0.2)] hover:shadow-[0_15px_30px_rgba(239,68,68,0.4)] hover:-translate-y-1 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed uppercase tracking-widest text-sm"
                                    :disabled="loading"
                                >
                                    <span v-if="loading">
                                        <i
                                            class="fas fa-spinner fa-spin mr-2"
                                        ></i
                                        >Encrypting Data...
                                    </span>
                                    <span v-else>
                                        <i class="fas fa-user-plus mr-2"></i
                                        >Register For GEL1
                                    </span>
                                </button>
                            </div>
                        </form>

                        <div
                            class="mt-10 pt-8 border-t border-white/5 text-center text-sm text-gray-500"
                        >
                            Already have an established link?
                            <a
                                href="#"
                                @click.prevent="goToLogin"
                                class="text-red-500 font-bold hover:text-red-400 transition-colors ml-1 border-b border-red-500/20 hover:border-red-500"
                            >
                                Login Instead
                            </a>
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
                        class="fas fa-user-plus text-red-500 text-2xl animate-pulse"
                    ></i>
                </div>
            </div>
            <div
                class="text-red-500 text-xs font-mono tracking-[0.5em] uppercase animate-pulse"
            >
                GENERATING LEARNER PROFILE
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Register",
    data() {
        return {
            form: {
                fname: "",
                lname: "",
                username: "",
                email: "",
                number: "",
                password: "",
                password_confirmation: "",
            },
            error: "",
            success: "",
            loading: false,
        };
    },
    methods: {
        async handleRegister() {
            this.error = "";
            this.success = "";
            this.loading = true;

            if (this.form.password !== this.form.password_confirmation) {
                this.error = "Security Mismatch: Passwords do not match.";
                this.loading = false;
                return;
            }

            if (this.form.password.length < 6) {
                this.error =
                    "Policy Violation: Password must be at least 6 characters.";
                this.loading = false;
                return;
            }

            try {
                const response = await axios.post("/api/register", this.form);

                if (response.data.status === "success") {
                    this.success =
                        "Success: Learner profile created. Redirecting to access terminal...";
                    setTimeout(() => {
                        this.$router.push("/login");
                    }, 2000);
                } else {
                    this.error =
                        response.data.message || "Registration failure";
                    this.loading = false;
                }
            } catch (error) {
                if (error.response && error.response.data) {
                    if (error.response.data.errors) {
                        const errors = error.response.data.errors;
                        const errorMessages = Object.values(errors).flat();
                        this.error = errorMessages.join(", ");
                    } else {
                        this.error =
                            error.response.data.message ||
                            "Registration failed. Check system logs.";
                    }
                } else {
                    this.error = "Critical system error during registration.";
                }
                this.loading = false;
            }
        },
        goToLogin() {
            this.$router.push("/login");
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

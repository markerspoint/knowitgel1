<template>
    <div
        class="min-h-screen bg-[#111111] text-gray-300 font-sans selection:bg-red-500 selection:text-white"
    >
        <!-- Navigation -->
        <nav
            class="fixed w-full z-50 bg-[#111111]/80 backdrop-blur-md border-b border-white/5"
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
                        class="text-xl font-bold tracking-tighter text-white group-hover:text-red-500 transition-colors"
                        >KNOWIT GEL1</span
                    >
                </router-link>

                <div
                    class="hidden md:flex items-center space-x-8 text-sm font-medium"
                >
                    <a
                        v-for="link in navLinks"
                        :key="link.href"
                        :href="link.href"
                        @click.prevent="scrollToSection(link.href)"
                        class="relative py-1 transition-colors hover:text-red-500 group"
                        :class="
                            activeSection === link.href.substring(1)
                                ? 'text-red-500'
                                : 'text-gray-400'
                        "
                    >
                        {{ link.label }}
                        <span
                            class="absolute bottom-0 left-0 w-full h-0.5 bg-red-500 transform origin-left transition-transform duration-300"
                            :class="
                                activeSection === link.href.substring(1)
                                    ? 'scale-x-100'
                                    : 'scale-x-0 group-hover:scale-x-100'
                            "
                        ></span>
                    </a>
                </div>

                <div class="flex items-center space-x-4">
                    <template v-if="!user">
                        <router-link
                            to="/login"
                            class="px-5 py-2 text-sm font-bold text-white hover:text-red-500 transition-colors"
                        >
                            LOG IN
                        </router-link>
                        <router-link
                            to="/register"
                            class="px-6 py-2 bg-red-500 text-white text-sm font-bold rounded-md hover:bg-red-600 transition-all shadow-[0_0_20px_rgba(239,68,68,0.3)]"
                        >
                            JOIN NOW
                        </router-link>
                    </template>
                    <template v-else>
                        <router-link
                            :to="dashboardLink"
                            class="px-8 py-2 bg-red-500 text-white text-sm font-black rounded-md hover:bg-red-600 transition-all shadow-[0_0_20px_rgba(239,68,68,0.3)] uppercase"
                        >
                            Dashboard
                        </router-link>
                    </template>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="relative pt-32 pb-20 overflow-hidden">
            <!-- Background Decorations -->
            <div
                class="absolute top-1/4 left-1/4 w-96 h-96 bg-red-500/10 rounded-full blur-[120px] pointer-events-none"
            ></div>
            <div
                class="absolute bottom-1/4 right-1/4 w-64 h-64 bg-blue-500/10 rounded-full blur-[100px] pointer-events-none"
            ></div>

            <div class="container mx-auto px-6 relative">
                <div class="max-w-4xl mx-auto text-center">
                    <h2
                        class="text-red-500 font-mono tracking-widest text-sm mb-6 uppercase"
                    >
                        Course Overview: GEL1
                    </h2>
                    <h1
                        class="text-5xl md:text-7xl font-black text-white mb-8 leading-[1.1] tracking-tight"
                    >
                        Navigating the
                        <span
                            class="text-transparent bg-clip-text bg-linear-to-r from-red-500 to-red-600"
                            >Digital Landscape</span
                        >
                        with Purpose
                    </h1>
                    <p
                        class="text-lg md:text-xl text-gray-400 mb-12 max-w-2xl mx-auto leading-relaxed italic"
                    >
                        "In an era where technology is woven into the fabric of
                        daily life, GEL1 is more than just a computer class."
                    </p>
                    <div
                        class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-6"
                    >
                        <template v-if="!user">
                            <router-link
                                to="/register"
                                class="w-full sm:w-auto px-10 py-4 bg-red-500 text-white font-black rounded-lg hover:bg-red-600 transition-all shadow-[0_10px_30px_rgba(239,68,68,0.4)] hover:-translate-y-1"
                            >
                                GET STARTED
                            </router-link>
                            <router-link
                                to="/login"
                                class="w-full sm:w-auto px-10 py-4 bg-white/5 text-white font-black rounded-lg border border-white/10 hover:bg-white/10 transition-all backdrop-blur-sm"
                            >
                                RESUME LEARNING
                            </router-link>
                        </template>
                        <template v-else>
                            <router-link
                                :to="dashboardLink"
                                class="w-full sm:w-auto px-12 py-4 bg-red-500 text-white font-black rounded-lg hover:bg-red-600 transition-all shadow-[0_10px_30px_rgba(239,68,68,0.4)] hover:-translate-y-1 uppercase tracking-widest"
                            >
                                Enter Dashboard Terminal
                            </router-link>
                        </template>
                    </div>
                </div>
            </div>
        </section>

        <!-- Exploration Section -->
        <section id="about" class="py-24 bg-[#0a0a0a] reveal-section">
            <div class="container mx-auto px-6">
                <div class="grid md:grid-cols-2 gap-16 items-center">
                    <div class="relative">
                        <div
                            class="absolute -inset-4 bg-linear-to-r from-red-500 to-purple-600 rounded-3xl opacity-20 blur-2xl"
                        ></div>
                        <div
                            class="relative bg-[#111111] border border-white/10 rounded-2xl p-8 shadow-2xl overflow-hidden group"
                        >
                            <div
                                class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-30 transition-opacity"
                            >
                                <i
                                    class="fas fa-terminal text-8xl text-red-500"
                                ></i>
                            </div>
                            <h3
                                class="text-2xl font-bold text-white mb-6 flex items-center"
                            >
                                <span
                                    class="w-8 h-8 bg-red-500/10 text-red-500 rounded flex items-center justify-center mr-3"
                                >
                                    <i class="fas fa-code"></i>
                                </span>
                                The Exploration
                            </h3>
                            <p
                                class="text-gray-400 leading-relaxed text-lg mb-6"
                            >
                                Understand how Information and Communication
                                Technology (ICT) shapes our society, our
                                relationships, and our future.
                            </p>
                            <div class="grid grid-cols-2 gap-4">
                                <div
                                    class="p-4 bg-white/5 rounded-xl border border-white/5"
                                >
                                    <div
                                        class="text-red-500 font-bold text-2xl mb-1"
                                    >
                                        Societal
                                    </div>
                                    <div
                                        class="text-xs text-gray-500 uppercase"
                                    >
                                        Impact Analysis
                                    </div>
                                </div>
                                <div
                                    class="p-4 bg-white/5 rounded-xl border border-white/5"
                                >
                                    <div
                                        class="text-red-500 font-bold text-2xl mb-1"
                                    >
                                        Human
                                    </div>
                                    <div
                                        class="text-xs text-gray-500 uppercase"
                                    >
                                        Connections
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h2
                            class="text-3xl md:text-4xl font-black text-white mb-8 tracking-tighter uppercase"
                        >
                            Living in the IT Era
                        </h2>
                        <p class="text-gray-400 leading-relaxed mb-8 text-lg">
                            Technology is no longer a peripheral tool; it's the
                            core of modern existence. In GEL1, we don't just
                            teach you how to use a keyboard—we teach you how to
                            master the digital epoch.
                        </p>
                        <div class="space-y-4">
                            <div
                                v-for="(item, i) in [
                                    'Purposeful Technology Use',
                                    'Digital Empowerment',
                                    'Civic Responsibility',
                                ]"
                                :key="i"
                                class="flex items-center space-x-3"
                            >
                                <i class="fas fa-check-circle text-red-500"></i>
                                <span class="text-white font-medium">{{
                                    item
                                }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Core Learning Pillars -->
        <section
            id="pillars"
            class="py-24 relative overflow-hidden reveal-section"
        >
            <div class="container mx-auto px-6">
                <div class="text-center mb-16">
                    <h2
                        class="text-4xl md:text-5xl font-black text-white mb-4 tracking-tighter uppercase"
                    >
                        Core Learning Pillars
                    </h2>
                    <div class="h-1 w-20 bg-red-500 mx-auto"></div>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div
                        v-for="(pillar, i) in pillars"
                        :key="i"
                        class="bg-white/5 p-8 rounded-2xl border border-white/5 hover:border-red-500/30 transition-all hover:bg-white/10 group cursor-default"
                    >
                        <div
                            class="w-14 h-14 bg-red-500/10 text-red-500 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform"
                        >
                            <i :class="pillar.icon" class="text-2xl"></i>
                        </div>
                        <h3
                            class="text-lg font-bold text-white mb-4 uppercase tracking-tighter"
                        >
                            {{ pillar.title }}
                        </h3>
                        <p class="text-sm text-gray-500 leading-relaxed">
                            {{ pillar.desc }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Curriculum / Mastering Modules -->
        <section id="modules" class="py-24 bg-[#0a0a0a] reveal-section">
            <div class="container mx-auto px-6">
                <div class="flex flex-col lg:flex-row gap-16">
                    <div class="lg:w-1/3">
                        <h2
                            class="text-4xl font-black text-white mb-6 tracking-tighter uppercase"
                        >
                            What You Will
                            <span class="text-red-500">Master</span>
                        </h2>
                        <p class="text-gray-500 leading-relaxed mb-8">
                            A comprehensive curriculum designed to take you from
                            foundational understanding to deep societal
                            analysis.
                        </p>
                        <div
                            class="p-6 bg-red-500/5 rounded-2xl border border-red-500/10"
                        >
                            <div class="text-sm text-red-500 font-mono mb-2">
                                PROGRESSION PATH
                            </div>
                            <div class="text-2xl font-bold text-white mb-4">
                                4 Key Modules
                            </div>
                            <div
                                class="w-full bg-gray-800 h-1.5 rounded-full overflow-hidden"
                            >
                                <div
                                    class="bg-red-500 h-full w-1/4 animate-pulse"
                                ></div>
                            </div>
                        </div>
                    </div>
                    <div class="lg:w-2/3">
                        <div class="space-y-6">
                            <div
                                v-for="mod in modules"
                                :key="mod.id"
                                class="flex group"
                            >
                                <div
                                    class="w-16 h-16 bg-[#111111] border border-white/5 rounded-xl flex flex-col items-center justify-center shrink-0 group-hover:border-red-500 transition-colors"
                                >
                                    <span
                                        class="text-xs text-gray-500 font-mono"
                                        >{{ mod.id }}</span
                                    >
                                    <span
                                        class="text-xl font-black text-white"
                                        >{{ mod.roman }}</span
                                    >
                                </div>
                                <div class="ml-6 grow">
                                    <h4
                                        class="text-xl font-bold text-white mb-2 group-hover:text-red-500 transition-colors uppercase tracking-tight"
                                    >
                                        {{ mod.title }}
                                    </h4>
                                    <p
                                        class="text-gray-500 text-sm leading-relaxed"
                                    >
                                        {{ mod.desc }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Wisdom Section -->
        <section class="py-32 relative text-center px-6">
            <div class="max-w-3xl mx-auto">
                <i class="fas fa-quote-left text-6xl text-red-500/20 mb-8"></i>
                <h2
                    class="text-3xl md:text-5xl font-black text-white italic mb-12 leading-tight tracking-tight"
                >
                    "Technology is a useful servant but a dangerous master."
                </h2>
                <p class="text-xl text-gray-400 leading-relaxed mb-12">
                    GEL1 equips Filipino students with the critical thinking
                    needed to use technology for personal and professional
                    advancement while avoiding the pitfalls of misinformation
                    and digital addiction.
                </p>
                <router-link
                    to="/register"
                    class="inline-flex items-center space-x-3 text-red-500 border-b-2 border-red-500/30 hover:border-red-500 pb-1 font-black transition-all text-xl uppercase tracking-widest"
                >
                    <span>Begin Your Journey</span>
                    <i class="fas fa-arrow-right"></i>
                </router-link>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-black py-16 px-6 border-t border-white/5">
            <div class="container mx-auto">
                <div
                    class="grid md:grid-cols-4 gap-12 mb-16 text-center md:text-left"
                >
                    <div class="md:col-span-1">
                        <router-link
                            to="/"
                            class="flex items-center space-x-3 mb-6 justify-center md:justify-start"
                        >
                            <div
                                class="w-8 h-8 bg-red-500 rounded flex items-center justify-center"
                            >
                                <i class="fas fa-microchip text-white"></i>
                            </div>
                            <span
                                class="text-lg font-bold text-white tracking-widest"
                                >KNOWIT GEL1</span
                            >
                        </router-link>
                        <p
                            class="text-xs text-gray-600 uppercase tracking-widest font-bold mb-4"
                        >
                            Achieve mastery through understanding.
                        </p>
                    </div>
                    <div>
                        <h5
                            class="text-white font-mono text-sm mb-6 uppercase tracking-widest"
                        >
                            Navigation
                        </h5>
                        <ul class="space-y-4 text-sm text-gray-500 font-medium">
                            <li>
                                <router-link
                                    to="/login"
                                    class="hover:text-red-500"
                                    >Log In</router-link
                                >
                            </li>
                            <li>
                                <router-link
                                    to="/register"
                                    class="hover:text-red-500"
                                    >Register</router-link
                                >
                            </li>
                            <li>
                                <router-link
                                    to="/leaderboard"
                                    class="hover:text-red-500"
                                    >Leaderboards</router-link
                                >
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h5
                            class="text-white font-mono text-sm mb-6 uppercase tracking-widest"
                        >
                            Subject Focus
                        </h5>
                        <ul class="space-y-4 text-sm text-gray-500 font-medium">
                            <li class="hover:text-gray-300 cursor-default">
                                Digital Ethics
                            </li>
                            <li class="hover:text-gray-300 cursor-default">
                                ICT Fundamentals
                            </li>
                            <li class="hover:text-gray-300 cursor-default">
                                IT & Society
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h5
                            class="text-white font-mono text-sm mb-6 uppercase tracking-widest"
                        >
                            Connect
                        </h5>
                        <div
                            class="flex justify-center md:justify-start space-x-4"
                        >
                            <a
                                href="#"
                                class="w-10 h-10 bg-white/5 rounded-full flex items-center justify-center hover:bg-red-500/20 hover:text-red-500 transition-all border border-white/5"
                            >
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a
                                href="#"
                                class="w-10 h-10 bg-white/5 rounded-full flex items-center justify-center hover:bg-red-500/20 hover:text-red-500 transition-all border border-white/5"
                            >
                                <i class="fab fa-github"></i>
                            </a>
                            <a
                                href="#"
                                class="w-10 h-10 bg-white/5 rounded-full flex items-center justify-center hover:bg-red-500/20 hover:text-red-500 transition-all border border-white/5"
                            >
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div
                    class="pt-8 border-t border-white/5 flex flex-col md:flex-row items-center justify-between text-xs font-mono text-gray-600 uppercase tracking-[0.2em]"
                >
                    <p>© 2026 KNOWIT GEL1. All rights reserved.</p>
                    <div class="flex space-x-8 mt-4 md:mt-0">
                        <span class="hover:text-gray-400 cursor-pointer"
                            >Privacy</span
                        >
                        <span class="hover:text-gray-400 cursor-pointer"
                            >Terms</span
                        >
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Home",
    data() {
        return {
            user: null,
            activeSection: "",
            navLinks: [
                { label: "Pillars", href: "#pillars" },
                { label: "Curriculum", href: "#modules" },
                { label: "Philosophy", href: "#about" },
            ],
            pillars: [
                {
                    title: "The Evolution of Tech",
                    desc: "Journey from the Pre-mechanical Age to the current Electronic Age. Understand AI and vacuum tubes.",
                    icon: "fas fa-history",
                },
                {
                    title: "Digital Citizenship",
                    desc: "Mastering 'Netiquette' and professional conduct in a borderless digital world.",
                    icon: "fas fa-user-shield",
                },
                {
                    title: "Privacy & Security",
                    desc: "Deep dive into Philippine Data Privacy Act (RA 10173) and protecting your digital identity.",
                    icon: "fas fa-lock",
                },
                {
                    title: "Emerging Trends",
                    desc: "Exploring IoT, Cloud Computing, and the impact of automation on the Filipino workforce.",
                    icon: "fas fa-chart-line",
                },
            ],
            modules: [
                {
                    id: "MOD",
                    roman: "I",
                    title: "ICT Fundamentals",
                    desc: "Understanding hardware, software, and how computers 'think' at their most core level.",
                },
                {
                    id: "MOD",
                    roman: "II",
                    title: "The Internet & Web",
                    desc: "The history of the WWW, DNS architecture, and the transformative power of the cloud.",
                },
                {
                    id: "MOD",
                    roman: "III",
                    title: "IT & Society",
                    desc: "Analyzing the influence of tech on Philippine culture, education, and modern social behavior.",
                },
                {
                    id: "MOD",
                    roman: "IV",
                    title: "Ethics & Law",
                    desc: "Cybersecurity basics, Intellectual Property rights, and anti-cybercrime legal frameworks.",
                },
            ],
        };
    },
    computed: {
        dashboardLink() {
            if (!this.user) return "/login";
            if (this.user.role === "admin") return "/admin/dashboard";
            return this.user.has_completed_assessment
                ? "/user/dashboard"
                : "/assessment";
        },
    },
    mounted() {
        this.fetchUser();
        this.initReveal();
    },
    methods: {
        async fetchUser() {
            try {
                const response = await axios.get("/api/user");
                if (response.data.status === "success") {
                    this.user = response.data.user;
                }
            } catch (error) {
                this.user = null;
            }
        },
        initReveal() {
            const observerOptions = {
                threshold: 0.15,
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("active");
                        this.activeSection = entry.target.id;
                    }
                });
            }, observerOptions);

            document.querySelectorAll(".reveal-section").forEach((section) => {
                observer.observe(section);
            });
        },
        scrollToSection(href) {
            const element = document.querySelector(href);
            if (element) {
                const navHeight = 80;
                const elementPosition = element.getBoundingClientRect().top;
                const offsetPosition =
                    elementPosition + window.pageYOffset - navHeight;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: "smooth",
                });
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

html {
    scroll-behavior: smooth;
}

.reveal-section {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);
}

.reveal-section.active {
    opacity: 1;
    transform: translateY(0);
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

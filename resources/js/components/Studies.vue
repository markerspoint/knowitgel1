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
                        class="w-10 h-10 bg-white/5 rounded-lg flex items-center justify-center border border-white/10 group-hover:border-red-500/50 transition-all"
                    >
                        <i
                            class="fas fa-arrow-left text-gray-500 group-hover:text-red-500 text-sm"
                        ></i>
                    </div>
                    <span
                        class="text-sm font-black tracking-widest text-gray-500 group-hover:text-white transition-colors uppercase"
                        >Return to Terminal</span
                    >
                </router-link>

                <div class="flex items-center space-x-3">
                    <div
                        class="w-8 h-8 bg-red-500 rounded-lg flex items-center justify-center"
                    >
                        <i class="fas fa-book-open text-white text-xs"></i>
                    </div>
                    <span
                        class="text-xl font-bold tracking-tighter text-white uppercase"
                        >KNOWIT GEL1</span
                    >
                </div>
                <div class="w-32 hidden md:block"></div>
            </div>
        </nav>

        <!-- Content Area -->
        <div class="flex-grow container mx-auto px-6 py-12 relative z-10">
            <div
                v-if="loading"
                class="flex flex-col justify-center items-center min-h-[60vh]"
            >
                <div class="relative w-16 h-16 mb-6">
                    <div
                        class="absolute inset-0 border-2 border-red-500/10 rounded-full"
                    ></div>
                    <div
                        class="absolute inset-0 border-2 border-t-red-500 rounded-full animate-spin"
                    ></div>
                </div>
                <p
                    class="text-xs font-mono text-gray-500 uppercase tracking-[0.4em] animate-pulse"
                >
                    Accessing Archive Systems...
                </p>
            </div>

            <div
                v-else-if="studies.length === 0"
                class="flex flex-col justify-center items-center min-h-[60vh] text-center"
            >
                <div
                    class="w-24 h-24 bg-white/5 rounded-3xl flex items-center justify-center mb-6 border border-white/10 opacity-20"
                >
                    <i class="fas fa-book text-4xl"></i>
                </div>
                <h2
                    class="text-2xl font-black text-white uppercase tracking-tighter mb-2"
                >
                    Archive Empty
                </h2>
                <p
                    class="text-xs font-mono text-gray-600 uppercase tracking-widest leading-relaxed"
                >
                    No study content identified in the neural buffer.
                </p>
            </div>

            <div v-else class="max-w-4xl mx-auto space-y-12">
                <div class="mb-12 text-center reveal-section active">
                    <h2
                        class="text-red-500 font-mono tracking-[0.3em] text-xs mb-3 uppercase"
                    >
                        Academic Repository
                    </h2>
                    <h1
                        class="text-4xl md:text-5xl font-black text-white tracking-tighter uppercase"
                    >
                        Knowledge
                        <span
                            class="text-transparent bg-clip-text bg-linear-to-r from-red-500 to-red-600"
                            >Base</span
                        >
                    </h1>
                </div>

                <div
                    v-for="(study, index) in studies"
                    :key="study.id"
                    class="reveal-section active bg-white/5 border border-white/10 rounded-[2.5rem] overflow-hidden shadow-2xl transition-all duration-500"
                    :class="{ hidden: currentPage !== index }"
                >
                    <div class="p-10 md:p-16">
                        <!-- Lesson Header -->
                        <div
                            class="flex flex-col items-center text-center mb-12"
                        >
                            <div
                                class="inline-flex items-center space-x-3 px-4 py-2 bg-red-500/10 border border-red-500/20 rounded-xl mb-6"
                            >
                                <span
                                    class="text-[10px] font-black text-red-500 uppercase tracking-widest"
                                    >Protocol {{ index + 1 }} of
                                    {{ studies.length }}</span
                                >
                            </div>
                            <h2
                                class="text-3xl md:text-4xl font-black text-white tracking-tighter uppercase mb-4 leading-none"
                            >
                                {{ study.title }}
                            </h2>
                            <p
                                v-if="study.description"
                                class="text-gray-500 font-medium max-w-2xl leading-relaxed italic"
                            >
                                {{ study.description }}
                            </p>
                        </div>

                        <!-- Lesson Content -->
                        <div class="relative">
                            <!-- Subtle Grid Overlay for Content -->
                            <div
                                class="prose max-w-none text-gray-300 whitespace-pre-wrap font-sans leading-relaxed text-lg"
                                v-html="formatContent(study.content)"
                            ></div>
                        </div>

                        <!-- Lesson Footer / Navigation -->
                        <div
                            class="mt-16 pt-10 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-8"
                        >
                            <div class="flex items-center space-x-4">
                                <div class="text-right">
                                    <p
                                        class="text-[8px] font-black text-gray-600 uppercase tracking-widest"
                                    >
                                        Total Integrity
                                    </p>
                                    <p
                                        class="text-xs font-mono font-bold text-gray-400"
                                    >
                                        {{
                                            getContentLength(study.content)
                                        }}
                                        Tokens
                                    </p>
                                </div>
                                <div class="w-px h-8 bg-white/5 mx-2"></div>
                                <div class="text-left">
                                    <p
                                        class="text-[8px] font-black text-gray-600 uppercase tracking-widest"
                                    >
                                        Sync Hash
                                    </p>
                                    <p
                                        class="text-xs font-mono font-bold text-red-500/50"
                                    >
                                        GEL-{{
                                            study.id.toString().padStart(4, "0")
                                        }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex gap-4">
                                <button
                                    v-if="index > 0"
                                    @click="goToPage(index - 1)"
                                    class="px-8 py-4 bg-white/5 text-gray-500 font-black rounded-xl hover:bg-white/10 hover:text-white transition-all uppercase text-[10px] tracking-widest border border-white/5"
                                >
                                    <i class="fas fa-chevron-left mr-3"></i
                                    >Shift Previous
                                </button>
                                <button
                                    v-if="index < studies.length - 1"
                                    @click="goToPage(index + 1)"
                                    class="px-10 py-4 bg-red-500 text-white font-black rounded-xl hover:bg-red-600 transition-all shadow-[0_15px_30px_rgba(239,68,68,0.2)] uppercase text-[10px] tracking-widest"
                                >
                                    Next Protocol
                                    <i class="fas fa-chevron-right ml-3"></i>
                                </button>
                                <router-link
                                    v-else
                                    to="/user/dashboard"
                                    class="px-10 py-4 bg-green-500 text-black font-black rounded-xl hover:bg-green-600 transition-all shadow-[0_15px_30px_rgba(34,197,94,0.2)] uppercase text-[10px] tracking-widest"
                                >
                                    Finish Sync
                                    <i class="fas fa-check ml-3"></i>
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Studies",
    data() {
        return {
            studies: [],
            loading: true,
            currentPage: 0,
        };
    },
    async mounted() {
        await this.fetchStudies();
    },
    methods: {
        async fetchStudies() {
            try {
                this.loading = true;
                const response = await axios.get("/api/user/studies");
                this.studies = response.data.studies || [];
            } catch (error) {
                console.error("Archive access fault:", error);
            } finally {
                this.loading = false;
            }
        },
        formatContent(content) {
            if (!content) return "";
            // Enhanced formatting for futuristic look
            return content
                .replace(/\n/g, "<br>")
                .replace(
                    /#(\w+)/g,
                    '<span class="text-red-500 font-bold tracking-tight">#$1</span>',
                )
                .replace(
                    /\*\*(.*?)\*\*/g,
                    '<span class="text-white font-black italic">$1</span>',
                );
        },
        getContentLength(content) {
            return content ? content.replace(/\s/g, "").length : 0;
        },
        goToPage(index) {
            this.currentPage = index;
            window.scrollTo({ top: 0, behavior: "smooth" });
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

.prose {
    line-height: 1.8;
}

.prose :deep(span.text-red-500) {
    font-weight: 700;
}

::-webkit-scrollbar {
    width: 4px;
}
::-webkit-scrollbar-track {
    background: transparent;
}
::-webkit-scrollbar-thumb {
    background: rgba(239, 68, 68, 0.2);
    border-radius: 10px;
}
</style>

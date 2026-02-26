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
                        >Back to Dashboard</span
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
                    Loading Lessons...
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
                    No Lessons Yet
                </h2>
                <p
                    class="text-xs font-mono text-gray-600 uppercase tracking-widest leading-relaxed"
                >
                    No lessons are available right now.
                </p>
            </div>

            <div v-else class="max-w-4xl mx-auto space-y-12">
                <div class="mb-12 text-center reveal-section active">
                    <h2
                        class="text-red-500 font-mono tracking-[0.3em] text-xs mb-3 uppercase"
                    >
                        Lessons
                    </h2>
                    <h1
                        class="text-4xl md:text-5xl font-black text-white tracking-tighter uppercase"
                    >
                        Study
                        <span
                            class="text-transparent bg-clip-text bg-linear-to-r from-red-500 to-red-600"
                            >Library</span
                        >
                    </h1>
                </div>

                <div
                    class="reveal-section active bg-white/5 border border-white/10 rounded-2xl p-4 md:p-5 flex flex-col gap-4"
                >
                    <div
                        class="flex flex-col md:flex-row md:items-center md:justify-between gap-4"
                    >
                        <div>
                            <p
                                class="text-[10px] font-black text-gray-500 uppercase tracking-widest"
                            >
                                Lessons
                            </p>
                            <p class="text-sm text-gray-400">
                                Use next/previous to move between lessons.
                            </p>
                        </div>
                        <button
                            @click="toggleSortOrder"
                            class="self-start md:self-auto px-4 py-2 rounded-xl border border-white/10 bg-white/5 hover:bg-white/10 text-xs font-black uppercase tracking-widest text-gray-300 transition-all"
                        >
                            <i class="fas fa-sort-amount-down-alt mr-2"></i>
                            {{
                                sortOrder === "asc"
                                    ? "Oldest First"
                                    : "Newest First"
                            }}
                        </button>
                    </div>
                </div>

                <div
                    v-if="currentStudy"
                    class="reveal-section active bg-white/5 border border-white/10 rounded-[2.5rem] overflow-hidden shadow-2xl transition-all duration-500"
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
                                    >Lesson {{ currentPage + 1 }} of
                                    {{ orderedStudies.length }}</span
                                >
                            </div>
                            <h2
                                class="text-3xl md:text-4xl font-black text-white tracking-tighter uppercase mb-4 leading-none"
                            >
                                {{ currentStudy.title }}
                            </h2>
                            <p
                                v-if="currentStudy.description"
                                class="text-gray-500 font-medium max-w-2xl leading-relaxed italic"
                            >
                                {{ currentStudy.description }}
                            </p>
                        </div>

                        <!-- Lesson Content -->
                        <div class="relative">
                            <!-- Subtle Grid Overlay for Content -->
                            <div
                                class="prose max-w-none text-gray-300 whitespace-pre-wrap font-sans leading-relaxed text-lg"
                                v-html="formatContent(currentStudy.content)"
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
                                        Characters
                                    </p>
                                    <p
                                        class="text-xs font-mono font-bold text-gray-400"
                                    >
                                        {{
                                            getContentLength(
                                                currentStudy.content,
                                            )
                                        }}
                                        Chars
                                    </p>
                                </div>
                                <div class="w-px h-8 bg-white/5 mx-2"></div>
                                <div class="text-left">
                                    <p
                                        class="text-[8px] font-black text-gray-600 uppercase tracking-widest"
                                    >
                                        Lesson ID
                                    </p>
                                    <p
                                        class="text-xs font-mono font-bold text-red-500/50"
                                    >
                                        GEL-{{
                                            currentStudy.id
                                                .toString()
                                                .padStart(4, "0")
                                        }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex gap-4">
                                <button
                                    v-if="currentPage > 0"
                                    @click="goToPage(currentPage - 1)"
                                    class="px-8 py-4 bg-white/5 text-gray-500 font-black rounded-xl hover:bg-white/10 hover:text-white transition-all uppercase text-[10px] tracking-widest border border-white/5"
                                >
                                    <i class="fas fa-chevron-left mr-3"></i
                                    >Previous Lesson
                                </button>
                                <button
                                    v-if="currentPage < orderedStudies.length - 1"
                                    @click="goToPage(currentPage + 1)"
                                    class="px-10 py-4 bg-red-500 text-white font-black rounded-xl hover:bg-red-600 transition-all shadow-[0_15px_30px_rgba(239,68,68,0.2)] uppercase text-[10px] tracking-widest"
                                >
                                    Next Lesson
                                    <i class="fas fa-chevron-right ml-3"></i>
                                </button>
                                <router-link
                                    v-else
                                    to="/user/dashboard"
                                    class="px-10 py-4 bg-green-500 text-black font-black rounded-xl hover:bg-green-600 transition-all shadow-[0_15px_30px_rgba(34,197,94,0.2)] uppercase text-[10px] tracking-widest"
                                >
                                    Back to Dashboard
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
            sortOrder: "asc",
        };
    },
    computed: {
        orderedStudies() {
            return [...this.studies].sort((a, b) => {
                const aTime = new Date(a.created_at || 0).getTime();
                const bTime = new Date(b.created_at || 0).getTime();

                return this.sortOrder === "asc" ? aTime - bTime : bTime - aTime;
            });
        },
        currentStudy() {
            return this.orderedStudies[this.currentPage] || null;
        },
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
                this.currentPage = 0;
            } catch (error) {
                console.error("Failed to load lessons:", error);
            } finally {
                this.loading = false;
            }
        },
        formatContent(content) {
            if (!content) return "";
            const safeContent = String(content);

            // If content is already rich HTML (from the admin editor), render it as-is.
            if (/<[a-z][\s\S]*>/i.test(safeContent)) {
                return safeContent;
            }

            return safeContent
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
            if (!content) return 0;
            const plainText = String(content).replace(/<[^>]*>/g, "");
            return plainText.replace(/\s/g, "").length;
        },
        goToPage(index) {
            const lastIndex = this.orderedStudies.length - 1;
            this.currentPage = Math.min(Math.max(index, 0), lastIndex);
            window.scrollTo({ top: 0, behavior: "smooth" });
        },
        toggleSortOrder() {
            this.sortOrder = this.sortOrder === "asc" ? "desc" : "asc";
            this.currentPage = 0;
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

.prose :deep(h1),
.prose :deep(h2),
.prose :deep(h3) {
    color: #fff;
    font-weight: 800;
    margin-top: 1.25rem;
    margin-bottom: 0.75rem;
    line-height: 1.2;
}

.prose :deep(p) {
    margin: 0 0 1rem 0;
}

.prose :deep(ul),
.prose :deep(ol) {
    margin: 0 0 1rem 1.25rem;
}

.prose :deep(li) {
    margin-bottom: 0.35rem;
}

.prose :deep(strong) {
    color: #fff;
    font-weight: 700;
}

.prose :deep(em) {
    color: #d1d5db;
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

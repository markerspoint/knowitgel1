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

        <!-- Navigation Placeholder/Header -->
        <nav
            class="w-full z-50 bg-[#111111]/80 backdrop-blur-md border-b border-white/5"
        >
            <div
                class="container mx-auto px-6 py-4 flex items-center justify-between"
            >
                <div class="flex items-center space-x-3 group cursor-default">
                    <div
                        class="w-10 h-10 bg-red-500 rounded-lg flex items-center justify-center"
                    >
                        <i class="fas fa-microchip text-white text-xl"></i>
                    </div>
                    <span
                        class="text-xl font-bold tracking-tighter text-white uppercase"
                        >KNOWIT GEL1</span
                    >
                </div>
                <div
                    class="text-xs font-mono text-gray-500 uppercase tracking-widest hidden md:block"
                >
                    Assessment Terminal v1.0
                </div>
            </div>
        </nav>

        <div class="flex-grow container mx-auto px-6 py-12 relative z-10">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-12">
                    <h2
                        class="text-red-500 font-mono tracking-[0.3em] text-xs mb-3 uppercase"
                    >
                        Welcome Assessment
                    </h2>
                    <h1
                        class="text-4xl md:text-5xl font-black text-white tracking-tighter uppercase mb-4"
                    >
                        Initialize Your
                        <span
                            class="text-transparent bg-clip-text bg-linear-to-r from-red-500 to-red-600"
                            >Knowledge Link</span
                        >
                    </h1>
                    <p class="text-gray-500 max-w-xl mx-auto">
                        Please complete this initial evaluation to calibrate
                        your learning path and unlock your student dashboard.
                    </p>
                </div>

                <!-- Loading State -->
                <div
                    v-if="isLoading"
                    class="bg-white/5 backdrop-blur-md rounded-3xl border border-white/10 p-12 text-center shadow-2xl"
                >
                    <div class="flex flex-col items-center justify-center py-8">
                        <div class="relative w-20 h-20 mb-8">
                            <div
                                class="absolute inset-0 border-4 border-red-500/10 rounded-full"
                            ></div>
                            <div
                                class="absolute inset-0 border-4 border-t-red-500 rounded-full animate-spin"
                            ></div>
                        </div>
                        <p
                            class="text-xl text-white font-bold tracking-tight uppercase"
                        >
                            Calibrating Questions...
                        </p>
                        <p
                            class="text-gray-500 mt-2 font-mono text-xs uppercase tracking-widest"
                        >
                            Accessing Neural Database
                        </p>
                    </div>
                </div>

                <!-- Assessment Content -->
                <div
                    v-else-if="currentQuestion && !showResults"
                    class="reveal-section active"
                >
                    <div
                        class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl shadow-2xl p-8 md:p-12 mb-8 transition-all duration-500 relative group overflow-hidden"
                    >
                        <!-- Decorative Watermark Icon -->
                        <div
                            class="absolute -bottom-10 -right-10 opacity-5 pointer-events-none"
                        >
                            <i
                                class="fas fa-brain text-[15rem] text-red-500"
                            ></i>
                        </div>

                        <div class="mb-10 relative z-10">
                            <div class="flex justify-between items-end mb-4">
                                <div>
                                    <span
                                        class="text-[10px] font-black text-red-500 uppercase tracking-[0.3em] block mb-1"
                                        >Current Task</span
                                    >
                                    <span
                                        class="text-lg font-bold text-white uppercase tracking-tighter"
                                        >Question
                                        {{ currentQuestionIndex + 1 }} /
                                        {{ questions.length }}</span
                                    >
                                </div>
                                <div class="w-48 text-right">
                                    <span
                                        class="text-[10px] font-black text-gray-500 uppercase tracking-[0.3em] block mb-2"
                                        >Sync Progress</span
                                    >
                                    <div
                                        class="w-full bg-white/5 rounded-full h-1.5 border border-white/5"
                                    >
                                        <div
                                            class="bg-linear-to-r from-red-500 to-red-600 h-full rounded-full transition-all duration-700 ease-out shadow-[0_0_15px_rgba(239,68,68,0.5)]"
                                            :style="{
                                                width: `${((currentQuestionIndex + 1) / questions.length) * 100}%`,
                                            }"
                                        ></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div
                            class="mb-12 text-center relative z-10"
                            v-if="currentQuestion.game_file"
                        >
                            <div
                                class="inline-block p-4 bg-white/5 rounded-2xl border border-white/10 shadow-inner group/img overflow-hidden"
                            >
                                <img
                                    :src="`/${currentQuestion.game_file}`"
                                    :alt="currentQuestion.title"
                                    class="max-w-full h-64 mx-auto rounded-xl object-contain group-hover/img:scale-105 transition-transform duration-500"
                                    @error="
                                        $event.target.style.display = 'none'
                                    "
                                />
                            </div>
                        </div>

                        <h3
                            class="text-2xl md:text-4xl font-black mb-12 text-white leading-tight tracking-tighter relative z-10"
                        >
                            {{ currentQuestion.question }}
                        </h3>

                        <div class="grid grid-cols-1 gap-4 relative z-10">
                            <button
                                v-for="(option, index) in getOptions()"
                                :key="index"
                                @click="selectAnswer(option)"
                                :class="[
                                    'group w-full p-6 text-left rounded-2xl border transition-all duration-300 transform relative overflow-hidden',
                                    selectedAnswer === option
                                        ? 'bg-red-500 border-red-500 text-white shadow-[0_10px_20px_rgba(239,68,68,0.3)] scale-[1.01]'
                                        : 'bg-white/5 border-white/5 text-gray-400 hover:border-red-500/50 hover:bg-white/10 hover:text-white',
                                ]"
                            >
                                <div class="flex items-center">
                                    <div
                                        class="w-10 h-10 rounded-xl border mr-5 flex items-center justify-center shrink-0 transition-all duration-300"
                                        :class="
                                            selectedAnswer === option
                                                ? 'bg-white/20 border-white text-white'
                                                : 'bg-black/20 border-white/10 text-gray-600 group-hover:border-red-500/50 group-hover:text-red-500'
                                        "
                                    >
                                        <span
                                            class="text-lg font-black uppercase"
                                            >{{
                                                String.fromCharCode(65 + index)
                                            }}</span
                                        >
                                    </div>
                                    <span
                                        class="text-lg font-bold tracking-tight"
                                        >{{ option }}</span
                                    >
                                </div>
                                <!-- Subtle Selection Glow -->
                                <div
                                    v-if="selectedAnswer === option"
                                    class="absolute inset-0 bg-linear-to-r from-white/0 via-white/5 to-white/0 animate-pulse pointer-events-none"
                                ></div>
                            </button>
                        </div>

                        <div
                            class="mt-12 flex flex-col md:flex-row justify-between gap-4 relative z-10"
                        >
                            <button
                                v-if="currentQuestionIndex > 0"
                                @click="previousQuestion"
                                class="order-2 md:order-1 px-8 py-4 bg-white/5 text-gray-500 font-bold rounded-xl border border-white/5 hover:bg-white/10 hover:text-white transition-all flex items-center justify-center uppercase tracking-widest text-xs"
                            >
                                <i class="fas fa-chevron-left mr-3"></i>Shift
                                Back
                            </button>
                            <div v-else class="order-2 md:order-1"></div>

                            <button
                                @click="nextQuestion"
                                :disabled="!selectedAnswer"
                                :class="[
                                    'order-1 md:order-2 px-10 py-5 rounded-xl font-black transition-all flex items-center justify-center text-sm uppercase tracking-[0.2em]',
                                    selectedAnswer
                                        ? 'bg-red-500 text-white shadow-lg hover:shadow-[0_15px_30px_rgba(239,68,68,0.4)] hover:-translate-y-1 active:scale-95'
                                        : 'bg-white/5 text-gray-700 cursor-not-allowed border border-white/5',
                                ]"
                            >
                                {{
                                    currentQuestionIndex ===
                                    questions.length - 1
                                        ? "Terminal Finalize"
                                        : "Proceed Link"
                                }}
                                <i
                                    class="fas fa-arrow-right ml-4"
                                    v-if="
                                        currentQuestionIndex <
                                        questions.length - 1
                                    "
                                ></i>
                                <i class="fas fa-power-off ml-4" v-else></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Done / Results State -->
                <div v-else-if="showResults" class="reveal-section active">
                    <div
                        class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-12 text-center shadow-2xl relative overflow-hidden group"
                    >
                        <div
                            class="absolute -top-10 -left-10 opacity-5 group-hover:opacity-10 transition-opacity"
                        >
                            <i
                                class="fas fa-check-double text-[15rem] text-red-500 font-black"
                            ></i>
                        </div>

                        <div
                            class="w-24 h-24 bg-red-500/10 text-red-500 rounded-2xl flex items-center justify-center mx-auto mb-8 animate-bounce"
                        >
                            <i class="fas fa-satellite-dish text-5xl"></i>
                        </div>
                        <h2
                            class="text-4xl md:text-5xl font-black mb-4 text-white tracking-tighter uppercase"
                        >
                            Link Synchronized
                        </h2>
                        <p class="text-xl text-gray-500 mb-10">
                            Your neural profile has been successfully uploaded
                            to the GEL1 network.
                        </p>

                        <div
                            class="bg-black/30 rounded-2xl p-8 mb-10 inline-block border border-white/5 relative z-10 backdrop-blur-sm"
                        >
                            <span
                                class="text-xs font-black text-gray-600 uppercase tracking-[0.4em] block mb-3"
                                >Calculated Aptitude</span
                            >
                            <div class="flex items-end justify-center">
                                <span
                                    class="text-7xl font-black text-white leading-none"
                                    >{{ correctAnswers }}</span
                                >
                                <span
                                    class="text-2xl font-bold text-red-500 ml-2 mb-1"
                                    >/ {{ questions.length }}</span
                                >
                            </div>
                        </div>
                        <br />
                        <button
                            @click="goToDashboard"
                            class="px-12 py-5 bg-red-500 text-white font-black rounded-xl hover:shadow-[0_20px_40px_rgba(239,68,68,0.3)] hover:-translate-y-1 transition-all active:scale-95 uppercase tracking-widest text-sm flex items-center mx-auto"
                        >
                            <span>Access Dashboard</span>
                            <i class="fas fa-external-link-alt ml-4"></i>
                        </button>
                    </div>
                </div>

                <!-- No Questions State -->
                <div
                    v-else-if="showNoQuestionsMessage"
                    class="bg-white/5 border border-white/10 rounded-3xl p-12 text-center reveal-section active"
                >
                    <div
                        class="w-20 h-20 bg-red-500/10 text-red-500 rounded-full flex items-center justify-center mx-auto mb-8"
                    >
                        <i class="fas fa-terminal text-3xl"></i>
                    </div>
                    <h2
                        class="text-3xl font-black mb-4 text-white uppercase tracking-tighter"
                    >
                        Database Offline
                    </h2>
                    <p
                        class="text-xl text-gray-600 mb-10 leading-relaxed italic"
                    >
                        "The network is silent. The data remains hidden."
                    </p>
                    <button
                        @click="goToDashboard"
                        class="px-8 py-4 bg-white/5 text-gray-400 font-bold rounded-xl border border-white/5 hover:bg-white/10 hover:text-white transition-all uppercase tracking-widest text-xs"
                    >
                        Return to Origin
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Assessment",
    data() {
        return {
            questions: [],
            currentQuestionIndex: 0,
            answers: {},
            selectedAnswer: null,
            showResults: false,
            correctAnswers: 0,
            showNoQuestionsMessage: false,
            isLoading: true,
        };
    },
    computed: {
        currentQuestion() {
            return this.questions[this.currentQuestionIndex] || null;
        },
    },
    async mounted() {
        await this.fetchQuestions();
    },
    methods: {
        async fetchQuestions() {
            try {
                this.isLoading = true;
                const response = await axios.get("/api/assessment/questions");
                this.questions = response.data.questions || [];
                if (this.questions.length === 0) {
                    this.showNoQuestionsMessage = true;
                }
            } catch (error) {
                console.error("Failed to fetch questions:", error);
                this.showNoQuestionsMessage = true;
            } finally {
                this.isLoading = false;
            }
        },
        getOptions() {
            if (!this.currentQuestion) return [];

            if (this.currentQuestion.options) {
                let options = this.currentQuestion.options;

                if (typeof options === "string") {
                    try {
                        const parsed = JSON.parse(options);
                        if (Array.isArray(parsed)) {
                            options = parsed;
                        } else {
                            options = options
                                .split(",")
                                .map((o) => o.trim())
                                .filter(Boolean);
                        }
                    } catch (e) {
                        options = options
                            .split(",")
                            .map((o) => o.trim())
                            .filter(Boolean);
                    }
                }

                if (Array.isArray(options) && options.length > 0) {
                    return options;
                }
            }

            return [
                "CPU",
                "GPU",
                "RAM",
                "Motherboard",
                "Hard Drive",
                "SSD",
                "Power Supply",
                "Cooling Fan",
            ];
        },
        selectAnswer(answer) {
            this.selectedAnswer = answer;
            this.answers[this.currentQuestionIndex] = answer;
        },
        previousQuestion() {
            if (this.currentQuestionIndex > 0) {
                this.currentQuestionIndex--;
                this.selectedAnswer =
                    this.answers[this.currentQuestionIndex] || null;
            }
        },
        async nextQuestion() {
            if (!this.selectedAnswer) return;

            this.answers[this.currentQuestionIndex] = this.selectedAnswer;

            if (this.currentQuestionIndex < this.questions.length - 1) {
                this.currentQuestionIndex++;
                this.selectedAnswer =
                    this.answers[this.currentQuestionIndex] || null;
                // Scroll to top of question card for mobile usability
                window.scrollTo({ top: 0, behavior: "smooth" });
            } else {
                await this.submitAssessment();
            }
        },
        async submitAssessment() {
            try {
                this.isLoading = true;
                const assessmentData = this.questions.map(
                    (question, index) => ({
                        game_id: question.id,
                        user_answer: this.answers[index],
                        is_correct: this.checkAnswer(
                            question,
                            this.answers[index],
                        ),
                    }),
                );

                const response = await axios.post("/api/assessment/submit", {
                    assessments: assessmentData,
                });

                this.correctAnswers = response.data.correct_count || 0;
                this.showResults = true;
            } catch (error) {
                console.error("Failed to submit assessment:", error);
                alert("Critical failure during sync. Reconnect and try again.");
            } finally {
                this.isLoading = false;
            }
        },
        checkAnswer(question, userAnswer) {
            if (!question || !userAnswer) return false;
            const correctAnswer = (question.answer || "").toLowerCase().trim();
            const userAnswerLower = (userAnswer || "").toLowerCase().trim();
            return correctAnswer === userAnswerLower;
        },
        goToDashboard() {
            this.$router.push("/user/dashboard");
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

@keyframes pulse-soft {
    0%,
    100% {
        opacity: 1;
    }
    50% {
        opacity: 0.8;
    }
}

.animate-pulse-soft {
    animation: pulse-soft 2s infinite;
}
</style>

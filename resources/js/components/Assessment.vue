<template>
    <div
        class="min-h-screen bg-gradient-to-br from-[#667eea] to-[#764ba2] text-white"
    >
        <div class="container mx-auto px-4 py-8">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-8">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">
                        Welcome Assessment
                    </h1>
                    <p class="text-lg md:text-xl opacity-90">
                        Please answer these assessment questions to continue to
                        your dashboard
                    </p>
                </div>

                <div
                    v-if="isLoading"
                    class="bg-white/95 backdrop-blur-md rounded-3xl shadow-2xl p-12 text-center"
                >
                    <div class="flex flex-col items-center justify-center py-8">
                        <div
                            class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-[#667eea] mb-6"
                        ></div>
                        <p class="text-xl text-gray-800 font-medium">
                            Preparing your assessment...
                        </p>
                    </div>
                </div>

                <div
                    v-else-if="currentQuestion && !showResults"
                    class="bg-white rounded-3xl shadow-2xl p-8 md:p-12 mb-8 transition-all duration-500"
                >
                    <div class="mb-10">
                        <div class="flex justify-between items-center mb-4">
                            <span
                                class="text-sm font-semibold text-gray-500 uppercase tracking-wider"
                                >Question {{ currentQuestionIndex + 1 }} /
                                {{ questions.length }}</span
                            >
                            <div class="w-32 bg-gray-100 rounded-full h-2.5">
                                <div
                                    class="bg-linear-to-r from-[#667eea] to-[#764ba2] h-2.5 rounded-full transition-all duration-500 ease-out shadow-[0_0_10px_rgba(102,126,234,0.5)]"
                                    :style="{
                                        width: `${((currentQuestionIndex + 1) / questions.length) * 100}%`,
                                    }"
                                ></div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="mb-10 text-center"
                        v-if="currentQuestion.game_file"
                    >
                        <img
                            :src="`/${currentQuestion.game_file}`"
                            :alt="currentQuestion.title"
                            class="max-w-full h-64 mx-auto rounded-2xl object-contain shadow-lg border border-gray-100"
                            @error="$event.target.style.display = 'none'"
                        />
                    </div>

                    <h3
                        class="text-2xl md:text-3xl font-bold mb-10 text-gray-800 leading-tight"
                    >
                        {{ currentQuestion.question }}
                    </h3>

                    <div class="grid grid-cols-1 gap-4">
                        <button
                            v-for="(option, index) in getOptions()"
                            :key="index"
                            @click="selectAnswer(option)"
                            :class="[
                                'group w-full p-6 text-left rounded-2xl border-2 transition-all duration-300 transform',
                                selectedAnswer === option
                                    ? 'bg-[#667eea] border-[#667eea] text-white shadow-xl scale-[1.02]'
                                    : 'bg-white border-gray-100 text-gray-700 hover:border-[#667eea] hover:bg-gray-50',
                            ]"
                        >
                            <div class="flex items-center">
                                <div
                                    class="w-10 h-10 rounded-xl border-2 mr-5 flex items-center justify-center shrink-0 transition-colors"
                                    :class="
                                        selectedAnswer === option
                                            ? 'bg-white/20 border-white'
                                            : 'bg-gray-50 border-gray-200 group-hover:border-[#667eea]'
                                    "
                                >
                                    <span
                                        class="text-lg font-bold"
                                        :class="
                                            selectedAnswer === option
                                                ? 'text-white'
                                                : 'text-gray-400 group-hover:text-[#667eea]'
                                        "
                                    >
                                        {{ String.fromCharCode(65 + index) }}
                                    </span>
                                </div>
                                <span class="text-lg font-semibold">{{
                                    option
                                }}</span>
                            </div>
                        </button>
                    </div>

                    <div
                        class="mt-12 flex flex-col md:flex-row justify-between gap-4"
                    >
                        <button
                            v-if="currentQuestionIndex > 0"
                            @click="previousQuestion"
                            class="order-2 md:order-1 px-8 py-4 bg-gray-50 text-gray-600 font-bold rounded-2xl hover:bg-gray-100 hover:text-gray-800 transition-all flex items-center justify-center"
                        >
                            <i class="fas fa-chevron-left mr-2"></i>Back
                        </button>
                        <div v-else class="order-2 md:order-1"></div>

                        <button
                            @click="nextQuestion"
                            :disabled="!selectedAnswer"
                            :class="[
                                'order-1 md:order-2 px-10 py-5 rounded-2xl font-bold transition-all flex items-center justify-center text-lg',
                                selectedAnswer
                                    ? 'bg-gradient-to-r from-[#667eea] to-[#764ba2] text-white shadow-lg hover:shadow-2xl hover:-translate-y-1 active:scale-95'
                                    : 'bg-gray-200 text-gray-400 cursor-not-allowed',
                            ]"
                        >
                            {{
                                currentQuestionIndex === questions.length - 1
                                    ? "Complete Assessment"
                                    : "Continue"
                            }}
                            <i
                                class="fas fa-arrow-right ml-3"
                                v-if="
                                    currentQuestionIndex < questions.length - 1
                                "
                            ></i>
                            <i class="fas fa-check-circle ml-3" v-else></i>
                        </button>
                    </div>
                </div>

                <div
                    v-else-if="showResults"
                    class="bg-white rounded-3xl shadow-2xl p-12 text-center"
                >
                    <div
                        class="w-24 h-24 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-8"
                    >
                        <i class="fas fa-check-circle text-5xl"></i>
                    </div>
                    <h2 class="text-4xl font-extrabold mb-4 text-gray-800">
                        Assessment Complete!
                    </h2>
                    <p class="text-xl text-gray-600 mb-10">
                        You've successfully finished the initial assessment.
                    </p>
                    <div
                        class="bg-gray-50 rounded-2xl p-8 mb-10 inline-block border border-gray-100"
                    >
                        <span
                            class="text-sm font-bold text-gray-400 uppercase tracking-widest block mb-2"
                            >Your Score</span
                        >
                        <span class="text-5xl font-black text-gray-800"
                            >{{ correctAnswers }} / {{ questions.length }}</span
                        >
                    </div>
                    <br />
                    <button
                        @click="goToDashboard"
                        class="px-12 py-5 bg-gradient-to-r from-[#667eea] to-[#764ba2] text-white font-bold rounded-2xl hover:shadow-[0_20px_40px_rgba(102,126,234,0.3)] hover:-translate-y-1 transition-all active:scale-95 text-lg"
                    >
                        Enter My Dashboard
                    </button>
                </div>

                <div
                    v-else-if="showNoQuestionsMessage"
                    class="bg-white rounded-3xl shadow-2xl p-12 text-center text-gray-800"
                >
                    <div
                        class="w-24 h-24 bg-yellow-100 text-yellow-500 rounded-full flex items-center justify-center mx-auto mb-8"
                    >
                        <i class="fas fa-exclamation-triangle text-5xl"></i>
                    </div>
                    <h2 class="text-3xl font-extrabold mb-4 text-gray-800">
                        Setup Required
                    </h2>
                    <p class="text-xl text-gray-600 mb-10">
                        The initial assessment is being prepared. Please check
                        back in a moment or contact support.
                    </p>
                    <button
                        @click="goToDashboard"
                        class="px-8 py-4 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-all"
                    >
                        Return to Home
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
                    // Try to parse as JSON; if that fails, treat as comma-separated list
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
            } else {
                await this.submitAssessment();
            }
        },
        async submitAssessment() {
            try {
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
                alert("Failed to submit assessment. Please try again.");
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

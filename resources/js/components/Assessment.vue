<template>
  <div class="min-h-screen bg-gradient-to-br from-[#667eea] to-[#764ba2] text-white">
    <div class="container mx-auto px-4 py-8">
      <div class="max-w-4xl mx-auto">
        <div class="text-center mb-8">
          <h1 class="text-4xl md:text-5xl font-bold mb-4">Welcome Assessment</h1>
          <p class="text-lg md:text-xl opacity-90">Please answer these questions about computer parts to continue</p>
        </div>

        <div v-if="isLoading" class="bg-white bg-opacity-10 backdrop-blur-lg border border-white border-opacity-20 rounded-2xl shadow-lg p-8 text-center">
          <div class="flex flex-col items-center justify-center py-12">
            <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-white mb-4"></div>
            <p class="text-xl">Loading assessment questions...</p>
          </div>
        </div>

        <div v-else-if="currentQuestion" class="bg-white bg-opacity-10 backdrop-blur-lg border border-white border-opacity-20 rounded-2xl shadow-lg p-8 mb-6 text-gray-900">
          <div class="mb-6">
            <div class="flex justify-between items-center mb-4">
              <span class="text-sm opacity-75">Question {{ currentQuestionIndex + 1 }} of {{ questions.length }}</span>
              <div class="w-32 bg-white bg-opacity-20 rounded-full h-2">
                <div class="bg-white h-2 rounded-full transition-all duration-300" 
                     :style="{ width: `${((currentQuestionIndex + 1) / questions.length) * 100}%` }"></div>
              </div>
            </div>
          </div>

          <div class="mb-6 text-center">
            <img v-if="currentQuestion.game_file" 
                 :src="`/${currentQuestion.game_file}`" 
                 :alt="currentQuestion.title" 
                 class="max-w-full h-64 mx-auto rounded-lg object-contain"
                 @error="$event.target.style.display='none'">
            <div v-else class="w-full h-64 bg-white bg-opacity-10 rounded-lg flex items-center justify-center">
              <i class="fas fa-image text-6xl text-white opacity-50"></i>
            </div>
          </div>

          <h3 class="text-2xl font-semibold mb-6 text-gray-900">{{ currentQuestion.question }}</h3>

          <div class="space-y-3">
            <button v-for="(option, index) in getOptions()" 
                    :key="index"
                    @click="selectAnswer(option)"
                    :class="[
                      'w-full p-4 text-left rounded-lg border-2 transition-all duration-200',
                      selectedAnswer === option 
                        ? 'bg-white bg-opacity-20 border-white border-opacity-50 shadow-lg' 
                        : 'bg-white bg-opacity-5 border-white border-opacity-20 hover:bg-white hover:bg-opacity-10'
                    ]">
              <div class="flex items-center">
                <div class="w-6 h-6 rounded-full border-2 border-white mr-3 flex items-center justify-center"
                     :class="selectedAnswer === option ? 'bg-white' : ''">
                  <i v-if="selectedAnswer === option" class="fas fa-check text-[#667eea] text-xs"></i>
                </div>
                <span class="text-lg text-gray-900">{{ option }}</span>
              </div>
            </button>
          </div>

          <div class="mt-8 flex justify-between">
            <button v-if="currentQuestionIndex > 0" 
                    @click="previousQuestion"
                    class="px-6 py-3 bg-white bg-opacity-20 text-white rounded-lg hover:bg-white hover:bg-opacity-30 transition-colors">
              <i class="fas fa-arrow-left mr-2"></i>Previous
            </button>
            <div v-else></div>
            <button @click="nextQuestion"
                    :disabled="!selectedAnswer"
                    :class="[
                      'px-6 py-3 rounded-lg transition-colors',
                      selectedAnswer 
                        ? 'bg-gradient-to-r from-[#667eea] to-[#764ba2] text-white hover:shadow-lg' 
                        : 'bg-white bg-opacity-20 text-white opacity-50 cursor-not-allowed'
                    ]">
              {{ currentQuestionIndex === questions.length - 1 ? 'Submit' : 'Next' }}
              <i class="fas fa-arrow-right ml-2"></i>
            </button>
          </div>
        </div>

        <div v-if="showNoQuestionsMessage" class="bg-white bg-opacity-10 backdrop-blur-lg border border-white border-opacity-20 rounded-2xl shadow-lg p-8 text-center text-gray-900">
          <i class="fas fa-exclamation-circle text-6xl text-yellow-400 mb-4"></i>
          <h2 class="text-3xl font-bold mb-4">No Assessment Questions Available</h2>
          <p class="text-xl mb-6">There are no assessment questions available at this time. Please contact an administrator.</p>
          <button @click="goToDashboard"
                  class="px-8 py-3 bg-gradient-to-r from-[#667eea] to-[#764ba2] text-white rounded-lg hover:shadow-lg transition-all">
            Go to Dashboard
          </button>
        </div>

        <div v-if="showResults" class="bg-white bg-opacity-10 backdrop-blur-lg border border-white border-opacity-20 rounded-2xl shadow-lg p-8 text-center text-gray-900">
          <i class="fas fa-check-circle text-6xl text-green-400 mb-4"></i>
          <h2 class="text-3xl font-bold mb-4">Assessment Completed!</h2>
          <p class="text-xl mb-6">You answered {{ correctAnswers }} out of {{ questions.length }} questions correctly.</p>
          <button @click="goToDashboard"
                  class="px-8 py-3 bg-gradient-to-r from-[#667eea] to-[#764ba2] text-white rounded-lg hover:shadow-lg transition-all">
            Go to Dashboard
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'Assessment',
  data() {
    return {
      questions: [],
      currentQuestionIndex: 0,
      answers: {},
      selectedAnswer: null,
      showResults: false,
      correctAnswers: 0,
      showNoQuestionsMessage: false,
      isLoading: true
    };
  },
  computed: {
    currentQuestion() {
      return this.questions[this.currentQuestionIndex] || null;
    }
  },
  async mounted() {
    await this.fetchQuestions();
  },
  methods: {
    async fetchQuestions() {
      try {
        this.isLoading = true;
        const response = await axios.get('/api/assessment/questions');
        this.questions = response.data.questions || [];
        if (this.questions.length === 0) {
          this.showNoQuestionsMessage = true;
        }
      } catch (error) {
        console.error('Failed to fetch questions:', error);
        this.showNoQuestionsMessage = true;
      } finally {
        this.isLoading = false;
      }
    },
    getOptions() {
      if (!this.currentQuestion) return [];
      
      if (this.currentQuestion.options) {
        let options = this.currentQuestion.options;

        if (typeof options === 'string') {
          // Try to parse as JSON; if that fails, treat as comma-separated list
          try {
            const parsed = JSON.parse(options);
            if (Array.isArray(parsed)) {
              options = parsed;
            } else {
              options = options.split(',').map(o => o.trim()).filter(Boolean);
            }
          } catch (e) {
            options = options.split(',').map(o => o.trim()).filter(Boolean);
          }
        }

        if (Array.isArray(options) && options.length > 0) {
          return options;
        }
      }
      
      return ['CPU', 'GPU', 'RAM', 'Motherboard', 'Hard Drive', 'SSD', 'Power Supply', 'Cooling Fan'];
    },
    selectAnswer(answer) {
      this.selectedAnswer = answer;
      this.answers[this.currentQuestionIndex] = answer;
    },
    previousQuestion() {
      if (this.currentQuestionIndex > 0) {
        this.currentQuestionIndex--;
        this.selectedAnswer = this.answers[this.currentQuestionIndex] || null;
      }
    },
    async nextQuestion() {
      if (!this.selectedAnswer) return;

      this.answers[this.currentQuestionIndex] = this.selectedAnswer;

      if (this.currentQuestionIndex < this.questions.length - 1) {
        this.currentQuestionIndex++;
        this.selectedAnswer = this.answers[this.currentQuestionIndex] || null;
      } else {
        await this.submitAssessment();
      }
    },
    async submitAssessment() {
      try {
        const assessmentData = this.questions.map((question, index) => ({
          game_id: question.id,
          user_answer: this.answers[index],
          is_correct: this.checkAnswer(question, this.answers[index])
        }));

        const response = await axios.post('/api/assessment/submit', {
          assessments: assessmentData
        });

        this.correctAnswers = response.data.correct_count || 0;
        this.showResults = true;
      } catch (error) {
        console.error('Failed to submit assessment:', error);
        alert('Failed to submit assessment. Please try again.');
      }
    },
    checkAnswer(question, userAnswer) {
      if (!question || !userAnswer) return false;
      const correctAnswer = (question.answer || '').toLowerCase().trim();
      const userAnswerLower = (userAnswer || '').toLowerCase().trim();
      return correctAnswer === userAnswerLower;
    },
    goToDashboard() {
      this.$router.push('/user/dashboard');
    }
  }
};
</script>


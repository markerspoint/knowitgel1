<template>
  <div class="min-h-screen bg-gradient-to-br from-[#667eea] to-[#764ba2]">
    <nav class="mb-4 relative z-50" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
      <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
          <router-link to="/admin/dashboard" class="flex items-center text-white font-semibold text-lg no-underline hover:opacity-80 transition-opacity">
            <i class="fas fa-gamepad mr-2"></i>KnowItGel Admin
          </router-link>
          <div class="hidden md:flex items-center space-x-4">
            <div class="relative ml-4 z-50" @click.stop>
              <button @click="showProfileDropdown = !showProfileDropdown" 
                      class="flex items-center text-white hover:opacity-80 transition-opacity bg-transparent border-0 cursor-pointer p-0">
                <div class="w-10 h-10 rounded-full border-2 border-white border-opacity-30 flex items-center justify-center overflow-hidden bg-gray-300">
                  <img
                    v-if="user && user.profile_picture"
                    :src="'/' + user.profile_picture"
                    alt="Profile"
                    class="w-full h-full object-cover"
                  >
                  <div
                    v-else
                    class="w-full h-full bg-gradient-to-br from-[#667eea] to-[#764ba2] flex items-center justify-center text-white font-bold"
                  >
                    <span v-if="user">
                      {{ user.fname ? user.fname.charAt(0).toUpperCase() : 'A' }}{{ user.lname ? user.lname.charAt(0).toUpperCase() : 'U' }}
                    </span>
                    <span v-else>AU</span>
                  </div>
                </div>
              </button>
              <ul v-show="showProfileDropdown" 
                  class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg list-none m-0 p-2"
                  style="min-width: 200px; z-index: 9999;">
                <li>
                  <router-link to="/admin/profile" 
                              class="block px-4 py-2 text-gray-800 hover:bg-gray-100 rounded no-underline flex items-center">
                    <i class="fas fa-user mr-2"></i>Profile
                  </router-link>
                </li>
                <li>
                  <router-link to="/admin/users" 
                              class="block px-4 py-2 text-gray-800 hover:bg-gray-100 rounded no-underline flex items-center">
                    <i class="fas fa-users mr-2"></i>Users
                  </router-link>
                </li>
                <li>
                  <router-link to="/admin/assessment" 
                              class="block px-4 py-2 text-gray-800 hover:bg-gray-100 rounded no-underline flex items-center">
                    <i class="fas fa-clipboard-check mr-2"></i>Assessment
                  </router-link>
                </li>
                <li>
                  <router-link to="/admin/settings" 
                              class="block px-4 py-2 text-gray-800 hover:bg-gray-100 rounded no-underline flex items-center">
                    <i class="fas fa-cog mr-2"></i>Settings
                  </router-link>
                </li>
                <li class="border-t border-gray-200 mt-1 pt-1">
                  <a @click.prevent="handleLogout" 
                     class="block px-4 py-2 text-gray-800 hover:bg-gray-100 rounded no-underline flex items-center cursor-pointer">
                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <div class="container mx-auto px-4 pb-8">
      <div v-if="message" 
           :class="['alert rounded-lg p-4 mb-4 flex items-center justify-between', messageType === 'success' ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-red-100 text-red-800 border border-red-200']">
        <span>{{ message }}</span>
        <button @click="message = ''" class="ml-4 text-lg font-bold">&times;</button>
      </div>

      <div class="bg-white bg-opacity-95 rounded-2xl shadow-lg mb-5">
        <div class="p-5 border-b border-gray-200 flex justify-between items-center">
          <h4 class="text-xl font-semibold text-gray-800 flex items-center">
            <i class="fas fa-clipboard-check mr-2"></i>Assessment Question Management
          </h4>
          <button @click="showAddQuestionModal = true" 
                  class="px-4 py-2 bg-gradient-to-r from-[#667eea] to-[#764ba2] text-white font-semibold rounded-lg hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
            <i class="fas fa-plus mr-1"></i>Add Assessment Question
          </button>
        </div>
        <div class="p-5">
          <div class="overflow-x-auto">
            <table class="w-full mb-0">
              <thead>
                <tr>
                  <th class="text-left py-3 px-4 font-semibold text-gray-600 border-t-0 border-b border-gray-200">ID</th>
                  <th class="text-left py-3 px-4 font-semibold text-gray-600 border-t-0 border-b border-gray-200">Image</th>
                  <th class="text-left py-3 px-4 font-semibold text-gray-600 border-t-0 border-b border-gray-200">Question</th>
                  <th class="text-left py-3 px-4 font-semibold text-gray-600 border-t-0 border-b border-gray-200">Answer</th>
                  <th class="text-left py-3 px-4 font-semibold text-gray-600 border-t-0 border-b border-gray-200">Options</th>
                  <th class="text-left py-3 px-4 font-semibold text-gray-600 border-t-0 border-b border-gray-200">Status</th>
                  <th class="text-left py-3 px-4 font-semibold text-gray-600 border-t-0 border-b border-gray-200">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="question in assessmentQuestions" :key="question.id" class="border-b border-gray-200">
                  <td class="py-3 px-4 align-middle">{{ question.id }}</td>
                  <td class="py-3 px-4 align-middle">
                    <img
                      v-if="question.game_file"
                      :src="question.game_file"
                      :alt="question.title"
                      class="w-16 h-16 object-cover rounded-md border border-gray-200"
                      @error="handleImageError($event)"
                    >
                    <div v-else class="w-16 h-16 rounded-md bg-gray-100 flex items-center justify-center text-gray-400 text-xs border border-dashed border-gray-300">
                      No image
                    </div>
                  </td>
                  <td class="py-3 px-4 align-middle">{{ truncate(question.question, 50) }}</td>
                  <td class="py-3 px-4 align-middle">{{ question.answer }}</td>
                  <td class="py-3 px-4 align-middle">
                    <span class="text-sm text-gray-600">
                      {{ getOptionsDisplay(question.options) }}
                    </span>
                  </td>
                  <td class="py-3 px-4 align-middle">
                    <span :class="['px-3 py-1 rounded text-sm font-medium', question.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800']">
                      {{ capitalize(question.status) }}
                    </span>
                  </td>
                  <td class="py-3 px-4 align-middle">
                    <button @click="editQuestion(question)" class="px-3 py-1.5 bg-[#0d6efd] text-white rounded text-sm font-medium hover:bg-[#0b5ed7]">
                      <i class="fas fa-edit"></i>
                    </button>
                    <button @click="deleteQuestion(question)" class="ml-2 px-3 py-1.5 bg-[#dc3545] text-white rounded text-sm font-medium hover:bg-[#bb2d3b]">
                      <i class="fas fa-trash"></i>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div v-if="showAddQuestionModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
      <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-5 border-b border-gray-200 flex justify-between items-center">
          <h5 class="text-xl font-semibold text-gray-800">Add Assessment Question</h5>
          <button @click="showAddQuestionModal = false" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        </div>
        <form @submit.prevent="submitQuestion" class="p-5">
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
            <input type="text" v-model="questionForm.title" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent">
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
            <textarea v-model="questionForm.description" rows="2" required
                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent"></textarea>
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Question</label>
            <input type="text" v-model="questionForm.question" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent">
            <small class="text-gray-500 text-xs mt-1 block">Enter the question about the computer part</small>
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Answer</label>
            <input type="text" v-model="questionForm.answer" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent">
            <small class="text-gray-500 text-xs mt-1 block">Enter the correct answer</small>
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Options (comma separated)</label>
            <input type="text" v-model="questionForm.options" required
                   placeholder="CPU, GPU, RAM, Motherboard, Hard Drive, SSD, Power Supply, Cooling Fan"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent">
            <small class="text-gray-500 text-xs mt-1 block">Enter multiple choice options separated by commas</small>
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Computer Part Image <span class="text-red-500">*</span></label>
            <input type="file" ref="fileInput" @change="handleImageChange" accept="image/*" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent">
            <small class="text-gray-500 text-xs mt-1 block">Upload an image of the computer part (Required)</small>
            <small v-if="questionForm.game_file" class="text-green-600 text-xs mt-1 block">
              File selected: {{ questionForm.game_file.name }}
            </small>
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <select v-model="questionForm.status" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent">
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
          </div>
          <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
            <button type="button" @click="showAddQuestionModal = false" 
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">
              Cancel
            </button>
            <button type="submit" 
                    class="px-4 py-2 bg-gradient-to-r from-[#667eea] to-[#764ba2] text-white font-semibold rounded-lg hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
              Add Question
            </button>
          </div>
        </form>
      </div>
    </div>

    <div v-if="showEditQuestionModal && editingQuestion" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
      <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-5 border-b border-gray-200 flex justify-between items-center">
          <h5 class="text-xl font-semibold text-gray-800">Edit Assessment Question</h5>
          <button @click="showEditQuestionModal = false" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        </div>
        <form @submit.prevent="updateQuestion" class="p-5">
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
            <input type="text" v-model="editingQuestion.title" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent">
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
            <textarea v-model="editingQuestion.description" rows="2" required
                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent"></textarea>
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Question</label>
            <input type="text" v-model="editingQuestion.question" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent">
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Answer</label>
            <input type="text" v-model="editingQuestion.answer" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent">
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Options (comma separated)</label>
            <input type="text" v-model="editingQuestion.optionsText" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent">
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Computer Part Image (Optional)</label>
            <input type="file" @change="handleEditImageChange" accept="image/*"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent">
            <div v-if="editingQuestion.game_file" class="mt-2">
              <p class="text-sm text-gray-600 mb-2">Current image:</p>
              <img :src="editingQuestion.game_file" 
                   :alt="editingQuestion.title" 
                   class="w-32 h-32 object-cover rounded-md border border-gray-200"
                   @error="handleImageError($event)">
            </div>
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <select v-model="editingQuestion.status" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent">
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
          </div>
          <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
            <button type="button" @click="showEditQuestionModal = false" 
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">
              Cancel
            </button>
            <button type="submit" 
                    class="px-4 py-2 bg-gradient-to-r from-[#667eea] to-[#764ba2] text-white font-semibold rounded-lg hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
              Update Question
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'AdminAssessment',
  data() {
    return {
      user: null,
      assessmentQuestions: [],
      message: '',
      messageType: 'success',
      showAddQuestionModal: false,
      showEditQuestionModal: false,
      editingQuestion: null,
      showProfileDropdown: false,
      questionForm: {
        title: '',
        description: '',
        question: '',
        answer: '',
        options: '',
        status: 'active',
        game_file: null
      },
      editImageFile: null
    };
  },
  async mounted() {
    await this.fetchUser();
    await this.fetchAssessmentQuestions();
    document.addEventListener('click', this.handleClickOutside);
  },
  beforeUnmount() {
    document.removeEventListener('click', this.handleClickOutside);
  },
  methods: {
    async fetchUser() {
      try {
        const response = await axios.get('/api/admin/profile');
        if (response.data.status === 'success') {
          this.user = response.data.user;
        }
      } catch (error) {
        console.error('Failed to fetch user:', error);
      }
    },
    async fetchAssessmentQuestions() {
      try {
        const response = await axios.get('/api/admin/assessment/questions');
        this.assessmentQuestions = response.data.questions;
      } catch (error) {
        console.error('Failed to fetch assessment questions:', error);
        this.showMessage('Failed to load assessment questions', 'error');
      }
    },
    async submitQuestion() {
      try {
        if (!this.questionForm.game_file) {
          this.showMessage('Please select an image for this question', 'error');
          return;
        }

        const formData = new FormData();
        formData.append('title', this.questionForm.title);
        formData.append('description', this.questionForm.description);
        formData.append('question', this.questionForm.question);
        formData.append('answer', this.questionForm.answer);
        formData.append('options', this.questionForm.options);
        formData.append('type', 'guess_part');
        formData.append('status', this.questionForm.status);
        formData.append('game_file', this.questionForm.game_file);

        await axios.post('/api/admin/assessment/questions', formData);
        
        this.showAddQuestionModal = false;
        this.resetQuestionForm();
        await this.fetchAssessmentQuestions();
        this.showMessage('Assessment question added successfully!', 'success');
      } catch (error) {
        if (error.response && error.response.data && error.response.data.message) {
          this.showMessage(error.response.data.message, 'error');
        } else {
        this.showMessage('Failed to add assessment question', 'error');
        }
      }
    },
    async updateQuestion() {
      try {
        const formData = new FormData();
        formData.append('title', this.editingQuestion.title);
        formData.append('description', this.editingQuestion.description);
        formData.append('question', this.editingQuestion.question);
        formData.append('answer', this.editingQuestion.answer);
        formData.append('options', this.editingQuestion.optionsText);
        formData.append('status', this.editingQuestion.status);
        formData.append('_method', 'PUT');
        if (this.editImageFile) formData.append('game_file', this.editImageFile);

        await axios.post(`/api/admin/assessment/questions/${this.editingQuestion.id}`, formData);
        
        this.showEditQuestionModal = false;
        this.editingQuestion = null;
        await this.fetchAssessmentQuestions();
        this.showMessage('Assessment question updated successfully!', 'success');
      } catch (error) {
        this.showMessage('Failed to update assessment question', 'error');
      }
    },
    editQuestion(question) {
      this.editingQuestion = {
        ...question,
        optionsText: this.getOptionsAsString(question.options)
      };
      this.editImageFile = null;
      this.editThumbnailFile = null;
      this.showEditQuestionModal = true;
    },
    async deleteQuestion(question) {
      if (!confirm('Are you sure you want to delete this assessment question?')) return;
      try {
        await axios.delete(`/api/admin/assessment/questions/${question.id}`);
        this.assessmentQuestions = this.assessmentQuestions.filter(q => q.id !== question.id);
        this.showMessage('Assessment question deleted successfully.', 'success');
      } catch (error) {
        this.showMessage('Failed to delete assessment question', 'error');
      }
    },
    handleImageChange(event) {
      this.questionForm.game_file = event.target.files[0];
    },
    handleEditImageChange(event) {
      this.editImageFile = event.target.files[0];
    },
    resetQuestionForm() {
      this.questionForm = {
        title: '',
        description: '',
        question: '',
        answer: '',
        options: '',
        status: 'active',
        game_file: null
      };
      if (this.$refs.fileInput) {
        this.$refs.fileInput.value = '';
      }
    },
    getOptionsAsString(options) {
      if (!options) return '';
      const opts = typeof options === 'string' ? JSON.parse(options || '[]') : options;
      return Array.isArray(opts) ? opts.join(', ') : '';
    },
    getOptionsDisplay(options) {
      if (!options) return 'N/A';
      const opts = typeof options === 'string' ? JSON.parse(options || '[]') : options;
      if (Array.isArray(opts)) {
        return opts.slice(0, 3).join(', ') + (opts.length > 3 ? '...' : '');
      }
      return 'N/A';
    },
    showMessage(msg, type) {
      this.message = msg;
      this.messageType = type;
      setTimeout(() => {
        this.message = '';
      }, 5000);
    },
    truncate(str, length) {
      if (!str) return '';
      return str.length > length ? str.substring(0, length) + '...' : str;
    },
    capitalize(str) {
      return str ? str.charAt(0).toUpperCase() + str.slice(1) : '';
    },
    async handleLogout() {
      try {
        await axios.post('/api/logout');
        this.$router.push('/login');
      } catch (error) {
        console.error('Logout failed:', error);
        this.$router.push('/login');
      }
    },
    handleClickOutside(event) {
      const profileDropdown = event.target.closest('.relative');
      if (!profileDropdown) {
        this.showProfileDropdown = false;
      }
    },
    handleImageError(event) {
      event.target.style.display = 'none';
      console.error('Failed to load image:', event.target.src);
    }
  }
};
</script>


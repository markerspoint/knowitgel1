<template>
  <div class="min-h-screen bg-gray-100">
    <nav class="mb-4 bg-white shadow-sm sticky top-0 z-50">
      <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
          <router-link to="/user/dashboard" class="flex items-center text-gray-800 font-semibold text-lg no-underline hover:opacity-80 transition-opacity">
            <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
          </router-link>
          <h1 class="text-xl font-bold text-gray-800">KNOWITGEL</h1>
          <div class="w-24"></div>
        </div>
      </div>
    </nav>

    <div class="container mx-auto px-4 pb-8">
      <div v-if="loading" class="flex justify-center items-center min-h-screen">
        <div class="text-center">
          <i class="fas fa-spinner fa-spin text-4xl text-gray-600 mb-4"></i>
          <p class="text-gray-600">Loading content...</p>
        </div>
      </div>

      <div v-else-if="studies.length === 0" class="flex justify-center items-center min-h-screen">
        <div class="text-center">
          <i class="fas fa-book text-6xl text-gray-400 mb-4"></i>
          <p class="text-xl text-gray-600">No study content available yet.</p>
        </div>
      </div>

      <div v-else class="max-w-4xl mx-auto">
        <div 
          v-for="(study, index) in studies" 
          :key="study.id"
          class="bg-white shadow-lg rounded-lg mb-8"
          style="min-height: 800px;"
        >
          <div class="p-8">
            <div class="text-center mb-6">
              <div class="inline-block bg-black text-white px-4 py-2 rounded mb-4">
                {{ index + 1 }}/{{ studies.length }}
              </div>
              <h2 class="text-3xl font-bold text-gray-900 mb-2">{{ study.title }}</h2>
              <p v-if="study.description" class="text-gray-600 text-lg">{{ study.description }}</p>
            </div>

            <div class="border-t border-gray-200 pt-6">
              <div 
                class="prose max-w-none text-gray-800 whitespace-pre-wrap font-sans"
                style="font-size: 11pt; line-height: 1.5;"
                v-html="formatContent(study.content)"
              ></div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between items-center text-sm text-gray-500">
              <div>Full text: {{ getContentLength(study.content) }}</div>
              <div class="flex gap-2">
                <button
                  v-if="index > 0"
                  @click="goToPage(index - 1)"
                  class="bg-black text-white px-4 py-2 rounded hover:bg-gray-800 transition-colors"
                >
                  PREVIOUS
                </button>
                <button
                  v-if="index < studies.length - 1"
                  @click="goToPage(index + 1)"
                  class="bg-black text-white px-4 py-2 rounded hover:bg-gray-800 transition-colors"
                >
                  NEXT
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'Studies',
  data() {
    return {
      studies: [],
      loading: true,
      currentPage: 0
    };
  },
  async mounted() {
    await this.fetchStudies();
  },
  methods: {
    async fetchStudies() {
      try {
        this.loading = true;
        const response = await axios.get('/api/user/studies');
        this.studies = response.data.studies || [];
      } catch (error) {
        console.error('Failed to fetch studies:', error);
        this.studies = [];
      } finally {
        this.loading = false;
      }
    },
    formatContent(content) {
      if (!content) return '';
      return content
        .replace(/\n/g, '<br>')
        .replace(/#(\w+)/g, '<span class="text-blue-600 font-semibold">#$1</span>');
    },
    getContentLength(content) {
      if (!content) return 0;
      return content.replace(/\s/g, '').length;
    },
    goToPage(index) {
      this.currentPage = index;
      const element = document.querySelectorAll('.bg-white.shadow-lg')[index];
      if (element) {
        element.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    }
  }
};
</script>

<style scoped>
.prose {
  font-family: 'Calibri', sans-serif;
}

.prose :deep(span.text-blue-600) {
  color: #2563eb;
  font-weight: 600;
}
</style>

<template>
  <div class="min-h-screen bg-gradient-to-br from-[#667eea] to-[#764ba2]">
    <nav class="mb-4 relative z-50" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
      <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
          <router-link to="/user/dashboard" class="flex items-center text-white font-semibold text-lg no-underline hover:opacity-80 transition-opacity">
            <i class="fas fa-gamepad mr-2"></i>KnowItGel
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
                  />
                  <div
                    v-else
                    class="w-full h-full bg-gradient-to-br from-[#667eea] to-[#764ba2] flex items-center justify-center text-white font-bold"
                  >
                    <span v-if="user">
                      {{ user.fname ? user.fname.charAt(0).toUpperCase() : 'U' }}{{ user.lname ? user.lname.charAt(0).toUpperCase() : 'U' }}
                    </span>
                    <span v-else>UU</span>
                  </div>
                </div>
              </button>
              <ul v-show="showProfileDropdown" 
                  class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg list-none m-0 p-2"
                  style="min-width: 200px; z-index: 9999;">
                <li>
                  <router-link to="/user/profile" 
                              class="block px-4 py-2 text-gray-800 hover:bg-gray-100 rounded no-underline flex items-center">
                    <i class="fas fa-user mr-2"></i>Profile
                  </router-link>
                </li>
                <li>
                  <router-link to="/leaderboard" 
                              class="block px-4 py-2 text-gray-800 hover:bg-gray-100 rounded no-underline flex items-center">
                    <i class="fas fa-trophy mr-2"></i>Leaderboards
                  </router-link>
                </li>
                <li>
                  <router-link to="/user/history" 
                              class="block px-4 py-2 text-gray-800 hover:bg-gray-100 rounded no-underline flex items-center">
                    <i class="fas fa-history mr-2"></i>History
                  </router-link>
                </li>
                <li>
                  <router-link to="/user/settings" 
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

    <div class="container mx-auto px-4 pb-8 relative z-10">
      <div class="text-center mb-8">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-2">
          <i class="fas fa-history mr-3"></i>Play History
        </h1>
        <p class="text-lg text-white opacity-90">Review your past game sessions and track your progress.</p>
      </div>

      <!-- Summary Cards -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white bg-opacity-95 rounded-2xl shadow p-4 flex flex-col justify-between">
          <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">Total Sessions</p>
          <p class="text-3xl font-bold text-gray-900">{{ stats.total_sessions }}</p>
        </div>
        <div class="bg-white bg-opacity-95 rounded-2xl shadow p-4 flex flex-col justify-between">
          <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">Total Score</p>
          <p class="text-3xl font-bold text-gray-900">{{ stats.total_score.toLocaleString() }}</p>
        </div>
        <div class="bg-white bg-opacity-95 rounded-2xl shadow p-4 flex flex-col justify-between">
          <p class="text-xs uppercase tracking-wide text-gray-500 mb-2">By Game</p>
          <div class="space-y-1 text-sm text-gray-700" v-if="Object.keys(stats.per_game).length">
            <div v-for="(item, key) in stats.per_game" :key="key" class="flex justify-between">
              <span>{{ gameLabel(key) }}</span>
              <span>{{ item.sessions }} sessions · {{ item.total_score.toLocaleString() }} pts</span>
            </div>
          </div>
          <p v-else class="text-sm text-gray-500">No games played yet.</p>
        </div>
      </div>

      <!-- History Table -->
      <div class="bg-white bg-opacity-95 rounded-2xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto max-h-[600px] overflow-y-auto">
          <table class="w-full">
            <thead class="bg-gradient-to-r from-[#667eea] to-[#764ba2] text-white sticky top-0 z-10">
              <tr>
                <th class="px-6 py-4 text-left font-semibold">Game</th>
                <th class="px-6 py-4 text-center font-semibold">Score</th>
                <th class="px-6 py-4 text-center font-semibold">Played At</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <tr v-for="entry in history" :key="entry.id" class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4">
                  <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center bg-gradient-to-br from-[#667eea] to-[#764ba2] text-white">
                      <i :class="gameIcon(entry.game_type)"></i>
                    </div>
                    <div>
                      <p class="font-semibold text-gray-800">{{ entry.game_label }}</p>
                      <p class="text-xs text-gray-500 uppercase tracking-wide">{{ entry.game_type }}</p>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 text-center">
                  <span class="font-bold text-lg text-gray-800">{{ entry.score }}</span>
                </td>
                <td class="px-6 py-4 text-center text-gray-600">
                  {{ formatDate(entry.played_at) }}
                </td>
              </tr>
              <tr v-if="!history.length && !isLoading">
                <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                  No history yet. Play some games to see your progress here.
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div v-if="isLoading" class="text-center py-6">
          <i class="fas fa-spinner fa-spin text-gray-500 text-2xl"></i>
          <p class="text-gray-600 mt-2">Loading history...</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'UserHistory',
  data() {
    return {
      user: null,
      history: [],
      stats: {
        total_score: 0,
        total_sessions: 0,
        per_game: {}
      },
      isLoading: false,
      showProfileDropdown: false
    };
  },
  async mounted() {
    await this.fetchUser();
    await this.fetchHistory();
    document.addEventListener('click', this.handleClickOutside);
  },
  beforeUnmount() {
    document.removeEventListener('click', this.handleClickOutside);
  },
  methods: {
    async fetchUser() {
      try {
        const response = await axios.get('/api/user');
        this.user = response.data.user;
      } catch (error) {
        console.error('Failed to fetch user:', error);
        this.$router.push('/login');
      }
    },
    async fetchHistory() {
      this.isLoading = true;
      try {
        const response = await axios.get('/api/user/history');
        if (response.data.status === 'success') {
          this.history = response.data.history || [];
          this.stats = response.data.stats || this.stats;
        }
      } catch (error) {
        console.error('Failed to fetch history:', error);
      } finally {
        this.isLoading = false;
      }
    },
    gameLabel(type) {
      const map = {
        qa_fps: 'Q&A FPS',
        typergel1: 'TyperGel1',
        assessment: 'Assessment',
        guess_part: 'Guess Part',
        lesson: 'Lesson'
      };
      return map[type] || type;
    },
    gameIcon(type) {
      const map = {
        qa_fps: 'fas fa-crosshairs',
        typergel1: 'fas fa-keyboard',
        assessment: 'fas fa-clipboard-check',
        guess_part: 'fas fa-microchip',
        lesson: 'fas fa-book-open'
      };
      return map[type] || 'fas fa-gamepad';
    },
    formatDate(value) {
      if (!value) return '';
      const date = new Date(value);
      return date.toLocaleString();
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
    }
  }
};
</script>



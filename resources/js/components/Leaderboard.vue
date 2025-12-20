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
          <i class="fas fa-trophy mr-3"></i>Leaderboard
        </h1>
        <p class="text-lg text-white opacity-90">Compete with other players and climb the ranks!</p>
      </div>

      <!-- Filter Section -->
      <div class="bg-white bg-opacity-95 rounded-2xl shadow-lg p-6 mb-6">
        <div class="flex flex-wrap items-center gap-4">
          <label class="text-sm font-medium text-gray-700">Filter by Game:</label>
          <select 
            v-model="selectedGameType" 
            @change="fetchLeaderboard"
            class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent"
          >
            <option value="all">All Games</option>
            <option value="qa_fps">Q&A FPS</option>
            <option value="typergel1">TyperGel1</option>
            <option value="assessment">Assessment</option>
          </select>
        </div>
      </div>

      <!-- Current User Rank Card -->
      <div v-if="currentUserRank" class="bg-gradient-to-r from-yellow-400 to-orange-500 rounded-2xl shadow-lg p-6 mb-6">
        <div class="flex items-center justify-between">
          <div class="flex items-center space-x-4">
            <div class="w-16 h-16 rounded-full overflow-hidden border-4 border-white shadow-lg bg-white">
              <img
                v-if="currentUserRank.profile_picture"
                :src="'/' + currentUserRank.profile_picture"
                alt="Profile"
                class="w-full h-full object-cover"
              />
              <div
                v-else
                class="w-full h-full bg-gradient-to-br from-[#667eea] to-[#764ba2] flex items-center justify-center text-white text-xl font-bold"
              >
                {{ currentUserRank.fname ? currentUserRank.fname.charAt(0).toUpperCase() : 'U' }}{{ currentUserRank.lname ? currentUserRank.lname.charAt(0).toUpperCase() : 'U' }}
              </div>
            </div>
            <div>
              <p class="text-sm text-white opacity-90">Your Rank</p>
              <h3 class="text-2xl font-bold text-white">#{{ currentUserRank.rank }}</h3>
              <p class="text-white font-semibold">{{ currentUserRank.fname }} {{ currentUserRank.lname }}</p>
            </div>
          </div>
          <div class="text-right">
            <p class="text-sm text-white opacity-90">Total Score</p>
            <p class="text-3xl font-bold text-white">{{ currentUserRank.total_score.toLocaleString() }}</p>
            <p class="text-sm text-white opacity-90 mt-1">{{ currentUserRank.games_played }} games played</p>
          </div>
        </div>
      </div>

      <!-- Leaderboard Table -->
      <div class="bg-white bg-opacity-95 rounded-2xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead class="bg-gradient-to-r from-[#667eea] to-[#764ba2] text-white">
              <tr>
                <th class="px-6 py-4 text-left font-semibold">Rank</th>
                <th class="px-6 py-4 text-left font-semibold">Player</th>
                <th class="px-6 py-4 text-center font-semibold">Total Score</th>
                <th class="px-6 py-4 text-center font-semibold">Games Played</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <tr 
                v-for="(player, index) in leaderboard" 
                :key="player.id"
                :class="[
                  'hover:bg-gray-50 transition-colors',
                  currentUserRank && player.id === currentUserRank.id ? 'bg-yellow-50 border-l-4 border-yellow-400' : ''
                ]"
              >
                <td class="px-6 py-4">
                  <div class="flex items-center">
                    <span 
                      v-if="player.rank <= 3" 
                      class="text-2xl mr-2"
                    >
                      {{ player.rank === 1 ? '🥇' : player.rank === 2 ? '🥈' : '🥉' }}
                    </span>
                    <span 
                      :class="[
                        'font-bold text-lg',
                        player.rank === 1 ? 'text-yellow-500' : player.rank === 2 ? 'text-gray-400' : player.rank === 3 ? 'text-orange-500' : 'text-gray-600'
                      ]"
                    >
                      #{{ player.rank }}
                    </span>
                  </div>
                </td>
                <td class="px-6 py-4">
                  <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-gray-200 shadow-md">
                      <img
                        v-if="player.profile_picture"
                        :src="'/' + player.profile_picture"
                        alt="Profile"
                        class="w-full h-full object-cover"
                      />
                      <div
                        v-else
                        class="w-full h-full bg-gradient-to-br from-[#667eea] to-[#764ba2] flex items-center justify-center text-white font-bold"
                      >
                        {{ player.fname ? player.fname.charAt(0).toUpperCase() : 'U' }}{{ player.lname ? player.lname.charAt(0).toUpperCase() : 'U' }}
                      </div>
                    </div>
                    <div>
                      <p class="font-semibold text-gray-800">{{ player.fname }} {{ player.lname }}</p>
                      <p class="text-sm text-gray-500">@{{ player.username }}</p>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 text-center">
                  <span class="font-bold text-lg text-gray-800">{{ player.total_score.toLocaleString() }}</span>
                </td>
                <td class="px-6 py-4 text-center">
                  <span class="text-gray-600">{{ player.games_played }}</span>
                </td>
              </tr>
              <tr v-if="leaderboard.length === 0">
                <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                  No players found. Be the first to play and get on the leaderboard!
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Loading State -->
      <div v-if="isLoading" class="text-center py-8">
        <i class="fas fa-spinner fa-spin text-white text-3xl"></i>
        <p class="text-white mt-2">Loading leaderboard...</p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'Leaderboard',
  data() {
    return {
      user: null,
      leaderboard: [],
      currentUserRank: null,
      selectedGameType: 'all',
      isLoading: false,
      showProfileDropdown: false
    };
  },
  async mounted() {
    await this.fetchUser();
    await this.fetchLeaderboard();
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
      }
    },
    async fetchLeaderboard() {
      this.isLoading = true;
      try {
        const response = await axios.get('/api/user/leaderboard', {
          params: {
            game_type: this.selectedGameType,
            limit: 100
          }
        });
        
        if (response.data.status === 'success') {
          this.leaderboard = response.data.leaderboard;
          this.currentUserRank = response.data.current_user_rank;
        }
      } catch (error) {
        console.error('Failed to fetch leaderboard:', error);
      } finally {
        this.isLoading = false;
      }
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


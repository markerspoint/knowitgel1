<template>
  <div class="min-h-screen bg-gradient-to-br from-[#667eea] to-[#764ba2] text-white overflow-hidden">
    <nav class="mb-4 relative z-50" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
      <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
          <a href="#" class="flex items-center text-white font-semibold text-lg no-underline">
            <i class="fas fa-gamepad mr-2"></i>KnowItGel
          </a>
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

    <div class="container mx-auto px-4 pb-8">
      <div class="text-center py-10 mb-8">
        <h1 class="text-4xl md:text-5xl font-bold mb-2">Welcome, {{ user?.fname }}!</h1>
        <p class="text-lg md:text-xl opacity-90 mb-6">Your personalized games will appear here soon.</p>
        
        <div v-if="gameAlertMessage" 
             class="mb-4 mx-auto max-w-md bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg flex items-center justify-between">
          <span class="flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ gameAlertMessage }}
          </span>
          <button @click="gameAlertMessage = ''" class="ml-4 text-red-700 hover:text-red-900">
            <i class="fas fa-times"></i>
          </button>
        </div>

        <div class="flex flex-wrap justify-center gap-4">
          <button
            @click="handleGameClick('qa_fps')"
            :disabled="!gameSettings.qa_fps_enabled"
            :class="[
              'inline-flex items-center px-6 py-3 font-semibold rounded-lg shadow-lg transition-all duration-300',
              gameSettings.qa_fps_enabled
                ? 'bg-gradient-to-r from-[#667eea] to-[#764ba2] text-white hover:shadow-xl hover:-translate-y-0.5 cursor-pointer'
                : 'bg-gray-400 text-gray-200 cursor-not-allowed opacity-60'
            ]"
          >
            <i class="fas fa-crosshairs mr-2"></i>
            Play Q&A Shooting Game
          </button>
          <button
            @click="handleGameClick('typergel1')"
            :disabled="!gameSettings.typergel1_enabled"
            :class="[
              'inline-flex items-center px-6 py-3 font-semibold rounded-lg shadow-lg transition-all duration-300',
              gameSettings.typergel1_enabled
                ? 'bg-gradient-to-r from-[#00bcd4] to-[#3f51b5] text-white hover:shadow-xl hover:-translate-y-0.5 cursor-pointer'
                : 'bg-gray-400 text-gray-200 cursor-not-allowed opacity-60'
            ]"
          >
            <i class="fas fa-keyboard mr-2"></i>
            Play Typing Game
          </button>
          <button
            @click="handleStudiesClick"
            class="inline-flex items-center px-6 py-3 font-semibold rounded-lg shadow-lg transition-all duration-300 bg-gradient-to-r from-[#f093fb] to-[#f5576c] text-white hover:shadow-xl hover:-translate-y-0.5 cursor-pointer"
          >
            <i class="fas fa-book mr-2"></i>
            Studies
          </button>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
        <div class="bg-white bg-opacity-90 rounded-2xl shadow-lg p-6 text-center">
          <i class="fas fa-trophy text-5xl mb-4 text-gray-800"></i>
          <h4 class="text-xl font-semibold mb-2 text-gray-900">Your Total Score</h4>
          <h2 class="text-4xl font-bold mb-2 text-gray-900">{{ stats?.total_score || 0 }}</h2>
          <p class="text-sm text-gray-700">{{ stats?.games_played > 0 ? 'Keep playing to improve!' : 'Start playing to earn points!' }}</p>
        </div>
        <div class="bg-white bg-opacity-90 rounded-2xl shadow-lg p-6 text-center">
          <i class="fas fa-gamepad text-5xl mb-4 text-gray-800"></i>
          <h4 class="text-xl font-semibold mb-2 text-gray-900">Games Played</h4>
          <h2 class="text-4xl font-bold mb-2 text-gray-900">{{ stats?.games_played || 0 }}</h2>
          <p class="text-sm text-gray-700">{{ stats?.games_played > 0 ? 'Keep playing to improve!' : 'Start playing to earn points!' }}</p>
        </div>
        <div class="bg-white bg-opacity-90 rounded-2xl shadow-lg p-6 text-center">
          <i class="fas fa-clipboard-check text-5xl mb-4 text-gray-800"></i>
          <h4 class="text-xl font-semibold mb-2 text-gray-900">Assessment Score</h4>
          <h2 class="text-4xl font-bold mb-2 text-gray-900">{{ stats?.assessment_score || 0 }}</h2>
          <p class="text-sm text-gray-700">{{ stats?.assessment_score > 0 ? 'Great job on your assessment!' : 'Complete the assessment to see your score!' }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'UserDashboard',
  data() {
    return {
      user: null,
      games: [],
      stats: {
        total_score: 0,
        games_played: 0,
        assessment_score: 0
      },
      gameSettings: {
        qa_fps_enabled: true,
        typergel1_enabled: true
      },
      gameAlertMessage: '',
      bgParticles: [],
      showProfileDropdown: false
    };
  },
  computed: {
    activeGames() {
      return this.games.filter(game => game.status === 'active');
    }
  },
  async mounted() {
    await this.fetchUser();
    await this.fetchDashboardData();
    await this.fetchGameSettings();
    this.createBackgroundParticles();
    document.addEventListener('click', this.handleClickOutside);
  },
  beforeUnmount() {
    document.removeEventListener('click', this.handleClickOutside);
    this.bgParticles.forEach(particle => {
      if (particle.parentNode) {
        particle.parentNode.removeChild(particle);
      }
    });
  },
  methods: {
    async fetchUser() {
      try {
        const response = await axios.get('/api/user');
        const user = response.data.user;
        
        if (user.is_disabled) {
          try {
            await axios.post('/api/logout');
          } catch (logoutError) {
            console.error('Logout error:', logoutError);
          }
          this.$router.push({
            path: '/login',
            query: { disabled: 'true' }
          });
          return;
        }
        
        this.user = user;
        this.stats = {
          total_score: user.total_score || 0,
          games_played: user.games_played || 0,
          lessons_completed: user.lessons_completed || 0
        };
      } catch (error) {
        console.error('Failed to fetch user:', error);
        this.$router.push('/login');
      }
    },
    async fetchDashboardData() {
      try {
        const response = await axios.get('/api/user/dashboard-data');
        this.games = response.data.games;
        this.stats = response.data.stats;
      } catch (error) {
        console.error('Failed to fetch dashboard data:', error);
      }
    },
    async fetchGameSettings() {
      try {
        const response = await axios.get('/api/user/game-settings');
        if (response.data.status === 'success') {
          this.gameSettings = response.data.settings;
        }
      } catch (error) {
        console.error('Failed to fetch game settings:', error);
      }
    },
    handleGameClick(gameType) {
      if (gameType === 'qa_fps' && !this.gameSettings.qa_fps_enabled) {
        this.gameAlertMessage = 'Q&A FPS game is currently disabled by the admin. Please contact the administrator for more information.';
        setTimeout(() => {
          this.gameAlertMessage = '';
        }, 5000);
        return;
      }
      
      if (gameType === 'typergel1' && !this.gameSettings.typergel1_enabled) {
        this.gameAlertMessage = 'TyperGel1 game is currently disabled by the admin. Please contact the administrator for more information.';
        setTimeout(() => {
          this.gameAlertMessage = '';
        }, 5000);
        return;
      }

      if (gameType === 'qa_fps') {
        this.$router.push('/qa-fps');
      } else if (gameType === 'typergel1') {
        this.$router.push('/typergel1');
      }
    },
    handleStudiesClick() {
      this.$router.push('/lessons');
    },
    getGameCardClass(type) {
      const classes = {
        'guess_part': 'bg-cover bg-center',
        'qa': 'bg-cover bg-center',
        'lesson': 'bg-cover bg-center'
      };
      const backgrounds = {
        'guess_part': 'bg-[url(\'/images/computer-parts-bg.png\')]',
        'qa': 'bg-[url(\'/images/qa-game-bg.png\')]',
        'lesson': 'bg-[url(\'/images/lesson-game-bg.png\')]'
      };
      return `${classes[type] || ''} ${backgrounds[type] || ''}`;
    },
    getGameRoute(type) {
      const routes = {
        'guess_part': '/computer-parts',
        'qa': '/qa-fps',
        'lesson': '/lessons'
      };
      return routes[type] || '#';
    },
    createBackgroundParticles() {
      const container = document.body;
      const colors = [
        'rgba(0, 255, 255, 0.7)',
        'rgba(102, 126, 234, 0.7)',
        'rgba(118, 75, 162, 0.7)',
        'rgba(255, 255, 255, 0.7)'
      ];

      for (let i = 0; i < 50; i++) {
        const particle = document.createElement('div');
        const size = Math.random() * 4 + 2;
        particle.style.cssText = `
          position: fixed;
          width: ${size}px;
          height: ${size}px;
          background: ${colors[Math.floor(Math.random() * colors.length)]};
          border-radius: 50%;
          pointer-events: none;
          filter: blur(1px);
          left: ${Math.random() * 100}%;
          top: ${Math.random() * 100}%;
          box-shadow: 0 0 ${size * 2}px currentColor;
          animation: float-particle ${Math.random() * 20 + 10}s linear ${Math.random() * 10}s infinite;
        `;
        container.appendChild(particle);
        this.bgParticles.push(particle);
      }

      if (!document.getElementById('particle-styles')) {
        const style = document.createElement('style');
        style.id = 'particle-styles';
        style.textContent = `
          @keyframes float-particle {
            0% { transform: translate(0, 0) rotate(0deg); opacity: 0; }
            10% { opacity: 0.8; }
            90% { opacity: 0.8; }
            100% { transform: translate(${Math.random() > 0.5 ? '+' : '-'}${Math.random() * 100 + 50}px, ${Math.random() > 0.5 ? '+' : '-'}${Math.random() * 100 + 50}px) rotate(360deg); opacity: 0; }
          }
        `;
        document.head.appendChild(style);
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

<style scoped>
html {
  -ms-overflow-style: none;
  scrollbar-width: none;
}

html::-webkit-scrollbar {
  display: none;
}
</style>

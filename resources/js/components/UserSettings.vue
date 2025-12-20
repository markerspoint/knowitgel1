<template>
  <div class="min-h-screen bg-gradient-to-br from-[#667eea] to-[#764ba2]">
    <nav class="mb-4 relative z-50" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
      <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
          <router-link
            to="/user/dashboard"
            class="flex items-center text-white font-semibold text-lg no-underline hover:opacity-80 transition-opacity"
          >
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
                  >
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
      <div class="bg-white bg-opacity-10 backdrop-blur-lg border border-white border-opacity-20 rounded-2xl shadow-lg mb-5">
        <div class="p-5 border-b border-white border-opacity-10">
          <h4 class="text-xl font-semibold text-white flex items-center">
            <i class="fas fa-cog mr-2"></i>Settings
          </h4>
        </div>
        <div class="p-5">
          <div v-if="message" 
               :class="['alert rounded-lg p-4 mb-4 flex items-center justify-between', messageType === 'success' ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-red-100 text-red-800 border border-red-200']">
            <span>{{ message }}</span>
            <button @click="message = ''" class="ml-4 text-lg font-bold">&times;</button>
          </div>

          <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Change Password -->
            <div class="bg-white bg-opacity-95 rounded-2xl shadow p-5">
              <h5 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-lock mr-2"></i>Change Password
              </h5>
              <form @submit.prevent="updatePassword" class="space-y-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                  <input
                    type="password"
                    v-model="passwordForm.current_password"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent"
                  >
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                  <input
                    type="password"
                    v-model="passwordForm.new_password"
                    required
                    minlength="6"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent"
                  >
                  <p class="text-xs text-gray-500 mt-1">Minimum 6 characters.</p>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                  <input
                    type="password"
                    v-model="passwordForm.new_password_confirmation"
                    required
                    minlength="6"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent"
                  >
                </div>
                <div class="pt-2">
                  <button
                    type="submit"
                    :disabled="isSavingPassword"
                    class="px-6 py-2 bg-gradient-to-r from-[#667eea] to-[#764ba2] text-white font-semibold rounded-lg hover:shadow-lg transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed flex items-center"
                  >
                    <span v-if="isSavingPassword">
                      <i class="fas fa-spinner fa-spin mr-2"></i>Updating...
                    </span>
                    <span v-else>
                      <i class="fas fa-save mr-2"></i>Update Password
                    </span>
                  </button>
                </div>
              </form>
            </div>

            <!-- Placeholder for future settings -->
            <div class="bg-white bg-opacity-95 rounded-2xl shadow p-5">
              <h5 class="text-lg font-semibold text-gray-800 mb-2 flex items-center">
                <i class="fas fa-sliders-h mr-2"></i>Preferences
              </h5>
              <p class="text-gray-600 text-sm mb-2">
                Additional settings and preferences will appear here in the future.
              </p>
              <ul class="list-disc list-inside text-gray-500 text-sm space-y-1">
                <li>Notification preferences</li>
                <li>Theme and accessibility options</li>
                <li>Game difficulty defaults</li>
              </ul>
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
  name: 'UserSettings',
  data() {
    return {
      user: null,
      showProfileDropdown: false,
      isSavingPassword: false,
      message: '',
      messageType: 'success',
      passwordForm: {
        current_password: '',
        new_password: '',
        new_password_confirmation: ''
      }
    };
  },
  async mounted() {
    await this.fetchUser();
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
    async updatePassword() {
      this.isSavingPassword = true;
      this.message = '';

      try {
        const response = await axios.post('/api/user/settings/password', {
          current_password: this.passwordForm.current_password,
          new_password: this.passwordForm.new_password,
          new_password_confirmation: this.passwordForm.new_password_confirmation
        });

        if (response.data.status === 'success') {
          this.passwordForm.current_password = '';
          this.passwordForm.new_password = '';
          this.passwordForm.new_password_confirmation = '';
          this.showMessage('Password updated successfully.', 'success');
        }
      } catch (error) {
        const msg =
          error.response?.data?.message ||
          (error.response?.data?.errors
            ? Object.values(error.response.data.errors).flat().join(' ')
            : 'Failed to update password.');
        this.showMessage(msg, 'error');
      } finally {
        this.isSavingPassword = false;
      }
    },
    showMessage(msg, type) {
      this.message = msg;
      this.messageType = type;
      setTimeout(() => {
        this.message = '';
      }, 5000);
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


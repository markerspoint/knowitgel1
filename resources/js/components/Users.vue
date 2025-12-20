<template>
  <div class="min-h-screen bg-gradient-to-br from-[#667eea] to-[#764ba2]">
    <nav class="mb-4" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
      <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
          <router-link to="/admin/dashboard" class="flex items-center text-white font-semibold text-lg no-underline hover:opacity-80 transition-opacity">
            <i class="fas fa-gamepad mr-2"></i>KnowItGel Admin
          </router-link>
          <div class="hidden md:flex items-center space-x-4">
            <div class="relative ml-4" @click.stop>
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
            <i class="fas fa-users mr-2"></i>User Management
          </h4>
        </div>
        <div class="p-5">
          <div class="overflow-x-auto">
            <table class="w-full mb-0">
              <thead>
                <tr>
                  <th class="text-left py-3 px-4 font-semibold text-gray-600 border-t-0 border-b border-gray-200">ID</th>
                  <th class="text-left py-3 px-4 font-semibold text-gray-600 border-t-0 border-b border-gray-200">Name</th>
                  <th class="text-left py-3 px-4 font-semibold text-gray-600 border-t-0 border-b border-gray-200">Email</th>
                  <th class="text-left py-3 px-4 font-semibold text-gray-600 border-t-0 border-b border-gray-200">Username</th>
                  <th class="text-left py-3 px-4 font-semibold text-gray-600 border-t-0 border-b border-gray-200">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="user in users" :key="user.id" class="border-b border-gray-200">
                  <td class="py-3 px-4 align-middle">{{ user.id }}</td>
                  <td class="py-3 px-4 align-middle">{{ user.fname }} {{ user.lname }}</td>
                  <td class="py-3 px-4 align-middle">{{ user.email }}</td>
                  <td class="py-3 px-4 align-middle">{{ user.username }}</td>
                  <td class="py-3 px-4 align-middle">
                    <button @click="toggleUserStatus(user)" 
                            :class="['px-3 py-1.5 rounded text-sm font-medium inline-block', user.is_disabled ? 'bg-[#198754] text-white hover:bg-[#157347]' : 'bg-[#ffc107] text-white hover:bg-[#ffca2c]']"
                            :title="user.is_disabled ? 'Enable User' : 'Disable User'">
                      <i :class="['fas', user.is_disabled ? 'fa-check-circle' : 'fa-ban']"></i>
                      {{ user.is_disabled ? ' Enable' : ' Disable' }}
                    </button>
                    <button @click="deleteUser(user)" 
                            class="ml-2 px-3 py-1.5 bg-[#dc3545] text-white rounded text-sm font-medium hover:bg-[#bb2d3b] inline-block">
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
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'Users',
  data() {
    return {
      user: null,
      users: [],
      message: '',
      messageType: 'success',
      showProfileDropdown: false
    };
  },
  async mounted() {
    await this.fetchUser();
    await this.fetchUsers();
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
    async fetchUsers() {
      try {
        const response = await axios.get('/api/admin/dashboard-data');
        this.users = response.data.users;
      } catch (error) {
        console.error('Failed to fetch users:', error);
        this.showMessage('Failed to load users', 'error');
      }
    },
    async toggleUserStatus(user) {
      try {
        await axios.patch(`/api/admin/users/${user.id}/toggle-status`);
        user.is_disabled = !user.is_disabled;
        this.showMessage(`User ${user.username} has been ${user.is_disabled ? 'disabled' : 'enabled'}.`, 'success');
      } catch (error) {
        this.showMessage('Failed to toggle user status', 'error');
      }
    },
    async deleteUser(user) {
      if (!confirm('Are you sure you want to delete this user?')) return;
      try {
        await axios.delete(`/api/admin/users/${user.id}`);
        this.users = this.users.filter(u => u.id !== user.id);
        this.showMessage('User deleted successfully.', 'success');
      } catch (error) {
        this.showMessage('Failed to delete user', 'error');
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


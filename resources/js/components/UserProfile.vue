<template>
  <div class="min-h-screen bg-gradient-to-br from-[#667eea] to-[#764ba2]">
    <nav class="mb-4 relative z-50" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
      <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
          <router-link
            to="/user/dashboard"
            class="flex items-center text-white font-semibold text-lg no-underline cursor-pointer"
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
      <div v-if="message" 
           :class="['alert rounded-lg p-4 mb-4 flex items-center justify-between', messageType === 'success' ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-red-100 text-red-800 border border-red-200']">
        <span>{{ message }}</span>
        <button @click="message = ''" class="ml-4 text-lg font-bold">&times;</button>
      </div>

      <div class="bg-white bg-opacity-95 rounded-2xl shadow-lg mb-5">
        <div class="p-5 border-b border-gray-200 flex items-center justify-between">
          <h4 class="text-xl font-semibold text-gray-800 flex items-center">
            <i class="fas fa-user mr-2"></i>Profile Information
          </h4>
          <button
            v-if="!isEditing"
            @click="enableEditMode"
            class="px-4 py-2 bg-gradient-to-r from-[#667eea] to-[#764ba2] text-white font-semibold rounded-lg hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 flex items-center"
          >
            <i class="fas fa-edit mr-2"></i>Edit Profile
          </button>
        </div>
        
        <div class="p-5" v-if="user">
          <form @submit.prevent="updateProfile" v-if="isEditing" enctype="multipart/form-data">
            <div class="mb-6">
              <label class="block text-sm font-medium text-gray-700 mb-2">Profile Picture</label>
              <div class="flex items-center space-x-4">
                <div class="relative">
                  <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-gray-200 shadow-lg">
                    <img
                      v-if="profilePicturePreview || (user.profile_picture && !editForm.remove_profile_picture)"
                      :src="profilePicturePreview || (user.profile_picture ? '/' + user.profile_picture : '')"
                      alt="Profile"
                      class="w-full h-full object-cover"
                    >
                    <div
                      v-else
                      class="w-full h-full bg-gradient-to-br from-[#667eea] to-[#764ba2] flex items-center justify-center text-white text-2xl font-bold"
                    >
                      {{ user.fname ? user.fname.charAt(0).toUpperCase() : 'U' }}{{ user.lname ? user.lname.charAt(0).toUpperCase() : 'U' }}
                    </div>
                  </div>
                  <label
                    class="absolute bottom-0 right-0 w-8 h-8 bg-[#667eea] rounded-full flex items-center justify-center cursor-pointer hover:bg-[#764ba2] transition-colors shadow-lg"
                    title="Change photo"
                  >
                    <i class="fas fa-camera text-white text-sm"></i>
                    <input
                      type="file"
                      ref="fileInput"
                      @change="handleFileSelect"
                      accept="image/*"
                      class="hidden"
                    >
                  </label>
                </div>
                <div class="flex-1">
                  <p class="text-sm text-gray-600 mb-2">Upload a new profile picture</p>
                  <p class="text-xs text-gray-500">JPG, PNG or GIF. Max size 2MB</p>
                  <button
                    v-if="(profilePicturePreview || user.profile_picture) && !editForm.remove_profile_picture"
                    type="button"
                    @click="removeProfilePicture"
                    class="mt-2 text-sm text-red-600 hover:text-red-800 flex items-center"
                  >
                    <i class="fas fa-trash mr-1"></i>Remove picture
                  </button>
                  <p v-if="editForm.remove_profile_picture && !profilePictureFile" class="mt-2 text-sm text-gray-500 italic">
                    Profile picture will be removed on save
                  </p>
                </div>
              </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                <input
                  type="text"
                  v-model="editForm.fname"
                  required
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent"
                >
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                <input
                  type="text"
                  v-model="editForm.lname"
                  required
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent"
                >
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                <input
                  type="text"
                  v-model="editForm.username"
                  required
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent"
                >
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input
                  type="email"
                  v-model="editForm.email"
                  required
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent"
                >
              </div>
            </div>
            <div class="mt-6">
              <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
              <span class="px-3 py-1 rounded text-sm font-medium bg-blue-100 text-blue-800">
                {{ capitalize(user.role) }}
              </span>
              <p class="text-xs text-gray-500 mt-1">Role cannot be changed</p>
            </div>
            <div class="mt-6 flex space-x-3">
              <button
                type="submit"
                :disabled="isSaving"
                class="px-6 py-2 bg-gradient-to-r from-[#667eea] to-[#764ba2] text-white font-semibold rounded-lg hover:shadow-lg transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed flex items-center"
              >
                <span v-if="isSaving">
                  <i class="fas fa-spinner fa-spin mr-2"></i>Saving...
                </span>
                <span v-else>
                  <i class="fas fa-save mr-2"></i>Save Changes
                </span>
              </button>
              <button
                type="button"
                @click="cancelEdit"
                :disabled="isSaving"
                class="px-6 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition-all duration-300 disabled:opacity-50"
              >
                Cancel
              </button>
            </div>
          </form>
          
          <div v-else class="space-y-6">
            <div class="flex items-center space-x-6 pb-6 border-b border-gray-200">
              <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-white shadow-lg">
                <img
                  v-if="user.profile_picture"
                  :src="'/' + user.profile_picture"
                  alt="Profile"
                  class="w-full h-full object-cover"
                >
                <div
                  v-else
                  class="w-full h-full bg-gradient-to-br from-[#667eea] to-[#764ba2] flex items-center justify-center text-white text-3xl font-bold"
                >
                  {{ user.fname ? user.fname.charAt(0).toUpperCase() : 'U' }}{{ user.lname ? user.lname.charAt(0).toUpperCase() : 'U' }}
                </div>
              </div>
              <div>
                <h3 class="text-2xl font-bold text-gray-800">{{ user.fname }} {{ user.lname }}</h3>
                <p class="text-gray-600">{{ user.email }}</p>
                <span class="inline-block mt-2 px-3 py-1 rounded text-sm font-medium bg-blue-100 text-blue-800">
                  {{ capitalize(user.role) }}
                </span>
              </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="bg-gray-50 rounded-lg p-4">
                <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wide">First Name</label>
                <p class="text-lg font-medium text-gray-800">{{ user.fname }}</p>
              </div>
              <div class="bg-gray-50 rounded-lg p-4">
                <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wide">Last Name</label>
                <p class="text-lg font-medium text-gray-800">{{ user.lname }}</p>
              </div>
              <div class="bg-gray-50 rounded-lg p-4">
                <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wide">Username</label>
                <p class="text-lg font-medium text-gray-800">{{ user.username }}</p>
              </div>
              <div class="bg-gray-50 rounded-lg p-4">
                <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wide">Email Address</label>
                <p class="text-lg font-medium text-gray-800">{{ user.email }}</p>
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
  name: 'UserProfile',
  data() {
    return {
      user: null,
      showProfileDropdown: false,
      isEditing: false,
      isSaving: false,
      message: '',
      messageType: 'success',
      editForm: {
        fname: '',
        lname: '',
        username: '',
        email: '',
        remove_profile_picture: false
      },
      profilePictureFile: null,
      profilePicturePreview: null
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
        const response = await axios.get('/api/user/profile');
        this.user = response.data.user;
      } catch (error) {
        console.error('Failed to fetch user:', error);
        this.$router.push('/login');
      }
    },
    capitalize(str) {
      return str ? str.charAt(0).toUpperCase() + str.slice(1) : '';
    },
    enableEditMode() {
      this.editForm = {
        fname: this.user.fname || '',
        lname: this.user.lname || '',
        username: this.user.username || '',
        email: this.user.email || '',
        remove_profile_picture: false
      };
      this.profilePictureFile = null;
      this.profilePicturePreview = null;
      this.isEditing = true;
      this.message = '';
    },
    cancelEdit() {
      this.isEditing = false;
      this.editForm = {
        fname: '',
        lname: '',
        username: '',
        email: '',
        remove_profile_picture: false
      };
      this.profilePictureFile = null;
      this.profilePicturePreview = null;
      this.message = '';
    },
    handleFileSelect(event) {
      const file = event.target.files[0];
      if (file) {
        if (file.size > 2048 * 1024) {
          this.showMessage('File size must be less than 2MB', 'error');
          return;
        }
        if (!file.type.startsWith('image/')) {
          this.showMessage('Please select an image file', 'error');
          return;
        }
        this.profilePictureFile = file;
        this.editForm.remove_profile_picture = false;
        const reader = new FileReader();
        reader.onload = (e) => {
          this.profilePicturePreview = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    },
    removeProfilePicture() {
      this.profilePictureFile = null;
      this.profilePicturePreview = null;
      if (this.$refs.fileInput) {
        this.$refs.fileInput.value = '';
      }
      this.editForm.remove_profile_picture = true;
    },
    async updateProfile() {
      this.isSaving = true;
      this.message = '';
      
      try {
        const formData = new FormData();
        formData.append('fname', this.editForm.fname);
        formData.append('lname', this.editForm.lname);
        formData.append('username', this.editForm.username);
        formData.append('email', this.editForm.email);
        
        if (this.profilePictureFile) {
          formData.append('profile_picture', this.profilePictureFile);
        }
        
        if (this.editForm.remove_profile_picture && !this.profilePictureFile) {
          formData.append('remove_profile_picture', '1');
        }
        
        const response = await axios.post('/api/user/profile', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        });
        
        if (response.data.status === 'success') {
          this.user = { ...this.user, ...response.data.user };
          this.profilePictureFile = null;
          this.profilePicturePreview = null;
          this.isEditing = false;
          this.showMessage('Profile updated successfully!', 'success');
        }
      } catch (error) {
        const errorMsg = error.response?.data?.message || error.response?.data?.errors || 'Failed to update profile';
        this.showMessage(typeof errorMsg === 'string' ? errorMsg : 'Failed to update profile. Please check your input.', 'error');
      } finally {
        this.isSaving = false;
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

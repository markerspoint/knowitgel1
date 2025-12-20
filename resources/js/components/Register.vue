<template>
  <div class="min-h-screen flex items-center bg-gradient-to-br from-[#667eea] to-[#764ba2]">
    <div class="container mx-auto px-4">
      <div class="flex justify-center">
        <div class="w-full max-w-md">
          <div class="bg-white rounded-[15px] shadow-[0_0_20px_rgba(0,0,0,0.1)] border-none">
            <div class="text-center pt-5 px-5 pb-0 border-b-0 bg-transparent">
              <h4 class="mb-3">
                <i class="fas fa-user-plus text-[3rem] text-[#667eea]"></i>
              </h4>
              <h4 class="text-[#333] font-semibold">Create Account</h4>
            </div>
            <div class="p-6">
              <div v-if="error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4 flex items-center justify-between">
                <span><i class="fas fa-exclamation-circle mr-2"></i>{{ error }}</span>
                <button @click="error = ''" class="ml-4 text-lg font-bold">&times;</button>
              </div>
              
              <div v-if="success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4 flex items-center justify-between">
                <span><i class="fas fa-check-circle mr-2"></i>{{ success }}</span>
                <button @click="success = ''" class="ml-4 text-lg font-bold">&times;</button>
              </div>
              
              <form @submit.prevent="handleRegister" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label for="fname" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                    <input
                      type="text"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent"
                      id="fname"
                      v-model="form.fname"
                      required
                    />
                  </div>

                  <div>
                    <label for="lname" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                    <input
                      type="text"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent"
                      id="lname"
                      v-model="form.lname"
                      required
                    />
                  </div>
                </div>

                <div>
                  <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                  <input
                    type="text"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent"
                    id="username"
                    v-model="form.username"
                    required
                  />
                </div>

                <div>
                  <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                  <input
                    type="email"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent"
                    id="email"
                    v-model="form.email"
                    required
                  />
                </div>

                <div>
                  <label for="number" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                  <input
                    type="tel"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent"
                    id="number"
                    v-model="form.number"
                    required
                  />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input
                      type="password"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent"
                      id="password"
                      v-model="form.password"
                      required
                      minlength="6"
                    />
                    <p class="text-xs text-gray-500 mt-1">Minimum 6 characters</p>
                  </div>

                  <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input
                      type="password"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent"
                      id="password_confirmation"
                      v-model="form.password_confirmation"
                      required
                      minlength="6"
                    />
                  </div>
                </div>

                <div class="pt-2">
                  <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-[#667eea] to-[#764ba2] text-white font-semibold py-2.5 rounded-lg hover:shadow-lg transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center"
                    :disabled="loading"
                  >
                    <span v-if="loading">
                      <i class="fas fa-spinner fa-spin mr-2"></i>Registering...
                    </span>
                    <span v-else>
                      <i class="fas fa-user-plus mr-2"></i>Register
                    </span>
                  </button>
                </div>
              </form>
            </div>
          </div>
          <div class="text-center mt-4">
            <span class="text-white">Already have an account?</span>
            <a href="#" @click.prevent="goToLogin" class="text-white font-medium ml-2 hover:underline">
              Login Now
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Loading Overlay -->
    <div
      v-if="loading"
      class="fixed inset-0 bg-black/90 z-[9999] flex flex-col justify-center items-center"
    >
      <div class="text-[#0ff] text-2xl mb-8 font-mono text-shadow-[0_0_10px_#0ff]">
        CREATING ACCOUNT
      </div>
      <div class="w-[200px] h-[200px] border-[5px] border-[rgba(0,255,255,0.3)] rounded-full border-t-[#0ff] animate-spin shadow-[0_0_10px_#0ff]"></div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'Register',
  data() {
    return {
      form: {
        fname: '',
        lname: '',
        username: '',
        email: '',
        number: '',
        password: '',
        password_confirmation: ''
      },
      error: '',
      success: '',
      loading: false
    };
  },
  methods: {
    async handleRegister() {
      this.error = '';
      this.success = '';
      this.loading = true;

      if (this.form.password !== this.form.password_confirmation) {
        this.error = 'Passwords do not match.';
        this.loading = false;
        return;
      }

      if (this.form.password.length < 6) {
        this.error = 'Password must be at least 6 characters.';
        this.loading = false;
        return;
      }

      try {
        const response = await axios.post('/api/register', this.form);
        
        if (response.data.status === 'success') {
          this.success = response.data.message || 'Registration successful! Redirecting to login...';
          setTimeout(() => {
            this.$router.push('/login');
          }, 2000);
        } else {
          this.error = response.data.message || 'Registration failed';
          this.loading = false;
        }
      } catch (error) {
        if (error.response && error.response.data) {
          if (error.response.data.errors) {
            const errors = error.response.data.errors;
            const errorMessages = Object.values(errors).flat();
            this.error = errorMessages.join(', ');
          } else {
            this.error = error.response.data.message || 'Registration failed. Please try again.';
          }
        } else {
          this.error = 'An error occurred during registration. Please try again.';
        }
        this.loading = false;
      }
    },
    goToLogin() {
      this.$router.push('/login');
    }
  }
};
</script>


<template>
  <div class="min-h-screen flex items-center bg-gradient-to-br from-[#667eea] to-[#764ba2]">
    <div class="container mx-auto px-4">
      <div class="flex justify-center">
        <div class="w-full max-w-md">
          <div class="bg-white rounded-[15px] shadow-[0_0_20px_rgba(0,0,0,0.1)] border-none">
            <div class="text-center pt-5 px-5 pb-0 border-b-0 bg-transparent">
              <h4 class="mb-3">
                <i class="fas fa-user-circle text-[3rem] text-[#667eea]"></i>
              </h4>
              <h4 class="text-[#333] font-semibold">Welcome Back</h4>
            </div>
            <div class="p-[30px]">
              <div v-if="error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-[10px] mb-4">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ error }}
              </div>
              
              <form @submit.prevent="handleLogin">
                <div class="mb-3">
                  <label for="username" class="block font-medium text-[#555] mb-2">Username</label>
                  <div class="flex">
                    <span class="inline-flex items-center px-3 rounded-l-[10px] border border-r-0 border-gray-300 bg-gray-50">
                      <i class="fas fa-user"></i>
                    </span>
                    <input
                      type="text"
                      class="flex-1 px-3 py-3 rounded-r-[10px] border border-gray-300 focus:outline-none focus:border-[#667eea] focus:ring-2 focus:ring-[#667eea]/25 transition-all duration-300"
                      id="username"
                      v-model="form.username"
                      required
                    />
                  </div>
                </div>

                <div class="mb-3">
                  <label for="password" class="block font-medium text-[#555] mb-2">Password</label>
                  <div class="flex">
                    <span class="inline-flex items-center px-3 rounded-l-[10px] border border-r-0 border-gray-300 bg-gray-50">
                      <i class="fas fa-lock"></i>
                    </span>
                    <input
                      type="password"
                      class="flex-1 px-3 py-3 rounded-r-[10px] border border-gray-300 focus:outline-none focus:border-[#667eea] focus:ring-2 focus:ring-[#667eea]/25 transition-all duration-300"
                      id="password"
                      v-model="form.password"
                      required
                    />
                  </div>
                </div>

                <button
                  type="submit"
                  class="w-full bg-gradient-to-r from-[#667eea] to-[#764ba2] text-white font-semibold py-3 rounded-[10px] border-none transition-all duration-300 hover:-translate-y-0.5 hover:shadow-[0_5px_15px_rgba(102,126,234,0.4)] disabled:opacity-50 disabled:cursor-not-allowed"
                  :disabled="loading"
                >
                  <i class="fas fa-sign-in-alt mr-2"></i>
                  {{ loading ? 'Logging in...' : 'Login' }}
                </button>
              </form>
            </div>
          </div>
          <div class="text-center mt-4">
            <span class="text-white">Don't have an account?</span>
            <a href="#" @click.prevent="goToRegister" class="text-white font-medium ml-2 hover:underline">
              Register Now
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
        INITIALIZING NEURAL INTERFACE
      </div>
      <div class="w-[200px] h-[200px] border-[5px] border-[rgba(0,255,255,0.3)] rounded-full border-t-[#0ff] animate-spin shadow-[0_0_10px_#0ff]"></div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'Login',
  data() {
    return {
      form: {
        username: '',
        password: '',
        login_type: 'user'
      },
      loginType: 'user',
      error: '',
      loading: false
    };
  },
  mounted() {
    // Check if redirected due to disabled account
    if (this.$route.query.disabled === 'true') {
      this.error = 'Your account has been disabled by the admin. Please contact admin.';
    }
  },
  watch: {
    loginType(newVal) {
      this.form.login_type = newVal;
    }
  },
  methods: {
    async handleLogin() {
      this.error = '';
      this.loading = true;
      this.form.login_type = this.loginType;

      try {
        const response = await axios.post('/api/login', this.form);
        
        if (response.data.status === 'success') {
          this.$router.push(response.data.data.redirect);
        } else {
          this.error = response.data.message || 'Login failed';
          this.loading = false;
        }
      } catch (error) {
        if (error.response && error.response.data) {
          this.error = error.response.data.message || 'Invalid credentials';
        } else {
          this.error = 'An error occurred during login. Please try again.';
        }
        this.loading = false;
      }
    },
    goToRegister() {
      this.$router.push('/register');
    }
  }
};
</script>

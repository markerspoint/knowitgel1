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
                  class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg z-50 list-none m-0 p-2"
                  style="min-width: 200px;">
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

      <div class="mt-4">
        <div class="flex space-x-2 mb-4">
          <button
            @click="activeTab = 'overview'"
            :class="['px-4 py-2 rounded-lg font-medium transition-all border-0 cursor-pointer',
                     activeTab === 'overview' ? 'bg-white text-black' : 'text-black bg-white bg-opacity-40 hover:bg-opacity-60']"
          >
            Overview
          </button>
          <button
            @click="activeTab = 'qa_fps'"
            :class="['px-4 py-2 rounded-lg font-medium transition-all border-0 cursor-pointer',
                     activeTab === 'qa_fps' ? 'bg-white text-black' : 'text-black bg-white bg-opacity-40 hover:bg-opacity-60']"
          >
            Q&A FPS Questions
          </button>
          <button
            @click="activeTab = 'typergel1'"
            :class="['px-4 py-2 rounded-lg font-medium transition-all border-0 cursor-pointer',
                     activeTab === 'typergel1' ? 'bg-white text-black' : 'text-black bg-white bg-opacity-40 hover:bg-opacity-60']"
          >
            TyperGel1 Words
          </button>
          <button
            @click="activeTab = 'studies'"
            :class="['px-4 py-2 rounded-lg font-medium transition-all border-0 cursor-pointer',
                     activeTab === 'studies' ? 'bg-white text-black' : 'text-black bg-white bg-opacity-40 hover:bg-opacity-60']"
          >
            Studies
          </button>
        </div>

        <div v-if="activeTab === 'overview'" class="space-y-6">
          <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-2xl shadow p-4">
              <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">Total users</p>
              <p class="text-2xl font-bold text-gray-900">{{ analytics.totals.total_users }}</p>
            </div>
            <div class="bg-white rounded-2xl shadow p-4">
              <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">New users (30 days)</p>
              <p class="text-2xl font-bold text-gray-900">{{ analytics.totals.new_users_last_30_days }}</p>
            </div>
            <div class="bg-white rounded-2xl shadow p-4">
              <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">Sessions</p>
              <p class="text-2xl font-bold text-gray-900">{{ analytics.totals.total_sessions }}</p>
            </div>
            <div class="bg-white rounded-2xl shadow p-4">
              <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">Total score</p>
              <p class="text-2xl font-bold text-gray-900">{{ analytics.totals.total_score }}</p>
            </div>
          </div>

          <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 h-[320px]">
            <div class="bg-white rounded-2xl shadow p-4 flex flex-col">
              <h4 class="text-sm font-semibold text-gray-800 mb-2">Daily Sessions (Last 30 Days)</h4>
              <div class="flex-1">
                <canvas ref="dailySessionsChart"></canvas>
              </div>
            </div>
            <div class="bg-white rounded-2xl shadow p-4 flex flex-col">
              <h4 class="text-sm font-semibold text-gray-800 mb-2">Monthly Sessions (Last 12 Months)</h4>
              <div class="flex-1">
                <canvas ref="monthlySessionsChart"></canvas>
              </div>
            </div>
          </div>

          <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-2xl shadow p-4 flex flex-col">
              <h4 class="text-sm font-semibold text-gray-800 mb-2">User Statistics</h4>
              <div class="flex items-start gap-4">
                <div class="flex-1 h-[320px]">
                  <canvas ref="userStatsChart"></canvas>
                </div>
                <div class="flex flex-col gap-3 min-w-[140px] pt-4">
                  <div class="flex items-center gap-2">
                    <div class="w-4 h-4 rounded-full bg-blue-500"></div>
                    <div>
                      <p class="text-xs text-gray-500">Regular Users</p>
                      <p class="text-lg font-bold text-gray-900">{{ analytics.user_stats.regular_users || 0 }}</p>
                    </div>
                  </div>
                  <div class="flex items-center gap-2">
                    <div class="w-4 h-4 rounded-full bg-purple-500"></div>
                    <div>
                      <p class="text-xs text-gray-500">Admin Users</p>
                      <p class="text-lg font-bold text-gray-900">{{ analytics.user_stats.admin_users || 0 }}</p>
                    </div>
                  </div>
                  <div class="flex items-center gap-2">
                    <div class="w-4 h-4 rounded-full bg-red-500"></div>
                    <div>
                      <p class="text-xs text-gray-500">Disabled Users</p>
                      <p class="text-lg font-bold text-gray-900">{{ analytics.user_stats.disabled_users || 0 }}</p>
                    </div>
                  </div>
                  <div class="pt-2 border-t border-gray-200 mt-1">
                    <p class="text-xs text-gray-500">Total Users</p>
                    <p class="text-xl font-bold text-gray-900">{{ analytics.user_stats.total_users || 0 }}</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="bg-white rounded-2xl shadow p-4 flex flex-col">
              <h4 class="text-sm font-semibold text-gray-800 mb-2">User Status Distribution</h4>
              <div class="flex items-start gap-4">
                <div class="flex-1 h-[320px]">
                  <canvas ref="userStatusChart"></canvas>
                </div>
                <div class="flex flex-col gap-3 min-w-[140px] pt-4">
                  <div>
                    <p class="text-xs text-gray-500">Active Users</p>
                    <p class="text-lg font-bold text-gray-900">{{ analytics.user_stats.active_users || 0 }}</p>
                  </div>
                  <div>
                    <p class="text-xs text-gray-500">Disabled Users</p>
                    <p class="text-lg font-bold text-gray-900">{{ analytics.user_stats.disabled_users || 0 }}</p>
                  </div>
                  <div>
                    <p class="text-xs text-gray-500">Admin Users</p>
                    <p class="text-lg font-bold text-gray-900">{{ analytics.user_stats.admin_users || 0 }}</p>
                  </div>
                  <div>
                    <p class="text-xs text-gray-500">Regular Users</p>
                    <p class="text-lg font-bold text-gray-900">{{ analytics.user_stats.regular_users || 0 }}</p>
                  </div>
                  <div class="pt-2 border-t border-gray-200 mt-1">
                    <p class="text-xs text-gray-500">Total Users</p>
                    <p class="text-xl font-bold text-gray-900">{{ analytics.user_stats.total_users || 0 }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div v-else-if="activeTab === 'qa_fps'" class="space-y-6">
          <div class="bg-white bg-opacity-95 rounded-2xl shadow-lg p-6 text-gray-800">
            <h4 class="text-xl font-semibold mb-4 flex items-center">
              <i class="fas fa-crosshairs mr-2"></i>
              Q&A FPS Questions
            </h4>
            <form @submit.prevent="submitQAFPSQuestion" class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                <input
                  type="text"
                  v-model="qaGameForm.title"
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent"
                >
              </div>
              <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea
                  v-model="qaGameForm.description"
                  rows="2"
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent"
                ></textarea>
              </div>
              <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Question</label>
                <input
                  type="text"
                  v-model="qaGameForm.question"
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent"
                >
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Answer</label>
                <input
                  type="text"
                  v-model="qaGameForm.answer"
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent"
                >
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select
                  v-model="qaGameForm.status"
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent"
                >
                  <option value="active">Active</option>
                  <option value="inactive">Inactive</option>
                </select>
              </div>
              <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Options (comma separated)</label>
                <input
                  type="text"
                  v-model="qaGameForm.options"
                  placeholder="Option 1, Option 2, Option 3"
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent"
                >
                <small class="text-gray-500 text-xs mt-1 block">
                  Enter multiple choice options separated by commas. One of them must match the Answer exactly.
                </small>
              </div>
              <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Thumbnail</label>
                <input
                  type="file"
                  accept="image/*"
                  @change="handleQAFPSThumbnailChange"
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent"
                >
                <small class="text-gray-500 text-xs mt-1 block">
                  Upload a thumbnail image for this Q&A FPS question.
                </small>
              </div>
              <div class="md:col-span-2 flex justify-end pt-2">
                <button
                  type="submit"
                  class="px-4 py-2 bg-gradient-to-r from-[#667eea] to-[#764ba2] text-white font-semibold rounded-lg hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300"
                >
                  Add Question
                </button>
              </div>
            </form>
          </div>

          <div class="bg-white bg-opacity-95 rounded-2xl shadow-lg p-6 text-gray-800">
            <h4 class="text-lg font-semibold mb-3 flex items-center">
              <i class="fas fa-list mr-2"></i>
              Existing Q&A FPS Questions
            </h4>
            <div v-if="qaGames.length" class="overflow-x-auto">
              <table class="w-full text-sm">
                <thead>
                  <tr>
                    <th class="text-left py-2 px-3 border-b border-white border-opacity-10">Title</th>
                    <th class="text-left py-2 px-3 border-b border-white border-opacity-10">Question</th>
                    <th class="text-left py-2 px-3 border-b border-white border-opacity-10">Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="game in qaGames" :key="game.id" class="border-b border-white border-opacity-5">
                    <td class="py-2 px-3">{{ game.title }}</td>
                    <td class="py-2 px-3">{{ truncate(game.question, 60) }}</td>
                    <td class="py-2 px-3">
                      <span :class="['px-3 py-1 rounded text-xs font-medium', game.status === 'active' ? 'bg-green-500 bg-opacity-20 text-green-200' : 'bg-red-500 bg-opacity-20 text-red-200']">
                        {{ capitalize(game.status) }}
                      </span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <p v-else class="text-sm opacity-70">No Q&A FPS questions yet. Add one using the form above.</p>
          </div>
        </div>

        <div v-else-if="activeTab === 'typergel1'" class="space-y-6">
          <div class="bg-white bg-opacity-95 rounded-2xl shadow-lg p-6 text-gray-800">
            <h4 class="text-xl font-semibold mb-4 flex items-center">
              <i class="fas fa-keyboard mr-2"></i>
              TyperGel1 Word Bank
            </h4>
            <form @submit.prevent="submitTyperGelWord" class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Word or Phrase</label>
                <input
                  type="text"
                  v-model="typerGelForm.question"
                  required
                  placeholder="Enter word or phrase (e.g., server, binary search, firewall)"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent"
                >
                <small class="text-gray-500 text-xs mt-1 block">
                  This text will appear inside typing bubbles in the TyperGel1 game.
                </small>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select
                  v-model="typerGelForm.status"
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent"
                >
                  <option value="active">Active</option>
                  <option value="inactive">Inactive</option>
                </select>
              </div>
              <div class="md:col-span-2 flex justify-end pt-2">
                <button
                  type="submit"
                  class="px-4 py-2 bg-gradient-to-r from-[#00bcd4] to-[#3f51b5] text-white font-semibold rounded-lg hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300"
                >
                  Add Word
                </button>
              </div>
            </form>
          </div>

          <div class="bg-white bg-opacity-95 rounded-2xl shadow-lg p-6 text-gray-800">
            <h4 class="text-xl font-semibold mb-4 flex items-center">
              <i class="fas fa-upload mr-2"></i>
              Bulk Import Words
            </h4>
            <form @submit.prevent="submitBulkTyperGelWords" class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Words or Phrases (one per line or comma-separated)</label>
                <textarea
                  v-model="bulkTyperGelWords"
                  rows="8"
                  placeholder="Enter words/phrases, one per line or separated by commas:&#10;server&#10;binary search&#10;firewall&#10;database&#10;algorithm"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent font-mono text-sm"
                ></textarea>
                <small class="text-gray-500 text-xs mt-1 block">
                  Enter multiple words or phrases. Each line or comma-separated item will be added as a separate entry.
                </small>
              </div>
              <div class="flex items-center justify-between">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Status for all words</label>
                  <select
                    v-model="bulkTyperGelStatus"
                    required
                    class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent"
                  >
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                  </select>
                </div>
                <div class="flex items-end">
                  <button
                    type="submit"
                    :disabled="!bulkTyperGelWords.trim() || isBulkSubmitting"
                    class="px-6 py-2 bg-gradient-to-r from-[#00bcd4] to-[#3f51b5] text-white font-semibold rounded-lg hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                  >
                    <span v-if="isBulkSubmitting">
                      <i class="fas fa-spinner fa-spin mr-2"></i>Adding...
                    </span>
                    <span v-else>
                      <i class="fas fa-upload mr-2"></i>Import {{ getBulkWordCount() }} Word(s)
                    </span>
                  </button>
                </div>
              </div>
            </form>
          </div>

          <div class="bg-white bg-opacity-95 rounded-2xl shadow-lg p-6 text-gray-800">
            <h4 class="text-lg font-semibold mb-3 flex items-center">
              <i class="fas fa-list mr-2"></i>
              Existing TyperGel1 Entries
            </h4>
            <div v-if="typerGelGames.length" class="overflow-x-auto">
              <table class="w-full text-sm">
                <thead>
                  <tr>
                    <th class="text-left py-2 px-3 border-b border-white border-opacity-10">Word/Phrase</th>
                    <th class="text-left py-2 px-3 border-b border-white border-opacity-10">Status</th>
                    <th class="text-left py-2 px-3 border-b border-white border-opacity-10">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="game in typerGelGames" :key="game.id" class="border-b border-white border-opacity-5">
                    <td class="py-2 px-3">{{ truncate(game.question, 60) }}</td>
                    <td class="py-2 px-3">
                      <span :class="['px-3 py-1 rounded text-xs font-medium', game.status === 'active' ? 'bg-green-500 bg-opacity-20 text-green-200' : 'bg-red-500 bg-opacity-20 text-red-200']">
                        {{ capitalize(game.status) }}
                      </span>
                    </td>
                    <td class="py-2 px-3">
                      <div class="flex items-center space-x-2">
                        <button
                          @click="openEditTyperGelModal(game)"
                          class="px-3 py-1 bg-blue-500 bg-opacity-20 text-blue-200 rounded text-xs hover:bg-opacity-30 transition-all"
                          title="Edit"
                        >
                          <i class="fas fa-edit"></i>
                        </button>
                        <button
                          @click="confirmDeleteTyperGel(game)"
                          class="px-3 py-1 bg-red-500 bg-opacity-20 text-red-200 rounded text-xs hover:bg-opacity-30 transition-all"
                          title="Delete"
                        >
                          <i class="fas fa-trash"></i>
                        </button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <p v-else class="text-sm opacity-70">No TyperGel1 words yet. Add one using the form above.</p>
          </div>
        </div>

        <div v-else-if="activeTab === 'studies'" class="space-y-6">
          <div class="bg-white bg-opacity-95 rounded-2xl shadow-lg p-6 text-gray-800">
            <h4 class="text-xl font-semibold mb-4 flex items-center">
              <i class="fas fa-book mr-2"></i>
              Add New Study Content
            </h4>
            <form @submit.prevent="editingStudy ? updateStudy() : submitStudy()" class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                <input
                  type="text"
                  v-model="studyForm.title"
                  required
                  placeholder="e.g., KNOW IT GEL 1"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent"
                >
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Description (Optional)</label>
                <input
                  type="text"
                  v-model="studyForm.description"
                  placeholder="Brief description of the study content"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent"
                >
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Content</label>
                <textarea
                  v-model="studyForm.content"
                  rows="15"
                  required
                  placeholder="Enter your study content here. You can use hashtags, line breaks, and any text format."
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent font-mono text-sm"
                ></textarea>
                <small class="text-gray-500 text-xs mt-1 block">
                  Enter the study content. This will be displayed in a document-like format to users.
                </small>
              </div>
              <div v-if="editingStudy" class="flex justify-end space-x-3 pt-2">
                <button
                  type="button"
                  @click="editingStudy = null; studyForm = { title: '', description: '', content: '', status: 'active' }"
                  class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-all"
                >
                  Cancel Edit
                </button>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select
                  v-model="studyForm.status"
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent"
                >
                  <option value="active">Active</option>
                  <option value="inactive">Inactive</option>
                </select>
              </div>
              <div class="flex justify-end pt-2">
                <button
                  type="submit"
                  :disabled="isSubmittingStudy"
                  class="px-6 py-2 bg-gradient-to-r from-[#f093fb] to-[#f5576c] text-white font-semibold rounded-lg hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 disabled:opacity-50"
                >
                  <span v-if="isSubmittingStudy">
                    <i class="fas fa-spinner fa-spin mr-2"></i>{{ editingStudy ? 'Updating...' : 'Adding...' }}
                  </span>
                  <span v-else>
                    <i class="fas fa-plus mr-2"></i>{{ editingStudy ? 'Update Study Content' : 'Add Study Content' }}
                  </span>
                </button>
              </div>
            </form>
          </div>

          <div class="bg-white bg-opacity-95 rounded-2xl shadow-lg p-6 text-gray-800">
            <h4 class="text-lg font-semibold mb-3 flex items-center">
              <i class="fas fa-list mr-2"></i>
              Existing Study Content
            </h4>
            <div v-if="lessons.length" class="overflow-x-auto">
              <table class="w-full text-sm">
                <thead>
                  <tr>
                    <th class="text-left py-2 px-3 border-b border-gray-200">Title</th>
                    <th class="text-left py-2 px-3 border-b border-gray-200">Description</th>
                    <th class="text-left py-2 px-3 border-b border-gray-200">Status</th>
                    <th class="text-left py-2 px-3 border-b border-gray-200">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="lesson in lessons" :key="lesson.id" class="border-b border-gray-100">
                    <td class="py-2 px-3">{{ truncate(lesson.title, 40) }}</td>
                    <td class="py-2 px-3">{{ truncate(lesson.description, 50) }}</td>
                    <td class="py-2 px-3">
                      <span :class="['px-3 py-1 rounded text-xs font-medium', lesson.status === 'active' ? 'bg-green-500 bg-opacity-20 text-green-700' : 'bg-red-500 bg-opacity-20 text-red-700']">
                        {{ capitalize(lesson.status) }}
                      </span>
                    </td>
                    <td class="py-2 px-3">
                      <div class="flex items-center space-x-2">
                        <button
                          @click="editStudy(lesson)"
                          class="px-3 py-1 bg-blue-500 bg-opacity-20 text-blue-700 rounded text-xs hover:bg-opacity-30 transition-all"
                          title="Edit"
                        >
                          <i class="fas fa-edit"></i>
                        </button>
                        <button
                          @click="confirmDeleteStudy(lesson)"
                          class="px-3 py-1 bg-red-500 bg-opacity-20 text-red-700 rounded text-xs hover:bg-opacity-30 transition-all"
                          title="Delete"
                        >
                          <i class="fas fa-trash"></i>
                        </button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <p v-else class="text-sm opacity-70">No study content yet. Add one using the form above.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit TyperGel1 Modal -->
    <div
      v-if="showEditTyperGelModal"
      class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
      @click.self="closeEditTyperGelModal"
    >
      <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
        <h3 class="text-xl font-semibold mb-4 text-gray-800">Edit TyperGel1 Word</h3>
        <form @submit.prevent="submitEditTyperGel">
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Word or Phrase</label>
            <input
              type="text"
              v-model="editingTyperGel.question"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent"
            >
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <select
              v-model="editingTyperGel.status"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#667eea] focus:border-transparent"
            >
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
          </div>
          <div class="flex justify-end space-x-3">
            <button
              type="button"
              @click="closeEditTyperGelModal"
              class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-all"
            >
              Cancel
            </button>
            <button
              type="submit"
              :disabled="isEditingTyperGel"
              class="px-4 py-2 bg-gradient-to-r from-[#00bcd4] to-[#3f51b5] text-white font-semibold rounded-lg hover:shadow-lg transition-all disabled:opacity-50"
            >
              <span v-if="isEditingTyperGel">
                <i class="fas fa-spinner fa-spin mr-2"></i>Saving...
              </span>
              <span v-else>Save Changes</span>
            </button>
          </div>
        </form>
      </div>
    </div>

  </div>
</template>

<script>
import axios from 'axios';
import Chart from 'chart.js/auto';

export default {
  name: 'AdminDashboard',
  data() {
    return {
      user: null,
      showProfileDropdown: false,
      message: '',
      messageType: 'success',
      games: [],
      lessons: [],
      activeTab: 'overview',
      studyForm: {
        title: '',
        description: '',
        content: '',
        status: 'active'
      },
      isSubmittingStudy: false,
      editingStudy: null,
      qaGameForm: {
        title: '',
        description: '',
        question: '',
        answer: '',
        options: '',
        status: 'active',
        thumbnail: null
      },
      typerGelForm: {
        question: '',
        status: 'active'
      },
      bulkTyperGelWords: '',
      bulkTyperGelStatus: 'active',
      isBulkSubmitting: false,
      showEditTyperGelModal: false,
      editingTyperGel: {
        id: null,
        question: '',
        status: 'active'
      },
      isEditingTyperGel: false,
      analytics: {
        totals: {
          total_users: 0,
          new_users_last_30_days: 0,
          total_sessions: 0,
          total_score: 0
        },
        user_stats: {
          total_users: 0,
          active_users: 0,
          disabled_users: 0,
          admin_users: 0,
          regular_users: 0
        },
        daily_sessions_last_30_days: [],
        monthly_sessions_last_12_months: []
      },
      dailyChart: null,
      monthlyChart: null,
      userStatsChart: null,
      userStatusChart: null
    };
  },
  computed: {
    qaGames() {
      return Array.isArray(this.games)
        ? this.games.filter(game => game.type === 'qa')
        : [];
    },
    typerGelGames() {
      return Array.isArray(this.games)
        ? this.games.filter(game => game.type === 'typergel')
        : [];
    }
  },
  async mounted() {
    await this.fetchUser();
    await this.fetchDashboardData();
    document.addEventListener('click', this.handleClickOutside);
  },
  beforeUnmount() {
    document.removeEventListener('click', this.handleClickOutside);
    if (this.dailyChart) {
      this.dailyChart.destroy();
    }
    if (this.monthlyChart) {
      this.monthlyChart.destroy();
    }
    if (this.userStatsChart) {
      this.userStatsChart.destroy();
    }
    if (this.userStatusChart) {
      this.userStatusChart.destroy();
    }
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
    async fetchDashboardData() {
      try {
        const response = await axios.get('/api/admin/dashboard-data');
        this.games = response.data.games || [];
        this.lessons = response.data.lessons || [];
        if (response.data.analytics) {
          this.analytics.totals = response.data.analytics.totals || this.analytics.totals;
          this.analytics.user_stats = response.data.analytics.user_stats || this.analytics.user_stats;
          this.analytics.daily_sessions_last_30_days = response.data.analytics.daily_sessions_last_30_days || [];
          this.analytics.monthly_sessions_last_12_months = response.data.analytics.monthly_sessions_last_12_months || [];
          this.$nextTick(() => {
            this.renderCharts();
          });
        }
      } catch (error) {
        console.error('Failed to fetch dashboard data:', error);
        this.showMessage('Failed to load dashboard data', 'error');
      }
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
    async submitQAFPSQuestion() {
      try {
        const formData = new FormData();
        formData.append('title', this.qaGameForm.title);
        formData.append('description', this.qaGameForm.description);
        formData.append('type', 'qa');
        formData.append('question', this.qaGameForm.question);
        formData.append('answer', this.qaGameForm.answer);
        formData.append('status', this.qaGameForm.status);
        formData.append('options', this.qaGameForm.options);
        if (this.qaGameForm.thumbnail) {
          formData.append('thumbnail', this.qaGameForm.thumbnail);
        }

        await axios.post('/api/admin/games', formData, {
          headers: { 'Content-Type': 'multipart/form-data' }
        });

        this.showMessage('Q&A FPS question created successfully!', 'success');
        this.qaGameForm = {
          title: '',
          description: '',
          question: '',
          answer: '',
          options: '',
          status: 'active',
          thumbnail: null
        };
        await this.fetchDashboardData();
      } catch (error) {
        this.showMessage('Failed to create Q&A FPS question', 'error');
      }
    },
    handleQAFPSThumbnailChange(event) {
      this.qaGameForm.thumbnail = event.target.files[0];
    },
    async submitTyperGelWord() {
      const trimmedQuestion = this.typerGelForm.question.trim();
      
      if (!trimmedQuestion) {
        this.showMessage('Please enter a word or phrase', 'error');
        return;
      }

      const duplicate = this.typerGelGames.find(
        game => game.question.toLowerCase().trim() === trimmedQuestion.toLowerCase()
      );

      if (duplicate) {
        this.showMessage('This word or phrase already exists in TyperGel1', 'error');
        return;
      }

      try {
        const formData = new FormData();
        formData.append('type', 'typergel');
        formData.append('question', trimmedQuestion);
        formData.append('status', this.typerGelForm.status);

        await axios.post('/api/admin/games', formData, {
          headers: { 'Content-Type': 'multipart/form-data' }
        });

        this.showMessage('TyperGel1 word added successfully!', 'success');
        this.typerGelForm = {
          question: '',
          status: 'active'
        };
        await this.fetchDashboardData();
      } catch (error) {
        const errorMsg = error.response?.data?.message || error.response?.data?.errors?.question?.[0] || 'Failed to add TyperGel1 word';
        this.showMessage(errorMsg, 'error');
      }
    },
    getBulkWordCount() {
      if (!this.bulkTyperGelWords.trim()) return 0;
      const words = this.parseBulkWords(this.bulkTyperGelWords);
      return words.length;
    },
    parseBulkWords(input) {
      if (!input || !input.trim()) return [];
      
      let words = [];
      
      if (input.includes(',')) {
        words = input.split(',').map(w => w.trim()).filter(w => w.length > 0);
      } else {
        words = input.split('\n').map(w => w.trim()).filter(w => w.length > 0);
      }
      
      return words;
    },
    async submitBulkTyperGelWords() {
      if (!this.bulkTyperGelWords.trim()) {
        this.showMessage('Please enter at least one word or phrase', 'error');
        return;
      }

      const words = this.parseBulkWords(this.bulkTyperGelWords);
      
      if (words.length === 0) {
        this.showMessage('No valid words found. Please check your input.', 'error');
        return;
      }

      const existingWords = this.typerGelGames.map(g => g.question.toLowerCase().trim());
      const duplicates = [];
      const uniqueWords = [];

      words.forEach(word => {
        const normalizedWord = word.toLowerCase().trim();
        if (existingWords.includes(normalizedWord) || uniqueWords.includes(normalizedWord)) {
          duplicates.push(word);
        } else {
          uniqueWords.push(normalizedWord);
        }
      });

      if (duplicates.length > 0 && duplicates.length === words.length) {
        this.showMessage('All words already exist in TyperGel1. No words were added.', 'error');
        return;
      }

      if (duplicates.length > 0) {
        const proceed = confirm(
          `${duplicates.length} word(s) already exist and will be skipped:\n${duplicates.slice(0, 5).join(', ')}${duplicates.length > 5 ? '...' : ''}\n\nContinue with the remaining ${uniqueWords.length} unique word(s)?`
        );
        if (!proceed) return;
      }

      this.isBulkSubmitting = true;
      let successCount = 0;
      let errorCount = 0;
      let duplicateSkippedCount = 0;
      const processedWords = new Set();

      try {
        for (const word of words) {
          const normalizedWord = word.toLowerCase().trim();
          
          if (processedWords.has(normalizedWord)) {
            duplicateSkippedCount++;
            continue;
          }

          if (existingWords.includes(normalizedWord)) {
            duplicateSkippedCount++;
            processedWords.add(normalizedWord);
            continue;
          }

          try {
            const formData = new FormData();
            formData.append('type', 'typergel');
            formData.append('question', word);
            formData.append('status', this.bulkTyperGelStatus);

            await axios.post('/api/admin/games', formData, {
              headers: { 'Content-Type': 'multipart/form-data' }
            });
            successCount++;
            processedWords.add(normalizedWord);
          } catch (error) {
            if (error.response?.data?.errors?.question) {
              duplicateSkippedCount++;
            } else {
              errorCount++;
            }
            processedWords.add(normalizedWord);
            console.error(`Failed to add word "${word}":`, error);
          }
        }

        const skippedCount = duplicateSkippedCount;
        if (successCount > 0) {
          let message = `Successfully added ${successCount} word(s)`;
          if (skippedCount > 0) {
            message += `, ${skippedCount} duplicate(s) skipped`;
          }
          if (errorCount > 0) {
            message += `, ${errorCount} failed`;
          }
          this.showMessage(message, errorCount > 0 ? 'error' : 'success');
          this.bulkTyperGelWords = '';
          await this.fetchDashboardData();
        } else {
          this.showMessage('Failed to add any words. All words may be duplicates or errors occurred.', 'error');
        }
      } catch (error) {
        this.showMessage('An error occurred during bulk import', 'error');
      } finally {
        this.isBulkSubmitting = false;
      }
    },
    openEditTyperGelModal(game) {
      this.editingTyperGel = {
        id: game.id,
        question: game.question,
        status: game.status
      };
      this.showEditTyperGelModal = true;
    },
    closeEditTyperGelModal() {
      this.showEditTyperGelModal = false;
      this.editingTyperGel = {
        id: null,
        question: '',
        status: 'active'
      };
    },
    async submitEditTyperGel() {
      if (!this.editingTyperGel.id) return;

      const trimmedQuestion = this.editingTyperGel.question.trim();
      
      if (!trimmedQuestion) {
        this.showMessage('Please enter a word or phrase', 'error');
        return;
      }

      const duplicate = this.typerGelGames.find(
        game => game.id !== this.editingTyperGel.id && 
                game.question.toLowerCase().trim() === trimmedQuestion.toLowerCase()
      );

      if (duplicate) {
        this.showMessage('This word or phrase already exists in TyperGel1', 'error');
        return;
      }

      this.isEditingTyperGel = true;
      try {
        const payload = {
          question: trimmedQuestion,
          status: this.editingTyperGel.status
        };

        await axios.put(`/api/admin/games/${this.editingTyperGel.id}`, payload);

        this.showMessage('TyperGel1 word updated successfully!', 'success');
        this.closeEditTyperGelModal();
        await this.fetchDashboardData();
      } catch (error) {
        const errorMsg = error.response?.data?.message || error.response?.data?.errors?.question?.[0] || 'Failed to update TyperGel1 word';
        this.showMessage(errorMsg, 'error');
      } finally {
        this.isEditingTyperGel = false;
      }
    },
    confirmDeleteTyperGel(game) {
      if (confirm(`Are you sure you want to delete "${game.question}"?`)) {
        this.deleteTyperGel(game.id);
      }
    },
    async deleteTyperGel(gameId) {
      try {
        await axios.delete(`/api/admin/games/${gameId}`);
        this.showMessage('TyperGel1 word deleted successfully!', 'success');
        await this.fetchDashboardData();
      } catch (error) {
        this.showMessage('Failed to delete TyperGel1 word', 'error');
      }
    },
    async submitStudy() {
      try {
        this.isSubmittingStudy = true;
        const formData = new FormData();
        formData.append('title', this.studyForm.title);
        formData.append('description', this.studyForm.description || '');
        formData.append('content', this.studyForm.content);
        formData.append('status', this.studyForm.status);

        await axios.post('/api/admin/lessons', formData, {
          headers: { 'Content-Type': 'multipart/form-data' }
        });

        this.showMessage('Study content created successfully!', 'success');
        this.studyForm = {
          title: '',
          description: '',
          content: '',
          status: 'active'
        };
        await this.fetchDashboardData();
      } catch (error) {
        const errorMsg = error.response?.data?.message || 'Failed to create study content';
        this.showMessage(errorMsg, 'error');
      } finally {
        this.isSubmittingStudy = false;
      }
    },
    editStudy(lesson) {
      this.editingStudy = { ...lesson };
      this.studyForm = {
        title: lesson.title,
        description: lesson.description || '',
        content: lesson.content,
        status: lesson.status
      };
      this.activeTab = 'studies';
      window.scrollTo({ top: 0, behavior: 'smooth' });
    },
    async updateStudy() {
      if (!this.editingStudy) return;
      
      try {
        this.isSubmittingStudy = true;
        const formData = new FormData();
        formData.append('title', this.studyForm.title);
        formData.append('description', this.studyForm.description || '');
        formData.append('content', this.studyForm.content);
        formData.append('status', this.studyForm.status);

        await axios.put(`/api/admin/lessons/${this.editingStudy.id}`, formData, {
          headers: { 'Content-Type': 'multipart/form-data' }
        });

        this.showMessage('Study content updated successfully!', 'success');
        this.studyForm = {
          title: '',
          description: '',
          content: '',
          status: 'active'
        };
        this.editingStudy = null;
        await this.fetchDashboardData();
      } catch (error) {
        const errorMsg = error.response?.data?.message || 'Failed to update study content';
        this.showMessage(errorMsg, 'error');
      } finally {
        this.isSubmittingStudy = false;
      }
    },
    confirmDeleteStudy(lesson) {
      if (confirm(`Are you sure you want to delete "${lesson.title}"?`)) {
        this.deleteStudy(lesson.id);
      }
    },
    async deleteStudy(lessonId) {
      try {
        await axios.delete(`/api/admin/lessons/${lessonId}`);
        this.showMessage('Study content deleted successfully!', 'success');
        await this.fetchDashboardData();
      } catch (error) {
        this.showMessage('Failed to delete study content', 'error');
      }
    },
    renderCharts() {
      this.renderDailyChart();
      this.renderMonthlyChart();
      this.renderUserStatsChart();
      this.renderUserStatusChart();
    },
    renderDailyChart() {
      const labels = this.analytics.daily_sessions_last_30_days.map(d => d.date);
      const data = this.analytics.daily_sessions_last_30_days.map(d => d.sessions);
      const ctx = this.$refs.dailySessionsChart;
      if (!ctx) return;
      if (this.dailyChart) {
        this.dailyChart.destroy();
      }
      this.dailyChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels,
          datasets: [
            {
              label: 'Sessions',
              data,
              borderColor: '#4f46e5',
              backgroundColor: 'rgba(79, 70, 229, 0.1)',
              tension: 0.3,
              fill: true
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            x: {
              ticks: { maxTicksLimit: 6, color: '#4b5563' }
            },
            y: {
              beginAtZero: true,
              ticks: { color: '#4b5563' }
            }
          },
          plugins: {
            legend: { labels: { color: '#4b5563' } }
          }
        }
      });
    },
    renderMonthlyChart() {
      const labels = this.analytics.monthly_sessions_last_12_months.map(d => d.label);
      const data = this.analytics.monthly_sessions_last_12_months.map(d => d.sessions);
      const ctx = this.$refs.monthlySessionsChart;
      if (!ctx) return;
      if (this.monthlyChart) {
        this.monthlyChart.destroy();
      }
      this.monthlyChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels,
          datasets: [
            {
              label: 'Sessions',
              data,
              backgroundColor: '#2563eb'
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            x: {
              ticks: { maxTicksLimit: 6, color: '#4b5563' }
            },
            y: {
              beginAtZero: true,
              ticks: { color: '#4b5563' }
            }
          },
          plugins: {
            legend: { labels: { color: '#4b5563' } }
          }
        }
      });
    },
    renderUserStatsChart() {
      const stats = this.analytics.user_stats;
      const ctx = this.$refs.userStatsChart;
      if (!ctx) return;
      if (this.userStatsChart) {
        this.userStatsChart.destroy();
      }
      this.userStatsChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: ['Regular Users', 'Admin Users', 'Disabled Users'],
          datasets: [
            {
              data: [
                stats.regular_users || 0,
                stats.admin_users || 0,
                stats.disabled_users || 0
              ],
              backgroundColor: [
                '#3b82f6',
                '#8b5cf6',
                '#ef4444'
              ],
              borderColor: '#ffffff',
              borderWidth: 2
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: 'bottom',
              labels: {
                color: '#4b5563',
                padding: 15,
                font: {
                  size: 12
                }
              }
            },
            tooltip: {
              callbacks: {
                label: function(context) {
                  const label = context.label || '';
                  const value = context.parsed || 0;
                  const total = context.dataset.data.reduce((a, b) => a + b, 0);
                  const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                  return `${label}: ${value} (${percentage}%)`;
                }
              }
            }
          }
        }
      });
    },
    renderUserStatusChart() {
      const stats = this.analytics.user_stats;
      const ctx = this.$refs.userStatusChart;
      if (!ctx) return;
      if (this.userStatusChart) {
        this.userStatusChart.destroy();
      }
      this.userStatusChart = new Chart(ctx, {
        type: 'radar',
        data: {
          labels: ['Active Users', 'Disabled Users', 'Admin Users', 'Regular Users', 'Total Users'],
          datasets: [
            {
              label: 'User Count',
              data: [
                stats.active_users || 0,
                stats.disabled_users || 0,
                stats.admin_users || 0,
                stats.regular_users || 0,
                stats.total_users || 0
              ],
              backgroundColor: 'rgba(102, 126, 234, 0.2)',
              borderColor: '#667eea',
              borderWidth: 2,
              pointBackgroundColor: '#667eea',
              pointBorderColor: '#ffffff',
              pointHoverBackgroundColor: '#764ba2',
              pointHoverBorderColor: '#ffffff'
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            r: {
              beginAtZero: true,
              ticks: {
                stepSize: 1,
                color: '#4b5563',
                backdropColor: 'transparent'
              },
              grid: {
                color: 'rgba(75, 85, 99, 0.2)'
              },
              pointLabels: {
                color: '#4b5563',
                font: {
                  size: 11
                }
              }
            }
          },
          plugins: {
            legend: {
              display: true,
              position: 'bottom',
              labels: {
                color: '#4b5563',
                padding: 10
              }
            },
            tooltip: {
              callbacks: {
                label: function(context) {
                  return `${context.dataset.label}: ${context.parsed.r}`;
                }
              }
            }
          }
        }
      });
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

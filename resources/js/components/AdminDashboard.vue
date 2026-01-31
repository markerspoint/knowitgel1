<template>
    <div
        class="min-h-screen bg-[#111111] text-gray-300 font-sans selection:bg-red-500 selection:text-white relative overflow-hidden flex flex-col"
    >
        <!-- Background Decorations -->
        <div
            class="absolute top-1/4 left-1/4 w-96 h-96 bg-red-500/10 rounded-full blur-[120px] pointer-events-none"
        ></div>
        <div
            class="absolute bottom-1/4 right-1/4 w-64 h-64 bg-blue-500/10 rounded-full blur-[100px] pointer-events-none"
        ></div>

        <!-- Navigation -->
        <nav
            class="sticky top-0 w-full z-50 bg-[#111111]/80 backdrop-blur-md border-b border-white/5"
        >
            <div
                class="container mx-auto px-6 py-4 flex items-center justify-between"
            >
                <router-link
                    to="/admin/dashboard"
                    class="flex items-center space-x-3 group"
                >
                    <div
                        class="w-10 h-10 bg-red-500 rounded-lg flex items-center justify-center transform group-hover:rotate-12 transition-transform duration-300 shadow-[0_0_15px_rgba(239,68,68,0.3)]"
                    >
                        <i class="fas fa-terminal text-white text-xl"></i>
                    </div>
                    <span
                        class="text-xl font-bold tracking-tighter text-white group-hover:text-red-500 transition-colors uppercase"
                        >KNOWIT GEL1 ADMIN</span
                    >
                </router-link>

                <div class="flex items-center space-x-6">
                    <div class="relative group" @click.stop>
                        <button
                            @click="showProfileDropdown = !showProfileDropdown"
                            class="flex items-center space-x-3 p-1 rounded-xl hover:bg-white/5 transition-all outline-none"
                        >
                            <div class="text-right hidden sm:block">
                                <p
                                    class="text-xs font-black text-white uppercase tracking-tighter"
                                >
                                    {{ user?.fname }} {{ user?.lname }}
                                </p>
                                <p
                                    class="text-[10px] font-mono text-red-500 uppercase tracking-widest"
                                >
                                    Network Authority
                                </p>
                            </div>
                            <div
                                class="w-10 h-10 rounded-lg border border-white/10 flex items-center justify-center overflow-hidden bg-white/5 group-hover:border-red-500/50 transition-colors"
                            >
                                <img
                                    v-if="user && user.profile_picture"
                                    :src="'/' + user.profile_picture"
                                    alt="Profile"
                                    class="w-full h-full object-cover"
                                />
                                <div
                                    v-else
                                    class="w-full h-full flex items-center justify-center text-red-500 font-black text-sm"
                                >
                                    {{ user?.fname?.charAt(0)
                                    }}{{ user?.lname?.charAt(0) }}
                                </div>
                            </div>
                        </button>
                        <transition name="dropdown">
                            <div
                                v-show="showProfileDropdown"
                                class="absolute right-0 mt-3 w-56 bg-[#181818] border border-white/10 rounded-2xl shadow-2xl overflow-hidden z-50"
                            >
                                <div class="p-2">
                                    <router-link
                                        to="/admin/profile"
                                        class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-white/5 text-sm font-bold text-gray-400 hover:text-white transition-all"
                                    >
                                        <i class="fas fa-user-shield w-5"></i
                                        ><span>Admin Profile</span>
                                    </router-link>
                                    <router-link
                                        to="/admin/users"
                                        class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-white/5 text-sm font-bold text-gray-400 hover:text-white transition-all"
                                    >
                                        <i class="fas fa-users w-5"></i
                                        ><span>User Manager</span>
                                    </router-link>
                                    <router-link
                                        to="/admin/assessment"
                                        class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-white/5 text-sm font-bold text-gray-400 hover:text-white transition-all"
                                    >
                                        <i class="fas fa-tasks w-5"></i
                                        ><span>Assessment Logic</span>
                                    </router-link>
                                    <router-link
                                        to="/admin/settings"
                                        class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-white/5 text-sm font-bold text-gray-400 hover:text-white transition-all"
                                    >
                                        <i class="fas fa-cogs w-5"></i
                                        ><span>System Settings</span>
                                    </router-link>
                                </div>
                                <button
                                    @click="handleLogout"
                                    class="w-full flex items-center space-x-3 px-6 py-4 bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white text-xs font-black uppercase tracking-[0.2em] transition-all border-t border-white/5"
                                >
                                    <i class="fas fa-power-off"></i
                                    ><span>Terminate Session</span>
                                </button>
                            </div>
                        </transition>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Content Area -->
        <div class="flex-grow container mx-auto px-6 py-12 relative z-10">
            <!-- Alerts -->
            <transition name="fade">
                <div
                    v-if="message"
                    :class="[
                        'fixed top-24 right-6 z-[60] px-6 py-4 rounded-2xl border backdrop-blur-md shadow-2xl flex items-center space-x-4 reveal-section active',
                        messageType === 'success'
                            ? 'bg-green-500/10 border-green-500/20 text-green-400'
                            : 'bg-red-500/10 border-red-500/20 text-red-400',
                    ]"
                >
                    <div
                        class="w-8 h-8 rounded-lg flex items-center justify-center font-bold"
                        :class="
                            messageType === 'success'
                                ? 'bg-green-500/20'
                                : 'bg-red-500/20'
                        "
                    >
                        <i
                            :class="
                                messageType === 'success'
                                    ? 'fas fa-check-circle'
                                    : 'fas fa-exclamation-triangle'
                            "
                        ></i>
                    </div>
                    <span class="text-sm font-bold">{{ message }}</span>
                    <button @click="message = ''" class="hover:opacity-70">
                        &times;
                    </button>
                </div>
            </transition>

            <!-- Dashboard Header -->
            <div class="mb-12 reveal-section active">
                <h2
                    class="text-red-500 font-mono tracking-[0.3em] text-xs mb-3 uppercase"
                >
                    Command Center
                </h2>
                <h1
                    class="text-4xl md:text-5xl font-black text-white tracking-tighter uppercase mb-4"
                >
                    Control
                    <span
                        class="text-transparent bg-clip-text bg-linear-to-r from-red-500 to-red-600"
                        >Interface</span
                    >
                </h1>
                <div class="flex flex-wrap gap-3 mt-8">
                    <button
                        v-for="tab in tabConfigs"
                        :key="tab.id"
                        @click="activeTab = tab.id"
                        :class="[
                            'px-6 py-3 rounded-xl font-black uppercase tracking-widest text-xs transition-all border outline-none',
                            activeTab === tab.id
                                ? 'bg-red-500 text-white border-red-500 shadow-[0_0_20px_rgba(239,68,68,0.3)]'
                                : 'bg-white/5 text-gray-500 border-white/10 hover:bg-white/10 hover:text-white',
                        ]"
                    >
                        <i :class="tab.icon" class="mr-2"></i>{{ tab.label }}
                    </button>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="reveal-section active">
                <!-- Overview Tab -->
                <div v-if="activeTab === 'overview'" class="space-y-12">
                    <!-- Stats Grid -->
                    <div
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6"
                    >
                        <div
                            v-for="stat in analyticsSummary"
                            :key="stat.label"
                            class="bg-white/5 border border-white/10 rounded-3xl p-8 hover:bg-white/10 transition-all group relative overflow-hidden"
                        >
                            <div
                                class="absolute -right-6 -bottom-6 opacity-5 group-hover:opacity-10 transition-opacity transform rotate-12"
                            >
                                <i
                                    :class="stat.icon"
                                    class="text-8xl text-red-500"
                                ></i>
                            </div>
                            <p
                                class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-4"
                            >
                                {{ stat.label }}
                            </p>
                            <p
                                class="text-4xl font-black text-white tracking-tighter mb-2"
                            >
                                {{ stat.value }}
                            </p>
                            <div class="flex items-center space-x-2">
                                <span
                                    :class="[
                                        'text-[10px] font-mono uppercase',
                                        stat.trendColor,
                                    ]"
                                    >{{ stat.trend }}</span
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Charts Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div
                            class="bg-white/5 border border-white/10 rounded-3xl p-8"
                        >
                            <h4
                                class="text-xs font-black text-white uppercase tracking-widest mb-8 flex items-center"
                            >
                                <i
                                    class="fas fa-chart-line mr-3 text-red-500"
                                ></i
                                >Daily Traffic Synchronisation
                            </h4>
                            <div class="h-[300px] w-full">
                                <canvas ref="dailySessionsChart"></canvas>
                            </div>
                        </div>
                        <div
                            class="bg-white/5 border border-white/10 rounded-3xl p-8"
                        >
                            <h4
                                class="text-xs font-black text-white uppercase tracking-widest mb-8 flex items-center"
                            >
                                <i
                                    class="fas fa-chart-bar mr-3 text-red-500"
                                ></i
                                >Monthly Engagement Load
                            </h4>
                            <div class="h-[300px] w-full">
                                <canvas ref="monthlySessionsChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Distribution Charts -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div
                            class="bg-white/5 border border-white/10 rounded-3xl p-8"
                        >
                            <h4
                                class="text-xs font-black text-white uppercase tracking-widest mb-8 flex items-center"
                            >
                                <i
                                    class="fas fa-circle-notch mr-3 text-red-500"
                                ></i
                                >User Role Metrics
                            </h4>
                            <div
                                class="flex flex-col md:flex-row items-center gap-8"
                            >
                                <div class="h-[250px] w-full md:w-1/2">
                                    <canvas ref="userStatsChart"></canvas>
                                </div>
                                <div class="flex-1 space-y-4">
                                    <div
                                        v-for="role in userRoleBreakdown"
                                        :key="role.label"
                                        class="flex items-center justify-between p-4 bg-white/5 rounded-2xl border border-white/5"
                                    >
                                        <div
                                            class="flex items-center space-x-3"
                                        >
                                            <div
                                                class="w-3 h-3 rounded-full"
                                                :class="role.color"
                                            ></div>
                                            <span
                                                class="text-xs font-bold text-gray-400 uppercase tracking-tight"
                                                >{{ role.label }}</span
                                            >
                                        </div>
                                        <span
                                            class="text-lg font-black text-white tracking-tighter"
                                            >{{ role.value }}</span
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="bg-white/5 border border-white/10 rounded-3xl p-8"
                        >
                            <h4
                                class="text-xs font-black text-white uppercase tracking-widest mb-8 flex items-center"
                            >
                                <i class="fas fa-radar mr-3 text-red-500"></i
                                >Network Status Spectrum
                            </h4>
                            <div class="h-[320px] w-full">
                                <canvas ref="userStatusChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- QA FPS Tab -->
                <div v-else-if="activeTab === 'qa_fps'" class="space-y-12">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Form Container -->
                        <div class="lg:col-span-1 space-y-8">
                            <div
                                class="bg-white/5 border border-white/10 rounded-3xl p-8 sticky top-28"
                            >
                                <h3
                                    class="text-sm font-black text-white uppercase tracking-widest mb-8 flex items-center"
                                >
                                    <i
                                        class="fas fa-plus-circle mr-3 text-red-500"
                                    ></i
                                    >Inject Question
                                </h3>
                                <form
                                    @submit.prevent="submitQAFPSQuestion"
                                    class="space-y-6"
                                >
                                    <!-- Form Fields -->
                                    <div class="space-y-1.5">
                                        <label
                                            class="text-[10px] font-black text-gray-500 uppercase tracking-widest"
                                            >Global Label</label
                                        >
                                        <input
                                            type="text"
                                            v-model="qaGameForm.title"
                                            required
                                            placeholder="Question Title"
                                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-red-500/50 transition-all font-medium text-sm"
                                        />
                                    </div>
                                    <div class="space-y-1.5">
                                        <label
                                            class="text-[10px] font-black text-gray-500 uppercase tracking-widest"
                                            >Terminal Output (Question)</label
                                        >
                                        <input
                                            type="text"
                                            v-model="qaGameForm.question"
                                            required
                                            placeholder="The query text"
                                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-red-500/50 transition-all font-medium text-sm"
                                        />
                                    </div>
                                    <div class="space-y-1.5">
                                        <label
                                            class="text-[10px] font-black text-gray-500 uppercase tracking-widest"
                                            >Correct Response Key</label
                                        >
                                        <input
                                            type="text"
                                            v-model="qaGameForm.answer"
                                            required
                                            placeholder="Required Exact Answer"
                                            class="w-full bg-linear-to-r from-red-500/5 to-transparent border border-white/10 rounded-xl px-4 py-3 text-red-500 focus:outline-none focus:border-red-500/50 transition-all font-bold text-sm"
                                        />
                                    </div>
                                    <div class="space-y-1.5">
                                        <label
                                            class="text-[10px] font-black text-gray-500 uppercase tracking-widest"
                                            >Multiple Choice Tokens (CSV)</label
                                        >
                                        <textarea
                                            v-model="qaGameForm.options"
                                            required
                                            placeholder="Option A, Option B, ..."
                                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-red-500/50 transition-all font-medium text-sm h-24 resize-none"
                                        ></textarea>
                                    </div>
                                    <div class="space-y-1.5">
                                        <label
                                            class="text-[10px] font-black text-gray-500 uppercase tracking-widest"
                                            >Identity Thumbnail</label
                                        >
                                        <div class="relative group/file">
                                            <input
                                                type="file"
                                                @change="
                                                    handleQAFPSThumbnailChange
                                                "
                                                accept="image/*"
                                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                            />
                                            <div
                                                class="w-full bg-white/5 border border-dashed border-white/10 rounded-xl px-4 py-6 text-center group-hover/file:border-red-500/50 transition-all"
                                            >
                                                <i
                                                    class="fas fa-cloud-upload-alt text-2xl text-gray-600 mb-2"
                                                ></i>
                                                <p
                                                    class="text-[10px] font-bold text-gray-400 uppercase tracking-widest"
                                                >
                                                    {{
                                                        qaGameForm.thumbnail
                                                            ? qaGameForm
                                                                  .thumbnail
                                                                  .name
                                                            : "Upload Sync Image"
                                                    }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <button
                                        type="submit"
                                        class="w-full py-4 bg-red-500 text-white font-black rounded-xl hover:bg-red-600 transition-all shadow-[0_15px_30px_rgba(239,68,68,0.2)] uppercase tracking-widest text-xs"
                                    >
                                        Commit Logic Link
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- List Container -->
                        <div class="lg:col-span-2 space-y-8">
                            <div
                                class="bg-white/5 border border-white/10 rounded-3xl overflow-hidden shadow-2xl"
                            >
                                <div
                                    class="p-8 border-b border-white/5 bg-white/[0.02] flex items-center justify-between"
                                >
                                    <span
                                        class="text-xs font-black text-white uppercase tracking-widest"
                                        >Active Combat Modules</span
                                    >
                                    <span
                                        class="text-[10px] font-mono text-gray-600 uppercase"
                                        >{{ qaGames.length }} Instances</span
                                    >
                                </div>
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left">
                                        <thead>
                                            <tr
                                                class="bg-white/5 border-b border-white/5 text-[10px] font-black text-gray-500 uppercase tracking-widest"
                                            >
                                                <th class="px-8 py-5">
                                                    Module Label
                                                </th>
                                                <th class="px-8 py-5">
                                                    Logic Output
                                                </th>
                                                <th class="px-8 py-5">
                                                    Status
                                                </th>
                                                <th
                                                    class="px-8 py-5 text-right"
                                                >
                                                    Operations
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-white/5">
                                            <tr
                                                v-for="game in qaGames"
                                                :key="game.id"
                                                class="hover:bg-white/[0.03] transition-colors group"
                                            >
                                                <td class="px-8 py-6">
                                                    <div
                                                        class="flex items-center space-x-4"
                                                    >
                                                        <div
                                                            class="w-10 h-10 rounded-lg bg-white/10 border border-white/10 flex items-center justify-center overflow-hidden"
                                                        >
                                                            <img
                                                                v-if="
                                                                    game.thumbnail
                                                                "
                                                                :src="
                                                                    '/' +
                                                                    game.thumbnail
                                                                "
                                                                class="w-full h-full object-cover"
                                                            />
                                                            <i
                                                                v-else
                                                                class="fas fa-image text-gray-600"
                                                            ></i>
                                                        </div>
                                                        <span
                                                            class="text-sm font-bold text-white uppercase tracking-tight"
                                                            >{{
                                                                game.title
                                                            }}</span
                                                        >
                                                    </div>
                                                </td>
                                                <td class="px-8 py-6">
                                                    <p
                                                        class="text-xs text-gray-400 max-w-xs"
                                                    >
                                                        {{
                                                            truncate(
                                                                game.question,
                                                                100,
                                                            )
                                                        }}
                                                    </p>
                                                </td>
                                                <td class="px-8 py-6">
                                                    <span
                                                        :class="[
                                                            'px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest',
                                                            game.status ===
                                                            'active'
                                                                ? 'bg-green-500/10 text-green-500'
                                                                : 'bg-red-500/10 text-red-500',
                                                        ]"
                                                    >
                                                        {{ game.status }}
                                                    </span>
                                                </td>
                                                <td
                                                    class="px-8 py-6 text-right"
                                                >
                                                    <div
                                                        class="flex items-center justify-end space-x-2"
                                                    >
                                                        <button
                                                            @click="
                                                                editQAGame(game)
                                                            "
                                                            class="w-10 h-10 rounded-xl bg-blue-500/10 text-blue-500 hover:bg-blue-500 hover:text-white transition-all flex items-center justify-center"
                                                        >
                                                            <i
                                                                class="fas fa-edit text-xs"
                                                            ></i>
                                                        </button>
                                                        <button
                                                            @click="
                                                                deleteQAGame(
                                                                    game,
                                                                )
                                                            "
                                                            class="w-10 h-10 rounded-xl bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white transition-all flex items-center justify-center"
                                                        >
                                                            <i
                                                                class="fas fa-trash-alt text-xs"
                                                            ></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TyperGel Tab -->
                <div v-else-if="activeTab === 'typergel1'" class="space-y-12">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Single Entry -->
                        <div
                            class="bg-white/5 border border-white/10 rounded-3xl p-8"
                        >
                            <h3
                                class="text-sm font-black text-white uppercase tracking-widest mb-8 flex items-center"
                            >
                                <i class="fas fa-keyboard mr-3 text-red-500"></i
                                >Isolate Entry
                            </h3>
                            <form
                                @submit.prevent="submitTyperGelWord"
                                class="flex items-end space-x-4"
                            >
                                <div class="flex-1 space-y-1.5">
                                    <label
                                        class="text-[10px] font-black text-gray-500 uppercase tracking-widest"
                                        >Vocabulary String</label
                                    >
                                    <input
                                        type="text"
                                        v-model="typerGelForm.question"
                                        required
                                        placeholder="Enter single word/phrase"
                                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-red-500/50 transition-all font-medium text-sm"
                                    />
                                </div>
                                <button
                                    type="submit"
                                    class="p-3.5 bg-red-500 text-white rounded-xl hover:bg-red-600 transition-all"
                                >
                                    <i class="fas fa-plus"></i>
                                </button>
                            </form>
                        </div>

                        <!-- Bulk Import -->
                        <div
                            class="bg-white/5 border border-white/10 rounded-3xl p-8"
                        >
                            <h3
                                class="text-sm font-black text-white uppercase tracking-widest mb-8 flex items-center"
                            >
                                <i
                                    class="fas fa-file-import mr-3 text-blue-500"
                                ></i
                                >Bulk Synchronisation
                            </h3>
                            <form
                                @submit.prevent="submitBulkTyperGelWords"
                                class="space-y-6"
                            >
                                <textarea
                                    v-model="bulkTyperGelWords"
                                    required
                                    placeholder="String List (Comma or Line Separated)"
                                    class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-red-500/50 transition-all font-mono text-xs h-32 resize-none"
                                ></textarea>
                                <div class="flex items-center justify-between">
                                    <span
                                        class="text-[10px] font-mono text-gray-500 uppercase tracking-widest"
                                        >{{ getBulkWordCount() }} Potential
                                        Tokens</span
                                    >
                                    <button
                                        type="submit"
                                        :disabled="isBulkSubmitting"
                                        class="px-6 py-2.5 bg-blue-500 text-white font-black rounded-xl hover:bg-blue-600 transition-all text-[10px] tracking-[0.2em] disabled:opacity-50"
                                    >
                                        <span v-if="!isBulkSubmitting"
                                            >EXECUTE BULK LINK</span
                                        >
                                        <span v-else
                                            ><i
                                                class="fas fa-sync-alt fa-spin mr-2"
                                            ></i
                                            >LINKING...</span
                                        >
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Full List Table -->
                    <div
                        class="bg-white/5 border border-white/10 rounded-3xl overflow-hidden shadow-2xl"
                    >
                        <div
                            class="p-8 border-b border-white/5 bg-white/[0.02] flex items-center justify-between"
                        >
                            <span
                                class="text-xs font-black text-white uppercase tracking-widest"
                                >Neural Vocabulary Registry</span
                            >
                            <span
                                class="text-[10px] font-mono text-gray-600 uppercase"
                                >{{ typerGelGames.length }} Tokens
                                Encrypted</span
                            >
                        </div>
                        <div
                            class="overflow-x-auto max-h-[500px] overflow-y-auto custom-scrollbar"
                        >
                            <table class="w-full text-left">
                                <thead
                                    class="sticky top-0 bg-[#161616] z-10 shadow-lg"
                                >
                                    <tr
                                        class="border-b border-white/5 text-[10px] font-black text-gray-500 uppercase tracking-widest"
                                    >
                                        <th class="px-8 py-5">Token String</th>
                                        <th class="px-8 py-5">Status</th>
                                        <th class="px-8 py-5 text-right">
                                            Operation Controls
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-white/5">
                                    <tr
                                        v-for="game in typerGelGames"
                                        :key="game.id"
                                        class="hover:bg-white/[0.03] transition-colors group"
                                    >
                                        <td class="px-8 py-6">
                                            <span
                                                class="text-sm font-bold text-white tracking-tight"
                                                >{{ game.question }}</span
                                            >
                                        </td>
                                        <td class="px-8 py-6">
                                            <span
                                                :class="[
                                                    'px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest',
                                                    game.status === 'active'
                                                        ? 'bg-green-500/10 text-green-500'
                                                        : 'bg-red-500/10 text-red-500',
                                                ]"
                                            >
                                                {{ game.status }}
                                            </span>
                                        </td>
                                        <td class="px-8 py-6 text-right">
                                            <div
                                                class="flex items-center justify-end space-x-2"
                                            >
                                                <button
                                                    @click="
                                                        openEditTyperGelModal(
                                                            game,
                                                        )
                                                    "
                                                    class="w-8 h-8 rounded-lg bg-blue-500/10 text-blue-500 hover:bg-blue-500 hover:text-white transition-all"
                                                >
                                                    <i
                                                        class="fas fa-edit text-xs"
                                                    ></i>
                                                </button>
                                                <button
                                                    @click="
                                                        confirmDeleteTyperGel(
                                                            game,
                                                        )
                                                    "
                                                    class="w-8 h-8 rounded-lg bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white transition-all"
                                                >
                                                    <i
                                                        class="fas fa-trash-alt text-xs"
                                                    ></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Studies Tab -->
                <div v-else-if="activeTab === 'studies'" class="space-y-12">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Content Creator -->
                        <div
                            class="lg:col-span-2 bg-white/5 border border-white/10 rounded-3xl p-8"
                        >
                            <h3
                                class="text-sm font-black text-white uppercase tracking-widest mb-8 flex items-center"
                            >
                                <i
                                    class="fas fa-pen-nib mr-3 text-amber-500"
                                ></i
                                >Sync Content Creator
                            </h3>
                            <form
                                @submit.prevent="
                                    editingStudy ? updateStudy() : submitStudy()
                                "
                                class="space-y-8"
                            >
                                <div class="grid md:grid-cols-2 gap-6">
                                    <div class="space-y-1.5">
                                        <label
                                            class="text-[10px] font-black text-gray-500 uppercase tracking-widest"
                                            >Protocol Title</label
                                        >
                                        <input
                                            type="text"
                                            v-model="studyForm.title"
                                            required
                                            placeholder="Lesson Heading"
                                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-4 text-white focus:outline-none focus:border-amber-500/50 transition-all font-black text-lg"
                                        />
                                    </div>
                                    <div class="space-y-1.5">
                                        <label
                                            class="text-[10px] font-black text-gray-500 uppercase tracking-widest"
                                            >Meta Description</label
                                        >
                                        <input
                                            type="text"
                                            v-model="studyForm.description"
                                            placeholder="Short Summary"
                                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-4 text-gray-400 focus:outline-none focus:border-amber-500/50 transition-all font-medium text-sm"
                                        />
                                    </div>
                                </div>
                                <div class="space-y-1.5">
                                    <label
                                        class="text-[10px] font-black text-gray-500 uppercase tracking-widest"
                                        >Central Knowledge Buffer
                                        (Markdown/Text)</label
                                    >
                                    <textarea
                                        v-model="studyForm.content"
                                        required
                                        placeholder="Enter full study materials..."
                                        class="w-full bg-white/2 border border-white/10 rounded-2xl px-6 py-6 text-gray-300 focus:outline-none focus:border-amber-500/50 transition-all font-mono text-sm h-[400px] leading-relaxed"
                                    ></textarea>
                                </div>
                                <div
                                    class="flex items-center justify-between pt-4 border-t border-white/5"
                                >
                                    <div class="flex items-center space-x-4">
                                        <select
                                            v-model="studyForm.status"
                                            class="bg-white/5 border border-white/10 rounded-xl px-4 py-2 text-xs font-bold uppercase text-gray-400 focus:outline-none"
                                        >
                                            <option value="active">
                                                Active Presence
                                            </option>
                                            <option value="inactive">
                                                Latent Link
                                            </option>
                                        </select>
                                        <button
                                            v-if="editingStudy"
                                            type="button"
                                            @click="cancelEditStudy"
                                            class="text-xs font-black text-gray-500 hover:text-red-500 transition-colors uppercase tracking-widest"
                                        >
                                            Discard Edit
                                        </button>
                                    </div>
                                    <button
                                        type="submit"
                                        :disabled="isSubmittingStudy"
                                        class="px-10 py-4 bg-amber-500 text-black font-black rounded-xl hover:bg-amber-600 transition-all shadow-[0_15px_30px_rgba(245,158,11,0.2)] uppercase tracking-widest text-xs"
                                    >
                                        <span v-if="!isSubmittingStudy">{{
                                            editingStudy
                                                ? "Apply Sync Revision"
                                                : "Broadcast Archive"
                                        }}</span>
                                        <span v-else
                                            ><i
                                                class="fas fa-circle-notch fa-spin mr-2"
                                            ></i
                                            >Processing Sync...</span
                                        >
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Existing Index -->
                        <div
                            class="lg:col-span-1 bg-white/5 border border-white/10 rounded-3xl overflow-hidden flex flex-col"
                        >
                            <div
                                class="p-8 border-b border-white/5 bg-white/[0.02]"
                            >
                                <span
                                    class="text-xs font-black text-white uppercase tracking-widest"
                                    >Archive Index</span
                                >
                            </div>
                            <div
                                class="flex-grow overflow-y-auto custom-scrollbar p-6 space-y-4 max-h-[750px]"
                            >
                                <div
                                    v-for="lesson in lessons"
                                    :key="lesson.id"
                                    class="group p-5 bg-white/5 border border-white/5 rounded-2xl hover:border-amber-500/30 hover:bg-white/10 transition-all"
                                >
                                    <div
                                        class="flex items-start justify-between mb-3"
                                    >
                                        <span
                                            :class="[
                                                'text-[8px] font-black uppercase tracking-[0.2em] px-2 py-0.5 rounded-md',
                                                lesson.status === 'active'
                                                    ? 'bg-green-500/10 text-green-500'
                                                    : 'bg-red-500/10 text-red-500',
                                            ]"
                                        >
                                            {{ lesson.status }}
                                        </span>
                                        <div class="flex space-x-2">
                                            <button
                                                @click="editStudy(lesson)"
                                                class="text-gray-600 hover:text-amber-500 transition-colors"
                                            >
                                                <i
                                                    class="fas fa-edit text-xs"
                                                ></i>
                                            </button>
                                            <button
                                                @click="
                                                    confirmDeleteStudy(lesson)
                                                "
                                                class="text-gray-600 hover:text-red-500 transition-colors"
                                            >
                                                <i
                                                    class="fas fa-trash-alt text-xs"
                                                ></i>
                                            </button>
                                        </div>
                                    </div>
                                    <h4
                                        class="text-sm font-black text-white uppercase tracking-tight mb-1 group-hover:text-amber-500 transition-colors"
                                    >
                                        {{ lesson.title }}
                                    </h4>
                                    <p
                                        class="text-[10px] text-gray-500 line-clamp-2 uppercase font-mono tracking-tight"
                                    >
                                        {{
                                            lesson.description ||
                                            "No descriptive data link provided."
                                        }}
                                    </p>
                                </div>
                                <div
                                    v-if="!lessons.length"
                                    class="text-center py-20 opacity-20"
                                >
                                    <i
                                        class="fas fa-book-open text-5xl mb-4"
                                    ></i>
                                    <p
                                        class="text-xs font-black uppercase tracking-widest font-mono"
                                    >
                                        Archive Empty
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit TyperGel Modal -->
        <transition name="fade">
            <div
                v-if="showEditTyperGelModal"
                class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-black/80 backdrop-blur-md"
            >
                <div
                    class="bg-[#181818] border border-white/10 rounded-3xl shadow-2xl w-full max-w-md overflow-hidden relative"
                >
                    <div class="absolute -right-10 -top-10 opacity-5">
                        <i class="fas fa-keyboard text-[8rem] text-white"></i>
                    </div>
                    <div class="p-8 border-b border-white/5 bg-white/[0.02]">
                        <h3
                            class="text-xl font-black text-white uppercase tracking-tighter"
                        >
                            Modify Token
                        </h3>
                        <p
                            class="text-[10px] font-mono text-gray-500 uppercase tracking-widest mt-1"
                        >
                            Direct Database Link Active
                        </p>
                    </div>
                    <div class="p-8 space-y-6">
                        <div class="space-y-1.5">
                            <label
                                class="text-[10px] font-black text-gray-500 uppercase tracking-widest"
                                >Updated String</label
                            >
                            <input
                                type="text"
                                v-model="editingTyperGel.question"
                                required
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-red-500/50 transition-all font-bold"
                            />
                        </div>
                        <div class="space-y-1.5">
                            <label
                                class="text-[10px] font-black text-gray-500 uppercase tracking-widest"
                                >Visibility Status</label
                            >
                            <select
                                v-model="editingTyperGel.status"
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none"
                            >
                                <option value="active">Active Presence</option>
                                <option value="inactive">Latent Link</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-4 pt-4">
                            <button
                                @click="closeEditTyperGelModal"
                                class="py-3.5 px-4 bg-white/5 text-gray-500 font-black rounded-xl hover:text-white hover:bg-white/10 transition-all uppercase text-[10px] tracking-widest"
                            >
                                Abort
                            </button>
                            <button
                                @click="submitEditTyperGel"
                                :disabled="isEditingTyperGel"
                                class="py-3.5 px-4 bg-red-500 text-white font-black rounded-xl hover:bg-red-600 transition-all shadow-[0_10px_20px_rgba(239,68,68,0.2)] uppercase text-[10px] tracking-widest"
                            >
                                <span v-if="!isEditingTyperGel"
                                    >Apply Patch</span
                                >
                                <span v-else
                                    ><i class="fas fa-circle-notch fa-spin"></i
                                ></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </transition>

        <!-- Edit QA Game Modal -->
        <transition name="fade">
            <div
                v-if="showEditQAModal && editingQAGame"
                class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-black/80 backdrop-blur-md"
            >
                <div
                    class="bg-[#181818] border border-white/10 rounded-3xl shadow-2xl w-full max-w-2xl overflow-hidden flex flex-col max-h-[90vh]"
                >
                    <div
                        class="p-8 border-b border-white/5 bg-white/[0.02] flex items-center justify-between"
                    >
                        <div>
                            <h3
                                class="text-xl font-black text-white uppercase tracking-tighter"
                            >
                                Patch Combat Protocol
                            </h3>
                            <p
                                class="text-[10px] font-mono text-gray-500 uppercase tracking-widest mt-1"
                            >
                                #{{ editingQAGame.id }} Module Revision
                            </p>
                        </div>
                        <button
                            @click="showEditQAModal = false"
                            class="w-10 h-10 rounded-xl hover:bg-white/5 text-gray-500 hover:text-white transition-all"
                        >
                            &times;
                        </button>
                    </div>
                    <form
                        @submit.prevent="updateQAGame"
                        class="p-8 overflow-y-auto custom-scrollbar space-y-8"
                    >
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="space-y-1.5">
                                <label
                                    class="text-[10px] font-black text-gray-500 uppercase tracking-widest"
                                    >Module Label</label
                                >
                                <input
                                    type="text"
                                    v-model="editingQAGame.title"
                                    required
                                    class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-red-500/50 transition-all font-bold"
                                />
                            </div>
                            <div class="space-y-1.5">
                                <label
                                    class="text-[10px] font-black text-gray-500 uppercase tracking-widest"
                                    >Response Key</label
                                >
                                <input
                                    type="text"
                                    v-model="editingQAGame.answer"
                                    required
                                    class="w-full bg-red-500/5 border border-red-500/10 rounded-xl px-4 py-3 text-red-500 focus:outline-none focus:border-red-500/50 transition-all font-black"
                                />
                            </div>
                        </div>
                        <div class="space-y-1.5">
                            <label
                                class="text-[10px] font-black text-gray-500 uppercase tracking-widest"
                                >Logic Output (Question)</label
                            >
                            <input
                                type="text"
                                v-model="editingQAGame.question"
                                required
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-red-500/50 transition-all font-medium"
                            />
                        </div>
                        <div class="space-y-1.5">
                            <label
                                class="text-[10px] font-black text-gray-500 uppercase tracking-widest"
                                >Choice Tokens (CSV)</label
                            >
                            <textarea
                                v-model="editingQAGame.options"
                                required
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-red-500/50 transition-all font-medium h-24 resize-none"
                            ></textarea>
                        </div>
                        <div class="grid md:grid-cols-2 gap-6 items-start">
                            <div class="space-y-4">
                                <label
                                    class="text-[10px] font-black text-gray-500 uppercase tracking-widest"
                                    >Update Identity Thumbnail</label
                                >
                                <div class="relative group/file">
                                    <input
                                        type="file"
                                        @change="
                                            (e) =>
                                                (editingQAGame.thumbnail =
                                                    e.target.files[0])
                                        "
                                        accept="image/*"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                    />
                                    <div
                                        class="w-full bg-white/5 border border-dashed border-white/10 rounded-xl px-4 py-5 text-center group-hover/file:border-red-500/50 transition-all"
                                    >
                                        <p
                                            class="text-[10px] font-bold text-gray-500 uppercase"
                                        >
                                            Revision Matrix
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-1.5">
                                <label
                                    class="text-[10px] font-black text-gray-500 uppercase tracking-widest"
                                    >Sync Status</label
                                >
                                <select
                                    v-model="editingQAGame.status"
                                    class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-4 text-xs font-black text-white focus:outline-none"
                                >
                                    <option value="active">Active Sync</option>
                                    <option value="inactive">
                                        Latent Protocol
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div
                            class="pt-6 border-t border-white/5 flex justify-end space-x-4"
                        >
                            <button
                                type="button"
                                @click="showEditQAModal = false"
                                class="px-8 py-3 bg-white/5 text-gray-500 font-black rounded-xl hover:text-white hover:bg-white/10 transition-all uppercase text-[10px] tracking-widest"
                            >
                                Abort
                            </button>
                            <button
                                type="submit"
                                class="px-10 py-3 bg-red-500 text-white font-black rounded-xl hover:bg-red-600 transition-all shadow-[0_15px_30px_rgba(239,68,68,0.2)] uppercase text-[10px] tracking-widest"
                            >
                                Commit Revision
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
import axios from "axios";
import Chart from "chart.js/auto";

export default {
    name: "AdminDashboard",
    data() {
        return {
            user: null,
            showProfileDropdown: false,
            message: "",
            messageType: "success",
            games: [],
            lessons: [],
            activeTab: "overview",
            tabConfigs: [
                {
                    id: "overview",
                    label: "Monitor",
                    icon: "fas fa-tachometer-alt",
                },
                {
                    id: "qa_fps",
                    label: "Combat Modules",
                    icon: "fas fa-crosshairs",
                },
                {
                    id: "typergel1",
                    label: "Vocabulary Link",
                    icon: "fas fa-keyboard",
                },
                { id: "studies", label: "Archive Hub", icon: "fas fa-book" },
            ],
            studyForm: {
                title: "",
                description: "",
                content: "",
                status: "active",
            },
            isSubmittingStudy: false,
            editingStudy: null,
            showEditQAModal: false,
            editingQAGame: null,
            qaGameForm: {
                title: "",
                description: "",
                question: "",
                answer: "",
                options: "",
                status: "active",
                thumbnail: null,
            },
            typerGelForm: {
                question: "",
                status: "active",
            },
            bulkTyperGelWords: "",
            bulkTyperGelStatus: "active",
            isBulkSubmitting: false,
            showEditTyperGelModal: false,
            editingTyperGel: {
                id: null,
                question: "",
                status: "active",
            },
            isEditingTyperGel: false,
            analytics: {
                totals: {
                    total_users: 0,
                    new_users_last_30_days: 0,
                    total_sessions: 0,
                    total_score: 0,
                },
                user_stats: {
                    total_users: 0,
                    active_users: 0,
                    disabled_users: 0,
                    admin_users: 0,
                    regular_users: 0,
                },
                daily_sessions_last_30_days: [],
                monthly_sessions_last_12_months: [],
            },
            dailyChart: null,
            monthlyChart: null,
            userStatsChart: null,
            userStatusChart: null,
        };
    },
    computed: {
        qaGames() {
            return Array.isArray(this.games)
                ? this.games.filter((game) => game.type === "qa")
                : [];
        },
        typerGelGames() {
            return Array.isArray(this.games)
                ? this.games.filter((game) => game.type === "typergel")
                : [];
        },
        analyticsSummary() {
            return [
                {
                    label: "Network Entities",
                    value: this.analytics.totals.total_users,
                    trend: "+Syncing Active",
                    trendColor: "text-green-500",
                    icon: "fas fa-users",
                },
                {
                    label: "30D Onboarding",
                    value: this.analytics.totals.new_users_last_30_days,
                    trend: "Protocol Normal",
                    trendColor: "text-blue-500",
                    icon: "fas fa-user-plus",
                },
                {
                    label: "Archived Syncs",
                    value: this.analytics.totals.total_sessions,
                    trend: "Database Locked",
                    trendColor: "text-red-500",
                    icon: "fas fa-database",
                },
                {
                    label: "Global Capacity",
                    value: this.analytics.totals.total_score.toLocaleString(),
                    trend: "System Peak",
                    trendColor: "text-amber-500",
                    icon: "fas fa-bolt",
                },
            ];
        },
        userRoleBreakdown() {
            const stats = this.analytics.user_stats;
            return [
                {
                    label: "Regular Entities",
                    value: stats.regular_users || 0,
                    color: "bg-blue-500",
                },
                {
                    label: "Authority Links",
                    value: stats.admin_users || 0,
                    color: "bg-red-500",
                },
                {
                    label: "Latent Links",
                    value: stats.disabled_users || 0,
                    color: "bg-gray-700",
                },
            ];
        },
    },
    async mounted() {
        console.log("[AdminDashboard] Component mounting...");
        try {
            await this.fetchUser();
            console.log("[AdminDashboard] User fetched:", this.user);
            await this.fetchDashboardData();
            console.log("[AdminDashboard] Dashboard data fetched");
            document.addEventListener("click", this.handleClickOutside);
            console.log("[AdminDashboard] Mount complete");
        } catch (error) {
            console.error("[AdminDashboard] Mount error:", error);
        }
    },
    beforeUnmount() {
        document.removeEventListener("click", this.handleClickOutside);
        this.destroyCharts();
    },
    methods: {
        async fetchUser() {
            try {
                const response = await axios.get("/api/user");
                this.user = response.data.user;
            } catch (error) {
                this.$router.push("/login");
            }
        },
        async fetchDashboardData() {
            try {
                const response = await axios.get("/api/admin/dashboard-data");
                this.games = response.data.games || [];
                this.lessons = response.data.lessons || [];
                if (response.data.analytics) {
                    this.analytics.totals =
                        response.data.analytics.totals || this.analytics.totals;
                    this.analytics.user_stats =
                        response.data.analytics.user_stats ||
                        this.analytics.user_stats;
                    this.analytics.daily_sessions_last_30_days =
                        response.data.analytics.daily_sessions_last_30_days ||
                        [];
                    this.analytics.monthly_sessions_last_12_months =
                        response.data.analytics
                            .monthly_sessions_last_12_months || [];
                    this.$nextTick(() => {
                        this.renderCharts();
                    });
                }
            } catch (error) {
                this.showMessage(
                    "System integrity fault during data sync.",
                    "error",
                );
            }
        },
        showMessage(msg, type) {
            this.message = msg;
            this.messageType = type;
            setTimeout(() => {
                this.message = "";
            }, 5000);
        },
        truncate(str, length) {
            if (!str) return "";
            return str.length > length ? str.substring(0, length) + "..." : str;
        },
        capitalize(str) {
            return str ? str.charAt(0).toUpperCase() + str.slice(1) : "";
        },
        handleQAFPSThumbnailChange(event) {
            this.qaGameForm.thumbnail = event.target.files[0];
        },
        async submitQAFPSQuestion() {
            try {
                const formData = new FormData();
                Object.keys(this.qaGameForm).forEach((key) => {
                    if (this.qaGameForm[key] !== null)
                        formData.append(key, this.qaGameForm[key]);
                });
                formData.append("type", "qa");

                await axios.post("/api/admin/games", formData, {
                    headers: { "Content-Type": "multipart/form-data" },
                });

                this.showMessage(
                    "Combat module successfully synchronised.",
                    "success",
                );
                this.qaGameForm = {
                    title: "",
                    description: "",
                    question: "",
                    answer: "",
                    options: "",
                    status: "active",
                    thumbnail: null,
                };
                await this.fetchDashboardData();
            } catch (error) {
                this.showMessage(
                    "Fault detected during combat module injection.",
                    "error",
                );
            }
        },
        editQAGame(game) {
            let optionsStr = "";
            if (Array.isArray(game.options)) {
                optionsStr = game.options.join(", ");
            } else if (typeof game.options === "string") {
                try {
                    const parsed = JSON.parse(game.options);
                    optionsStr = Array.isArray(parsed)
                        ? parsed.join(", ")
                        : game.options;
                } catch (e) {
                    optionsStr = game.options;
                }
            }
            this.editingQAGame = { ...game, options: optionsStr };
            this.showEditQAModal = true;
        },
        async updateQAGame() {
            try {
                const formData = new FormData();
                formData.append("title", this.editingQAGame.title);
                formData.append("description", this.editingQAGame.description);
                formData.append("question", this.editingQAGame.question);
                formData.append("answer", this.editingQAGame.answer);
                formData.append(
                    "options",
                    Array.isArray(this.editingQAGame.options)
                        ? this.editingQAGame.options.join(",")
                        : this.editingQAGame.options,
                );
                formData.append("status", this.editingQAGame.status);
                formData.append("_method", "PUT");

                if (this.editingQAGame.thumbnail instanceof File) {
                    formData.append("thumbnail", this.editingQAGame.thumbnail);
                }

                await axios.post(
                    `/api/admin/games/${this.editingQAGame.id}`,
                    formData,
                    { headers: { "Content-Type": "multipart/form-data" } },
                );

                this.showMessage(
                    "Combat module revision committed.",
                    "success",
                );
                this.showEditQAModal = false;
                await this.fetchDashboardData();
            } catch (error) {
                this.showMessage("Revision failure: Registry block.", "error");
            }
        },
        async deleteQAGame(game) {
            if (
                !confirm(
                    "Decommission this combat module? Logic sync will be severed.",
                )
            )
                return;
            try {
                await axios.delete(`/api/admin/games/${game.id}`);
                this.showMessage("Combat module decommissioned.", "success");
                await this.fetchDashboardData();
            } catch (error) {
                this.showMessage(
                    "Decommissioning failure: Unit vital.",
                    "error",
                );
            }
        },
        async submitTyperGelWord() {
            const word = this.typerGelForm.question.trim();
            if (!word)
                return this.showMessage(
                    "Token string cannot be null.",
                    "error",
                );

            try {
                const formData = new FormData();
                formData.append("type", "typergel");
                formData.append("question", word);
                formData.append("status", this.typerGelForm.status);

                await axios.post("/api/admin/games", formData, {
                    headers: { "Content-Type": "multipart/form-data" },
                });
                this.showMessage(
                    "Neural token archived successfully.",
                    "success",
                );
                this.typerGelForm.question = "";
                await this.fetchDashboardData();
            } catch (error) {
                this.showMessage(
                    "Token duplication or registry fault.",
                    "error",
                );
            }
        },
        getBulkWordCount() {
            if (!this.bulkTyperGelWords.trim()) return 0;
            return this.parseBulkWords(this.bulkTyperGelWords).length;
        },
        parseBulkWords(input) {
            if (!input?.trim()) return [];
            return input.includes(",")
                ? input
                      .split(",")
                      .map((w) => w.trim())
                      .filter((w) => w.length)
                : input
                      .split("\n")
                      .map((w) => w.trim())
                      .filter((w) => w.length);
        },
        async submitBulkTyperGelWords() {
            const words = this.parseBulkWords(this.bulkTyperGelWords);
            if (!words.length)
                return this.showMessage(
                    "No tokens identified in buffer.",
                    "error",
                );

            this.isBulkSubmitting = true;
            try {
                for (const word of words) {
                    const formData = new FormData();
                    formData.append("type", "typergel");
                    formData.append("question", word);
                    formData.append("status", this.bulkTyperGelStatus);
                    try {
                        await axios.post("/api/admin/games", formData);
                    } catch (e) {
                        console.error(`Failed: ${word}`);
                    }
                }
                this.showMessage(
                    "Bulk token synchronisation complete.",
                    "success",
                );
                this.bulkTyperGelWords = "";
                await this.fetchDashboardData();
            } catch (error) {
                this.showMessage("Bulk synchronisation interrupted.", "error");
            } finally {
                this.isBulkSubmitting = false;
            }
        },
        openEditTyperGelModal(game) {
            this.editingTyperGel = {
                id: game.id,
                question: game.question,
                status: game.status,
            };
            this.showEditTyperGelModal = true;
        },
        closeEditTyperGelModal() {
            this.showEditTyperGelModal = false;
        },
        async submitEditTyperGel() {
            this.isEditingTyperGel = true;
            try {
                await axios.put(`/api/admin/games/${this.editingTyperGel.id}`, {
                    question: this.editingTyperGel.question,
                    status: this.editingTyperGel.status,
                });
                this.showMessage(
                    "Registry patch successfully applied.",
                    "success",
                );
                this.closeEditTyperGelModal();
                await this.fetchDashboardData();
            } catch (error) {
                this.showMessage(
                    "Patch rejection: Core collision detected.",
                    "error",
                );
            } finally {
                this.isEditingTyperGel = false;
            }
        },
        confirmDeleteTyperGel(game) {
            if (confirm(`Purge token "${game.question}" from registry?`))
                this.deleteTyperGel(game.id);
        },
        async deleteTyperGel(id) {
            try {
                await axios.delete(`/api/admin/games/${id}`);
                this.showMessage("Token purged from network.", "success");
                await this.fetchDashboardData();
            } catch (error) {
                this.showMessage(
                    "Purge failure: Token locked by session.",
                    "error",
                );
            }
        },
        async submitStudy() {
            try {
                this.isSubmittingStudy = true;
                const formData = new FormData();
                Object.keys(this.studyForm).forEach((k) =>
                    formData.append(k, this.studyForm[k]),
                );
                await axios.post("/api/admin/lessons", formData);
                this.showMessage("Archive broadcast successful.", "success");
                this.studyForm = {
                    title: "",
                    description: "",
                    content: "",
                    status: "active",
                };
                await this.fetchDashboardData();
            } catch (error) {
                this.showMessage(
                    "Broadcast fault: Interference detected.",
                    "error",
                );
            } finally {
                this.isSubmittingStudy = false;
            }
        },
        editStudy(lesson) {
            this.editingStudy = { ...lesson };
            this.studyForm = {
                title: lesson.title,
                description: lesson.description || "",
                content: lesson.content,
                status: lesson.status,
            };
            window.scrollTo({ top: 0, behavior: "smooth" });
        },
        cancelEditStudy() {
            this.editingStudy = null;
            this.studyForm = {
                title: "",
                description: "",
                content: "",
                status: "active",
            };
        },
        async updateStudy() {
            try {
                this.isSubmittingStudy = true;
                await axios.put(
                    `/api/admin/lessons/${this.editingStudy.id}`,
                    this.studyForm,
                );
                this.showMessage("Archive revision committed.", "success");
                this.cancelEditStudy();
                await this.fetchDashboardData();
            } catch (error) {
                this.showMessage(
                    "Revision failure: Access denied to block.",
                    "error",
                );
            } finally {
                this.isSubmittingStudy = false;
            }
        },
        confirmDeleteStudy(lesson) {
            if (confirm(`Decommission archive "${lesson.title}"?`))
                this.deleteStudy(lesson.id);
        },
        async deleteStudy(id) {
            try {
                await axios.delete(`/api/admin/lessons/${id}`);
                this.showMessage(
                    "Archive decommissioning complete.",
                    "success",
                );
                await this.fetchDashboardData();
            } catch (error) {
                this.showMessage(
                    "Decommission failure: Block integrity vital.",
                    "error",
                );
            }
        },
        renderCharts() {
            const sharedOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: "#6a7280",
                            font: { family: "Space Grotesk", weight: "bold" },
                        },
                    },
                },
                scales: {
                    x: {
                        grid: { color: "rgba(255,255,255,0.05)" },
                        ticks: {
                            color: "#4b5563",
                            font: { family: "Space Grotesk" },
                        },
                    },
                    y: {
                        grid: { color: "rgba(255,255,255,0.05)" },
                        ticks: {
                            color: "#4b5563",
                            font: { family: "Space Grotesk" },
                        },
                    },
                },
            };

            // Daily Chart
            if (this.$refs.dailySessionsChart) {
                if (this.dailyChart) this.dailyChart.destroy();
                this.dailyChart = new Chart(this.$refs.dailySessionsChart, {
                    type: "line",
                    data: {
                        labels: this.analytics.daily_sessions_last_30_days.map(
                            (d) => d.date,
                        ),
                        datasets: [
                            {
                                label: "Pulse Rate",
                                data: this.analytics.daily_sessions_last_30_days.map(
                                    (d) => d.sessions,
                                ),
                                borderColor: "#ef4444",
                                backgroundColor: "rgba(239, 68, 68, 0.1)",
                                fill: true,
                                tension: 0.4,
                            },
                        ],
                    },
                    options: sharedOptions,
                });
            }

            // Monthly Chart
            if (this.$refs.monthlySessionsChart) {
                if (this.monthlyChart) this.monthlyChart.destroy();
                this.monthlyChart = new Chart(this.$refs.monthlySessionsChart, {
                    type: "bar",
                    data: {
                        labels: this.analytics.monthly_sessions_last_12_months.map(
                            (d) => d.label,
                        ),
                        datasets: [
                            {
                                label: "Data Volume",
                                data: this.analytics.monthly_sessions_last_12_months.map(
                                    (d) => d.sessions,
                                ),
                                backgroundColor: "#ef4444",
                                borderRadius: 10,
                            },
                        ],
                    },
                    options: sharedOptions,
                });
            }

            // User Stats Doughnut
            if (this.$refs.userStatsChart) {
                if (this.userStatsChart) this.userStatsChart.destroy();
                this.userStatsChart = new Chart(this.$refs.userStatsChart, {
                    type: "doughnut",
                    data: {
                        labels: ["Regular", "Authority", "Latent"],
                        datasets: [
                            {
                                data: [
                                    this.analytics.user_stats.regular_users,
                                    this.analytics.user_stats.admin_users,
                                    this.analytics.user_stats.disabled_users,
                                ],
                                backgroundColor: ["#3b82f6", "#ef4444", "#111"],
                                borderColor: "rgba(255,255,255,0.1)",
                                borderWidth: 2,
                            },
                        ],
                    },
                    options: {
                        ...sharedOptions,
                        scales: {
                            x: { display: false },
                            y: { display: false },
                        },
                    },
                });
            }

            // Radar Chart
            if (this.$refs.userStatusChart) {
                if (this.userStatusChart) this.userStatusChart.destroy();
                this.userStatusChart = new Chart(this.$refs.userStatusChart, {
                    type: "radar",
                    data: {
                        labels: [
                            "Active",
                            "Latent",
                            "Authority",
                            "Entities",
                            "Global",
                        ],
                        datasets: [
                            {
                                label: "Status Spectrum",
                                data: [
                                    this.analytics.user_stats.active_users,
                                    this.analytics.user_stats.disabled_users,
                                    this.analytics.user_stats.admin_users,
                                    this.analytics.user_stats.regular_users,
                                    this.analytics.user_stats.total_users,
                                ],
                                borderColor: "#ef4444",
                                backgroundColor: "rgba(239, 68, 68, 0.2)",
                            },
                        ],
                    },
                    options: {
                        ...sharedOptions,
                        scales: {
                            r: {
                                grid: { color: "rgba(255,255,255,0.1)" },
                                angleLines: { color: "rgba(255,255,255,0.1)" },
                                pointLabels: {
                                    color: "#6a7280",
                                    font: { family: "Space Grotesk" },
                                },
                                ticks: {
                                    display: false,
                                    backdropColor: "transparent",
                                },
                            },
                            x: { display: false },
                            y: { display: false },
                        },
                    },
                });
            }
        },
        destroyCharts() {
            [
                this.dailyChart,
                this.monthlyChart,
                this.userStatsChart,
                this.userStatusChart,
            ].forEach((c) => c?.destroy());
        },
        async handleLogout() {
            try {
                await axios.post("/api/logout");
                this.$router.push("/login");
            } catch (error) {
                this.$router.push("/login");
            }
        },
        handleClickOutside(event) {
            if (!event.target.closest(".relative"))
                this.showProfileDropdown = false;
        },
    },
};
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap");

.font-sans {
    font-family: "Space Grotesk", sans-serif;
}

.reveal-section {
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.6s cubic-bezier(0.2, 0.8, 0.2, 1);
}

.reveal-section.active {
    opacity: 1;
    transform: translateY(0);
}

.dropdown-enter-active,
.dropdown-leave-active {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.dropdown-enter-from,
.dropdown-leave-to {
    opacity: 0;
    transform: translateY(-10px);
}

.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(239, 68, 68, 0.2);
    border-radius: 10px;
}
</style>

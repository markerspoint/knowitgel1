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

            <!-- Header -->
            <div
                class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-8 reveal-section active"
            >
                <div>
                    <h2
                        class="text-red-500 font-mono tracking-[0.3em] text-xs mb-3 uppercase"
                    >
                        Cognitive Calibration
                    </h2>
                    <h1
                        class="text-4xl md:text-5xl font-black text-white tracking-tighter uppercase"
                    >
                        Assessment
                        <span
                            class="text-transparent bg-clip-text bg-linear-to-r from-red-500 to-red-600"
                            >Logic</span
                        >
                    </h1>
                </div>
                <button
                    @click="showAddQuestionModal = true"
                    class="px-8 py-4 bg-red-500 text-white font-black rounded-xl hover:bg-red-600 transition-all shadow-[0_15px_30px_rgba(239,68,68,0.2)] uppercase tracking-widest text-xs flex items-center group"
                >
                    <i
                        class="fas fa-plus mr-3 group-hover:rotate-90 transition-transform"
                    ></i
                    >Add Logic Module
                </button>
            </div>

            <!-- Logic Table Container -->
            <div
                class="reveal-section active bg-white/5 border border-white/10 rounded-3xl overflow-hidden shadow-2xl"
            >
                <div
                    class="p-8 border-b border-white/5 bg-white/[0.02] flex items-center justify-between"
                >
                    <span
                        class="text-xs font-black text-white uppercase tracking-widest"
                        >Active Logic Chains</span
                    >
                    <span class="text-[10px] font-mono text-gray-600 uppercase"
                        >{{ assessmentQuestions.length }} Protocols
                        Authenticated</span
                    >
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-white/5 border-b border-white/5 text-[10px] font-black text-gray-500 uppercase tracking-widest"
                            >
                                <th class="px-8 py-5">Visual Key</th>
                                <th class="px-8 py-5">Query String</th>
                                <th class="px-8 py-5">Response Key</th>
                                <th class="px-8 py-5">Status</th>
                                <th class="px-8 py-5 text-right">Operations</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            <tr
                                v-for="q in assessmentQuestions"
                                :key="q.id"
                                class="hover:bg-white/[0.03] transition-colors group"
                            >
                                <td class="px-8 py-6">
                                    <div
                                        class="w-20 h-20 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center overflow-hidden group-hover:border-red-500/50 transition-all"
                                    >
                                        <img
                                            v-if="q.game_file"
                                            :src="q.game_file"
                                            :alt="q.title"
                                            class="w-full h-full object-cover"
                                        />
                                        <div
                                            v-else
                                            class="text-[10px] font-black text-gray-600 uppercase"
                                        >
                                            Empty
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="space-y-1">
                                        <p
                                            class="text-sm font-bold text-white uppercase tracking-tight"
                                        >
                                            {{ q.title }}
                                        </p>
                                        <p
                                            class="text-[10px] text-gray-500 uppercase tracking-widest font-mono leading-relaxed"
                                        >
                                            {{ truncate(q.question, 60) }}
                                        </p>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div
                                        class="p-2 bg-red-500/5 rounded-lg border border-red-500/10"
                                    >
                                        <p
                                            class="text-[10px] font-black text-red-500 uppercase tracking-widest mb-1"
                                        >
                                            Pass-Key
                                        </p>
                                        <p
                                            class="text-xs font-mono font-bold text-white"
                                        >
                                            {{ q.answer }}
                                        </p>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <span
                                        :class="[
                                            'px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest',
                                            q.status === 'active'
                                                ? 'bg-green-500/10 text-green-500'
                                                : 'bg-red-500/10 text-red-500',
                                        ]"
                                    >
                                        {{ q.status }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div
                                        class="flex items-center justify-end space-x-2"
                                    >
                                        <button
                                            @click="editQuestion(q)"
                                            class="w-10 h-10 rounded-xl bg-blue-500/10 text-blue-500 hover:bg-blue-500 hover:text-white transition-all flex items-center justify-center"
                                        >
                                            <i class="fas fa-edit text-xs"></i>
                                        </button>
                                        <button
                                            @click="deleteQuestion(q)"
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

        <!-- Modals -->
        <transition name="fade">
            <div
                v-if="showAddQuestionModal"
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
                                New Logic Protocol
                            </h3>
                            <p
                                class="text-[10px] font-mono text-gray-500 uppercase tracking-widest mt-1"
                            >
                                Assessment Calibration Entry
                            </p>
                        </div>
                        <button
                            @click="showAddQuestionModal = false"
                            class="w-10 h-10 rounded-xl hover:bg-white/5 text-gray-500 hover:text-white transition-all"
                        >
                            &times;
                        </button>
                    </div>
                    <form
                        @submit.prevent="submitQuestion"
                        class="p-8 overflow-y-auto custom-scrollbar space-y-8"
                    >
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="space-y-1.5">
                                <label
                                    class="text-[10px] font-black text-gray-500 uppercase tracking-widest"
                                    >Protocol ID Label</label
                                >
                                <input
                                    type="text"
                                    v-model="questionForm.title"
                                    required
                                    placeholder="Question Title"
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
                                    v-model="questionForm.answer"
                                    required
                                    placeholder="Correct Answer"
                                    class="w-full bg-red-500/5 border border-red-500/10 rounded-xl px-4 py-3 text-red-500 focus:outline-none focus:border-red-500/50 transition-all font-black"
                                />
                            </div>
                        </div>
                        <div class="space-y-1.5">
                            <label
                                class="text-[10px] font-black text-gray-500 uppercase tracking-widest"
                                >Logic Query Output</label
                            >
                            <textarea
                                v-model="questionForm.question"
                                required
                                placeholder="The actual query string..."
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-red-500/50 transition-all font-medium h-24 resize-none"
                            ></textarea>
                        </div>
                        <div class="space-y-1.5">
                            <label
                                class="text-[10px] font-black text-gray-500 uppercase tracking-widest"
                                >Calibration Options (CSV Tokens)</label
                            >
                            <input
                                type="text"
                                v-model="questionForm.options"
                                required
                                placeholder="Token A, Token B, Token C..."
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-red-500/50 transition-all font-bold text-xs uppercase tracking-widest"
                            />
                        </div>
                        <div class="grid md:grid-cols-2 gap-6 items-end">
                            <div class="space-y-1.5">
                                <label
                                    class="text-[10px] font-black text-gray-500 uppercase tracking-widest"
                                    >Visual Logic Key (Image)</label
                                >
                                <div class="relative group/file">
                                    <input
                                        type="file"
                                        ref="fileInput"
                                        @change="handleImageChange"
                                        accept="image/*"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                    />
                                    <div
                                        class="w-full bg-white/5 border border-dashed border-white/10 rounded-xl px-4 py-6 text-center group-hover/file:border-red-500/50 transition-all"
                                    >
                                        <i
                                            class="fas fa-microchip text-2xl text-gray-600 mb-2"
                                        ></i>
                                        <p
                                            class="text-[10px] font-bold text-gray-500 uppercase tracking-widest"
                                        >
                                            {{
                                                questionForm.game_file
                                                    ? questionForm.game_file
                                                          .name
                                                    : "Upload Identity Matrix"
                                            }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-1.5">
                                <label
                                    class="text-[10px] font-black text-gray-500 uppercase tracking-widest"
                                    >Link Presence</label
                                >
                                <select
                                    v-model="questionForm.status"
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
                                @click="showAddQuestionModal = false"
                                class="px-8 py-3 bg-white/5 text-gray-500 font-black rounded-xl hover:text-white hover:bg-white/10 transition-all uppercase text-[10px] tracking-widest"
                            >
                                Abort
                            </button>
                            <button
                                type="submit"
                                class="px-10 py-3 bg-red-500 text-white font-black rounded-xl hover:bg-red-600 transition-all shadow-[0_15px_30px_rgba(239,68,68,0.2)] uppercase text-[10px] tracking-widest"
                            >
                                Sync Logic
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </transition>

        <transition name="fade">
            <div
                v-if="showEditQuestionModal && editingQuestion"
                class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-black/80 backdrop-blur-md"
            >
                <div
                    class="bg-[#181818] border border-white/10 rounded-3xl shadow-2xl w-full max-w-2xl overflow-hidden flex flex-col max-h-[90vh]"
                >
                    <!-- Same style as Add modal, updated for Edit -->
                    <div
                        class="p-8 border-b border-white/5 bg-white/[0.02] flex items-center justify-between"
                    >
                        <div>
                            <h3
                                class="text-xl font-black text-white uppercase tracking-tighter"
                            >
                                Patch Logic Protocol
                            </h3>
                            <p
                                class="text-[10px] font-mono text-gray-500 uppercase tracking-widest mt-1"
                            >
                                #{{ editingQuestion.id }} Registry Update
                            </p>
                        </div>
                        <button
                            @click="showEditQuestionModal = false"
                            class="w-10 h-10 rounded-xl hover:bg-white/5 text-gray-500 hover:text-white transition-all"
                        >
                            &times;
                        </button>
                    </div>
                    <form
                        @submit.prevent="updateQuestion"
                        class="p-8 overflow-y-auto custom-scrollbar space-y-8"
                    >
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="space-y-1.5">
                                <label
                                    class="text-[10px] font-black text-gray-500 uppercase tracking-widest"
                                    >Protocol ID Label</label
                                >
                                <input
                                    type="text"
                                    v-model="editingQuestion.title"
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
                                    v-model="editingQuestion.answer"
                                    required
                                    class="w-full bg-red-500/5 border border-red-500/10 rounded-xl px-4 py-3 text-red-500 focus:outline-none focus:border-red-500/50 transition-all font-black"
                                />
                            </div>
                        </div>
                        <div class="space-y-1.5">
                            <label
                                class="text-[10px] font-black text-gray-500 uppercase tracking-widest"
                                >Logic Query Output</label
                            >
                            <textarea
                                v-model="editingQuestion.question"
                                required
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-red-500/50 transition-all font-medium h-24 resize-none"
                            ></textarea>
                        </div>
                        <div class="space-y-1.5">
                            <label
                                class="text-[10px] font-black text-gray-500 uppercase tracking-widest"
                                >Calibration Tokens</label
                            >
                            <input
                                type="text"
                                v-model="editingQuestion.optionsText"
                                required
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-red-500/50 transition-all font-bold text-xs uppercase tracking-widest"
                            />
                        </div>
                        <div class="grid md:grid-cols-2 gap-6 items-start">
                            <div class="space-y-4">
                                <label
                                    class="text-[10px] font-black text-gray-500 uppercase tracking-widest"
                                    >Update Identity Matrix</label
                                >
                                <div class="relative group/file">
                                    <input
                                        type="file"
                                        @change="handleEditImageChange"
                                        accept="image/*"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                    />
                                    <div
                                        class="w-full bg-white/5 border border-dashed border-white/10 rounded-xl px-4 py-5 text-center group-hover/file:border-red-500/50 transition-all"
                                    >
                                        <p
                                            class="text-[10px] font-bold text-gray-500 uppercase"
                                        >
                                            Change Image System
                                        </p>
                                    </div>
                                </div>
                                <div
                                    v-if="editingQuestion.game_file"
                                    class="w-32 h-32 rounded-xl border border-white/10 overflow-hidden bg-white/5"
                                >
                                    <img
                                        :src="editingQuestion.game_file"
                                        class="w-full h-full object-cover"
                                    />
                                </div>
                            </div>
                            <div class="space-y-1.5">
                                <label
                                    class="text-[10px] font-black text-gray-500 uppercase tracking-widest"
                                    >Current Presence Status</label
                                >
                                <select
                                    v-model="editingQuestion.status"
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
                                @click="showEditQuestionModal = false"
                                class="px-8 py-3 bg-white/5 text-gray-500 font-black rounded-xl hover:text-white hover:bg-white/10 transition-all uppercase text-[10px] tracking-widest"
                            >
                                Abort Patch
                            </button>
                            <button
                                type="submit"
                                class="px-10 py-3 bg-blue-500 text-white font-black rounded-xl hover:bg-blue-600 transition-all shadow-[0_15px_30px_rgba(59,130,246,0.2)] uppercase text-[10px] tracking-widest"
                            >
                                Execute Revision
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

export default {
    name: "AdminAssessment",
    data() {
        return {
            user: null,
            assessmentQuestions: [],
            message: "",
            messageType: "success",
            showAddQuestionModal: false,
            showEditQuestionModal: false,
            editingQuestion: null,
            showProfileDropdown: false,
            questionForm: {
                title: "",
                description: "",
                question: "",
                answer: "",
                options: "",
                status: "active",
                game_file: null,
            },
            editImageFile: null,
        };
    },
    async mounted() {
        await this.fetchUser();
        await this.fetchAssessmentQuestions();
        document.addEventListener("click", this.handleClickOutside);
    },
    beforeUnmount() {
        document.removeEventListener("click", this.handleClickOutside);
    },
    methods: {
        async fetchUser() {
            try {
                const response = await axios.get("/api/user");
                if (response.data.status === "success")
                    this.user = response.data.user;
            } catch (error) {
                console.error("Identity fetch fault:", error);
            }
        },
        async fetchAssessmentQuestions() {
            try {
                const response = await axios.get(
                    "/api/admin/assessment/questions",
                );
                this.assessmentQuestions = response.data.questions || [];
            } catch (error) {
                this.showMessage(
                    "Failed to retrieve logic protocols.",
                    "error",
                );
            }
        },
        async submitQuestion() {
            try {
                const formData = new FormData();
                Object.keys(this.questionForm).forEach((k) =>
                    formData.append(k, this.questionForm[k]),
                );
                formData.append("type", "guess_part");

                await axios.post("/api/admin/assessment/questions", formData);
                this.showAddQuestionModal = false;
                this.resetQuestionForm();
                await this.fetchAssessmentQuestions();
                this.showMessage(
                    "Logic protocol successfully synchronised.",
                    "success",
                );
            } catch (error) {
                this.showMessage("Sync rejection: Integrity breach.", "error");
            }
        },
        async updateQuestion() {
            try {
                const formData = new FormData();
                formData.append("title", this.editingQuestion.title);
                formData.append(
                    "description",
                    this.editingQuestion.description,
                );
                formData.append("question", this.editingQuestion.question);
                formData.append("answer", this.editingQuestion.answer);
                formData.append("options", this.editingQuestion.optionsText);
                formData.append("status", this.editingQuestion.status);
                formData.append("_method", "PUT");
                if (this.editImageFile)
                    formData.append("game_file", this.editImageFile);

                await axios.post(
                    `/api/admin/assessment/questions/${this.editingQuestion.id}`,
                    formData,
                );
                this.showEditQuestionModal = false;
                this.editingQuestion = null;
                await this.fetchAssessmentQuestions();
                this.showMessage(
                    "Protocol revision committed to registry.",
                    "success",
                );
            } catch (error) {
                this.showMessage("Revision failure: Access denied.", "error");
            }
        },
        editQuestion(question) {
            this.editingQuestion = {
                ...question,
                optionsText: this.getOptionsAsString(question.options),
            };
            this.editImageFile = null;
            this.showEditQuestionModal = true;
        },
        async deleteQuestion(question) {
            if (
                !confirm(
                    "Decommission this assessment logic module? This will break cognitive sync chains.",
                )
            )
                return;
            try {
                await axios.delete(
                    `/api/admin/assessment/questions/${question.id}`,
                );
                this.assessmentQuestions = this.assessmentQuestions.filter(
                    (q) => q.id !== question.id,
                );
                this.showMessage("Logic protocol decommissioned.", "success");
            } catch (error) {
                this.showMessage("Decommission failure: Logic vital.", "error");
            }
        },
        handleImageChange(event) {
            this.questionForm.game_file = event.target.files[0];
        },
        handleEditImageChange(event) {
            this.editImageFile = event.target.files[0];
        },
        resetQuestionForm() {
            this.questionForm = {
                title: "",
                description: "",
                question: "",
                answer: "",
                options: "",
                status: "active",
                game_file: null,
            };
            if (this.$refs.fileInput) this.$refs.fileInput.value = "";
        },
        getOptionsAsString(options) {
            if (!options) return "";
            const opts =
                typeof options === "string"
                    ? JSON.parse(options || "[]")
                    : options;
            return Array.isArray(opts) ? opts.join(", ") : "";
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

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
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

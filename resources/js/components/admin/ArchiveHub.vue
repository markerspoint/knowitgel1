<template>
    <div class="space-y-12">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h3
                    class="text-sm font-black text-white uppercase tracking-widest mb-2 flex items-center"
                >
                    <i class="fas fa-archive mr-3 text-red-500"></i>Knowledge
                    Repository
                </h3>
                <p class="text-[10px] font-mono text-gray-500 uppercase">
                    Centralized Archive Management Terminal
                </p>
            </div>
            <button
                @click="openCreateModal"
                class="px-6 py-3 bg-red-500 text-white font-black rounded-xl hover:bg-red-600 transition-all shadow-[0_10px_20px_rgba(239,68,68,0.2)] uppercase tracking-widest text-[10px]"
            >
                <i class="fas fa-plus-circle mr-2"></i>Initialize Archive
            </button>
        </div>

        <!-- Archive Index -->
        <div
            class="bg-white/5 border border-white/10 rounded-3xl overflow-hidden shadow-2xl"
        >
            <div
                class="p-8 border-b border-white/5 bg-white/2 flex items-center justify-between"
            >
                <span
                    class="text-xs font-black text-white uppercase tracking-widest"
                    >Archive Records</span
                >
                <span class="text-[10px] font-mono text-gray-600 uppercase"
                    >{{ lessons.length }} Sectors Synchronized</span
                >
            </div>
            <div
                class="overflow-x-auto custom-scrollbar max-h-[600px] overflow-y-auto"
            >
                <table class="w-full text-left">
                    <thead class="sticky top-0 bg-[#161616] z-10">
                        <tr
                            class="border-b border-white/5 text-[10px] font-black text-gray-500 uppercase tracking-widest"
                        >
                            <th class="px-8 py-5">Protocol Title</th>
                            <th class="px-8 py-5">Status</th>
                            <th class="px-8 py-5">Last Link</th>
                            <th class="px-8 py-5 text-right">Operations</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        <tr
                            v-for="lesson in lessons"
                            :key="lesson.id"
                            class="hover:bg-white/3 transition-colors group"
                        >
                            <td class="px-8 py-6">
                                <h4
                                    class="text-sm font-bold text-white uppercase tracking-tight mb-1"
                                >
                                    {{ lesson.title }}
                                </h4>
                                <p
                                    class="text-[10px] text-gray-500 line-clamp-1 max-w-sm uppercase font-mono"
                                >
                                    {{ lesson.description }}
                                </p>
                            </td>
                            <td class="px-8 py-6">
                                <span
                                    :class="[
                                        'px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest',
                                        lesson.status === 'active'
                                            ? 'bg-green-500/10 text-green-500'
                                            : 'bg-red-500/10 text-red-500',
                                    ]"
                                >
                                    {{ lesson.status }}
                                </span>
                            </td>
                            <td
                                class="px-8 py-6 text-[10px] font-mono text-gray-600"
                            >
                                {{ formatDate(lesson.updated_at) }}
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div
                                    class="flex items-center justify-end space-x-2"
                                >
                                    <button
                                        @click="editStudy(lesson)"
                                        class="w-8 h-8 rounded-lg bg-blue-500/10 text-blue-500 hover:bg-blue-500 hover:text-white transition-all flex items-center justify-center"
                                    >
                                        <i class="fas fa-edit text-xs"></i>
                                    </button>
                                    <button
                                        @click="confirmDeleteStudy(lesson)"
                                        class="w-8 h-8 rounded-lg bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white transition-all flex items-center justify-center"
                                    >
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div
                    v-if="!lessons.length"
                    class="text-center py-20 opacity-20"
                >
                    <i class="fas fa-book-open text-5xl mb-4 text-red-500"></i>
                    <p
                        class="text-xs font-black uppercase tracking-widest font-mono"
                    >
                        Archive Empty
                    </p>
                </div>
            </div>
        </div>

        <!-- Edit/Create Modal -->
        <transition name="fade">
            <div
                v-if="showEditModal"
                class="fixed inset-0 z-100 flex items-center justify-center p-6 bg-black/80 backdrop-blur-md"
            >
                <div
                    class="bg-[#181818] border border-white/10 rounded-3xl shadow-2xl w-full max-w-4xl overflow-hidden flex flex-col max-h-[90vh]"
                >
                    <div
                        class="p-8 border-b border-white/5 bg-white/2 flex items-center justify-between"
                    >
                        <div>
                            <h3
                                class="text-xl font-black text-white uppercase tracking-tighter"
                            >
                                {{
                                    editingStudy
                                        ? "Archive Revision Protocol"
                                        : "Knowledge Archive Link"
                                }}
                            </h3>
                            <p
                                class="text-[10px] font-mono text-gray-500 uppercase tracking-widest mt-1"
                            >
                                System Channel Encryption Active
                            </p>
                        </div>
                        <button
                            @click="closeEditModal"
                            class="w-10 h-10 rounded-xl hover:bg-white/5 text-gray-500 hover:text-white transition-all"
                        >
                            &times;
                        </button>
                    </div>
                    <form
                        @submit.prevent="
                            editingStudy ? updateStudy() : submitStudy()
                        "
                        class="p-8 overflow-y-auto custom-scrollbar"
                    >
                        <div class="space-y-6">
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label
                                        class="text-[10px] font-black text-gray-400 uppercase tracking-widest"
                                        >Protocol Title</label
                                    >
                                    <input
                                        type="text"
                                        v-model="studyForm.title"
                                        required
                                        placeholder="Lesson Heading"
                                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-4 text-white focus:outline-none focus:border-red-500/50 transition-all font-bold text-sm"
                                    />
                                </div>
                                <div class="space-y-2">
                                    <label
                                        class="text-[10px] font-black text-gray-400 uppercase tracking-widest"
                                        >Meta Description</label
                                    >
                                    <input
                                        type="text"
                                        v-model="studyForm.description"
                                        placeholder="Short Summary"
                                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-4 text-gray-300 focus:outline-none focus:border-red-500/50 transition-all font-medium text-sm"
                                    />
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label
                                    class="text-[10px] font-black text-gray-400 uppercase tracking-widest"
                                    >Central Knowledge Buffer</label
                                >
                                <textarea
                                    v-model="studyForm.content"
                                    required
                                    placeholder="Enter full archive materials (Markdown supported)..."
                                    class="w-full bg-white/2 border border-white/10 rounded-2xl px-6 py-6 text-gray-300 focus:outline-none focus:border-red-500/50 transition-all font-mono text-sm h-[200px] leading-relaxed resize-none custom-scrollbar"
                                ></textarea>
                            </div>

                            <div
                                class="flex items-center justify-between pt-6 border-t border-white/5"
                            >
                                <div class="space-y-2">
                                    <label
                                        class="text-[10px] font-black text-gray-400 uppercase tracking-widest"
                                        >Sync Status</label
                                    >
                                    <select
                                        v-model="studyForm.status"
                                        class="block bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-xs font-bold uppercase text-gray-400 focus:outline-none"
                                    >
                                        <option value="active">
                                            Active Sync
                                        </option>
                                        <option value="inactive">
                                            Latent Protocol
                                        </option>
                                    </select>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <button
                                        type="button"
                                        @click="closeEditModal"
                                        class="px-8 py-3 bg-white/5 text-gray-500 font-black rounded-xl hover:text-white hover:bg-white/10 transition-all uppercase text-[10px] tracking-widest"
                                    >
                                        Abort
                                    </button>
                                    <button
                                        type="submit"
                                        :disabled="isSubmittingStudy"
                                        class="px-10 py-3 bg-red-500 text-white font-black rounded-xl hover:bg-red-600 transition-all shadow-[0_10px_20px_rgba(239,68,68,0.2)] uppercase text-[10px] tracking-widest"
                                    >
                                        <span v-if="!isSubmittingStudy">{{
                                            editingStudy
                                                ? "Apply Sync Revision"
                                                : "Broadcast Archive"
                                        }}</span>
                                        <span v-else
                                            ><i
                                                class="fas fa-sync-alt fa-spin"
                                            ></i
                                        ></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </transition>

        <!-- Delete Confirmation Modal -->
        <transition name="fade">
            <div
                v-if="showDeleteModal"
                class="fixed inset-0 z-110 flex items-center justify-center p-6 bg-black/95 backdrop-blur-xl"
            >
                <div
                    class="bg-[#111111] border border-red-500/20 rounded-3xl shadow-2xl w-full max-w-md overflow-hidden relative"
                >
                    <div class="p-10 text-center">
                        <div
                            class="w-20 h-20 bg-red-500/10 rounded-2xl flex items-center justify-center mx-auto mb-8 border border-red-500/20"
                        >
                            <i
                                class="fas fa-trash-alt text-3xl text-red-500"
                            ></i>
                        </div>
                        <h3
                            class="text-2xl font-black text-white uppercase tracking-tighter mb-4"
                        >
                            Confirm Decommission
                        </h3>
                        <p
                            class="text-sm text-gray-500 leading-relaxed mb-10 font-medium"
                        >
                            Are you certain you want to purge
                            <span class="text-white font-black">{{
                                studyToDelete?.title
                            }}</span>
                            from the central archives? This action is
                            irreversible.
                        </p>
                        <div class="grid grid-cols-2 gap-4">
                            <button
                                @click="showDeleteModal = false"
                                class="py-4 px-6 bg-white/5 text-gray-500 font-black rounded-xl hover:text-white hover:bg-white/10 transition-all uppercase text-[10px] tracking-widest"
                            >
                                Abort
                            </button>
                            <button
                                @click="executeDeleteStudy"
                                class="py-4 px-6 bg-red-500 text-white font-black rounded-xl hover:bg-red-600 transition-all shadow-[0_15px_30px_rgba(239,68,68,0.3)] uppercase text-[10px] tracking-widest"
                            >
                                Execute Purge
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "ArchiveHub",
    props: {
        lessons: { type: Array, required: true },
    },
    data() {
        return {
            studyForm: {
                title: "",
                description: "",
                content: "",
                status: "active",
            },
            isSubmittingStudy: false,
            editingStudy: null,
            showEditModal: false,
            showDeleteModal: false,
            studyToDelete: null,
        };
    },
    methods: {
        formatDate(date) {
            if (!date) return "Latent";
            return new Date(date).toLocaleDateString("en-US", {
                year: "numeric",
                month: "short",
                day: "numeric",
            });
        },
        openCreateModal() {
            this.editingStudy = null;
            this.studyForm = {
                title: "",
                description: "",
                content: "",
                status: "active",
            };
            this.showEditModal = true;
        },
        closeEditModal() {
            this.showEditModal = false;
            this.editingStudy = null;
        },
        async submitStudy() {
            try {
                this.isSubmittingStudy = true;
                const formData = new FormData();
                Object.keys(this.studyForm).forEach((k) =>
                    formData.append(k, this.studyForm[k]),
                );
                await axios.post("/api/admin/lessons", formData);
                this.$emit(
                    "message",
                    "Archive broadcast successful.",
                    "success",
                );
                this.closeEditModal();
                this.$emit("refresh");
            } catch (error) {
                this.$emit(
                    "message",
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
            this.showEditModal = true;
        },
        async updateStudy() {
            try {
                this.isSubmittingStudy = true;
                await axios.put(
                    `/api/admin/lessons/${this.editingStudy.id}`,
                    this.studyForm,
                );
                this.$emit("message", "Archive revision committed.", "success");
                this.closeEditModal();
                this.$emit("refresh");
            } catch (error) {
                this.$emit(
                    "message",
                    "Revision failure: Access denied to block.",
                    "error",
                );
            } finally {
                this.isSubmittingStudy = false;
            }
        },
        confirmDeleteStudy(lesson) {
            this.studyToDelete = lesson;
            this.showDeleteModal = true;
        },
        async executeDeleteStudy() {
            try {
                await axios.delete(
                    `/api/admin/lessons/${this.studyToDelete.id}`,
                );
                this.$emit(
                    "message",
                    "Archive decommissioning complete.",
                    "success",
                );
                this.showDeleteModal = false;
                this.$emit("refresh");
            } catch (error) {
                this.$emit(
                    "message",
                    "Decommission failure: Block integrity vital.",
                    "error",
                );
            }
        },
    },
};
</script>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
    width: 0px;
}

.custom-scrollbar {
    scrollbar-width: none;
    -ms-overflow-style: none;
}

.custom-scrollbar:hover::-webkit-scrollbar {
    width: 3px;
}

.custom-scrollbar:hover::-webkit-scrollbar-thumb {
    background: rgba(239, 68, 68, 0.3);
    border-radius: 10px;
}
</style>

<template>
    <div class="space-y-12">
        <div
            class="bg-white/5 border border-white/10 rounded-3xl overflow-hidden shadow-2xl relative"
        >
            <!-- Decorative Background Element -->
            <div
                class="absolute top-0 right-0 p-12 opacity-5 pointer-events-none"
            >
                <i class="fas fa-book-open text-[120px] rotate-12"></i>
            </div>

            <div
                class="p-8 border-b border-white/5 bg-white/2 flex items-center justify-between relative z-10"
            >
                <div>
                    <h2
                        class="text-2xl font-black text-white uppercase tracking-tighter"
                    >
                        Study Library
                    </h2>
                    <p
                        class="text-[10px] font-mono text-gray-500 uppercase tracking-widest mt-1"
                    >
                        Manage lessons and study materials
                    </p>
                </div>
                <button
                    @click="openCreateModal"
                    class="px-6 py-3 bg-red-500 text-white font-black rounded-xl hover:bg-red-600 transition-all shadow-[0_15px_30px_rgba(239,68,68,0.2)] flex items-center space-x-3 uppercase text-[10px] tracking-widest"
                >
                    <i class="fas fa-plus"></i>
                    <span>Add Lesson</span>
                </button>
            </div>

            <div class="overflow-x-auto custom-scrollbar relative z-10">
                <table class="w-full text-left">
                    <thead>
                        <tr
                            class="bg-white/5 border-b border-white/5 text-[10px] font-black text-gray-400 uppercase tracking-widest"
                        >
                            <th class="px-8 py-5">Lesson</th>
                            <th class="px-8 py-5">Summary</th>
                            <th class="px-8 py-5">Date</th>
                            <th class="px-8 py-5">Status</th>
                            <th class="px-8 py-5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        <tr
                            v-for="lesson in lessons"
                            :key="lesson.id"
                            class="hover:bg-white/3 transition-colors group"
                        >
                            <td class="px-8 py-6">
                                <div class="flex items-center space-x-4">
                                    <div
                                        class="w-12 h-12 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center overflow-hidden shrink-0"
                                    >
                                        <img
                                            v-if="lesson.thumbnail"
                                            :src="'/' + lesson.thumbnail"
                                            @error="
                                                (e) =>
                                                    (e.target.src =
                                                        '/thumbnails/default-thumbnail.png')
                                            "
                                            class="w-full h-full object-cover"
                                        />
                                        <i
                                            v-else
                                            class="fas fa-microchip text-red-500/20 text-xl"
                                        ></i>
                                    </div>
                                    <span
                                        class="text-sm font-bold text-white uppercase tracking-tight"
                                        >{{ lesson.title }}</span
                                    >
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <p class="text-[10px] text-gray-500 font-mono">
                                    {{
                                        lesson.description ||
                                        "No summary"
                                    }}
                                </p>
                            </td>
                            <td class="px-8 py-6">
                                <span class="text-xs font-mono text-gray-400">{{
                                    formatDate(lesson.created_at)
                                }}</span>
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
                            <td class="px-8 py-6 text-right">
                                <div
                                    class="flex items-center justify-end space-x-2"
                                >
                                    <button
                                        @click="editStudy(lesson)"
                                        class="w-10 h-10 rounded-xl bg-blue-500/10 text-blue-500 hover:bg-blue-500 hover:text-white transition-all flex items-center justify-center"
                                    >
                                        <i class="fas fa-edit text-xs"></i>
                                    </button>
                                    <button
                                        @click="confirmDeleteStudy(lesson)"
                                        class="w-10 h-10 rounded-xl bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white transition-all flex items-center justify-center"
                                    >
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div
                    v-if="lessons.length === 0"
                    class="text-center py-20 opacity-20"
                >
                    <i class="fas fa-book-open text-5xl mb-4 text-red-500"></i>
                    <p
                        class="text-xs font-black uppercase tracking-widest font-mono"
                    >
                        No lessons yet
                    </p>
                </div>
            </div>
        </div>

        <!-- Edit/Create Modal -->
        <Teleport to="body">
        <transition name="fade">
            <div
                v-if="showEditModal"
                class="fixed inset-0 z-[9999] flex items-center justify-center p-4 md:p-6 bg-black/85 backdrop-blur-md overflow-y-auto"
            >
                <div
                    class="relative bg-[#181818] border border-white/10 rounded-3xl shadow-2xl w-full max-w-4xl overflow-hidden flex flex-col max-h-[calc(100vh-2rem)] md:max-h-[90vh] my-auto"
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
                                        ? "Edit Lesson"
                                        : "Add Lesson"
                                }}
                            </h3>
                            <p
                                class="text-[10px] font-mono text-gray-500 uppercase tracking-widest mt-1"
                            >
                                Update lesson details
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
                        class="flex flex-col min-h-0 flex-1"
                    >
                        <div
                            class="p-8 overflow-y-auto custom-scrollbar flex-1 min-h-0"
                        >
                            <div class="space-y-6">
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label
                                        class="text-[10px] font-black text-gray-400 uppercase tracking-widest"
                                        >Lesson Title</label
                                    >
                                    <input
                                        type="text"
                                        v-model="studyForm.title"
                                        required
                                        placeholder="Lesson title"
                                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-4 text-white focus:outline-none focus:border-red-500/50 transition-all font-bold text-sm"
                                    />
                                </div>
                                <div class="space-y-2">
                                    <label
                                        class="text-[10px] font-black text-gray-400 uppercase tracking-widest"
                                        >Description</label
                                    >
                                    <input
                                        type="text"
                                        v-model="studyForm.description"
                                        placeholder="Short summary (optional)"
                                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-4 text-gray-300 focus:outline-none focus:border-red-500/50 transition-all font-medium text-sm"
                                    />
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-6 items-start">
                                <div class="space-y-2">
                                    <label
                                        class="text-[10px] font-black text-gray-400 uppercase tracking-widest"
                                        >Lesson Content</label
                                    >
                                    <textarea
                                        v-model="studyForm.content"
                                        required
                                        placeholder="Enter lesson content (Markdown supported)..."
                                        class="w-full bg-white/2 border border-white/10 rounded-2xl px-6 py-6 text-gray-300 focus:outline-none focus:border-red-500/50 transition-all font-mono text-sm h-[200px] leading-relaxed resize-none custom-scrollbar"
                                    ></textarea>
                                </div>
                                <div class="space-y-4">
                                    <label
                                        class="text-[10px] font-black text-gray-400 uppercase tracking-widest"
                                        >Thumbnail</label
                                    >
                                    <div class="flex items-center space-x-4">
                                        <div
                                            class="w-16 h-16 rounded-xl bg-white/5 border border-white/10 overflow-hidden flex items-center justify-center shrink-0"
                                        >
                                            <img
                                                v-if="studyForm.preview"
                                                :src="studyForm.preview"
                                                class="w-full h-full object-cover"
                                            />
                                            <img
                                                v-else-if="
                                                    editingStudy &&
                                                    editingStudy.thumbnail
                                                "
                                                :src="
                                                    '/' + editingStudy.thumbnail
                                                "
                                                class="w-full h-full object-cover"
                                            />
                                            <i
                                                v-else
                                                class="fas fa-microchip text-gray-700 text-xl"
                                            ></i>
                                        </div>
                                        <div class="relative group/file flex-1">
                                            <input
                                                type="file"
                                                @change="handleThumbnailChange"
                                                accept="image/*"
                                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                            />
                                            <div
                                                class="w-full bg-white/5 border border-dashed border-white/10 rounded-xl px-4 py-5 text-center group-hover/file:border-red-500/50 transition-all"
                                            >
                                                <p
                                                    class="text-[10px] font-bold text-gray-500 uppercase"
                                                >
                                                    {{
                                                        studyForm.thumbnail
                                                            ? studyForm
                                                                  .thumbnail
                                                                  .name
                                                            : "Choose image"
                                                    }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="space-y-2 mt-4">
                                        <label
                                            class="text-[10px] font-black text-gray-400 uppercase tracking-widest"
                                            >Status</label
                                        >
                                        <select
                                            v-model="studyForm.status"
                                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-xs font-bold uppercase text-gray-400 focus:outline-none"
                                        >
                                            <option value="active">
                                                Active
                                            </option>
                                            <option value="inactive">
                                                Inactive
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            </div>
                        </div>
                        <div
                            class="flex items-center justify-end pt-6 px-8 pb-8 border-t border-white/5 space-x-4 shrink-0 bg-[#181818]"
                        >
                            <button
                                type="button"
                                @click="closeEditModal"
                                class="px-8 py-3 bg-white/5 text-gray-500 font-black rounded-xl hover:text-white hover:bg-white/10 transition-all uppercase text-[10px] tracking-widest"
                            >
                                Cancel
                            </button>
                            <button
                                type="submit"
                                :disabled="isSubmittingStudy"
                                class="px-10 py-3 bg-red-500 text-white font-black rounded-xl hover:bg-red-600 transition-all shadow-[0_10px_20px_rgba(239,68,68,0.2)] uppercase text-[10px] tracking-widest"
                            >
                                <span v-if="!isSubmittingStudy">{{
                                    editingStudy
                                        ? "Save Changes"
                                        : "Create Lesson"
                                }}</span>
                                <span v-else
                                    ><i class="fas fa-sync-alt fa-spin"></i
                                ></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </transition>
        </Teleport>

        <!-- Delete Confirmation Modal -->
        <Teleport to="body">
        <transition name="fade">
            <div
                v-if="showDeleteModal"
                @click.self="showDeleteModal = false"
                class="fixed inset-0 z-[10000] grid place-items-center p-4 md:p-6 bg-black/90 backdrop-blur-md"
            >
                <div
                    @click.stop
                    class="relative z-[10001] bg-[#111111] border border-red-500/20 rounded-3xl shadow-2xl w-full max-w-md overflow-hidden"
                >
                    <div class="p-10 text-center">
                        <div
                            class="w-20 h-20 bg-red-500/10 rounded-2xl flex items-center justify-center mx-auto mb-8 border border-red-500/20"
                        >
                            <i
                                class="fas fa-exclamation-triangle text-3xl text-red-500"
                            ></i>
                        </div>
                        <h3
                            class="text-2xl font-black text-white uppercase tracking-tighter mb-4"
                        >
                            Delete Lesson
                        </h3>
                        <p
                            class="text-sm text-gray-500 leading-relaxed mb-10 font-medium"
                        >
                            Are you sure you want to delete
                            <span class="text-white font-black">{{
                                studyToDelete?.title
                            }}</span
                            >? This action cannot be undone.
                        </p>
                        <div class="grid grid-cols-2 gap-4">
                            <button
                                @click="showDeleteModal = false"
                                class="py-4 px-6 bg-white/5 text-gray-500 font-black rounded-xl hover:text-white hover:bg-white/10 transition-all uppercase text-[10px] tracking-widest"
                            >
                                Cancel
                            </button>
                            <button
                                @click="executeDeleteStudy"
                                class="py-4 px-6 bg-red-500 text-white font-black rounded-xl hover:bg-red-600 transition-all shadow-[0_15px_30px_rgba(239,68,68,0.3)] uppercase text-[10px] tracking-widest"
                            >
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
        </Teleport>
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
                thumbnail: null,
                preview: null,
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
            if (!date) return "-";
            return new Date(date).toLocaleDateString("en-US", {
                year: "numeric",
                month: "short",
                day: "numeric",
            });
        },
        handleThumbnailChange(event) {
            const file = event.target.files[0];
            if (file) {
                this.studyForm.thumbnail = file;
                this.studyForm.preview = URL.createObjectURL(file);
            }
        },
        openCreateModal() {
            this.editingStudy = null;
            this.studyForm = {
                title: "",
                description: "",
                content: "",
                status: "active",
                thumbnail: null,
                preview: null,
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
                Object.keys(this.studyForm).forEach((k) => {
                    if (k !== "preview" && this.studyForm[k] !== null) {
                        formData.append(k, this.studyForm[k]);
                    }
                });

                await axios.post("/api/admin/lessons", formData, {
                    headers: { "Content-Type": "multipart/form-data" },
                });

                this.$emit(
                    "message",
                    "Lesson created successfully.",
                    "success",
                );
                this.closeEditModal();
                this.$emit("refresh");
            } catch (error) {
                let msg = "Failed to create lesson.";
                if (error.response?.data?.errors) {
                    const errors = error.response.data.errors;
                    msg = Object.values(errors).flat().join(" ");
                } else if (error.response?.data?.message) {
                    msg = error.response.data.message;
                }
                this.$emit("message", msg, "error");
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
                thumbnail: null,
                preview: null,
            };
            this.showEditModal = true;
        },
        async updateStudy() {
            try {
                this.isSubmittingStudy = true;
                const formData = new FormData();
                formData.append("title", this.studyForm.title);
                formData.append("description", this.studyForm.description);
                formData.append("content", this.studyForm.content);
                formData.append("status", this.studyForm.status);
                formData.append("_method", "PUT");

                if (this.studyForm.thumbnail) {
                    formData.append("thumbnail", this.studyForm.thumbnail);
                }

                await axios.post(
                    `/api/admin/lessons/${this.editingStudy.id}`,
                    formData,
                    {
                        headers: { "Content-Type": "multipart/form-data" },
                    },
                );

                this.$emit("message", "Lesson updated successfully.", "success");
                this.closeEditModal();
                this.$emit("refresh");
            } catch (error) {
                let msg = "Failed to update lesson.";
                if (error.response?.data?.errors) {
                    const errors = error.response.data.errors;
                    msg = Object.values(errors).flat().join(" ");
                } else if (error.response?.data?.message) {
                    msg = error.response.data.message;
                }
                this.$emit("message", msg, "error");
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
                    "Lesson deleted successfully.",
                    "success",
                );
                this.showDeleteModal = false;
                this.$emit("refresh");
            } catch (error) {
                this.$emit(
                    "message",
                    "Failed to delete lesson.",
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

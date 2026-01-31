<template>
    <div class="space-y-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Content Creator -->
            <div
                class="lg:col-span-2 bg-white/5 border border-white/10 rounded-3xl p-8"
            >
                <h3
                    class="text-sm font-black text-white uppercase tracking-widest mb-8 flex items-center"
                >
                    <i class="fas fa-pen-nib mr-3 text-amber-500"></i>Sync
                    Content Creator
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
                            >Central Knowledge Buffer (Markdown/Text)</label
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
                                <option value="active">Active Presence</option>
                                <option value="inactive">Latent Link</option>
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
                                ><i class="fas fa-circle-notch fa-spin mr-2"></i
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
                <div class="p-8 border-b border-white/5 bg-white/[0.02]">
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
                        <div class="flex items-start justify-between mb-3">
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
                                    <i class="fas fa-edit text-xs"></i>
                                </button>
                                <button
                                    @click="confirmDeleteStudy(lesson)"
                                    class="text-gray-600 hover:text-red-500 transition-colors"
                                >
                                    <i class="fas fa-trash-alt text-xs"></i>
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
                        <i class="fas fa-book-open text-5xl mb-4"></i>
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
        };
    },
    methods: {
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
                this.studyForm = {
                    title: "",
                    description: "",
                    content: "",
                    status: "active",
                };
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
                this.$emit("message", "Archive revision committed.", "success");
                this.cancelEditStudy();
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
            if (confirm(`Decommission archive "${lesson.title}"?`))
                this.deleteStudy(lesson.id);
        },
        async deleteStudy(id) {
            try {
                await axios.delete(`/api/admin/lessons/${id}`);
                this.$emit(
                    "message",
                    "Archive decommissioning complete.",
                    "success",
                );
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

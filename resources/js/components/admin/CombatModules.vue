<template>
    <div class="space-y-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Form Container -->
            <div class="lg:col-span-1 space-y-8">
                <div
                    class="bg-white/5 border border-white/10 rounded-3xl p-8 sticky top-28"
                >
                    <h3
                        class="text-sm font-black text-white uppercase tracking-widest mb-8 flex items-center"
                    >
                        <i class="fas fa-plus-circle mr-3 text-red-500"></i
                        >Inject Question
                    </h3>
                    <form
                        @submit.prevent="submitQAFPSQuestion"
                        class="space-y-6"
                    >
                        <div class="space-y-1.5">
                            <label
                                class="text-[10px] font-black text-gray-500 uppercase tracking-widest"
                                >Global Label (Auto-incremented)</label
                            >
                            <input
                                type="text"
                                v-model="qaGameForm.title"
                                required
                                placeholder="e.g. Combat Module #1"
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
                        <div class="space-y-3">
                            <label
                                class="text-[10px] font-black text-gray-500 uppercase tracking-widest"
                                >Identity Thumbnail</label
                            >
                            <div class="flex items-center space-x-4">
                                <div
                                    class="w-16 h-16 rounded-xl bg-white/5 border border-white/10 overflow-hidden flex items-center justify-center shrink-0"
                                >
                                    <img
                                        v-if="qaGameForm.preview"
                                        :src="qaGameForm.preview"
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
                                        @change="handleQAFPSThumbnailChange"
                                        accept="image/*"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                    />
                                    <div
                                        class="w-full bg-white/5 border border-dashed border-white/10 rounded-xl px-4 py-4 text-center group-hover/file:border-red-500/50 transition-all"
                                    >
                                        <p
                                            class="text-[10px] font-bold text-gray-400 uppercase tracking-widest"
                                        >
                                            {{
                                                qaGameForm.thumbnail
                                                    ? qaGameForm.thumbnail.name
                                                    : "Upload Sync Image"
                                            }}
                                        </p>
                                    </div>
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
                        class="p-8 border-b border-white/5 bg-white/2 flex items-center justify-between"
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
                    <div class="overflow-x-auto custom-scrollbar">
                        <table class="w-full text-left">
                            <thead>
                                <tr
                                    class="bg-white/5 border-b border-white/5 text-[10px] font-black text-gray-500 uppercase tracking-widest"
                                >
                                    <th class="px-8 py-5">Module Label</th>
                                    <th class="px-8 py-5">Logic Output</th>
                                    <th class="px-8 py-5">Status</th>
                                    <th class="px-8 py-5 text-right">
                                        Operations
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                <tr
                                    v-for="game in qaGames"
                                    :key="game.id"
                                    class="hover:bg-white/3 transition-colors group"
                                >
                                    <td class="px-8 py-6">
                                        <div
                                            class="flex items-center space-x-4"
                                        >
                                            <div
                                                class="w-10 h-10 rounded-lg bg-white/10 border border-white/10 flex items-center justify-center overflow-hidden"
                                            >
                                                <img
                                                    v-if="game.thumbnail"
                                                    :src="'/' + game.thumbnail"
                                                    @error="
                                                        (e) =>
                                                            (e.target.src =
                                                                '/thumbnails/default-thumbnail.png')
                                                    "
                                                    class="w-full h-full object-cover"
                                                />
                                                <div
                                                    v-else
                                                    class="w-full h-full flex items-center justify-center bg-red-500/10"
                                                >
                                                    <i
                                                        class="fas fa-microchip text-red-500/30"
                                                    ></i>
                                                </div>
                                            </div>
                                            <span
                                                class="text-sm font-bold text-white uppercase tracking-tight"
                                                >{{ game.title }}</span
                                            >
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <p
                                            class="text-xs text-gray-400 max-w-xs"
                                        >
                                            {{ truncate(game.question, 100) }}
                                        </p>
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
                                                @click="editQAGame(game)"
                                                class="w-10 h-10 rounded-xl bg-blue-500/10 text-blue-500 hover:bg-blue-500 hover:text-white transition-all flex items-center justify-center"
                                            >
                                                <i
                                                    class="fas fa-edit text-xs"
                                                ></i>
                                            </button>
                                            <button
                                                @click="
                                                    confirmDeleteQAGame(game)
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

        <!-- Edit Modal -->
        <transition name="fade">
            <div
                v-if="showEditQAModal && editingQAGame"
                class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-black/80 backdrop-blur-md"
            >
                <div
                    class="bg-[#181818] border border-white/10 rounded-3xl shadow-2xl w-full max-w-2xl overflow-hidden flex flex-col max-h-[90vh]"
                >
                    <div
                        class="p-8 border-b border-white/5 bg-white/2 flex items-center justify-between"
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
                                <div class="flex items-center space-x-4">
                                    <div
                                        class="w-16 h-16 rounded-xl bg-white/5 border border-white/10 overflow-hidden flex items-center justify-center shrink-0"
                                    >
                                        <img
                                            v-if="
                                                editingQAGame.preview ||
                                                editingQAGame.thumbnail
                                            "
                                            :src="
                                                editingQAGame.preview ||
                                                '/' + editingQAGame.thumbnail
                                            "
                                            @error="
                                                (e) =>
                                                    (e.target.src =
                                                        '/thumbnails/default-thumbnail.png')
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
                                            @change="handleEditThumbnailChange"
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

        <!-- Delete Confirmation Modal -->
        <transition name="fade">
            <div
                v-if="showDeleteQAModal"
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
                                class="fas fa-exclamation-triangle text-3xl text-red-500"
                            ></i>
                        </div>
                        <h3
                            class="text-2xl font-black text-white uppercase tracking-tighter mb-4"
                        >
                            Confirm Purge
                        </h3>
                        <p
                            class="text-sm text-gray-500 leading-relaxed mb-10 font-medium"
                        >
                            Are you certain you want to decommission
                            <span class="text-white font-black">{{
                                gameToDelete?.title
                            }}</span
                            >? This action will permanently sever the logic link
                            from the network.
                        </p>
                        <div class="grid grid-cols-2 gap-4">
                            <button
                                @click="showDeleteQAModal = false"
                                class="py-4 px-6 bg-white/5 text-gray-500 font-black rounded-xl hover:text-white hover:bg-white/10 transition-all uppercase text-[10px] tracking-widest"
                            >
                                Abort
                            </button>
                            <button
                                @click="executeDeleteQAGame"
                                class="py-4 px-6 bg-red-500 text-white font-black rounded-xl hover:bg-red-600 transition-all shadow-[0_15px_30px_rgba(239,68,68,0.3)] uppercase text-[10px] tracking-widest"
                            >
                                Purge Unit
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
    name: "CombatModules",
    props: {
        games: { type: Array, required: true },
    },
    data() {
        return {
            showEditQAModal: false,
            showDeleteQAModal: false,
            gameToDelete: null,
            editingQAGame: null,
            qaGameForm: {
                title: "",
                description: "",
                question: "",
                answer: "",
                options: "",
                status: "active",
                thumbnail: null,
                preview: null,
            },
        };
    },
    watch: {
        qaGames: {
            handler() {
                this.autoFillTitle();
            },
            immediate: true,
        },
    },
    computed: {
        qaGames() {
            return this.games.filter((g) => g.type === "qa");
        },
    },
    methods: {
        truncate(str, length) {
            if (!str) return "";
            return str.length > length ? str.substring(0, length) + "..." : str;
        },
        autoFillTitle() {
            // Only auto-fill if the title is empty or follows the auto-increment pattern
            if (
                !this.qaGameForm.title ||
                this.qaGameForm.title.startsWith("Combat Module #")
            ) {
                const nextNum = this.qaGames.length + 1;
                this.qaGameForm.title = `Combat Module #${nextNum}`;
            }
        },
        handleQAFPSThumbnailChange(event) {
            const file = event.target.files[0];
            if (file) {
                this.qaGameForm.thumbnail = file;
                this.qaGameForm.preview = URL.createObjectURL(file);
            }
        },
        handleEditThumbnailChange(event) {
            const file = event.target.files[0];
            if (file) {
                this.editingQAGame.thumbnail = file;
                this.editingQAGame.preview = URL.createObjectURL(file);
            }
        },
        async submitQAFPSQuestion() {
            try {
                const formData = new FormData();
                Object.keys(this.qaGameForm).forEach((key) => {
                    if (this.qaGameForm[key] !== null && key !== "preview")
                        formData.append(key, this.qaGameForm[key]);
                });
                formData.append("type", "qa");

                await axios.post("/api/admin/games", formData, {
                    headers: { "Content-Type": "multipart/form-data" },
                });

                this.$emit(
                    "message",
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
                    preview: null,
                };
                this.$emit("refresh");
            } catch (error) {
                this.$emit(
                    "message",
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
            this.editingQAGame = {
                ...game,
                options: optionsStr,
                preview: null,
            };
            this.showEditQAModal = true;
        },
        async updateQAGame() {
            try {
                const formData = new FormData();
                formData.append("title", this.editingQAGame.title);
                formData.append(
                    "description",
                    this.editingQAGame.description || "",
                );
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
                    {
                        headers: { "Content-Type": "multipart/form-data" },
                    },
                );

                this.$emit(
                    "message",
                    "Combat module revision committed.",
                    "success",
                );
                this.showEditQAModal = false;
                this.$emit("refresh");
            } catch (error) {
                this.$emit(
                    "message",
                    "Revision failure: Registry block.",
                    "error",
                );
            }
        },
        confirmDeleteQAGame(game) {
            this.gameToDelete = game;
            this.showDeleteQAModal = true;
        },
        async executeDeleteQAGame() {
            try {
                await axios.delete(`/api/admin/games/${this.gameToDelete.id}`);
                this.$emit(
                    "message",
                    "Combat module decommissioned.",
                    "success",
                );
                this.showDeleteQAModal = false;
                this.$emit("refresh");
            } catch (error) {
                this.$emit(
                    "message",
                    "Decommissioning failure: Unit vital.",
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

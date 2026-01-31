<template>
    <div class="space-y-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Single Entry -->
            <div class="bg-white/5 border border-white/10 rounded-3xl p-8">
                <h3
                    class="text-sm font-black text-white uppercase tracking-widest mb-8 flex items-center"
                >
                    <i class="fas fa-keyboard mr-3 text-red-500"></i>Isolate
                    Entry
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
            <div class="bg-white/5 border border-white/10 rounded-3xl p-8">
                <h3
                    class="text-sm font-black text-white uppercase tracking-widest mb-8 flex items-center"
                >
                    <i class="fas fa-file-import mr-3 text-blue-500"></i>Bulk
                    Synchronisation
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
                            >{{ getBulkWordCount() }} Potential Tokens</span
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
                                ><i class="fas fa-sync-alt fa-spin mr-2"></i
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
                <span class="text-[10px] font-mono text-gray-600 uppercase"
                    >{{ typerGelGames.length }} Tokens Encrypted</span
                >
            </div>
            <div
                class="overflow-x-auto max-h-[500px] overflow-y-auto custom-scrollbar"
            >
                <table class="w-full text-left">
                    <thead class="sticky top-0 bg-[#161616] z-10 shadow-lg">
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
                                        @click="openEditTyperGelModal(game)"
                                        class="w-8 h-8 rounded-lg bg-blue-500/10 text-blue-500 hover:bg-blue-500 hover:text-white transition-all"
                                    >
                                        <i class="fas fa-edit text-xs"></i>
                                    </button>
                                    <button
                                        @click="confirmDeleteTyperGel(game)"
                                        class="w-8 h-8 rounded-lg bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white transition-all"
                                    >
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Edit Modal -->
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
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "VocabularyLink",
    props: {
        games: { type: Array, required: true },
    },
    data() {
        return {
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
        };
    },
    computed: {
        typerGelGames() {
            return this.games.filter((g) => g.type === "typergel");
        },
    },
    methods: {
        async submitTyperGelWord() {
            const word = this.typerGelForm.question.trim();
            if (!word)
                return this.$emit(
                    "message",
                    "Token string cannot be null.",
                    "error",
                );

            try {
                const formData = new FormData();
                formData.append("type", "typergel");
                formData.append("question", word);
                formData.append("status", this.typerGelForm.status);

                await axios.post("/api/admin/games", formData);
                this.$emit(
                    "message",
                    "Neural token archived successfully.",
                    "success",
                );
                this.typerGelForm.question = "";
                this.$emit("refresh");
            } catch (error) {
                this.$emit(
                    "message",
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
                return this.$emit(
                    "message",
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
                this.$emit(
                    "message",
                    "Bulk token synchronisation complete.",
                    "success",
                );
                this.bulkTyperGelWords = "";
                this.$emit("refresh");
            } catch (error) {
                this.$emit(
                    "message",
                    "Bulk synchronisation interrupted.",
                    "error",
                );
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
                this.$emit(
                    "message",
                    "Registry patch successfully applied.",
                    "success",
                );
                this.closeEditTyperGelModal();
                this.$emit("refresh");
            } catch (error) {
                this.$emit(
                    "message",
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
                this.$emit("message", "Token purged from network.", "success");
                this.$emit("refresh");
            } catch (error) {
                this.$emit(
                    "message",
                    "Purge failure: Token locked by session.",
                    "error",
                );
            }
        },
    },
};
</script>

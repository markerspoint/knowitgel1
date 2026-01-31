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
                    to="/user/dashboard"
                    class="flex items-center space-x-3 group"
                >
                    <div
                        class="w-10 h-10 bg-red-500 rounded-lg flex items-center justify-center transform group-hover:rotate-12 transition-transform duration-300"
                    >
                        <i class="fas fa-microchip text-white text-xl"></i>
                    </div>
                    <span
                        class="text-xl font-bold tracking-tighter text-white group-hover:text-red-500 transition-colors uppercase"
                        >KNOWIT GEL1</span
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
                                    class="text-[10px] font-mono text-gray-500 uppercase tracking-widest"
                                >
                                    Learner Mode
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
                                        to="/user/dashboard"
                                        class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-white/5 text-sm font-bold text-gray-400 hover:text-white transition-all"
                                    >
                                        <i class="fas fa-th-large w-5"></i
                                        ><span>Dashboard Hub</span>
                                    </router-link>
                                    <router-link
                                        to="/leaderboard"
                                        class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-white/5 text-sm font-bold text-gray-400 hover:text-white transition-all"
                                    >
                                        <i
                                            class="fas fa-trophy w-5 text-yellow-500/50"
                                        ></i
                                        ><span>Global Rankings</span>
                                    </router-link>
                                </div>
                                <button
                                    @click="handleLogout"
                                    class="w-full flex items-center space-x-3 px-6 py-4 bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white text-xs font-black uppercase tracking-[0.2em] transition-all border-t border-white/5"
                                >
                                    <i class="fas fa-power-off"></i
                                    ><span>Terminate Link</span>
                                </button>
                            </div>
                        </transition>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Content -->
        <div
            class="flex-grow container mx-auto px-6 py-12 relative z-10 max-w-5xl"
        >
            <!-- Status Feedback -->
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
                        class="w-8 h-8 rounded-lg flex items-center justify-center"
                        :class="
                            messageType === 'success'
                                ? 'bg-green-500/20'
                                : 'bg-red-500/20'
                        "
                    >
                        <i
                            :class="
                                messageType === 'success'
                                    ? 'fas fa-check'
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

            <div class="mb-12 reveal-section active">
                <h2
                    class="text-red-500 font-mono tracking-[0.3em] text-xs mb-3 uppercase"
                >
                    Profile Identity
                </h2>
                <h1
                    class="text-4xl md:text-5xl font-black text-white tracking-tighter uppercase mb-4"
                >
                    Metadata
                    <span
                        class="text-transparent bg-clip-text bg-linear-to-r from-red-500 to-red-600"
                        >Parameters</span
                    >
                </h1>
                <p class="text-gray-500 max-w-xl font-medium">
                    Update your learner profile credentials and neural link
                    interface avatar.
                </p>
            </div>

            <div
                class="bg-white/5 border border-white/10 rounded-3xl shadow-2xl overflow-hidden reveal-section active"
            >
                <!-- Header / Toggle -->
                <div
                    class="p-8 border-b border-white/5 bg-white/[0.02] flex items-center justify-between"
                >
                    <div class="flex items-center space-x-4">
                        <div
                            class="w-12 h-12 bg-red-500/10 rounded-xl flex items-center justify-center text-red-500"
                        >
                            <i class="fas fa-fingerprint text-xl"></i>
                        </div>
                        <div>
                            <h3
                                class="text-xl font-bold text-white uppercase tracking-tight"
                            >
                                Identity Matrix
                            </h3>
                            <p
                                class="text-xs font-mono text-gray-600 uppercase"
                            >
                                Registry Status: Synchronized
                            </p>
                        </div>
                    </div>

                    <button
                        v-if="!isEditing"
                        @click="enableEditMode"
                        class="px-6 py-2.5 bg-red-500 text-white text-xs font-black rounded-xl hover:bg-red-600 transition-all shadow-[0_10px_20px_rgba(239,68,68,0.2)] hover:-translate-y-1 uppercase tracking-widest"
                    >
                        <i class="fas fa-edit mr-2"></i>Edit Parameters
                    </button>
                </div>

                <div class="p-8 md:p-12" v-if="user">
                    <form
                        @submit.prevent="updateProfile"
                        v-if="isEditing"
                        enctype="multipart/form-data"
                        class="space-y-10"
                    >
                        <!-- Profile Pic Section -->
                        <div
                            class="flex flex-col md:flex-row items-center md:items-start space-y-6 md:space-y-0 md:space-x-10"
                        >
                            <div class="relative group/avatar">
                                <div
                                    class="w-32 h-32 rounded-3xl overflow-hidden border-2 border-white/10 shadow-2xl bg-white/5"
                                >
                                    <img
                                        v-if="
                                            profilePicturePreview ||
                                            (user.profile_picture &&
                                                !editForm.remove_profile_picture)
                                        "
                                        :src="
                                            profilePicturePreview ||
                                            (user.profile_picture
                                                ? '/' + user.profile_picture
                                                : '')
                                        "
                                        alt="Profile"
                                        class="w-full h-full object-cover"
                                    />
                                    <div
                                        v-else
                                        class="w-full h-full flex items-center justify-center text-red-500 text-4xl font-black italic"
                                    >
                                        {{ user.fname?.charAt(0)
                                        }}{{ user.lname?.charAt(0) }}
                                    </div>
                                </div>
                                <!-- Upload Overlay -->
                                <label
                                    class="absolute inset-0 bg-black/60 opacity-0 group-hover/avatar:opacity-100 transition-opacity flex flex-col items-center justify-center cursor-pointer rounded-3xl backdrop-blur-sm"
                                >
                                    <i
                                        class="fas fa-camera text-white mb-2"
                                    ></i>
                                    <span
                                        class="text-[10px] font-black text-white uppercase tracking-widest"
                                        >Upload</span
                                    >
                                    <input
                                        type="file"
                                        ref="fileInput"
                                        @change="handleFileSelect"
                                        accept="image/*"
                                        class="hidden"
                                    />
                                </label>
                            </div>

                            <div class="flex-1 text-center md:text-left">
                                <h4
                                    class="text-white font-bold mb-2 uppercase tracking-tight"
                                >
                                    Interface Avatar
                                </h4>
                                <p
                                    class="text-sm text-gray-500 mb-6 leading-relaxed"
                                >
                                    Update your visual representation in the
                                    GEL1 network. Supported types: JPG, PNG,
                                    GIF. Max limit: 2MB.
                                </p>
                                <div
                                    class="flex flex-wrap items-center justify-center md:justify-start gap-4"
                                >
                                    <button
                                        type="button"
                                        @click="$refs.fileInput.click()"
                                        class="px-5 py-2 bg-white/5 border border-white/10 rounded-xl text-xs font-bold text-white hover:bg-white/10 hover:border-red-500/50 transition-all uppercase tracking-widest"
                                    >
                                        Select New Link
                                    </button>
                                    <button
                                        v-if="
                                            (profilePicturePreview ||
                                                user.profile_picture) &&
                                            !editForm.remove_profile_picture
                                        "
                                        type="button"
                                        @click="removeProfilePicture"
                                        class="px-5 py-2 bg-red-500/10 border border-red-500/20 rounded-xl text-xs font-bold text-red-500 hover:bg-red-500 hover:text-white transition-all uppercase tracking-widest"
                                    >
                                        Clear Data
                                    </button>
                                    <span
                                        v-if="
                                            editForm.remove_profile_picture &&
                                            !profilePictureFile
                                        "
                                        class="text-[10px] font-mono text-red-500 uppercase tracking-widest animate-pulse"
                                        >Deletion Pending Save</span
                                    >
                                </div>
                            </div>
                        </div>

                        <!-- Inputs Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div
                                v-for="field in [
                                    {
                                        id: 'fname',
                                        label: 'First Name',
                                        model: 'fname',
                                    },
                                    {
                                        id: 'lname',
                                        label: 'Last Name',
                                        model: 'lname',
                                    },
                                    {
                                        id: 'username',
                                        label: 'Username',
                                        model: 'username',
                                    },
                                    {
                                        id: 'email',
                                        label: 'Network Email',
                                        model: 'email',
                                    },
                                ]"
                                :key="field.id"
                            >
                                <label
                                    :for="field.id"
                                    class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.3em] mb-3"
                                    >{{ field.label }}</label
                                >
                                <input
                                    :id="field.id"
                                    type="text"
                                    v-model="editForm[field.model]"
                                    required
                                    class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 text-white placeholder-gray-700 focus:outline-none focus:border-red-500/50 focus:bg-white/10 transition-all font-medium"
                                />
                            </div>
                        </div>

                        <div
                            class="pt-10 flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 border-t border-white/5"
                        >
                            <button
                                type="submit"
                                :disabled="isSaving"
                                class="px-10 py-4 bg-red-500 text-white font-black rounded-2xl hover:bg-red-600 transition-all shadow-[0_15px_30px_rgba(239,68,68,0.2)] hover:-translate-y-1 disabled:opacity-50 disabled:cursor-not-allowed uppercase tracking-widest text-sm flex items-center justify-center"
                            >
                                <span v-if="isSaving"
                                    ><i class="fas fa-sync-alt fa-spin mr-3"></i
                                    >Encrypting...</span
                                >
                                <span v-else
                                    ><i class="fas fa-save mr-3"></i>Commit
                                    Metadata</span
                                >
                            </button>
                            <button
                                type="button"
                                @click="cancelEdit"
                                :disabled="isSaving"
                                class="px-10 py-4 bg-white/5 text-gray-400 font-bold rounded-2xl border border-white/5 hover:bg-white/10 hover:text-white transition-all uppercase tracking-widest text-sm"
                            >
                                Abort
                            </button>
                        </div>
                    </form>

                    <!-- Read Mode -->
                    <div v-else class="space-y-12">
                        <div
                            class="flex flex-col md:flex-row items-center md:items-start space-y-6 md:space-y-0 md:space-x-10"
                        >
                            <div
                                class="w-32 h-32 rounded-3xl overflow-hidden border-2 border-white/10 shadow-2xl bg-white/5"
                            >
                                <img
                                    v-if="user.profile_picture"
                                    :src="'/' + user.profile_picture"
                                    alt="Profile"
                                    class="w-full h-full object-cover"
                                />
                                <div
                                    v-else
                                    class="w-full h-full flex items-center justify-center text-red-500 text-4xl font-black italic"
                                >
                                    {{ user.fname?.charAt(0)
                                    }}{{ user.lname?.charAt(0) }}
                                </div>
                            </div>
                            <div class="text-center md:text-left">
                                <h3
                                    class="text-3xl font-black text-white italic tracking-tighter uppercase mb-2"
                                >
                                    {{ user.fname }} {{ user.lname }}
                                </h3>
                                <p class="text-gray-500 font-mono mb-4">
                                    {{ user.email }}
                                </p>
                                <div
                                    class="inline-flex items-center px-4 py-1.5 bg-red-500/10 border border-red-500/20 rounded-full text-[10px] font-black text-red-500 uppercase tracking-widest"
                                >
                                    <i class="fas fa-id-badge mr-2"></i> Role:
                                    {{ user.role }}
                                </div>
                            </div>
                        </div>

                        <div
                            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6"
                        >
                            <div
                                v-for="info in [
                                    { l: 'First Name', v: user.fname },
                                    { l: 'Last Name', v: user.lname },
                                    { l: 'Username', v: user.username },
                                    { l: 'Sync Method', v: 'Encrypted Link' },
                                ]"
                                :key="info.l"
                                class="bg-white/[0.02] border border-white/5 rounded-2xl p-6"
                            >
                                <p
                                    class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2"
                                >
                                    {{ info.l }}
                                </p>
                                <p
                                    class="text-lg font-bold text-white tracking-tight"
                                >
                                    {{ info.v }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Interface Loader -->
        <div
            v-if="isLoading"
            class="fixed inset-0 bg-[#0a0a0a]/95 z-[9999] flex flex-col justify-center items-center backdrop-blur-sm"
        >
            <div class="relative w-24 h-24 mb-8">
                <div
                    class="absolute inset-0 border-4 border-red-500/20 rounded-full"
                ></div>
                <div
                    class="absolute inset-0 border-4 border-t-red-500 rounded-full animate-spin"
                ></div>
                <i
                    class="fas fa-fingerprint text-red-500 text-2xl absolute inset-0 flex items-center justify-center animate-pulse"
                ></i>
            </div>
            <div
                class="text-red-500 text-xs font-mono tracking-[0.5em] uppercase"
            >
                Accessing Profile Registry...
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "UserProfile",
    data() {
        return {
            user: null,
            showProfileDropdown: false,
            isEditing: false,
            isSaving: false,
            isLoading: true,
            message: "",
            messageType: "success",
            editForm: {
                fname: "",
                lname: "",
                username: "",
                email: "",
                remove_profile_picture: false,
            },
            profilePictureFile: null,
            profilePicturePreview: null,
        };
    },
    async mounted() {
        await this.fetchUser();
        document.addEventListener("click", this.handleClickOutside);
        this.isLoading = false;
    },
    beforeUnmount() {
        document.removeEventListener("click", this.handleClickOutside);
    },
    methods: {
        async fetchUser() {
            try {
                const response = await axios.get("/api/user/profile");
                this.user = response.data.user;
            } catch (error) {
                console.error("Failed to fetch user:", error);
                this.$router.push("/login");
            }
        },
        enableEditMode() {
            this.editForm = {
                fname: this.user.fname || "",
                lname: this.user.lname || "",
                username: this.user.username || "",
                email: this.user.email || "",
                remove_profile_picture: false,
            };
            this.profilePictureFile = null;
            this.profilePicturePreview = null;
            this.isEditing = true;
            this.message = "";
        },
        cancelEdit() {
            this.isEditing = false;
            this.editForm = {
                fname: "",
                lname: "",
                username: "",
                email: "",
                remove_profile_picture: false,
            };
            this.profilePictureFile = null;
            this.profilePicturePreview = null;
            this.message = "";
        },
        handleFileSelect(event) {
            const file = event.target.files[0];
            if (file) {
                if (file.size > 2048 * 1024) {
                    this.showMessage(
                        "System Fault: File size limit (2MB) exceeded.",
                        "error",
                    );
                    return;
                }
                if (!file.type.startsWith("image/")) {
                    this.showMessage(
                        "Format Error: Invalid visual matrix format.",
                        "error",
                    );
                    return;
                }
                this.profilePictureFile = file;
                this.editForm.remove_profile_picture = false;
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.profilePicturePreview = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },
        removeProfilePicture() {
            this.profilePictureFile = null;
            this.profilePicturePreview = null;
            if (this.$refs.fileInput) {
                this.$refs.fileInput.value = "";
            }
            this.editForm.remove_profile_picture = true;
        },
        async updateProfile() {
            this.isSaving = true;
            this.message = "";

            try {
                const formData = new FormData();
                formData.append("fname", this.editForm.fname);
                formData.append("lname", this.editForm.lname);
                formData.append("username", this.editForm.username);
                formData.append("email", this.editForm.email);

                if (this.profilePictureFile) {
                    formData.append("profile_picture", this.profilePictureFile);
                }

                if (
                    this.editForm.remove_profile_picture &&
                    !this.profilePictureFile
                ) {
                    formData.append("remove_profile_picture", "1");
                }

                const response = await axios.post(
                    "/api/user/profile",
                    formData,
                    {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    },
                );

                if (response.data.status === "success") {
                    this.user = { ...this.user, ...response.data.user };
                    this.profilePictureFile = null;
                    this.profilePicturePreview = null;
                    this.isEditing = false;
                    this.showMessage(
                        "Metadata successfully committed to registry.",
                        "success",
                    );
                }
            } catch (error) {
                const errorMsg =
                    error.response?.data?.message ||
                    "Policy violation during encryption.";
                this.showMessage(errorMsg, "error");
            } finally {
                this.isSaving = false;
            }
        },
        showMessage(msg, type) {
            this.message = msg;
            this.messageType = type;
            setTimeout(() => {
                this.message = "";
            }, 5000);
        },
        async handleLogout() {
            try {
                await axios.post("/api/logout");
                this.$router.push("/login");
            } catch (error) {
                console.error("Logout failed:", error);
                this.$router.push("/login");
            }
        },
        handleClickOutside(event) {
            const dropdown = event.target.closest(".relative");
            if (!dropdown) {
                this.showProfileDropdown = false;
            }
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

.fade-enter-active,
.fade-leave-active {
    transition: all 0.4s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
    transform: translateX(20px);
}
</style>

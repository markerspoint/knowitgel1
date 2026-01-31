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
        <div
            class="flex-grow container mx-auto px-6 py-12 relative z-10 max-w-5xl"
        >
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

            <!-- Profile Header -->
            <div
                class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-8 reveal-section active"
            >
                <div>
                    <h2
                        class="text-red-500 font-mono tracking-[0.3em] text-xs mb-3 uppercase"
                    >
                        Security Terminal
                    </h2>
                    <h1
                        class="text-4xl md:text-5xl font-black text-white tracking-tighter uppercase"
                    >
                        Admin
                        <span
                            class="text-transparent bg-clip-text bg-linear-to-r from-red-500 to-red-600"
                            >Profile</span
                        >
                    </h1>
                </div>
                <button
                    v-if="!isEditing"
                    @click="enableEditMode"
                    class="px-8 py-4 bg-white/5 border border-white/10 text-white font-black rounded-xl hover:bg-white/10 transition-all uppercase tracking-widest text-xs flex items-center group"
                >
                    <i class="fas fa-user-edit mr-3"></i>Modify Credentials
                </button>
            </div>

            <!-- Main Profile Card -->
            <div
                class="reveal-section active bg-white/5 border border-white/10 rounded-[2.5rem] overflow-hidden shadow-2xl flex flex-col md:flex-row"
            >
                <!-- Left Side: Avatar Panel -->
                <div
                    class="md:w-1/3 bg-white/[0.02] border-r border-white/5 p-12 flex flex-col items-center text-center"
                >
                    <div class="relative group/avatar mb-8">
                        <div
                            class="w-48 h-48 rounded-[2.5rem] overflow-hidden border-2 border-white/10 bg-[#111] shadow-[0_0_50px_rgba(239,68,68,0.1)] group-hover/avatar:border-red-500/50 transition-all duration-500"
                        >
                            <img
                                v-if="
                                    profilePicturePreview ||
                                    (user?.profile_picture &&
                                        !editForm.remove_profile_picture)
                                "
                                :src="
                                    profilePicturePreview ||
                                    '/' + user.profile_picture
                                "
                                class="w-full h-full object-cover"
                            />
                            <div
                                v-else
                                class="w-full h-full flex items-center justify-center text-red-500 bg-red-500/5"
                            >
                                <i class="fas fa-user-shield text-6xl"></i>
                            </div>
                        </div>
                        <label
                            v-if="isEditing"
                            class="absolute -bottom-2 -right-2 w-12 h-12 bg-red-500 text-white rounded-2xl flex items-center justify-center cursor-pointer hover:bg-red-600 transition-all shadow-xl"
                        >
                            <i class="fas fa-camera text-sm"></i>
                            <input
                                type="file"
                                ref="fileInput"
                                @change="handleFileSelect"
                                accept="image/*"
                                class="hidden"
                            />
                        </label>
                    </div>

                    <h3
                        class="text-2xl font-black text-white tracking-tighter mb-1 uppercase"
                    >
                        {{ user?.fname }} {{ user?.lname }}
                    </h3>
                    <p
                        class="text-[10px] font-mono text-red-500 uppercase tracking-[0.3em] font-bold mb-6 italic"
                    >
                        Identity Synchronised
                    </p>

                    <div
                        class="w-full p-4 bg-blue-500/5 border border-blue-500/10 rounded-2xl flex items-center justify-center space-x-3 mb-4"
                    >
                        <i class="fas fa-shield-alt text-blue-500 text-sm"></i>
                        <span
                            class="text-[10px] font-black text-blue-500 uppercase tracking-widest"
                            >Network Administrator</span
                        >
                    </div>

                    <button
                        v-if="
                            isEditing &&
                            (profilePicturePreview || user?.profile_picture) &&
                            !editForm.remove_profile_picture
                        "
                        @click="removeProfilePicture"
                        type="button"
                        class="text-[10px] font-black text-gray-500 hover:text-red-500 uppercase tracking-widest transition-colors flex items-center space-x-2"
                    >
                        <i class="fas fa-trash-alt"></i
                        ><span>Discard Matrix Image</span>
                    </button>
                </div>

                <!-- Right Side: Data Panel -->
                <div class="flex-1 p-12">
                    <form
                        v-if="isEditing"
                        @submit.prevent="updateProfile"
                        class="space-y-8"
                    >
                        <div class="grid md:grid-cols-2 gap-8">
                            <div class="space-y-1.5">
                                <label
                                    class="text-[10px] font-black text-gray-500 uppercase tracking-widest"
                                    >First Name</label
                                >
                                <input
                                    type="text"
                                    v-model="editForm.fname"
                                    required
                                    class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-4 text-white focus:outline-none focus:border-red-500/50 transition-all font-bold"
                                />
                            </div>
                            <div class="space-y-1.5">
                                <label
                                    class="text-[10px] font-black text-gray-500 uppercase tracking-widest"
                                    >Last Name</label
                                >
                                <input
                                    type="text"
                                    v-model="editForm.lname"
                                    required
                                    class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-4 text-white focus:outline-none focus:border-red-500/50 transition-all font-bold"
                                />
                            </div>
                        </div>
                        <div class="grid md:grid-cols-2 gap-8">
                            <div class="space-y-1.5">
                                <label
                                    class="text-[10px] font-black text-gray-500 uppercase tracking-widest"
                                    >Global Username</label
                                >
                                <input
                                    type="text"
                                    v-model="editForm.username"
                                    required
                                    class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-4 text-white focus:outline-none focus:border-red-500/50 transition-all font-bold"
                                />
                            </div>
                            <div class="space-y-1.5">
                                <label
                                    class="text-[10px] font-black text-gray-500 uppercase tracking-widest"
                                    >Communication Email</label
                                >
                                <input
                                    type="email"
                                    v-model="editForm.email"
                                    required
                                    class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-4 text-white focus:outline-none focus:border-red-500/50 transition-all font-bold"
                                />
                            </div>
                        </div>

                        <div
                            class="pt-8 border-t border-white/5 flex items-center space-x-4"
                        >
                            <button
                                type="submit"
                                :disabled="isSaving"
                                class="px-10 py-4 bg-red-500 text-white font-black rounded-xl hover:bg-red-600 transition-all shadow-[0_15px_30px_rgba(239,68,68,0.2)] uppercase text-[10px] tracking-widest"
                            >
                                <span v-if="!isSaving">Commit Revisions</span>
                                <span v-else
                                    ><i class="fas fa-circle-notch fa-spin"></i>
                                    Processing...</span
                                >
                            </button>
                            <button
                                type="button"
                                @click="cancelEdit"
                                :disabled="isSaving"
                                class="px-8 py-4 bg-white/5 text-gray-500 font-black rounded-xl hover:text-white hover:bg-white/10 transition-all uppercase text-[10px] tracking-widest"
                            >
                                Abort Changes
                            </button>
                        </div>
                    </form>

                    <div v-else class="space-y-12">
                        <!-- View Mode Information -->
                        <div class="grid md:grid-cols-2 gap-12">
                            <div class="space-y-1">
                                <p
                                    class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2"
                                >
                                    Subject Full Name
                                </p>
                                <p
                                    class="text-xl font-bold text-white tracking-tight"
                                >
                                    {{ user?.fname }} {{ user?.lname }}
                                </p>
                            </div>
                            <div class="space-y-1">
                                <p
                                    class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2"
                                >
                                    System Email Link
                                </p>
                                <p
                                    class="text-xl font-bold text-red-500 tracking-tight"
                                >
                                    {{ user?.email }}
                                </p>
                            </div>
                            <div class="space-y-1">
                                <p
                                    class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2"
                                >
                                    Network Handle
                                </p>
                                <p
                                    class="text-xl font-bold text-white tracking-tight uppercase"
                                >
                                    @{{ user?.username }}
                                </p>
                            </div>
                            <div class="space-y-1">
                                <p
                                    class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2"
                                >
                                    Authority Status
                                </p>
                                <div class="flex items-center space-x-2">
                                    <div
                                        class="w-2 h-2 rounded-full bg-green-500 animate-pulse"
                                    ></div>
                                    <p
                                        class="text-xl font-bold text-white tracking-tight uppercase"
                                    >
                                        Session Active
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div
                            class="p-8 bg-white/2 border border-white/5 rounded-3xl relative overflow-hidden group"
                        >
                            <div
                                class="absolute -right-6 -bottom-6 opacity-5 group-hover:opacity-10 transition-opacity"
                            >
                                <i
                                    class="fas fa-fingerprint text-8xl text-red-500"
                                ></i>
                            </div>
                            <div
                                class="flex items-center space-x-6 relative z-10"
                            >
                                <div
                                    class="w-16 h-16 rounded-2xl bg-red-500/10 border border-red-500/20 flex items-center justify-center"
                                >
                                    <i
                                        class="fas fa-lock text-red-500 text-2xl"
                                    ></i>
                                </div>
                                <div>
                                    <h4
                                        class="text-sm font-black text-white uppercase tracking-widest mb-1"
                                    >
                                        Security Level: High
                                    </h4>
                                    <p
                                        class="text-xs text-gray-500 font-medium"
                                    >
                                        Your identity is cryptographically
                                        protected within the KNOWIT GEL1 neural
                                        core.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Profile",
    data() {
        return {
            user: null,
            showProfileDropdown: false,
            isEditing: false,
            isSaving: false,
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
    },
    beforeUnmount() {
        document.removeEventListener("click", this.handleClickOutside);
    },
    methods: {
        async fetchUser() {
            try {
                const response = await axios.get("/api/admin/profile");
                this.user = response.data.user;
            } catch (error) {
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
            this.message = "";
        },
        handleFileSelect(event) {
            const file = event.target.files[0];
            if (file) {
                if (file.size > 2048 * 1024)
                    return this.showMessage(
                        "Matrix stream overload: Max 2MB.",
                        "error",
                    );
                this.profilePictureFile = file;
                this.editForm.remove_profile_picture = false;
                const reader = new FileReader();
                reader.onload = (e) =>
                    (this.profilePicturePreview = e.target.result);
                reader.readAsDataURL(file);
            }
        },
        removeProfilePicture() {
            this.profilePictureFile = null;
            this.profilePicturePreview = null;
            this.editForm.remove_profile_picture = true;
        },
        async updateProfile() {
            this.isSaving = true;
            try {
                const formData = new FormData();
                Object.keys(this.editForm).forEach((k) =>
                    formData.append(k, this.editForm[k]),
                );
                if (this.profilePictureFile)
                    formData.append("profile_picture", this.profilePictureFile);

                const response = await axios.post(
                    "/api/admin/profile",
                    formData,
                    { headers: { "Content-Type": "multipart/form-data" } },
                );
                if (response.data.status === "success") {
                    this.user = { ...this.user, ...response.data.user };
                    this.isEditing = false;
                    this.showMessage(
                        "Identity revisions successfully synchronised.",
                        "success",
                    );
                }
            } catch (error) {
                this.showMessage(
                    "Profile revision failure: Access denied.",
                    "error",
                );
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
</style>

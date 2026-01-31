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

            <!-- Users Header -->
            <div class="mb-12 reveal-section active">
                <h2
                    class="text-red-500 font-mono tracking-[0.3em] text-xs mb-3 uppercase"
                >
                    Identity Registry
                </h2>
                <h1
                    class="text-4xl md:text-5xl font-black text-white tracking-tighter uppercase mb-4"
                >
                    User
                    <span
                        class="text-transparent bg-clip-text bg-linear-to-r from-red-500 to-red-600"
                        >Management</span
                    >
                </h1>
                <p class="text-gray-500 font-medium max-w-2xl">
                    Monitor and control network permissions for all registered
                    entities within the KNOWIT GEL1 ecosystem.
                </p>
            </div>

            <!-- Users Table Container -->
            <div
                class="reveal-section active bg-white/5 border border-white/10 rounded-3xl overflow-hidden shadow-2xl"
            >
                <div
                    class="p-8 border-b border-white/5 bg-white/[0.02] flex items-center justify-between"
                >
                    <span
                        class="text-xs font-black text-white uppercase tracking-widest"
                        >Active Entities</span
                    >
                    <span class="text-[10px] font-mono text-gray-600 uppercase"
                        >{{ users.length }} Identity Links Found</span
                    >
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr
                                class="bg-white/5 border-b border-white/5 text-[10px] font-black text-gray-500 uppercase tracking-widest"
                            >
                                <th class="px-8 py-5">Identity ID</th>
                                <th class="px-8 py-5">Standard Name</th>
                                <th class="px-8 py-5">
                                    Neural Email / Sync Username
                                </th>
                                <th class="px-8 py-5 text-right">
                                    Access Controls
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            <tr
                                v-for="u in users"
                                :key="u.id"
                                class="hover:bg-white/[0.03] transition-colors group"
                            >
                                <td class="px-8 py-6">
                                    <span
                                        class="text-xs font-mono text-gray-500"
                                        >#{{
                                            u.id.toString().padStart(4, "0")
                                        }}</span
                                    >
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center space-x-3">
                                        <div
                                            class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center text-[10px] font-black text-red-500"
                                        >
                                            {{ u.fname.charAt(0)
                                            }}{{ u.lname.charAt(0) }}
                                        </div>
                                        <span
                                            class="text-sm font-bold text-white uppercase tracking-tight"
                                            >{{ u.fname }} {{ u.lname }}</span
                                        >
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="space-y-1">
                                        <p
                                            class="text-xs text-blue-400 font-medium"
                                        >
                                            {{ u.email }}
                                        </p>
                                        <p
                                            class="text-[10px] text-gray-600 font-mono uppercase tracking-widest"
                                        >
                                            {{ u.username }}
                                        </p>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div
                                        class="flex items-center justify-end space-x-3"
                                    >
                                        <button
                                            @click="toggleUserStatus(u)"
                                            :class="[
                                                'px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all',
                                                u.is_disabled
                                                    ? 'bg-green-500/10 text-green-500 hover:bg-green-500 hover:text-white'
                                                    : 'bg-amber-500/10 text-amber-500 hover:bg-amber-500 hover:text-white',
                                            ]"
                                        >
                                            <i
                                                :class="[
                                                    'fas mr-2',
                                                    u.is_disabled
                                                        ? 'fa-unlock'
                                                        : 'fa-lock',
                                                ]"
                                            ></i>
                                            {{
                                                u.is_disabled
                                                    ? "Activate"
                                                    : "Deactivate"
                                            }}
                                        </button>
                                        <button
                                            @click="deleteUser(u)"
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
                <div v-if="!users.length" class="text-center py-32 opacity-20">
                    <i class="fas fa-user-slash text-6xl mb-6"></i>
                    <p
                        class="text-xs font-black uppercase tracking-widest font-mono"
                    >
                        No Identity Links Identified
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Users",
    data() {
        return {
            user: null,
            users: [],
            message: "",
            messageType: "success",
            showProfileDropdown: false,
        };
    },
    async mounted() {
        await this.fetchUser();
        await this.fetchUsers();
        document.addEventListener("click", this.handleClickOutside);
    },
    beforeUnmount() {
        document.removeEventListener("click", this.handleClickOutside);
    },
    methods: {
        async fetchUser() {
            try {
                const response = await axios.get("/api/user");
                if (response.data.status === "success") {
                    this.user = response.data.user;
                }
            } catch (error) {
                console.error("Failed to fetch user:", error);
            }
        },
        async fetchUsers() {
            try {
                const response = await axios.get("/api/admin/dashboard-data");
                this.users = response.data.users || [];
            } catch (error) {
                this.showMessage(
                    "Failed to load identity links from network.",
                    "error",
                );
            }
        },
        async toggleUserStatus(user) {
            try {
                await axios.patch(`/api/admin/users/${user.id}/toggle-status`);
                user.is_disabled = !user.is_disabled;
                this.showMessage(
                    `User ${user.username} state successfully modified.`,
                    "success",
                );
            } catch (error) {
                this.showMessage(
                    "Protocol rejection: Failed to modify identity state.",
                    "error",
                );
            }
        },
        async deleteUser(user) {
            if (
                !confirm(
                    `Purge entity "${user.username}" from the network? This operation is irreversible.`,
                )
            )
                return;
            try {
                await axios.delete(`/api/admin/users/${user.id}`);
                this.users = this.users.filter((u) => u.id !== user.id);
                this.showMessage(
                    "Entity purged from neural registry.",
                    "success",
                );
            } catch (error) {
                this.showMessage(
                    "Purge failure: Entity record is system vital.",
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
        async handleLogout() {
            try {
                await axios.post("/api/logout");
                this.$router.push("/login");
            } catch (error) {
                this.$router.push("/login");
            }
        },
        handleClickOutside(event) {
            if (!event.target.closest(".relative")) {
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
</style>

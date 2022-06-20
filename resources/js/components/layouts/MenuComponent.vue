<template>
    <div
        class="flex h-screen bg-gray-50 dark:bg-gray-900"
        :class="{ 'overflow-hidden': this.isSideMenuOpen }"
    >
        <!-- Desktop sidebar -->
        <aside
            class="z-20 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0"
        >
            <div class="py-4 text-gray-500 dark:text-gray-400">
                <a
                    class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200"
                    href="#"
                >
                    ALPanel
                </a>
                <ul class="mt-6">
                    <li class="relative px-6 py-3">
              <span
                  class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                  aria-hidden="true"
              ></span>
                        <a
                            class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100"
                            href="/dashboard"
                        >
                            <svg
                                class="w-5 h-5"
                                aria-hidden="true"
                                fill="none"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                                ></path>
                            </svg>
                            <span class="ml-4">Dashboard</span>
                        </a>
                    </li>
                </ul>

                <!-- Admin Menu -->
                <admin-menu
                    v-if="user.role.key === 'association_manager' || user.role.key === 'sub_association_manager'"></admin-menu>
                <!-- end Admin Menu -->

                <!-- Manager Menu -->
                <manager-menu
                    v-if="user.role.key === 'association_manager' || user.role.key === 'sub_association_manager'"></manager-menu>
                <!-- end Manager Menu -->

                <!-- Parent Menu -->
                <parent-menu v-if="user.role.key === 'parent'"></parent-menu>
                <!-- end Parent Menu -->

                <!-- Teacher Menu -->
                <teacher-menu v-if="user.role.key === 'teacher'"></teacher-menu>
                <!-- end Teacher Menu -->

                <!-- Student Menu -->
                <student-menu v-if="user.role.key === 'teacher'"></student-menu>
                <!-- end Student Menu -->

                <div class="px-6 my-6" v-if="user.role.key !== 'student'">
                    <a
                        class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                        href="/users/create"
                    >
                        Kullanıcı Kaydet
                        <span class="ml-2" aria-hidden="true">+</span>
                    </a>
                </div>
            </div>
        </aside>
    </div>

</template>

<script>

export default {
    name: "MenuComponent",
    props: ['user'],
    data() {
        return {
            isSideMenuOpen: false,
            isNotificationsMenuOpen: false,
            isProfileMenuOpen: false,
            isPagesMenuOpen: false,
            isModalOpen: false,
            trapCleanup: null,
        }
    },
    methods: {
        toggleTheme() {
            this.dark = !this.dark
            setThemeToLocalStorage(this.dark)
        },

        toggleSideMenu() {
            this.isSideMenuOpen = !this.isSideMenuOpen
        },
        closeSideMenu() {
            this.isSideMenuOpen = false
        },

        toggleNotificationsMenu() {
            this.isNotificationsMenuOpen = !this.isNotificationsMenuOpen
        },
        closeNotificationsMenu() {
            this.isNotificationsMenuOpen = false
        },

        toggleProfileMenu() {
            this.isProfileMenuOpen = !this.isProfileMenuOpen
        },
        closeProfileMenu() {
            this.isProfileMenuOpen = false
        },

        togglePagesMenu() {
            this.isPagesMenuOpen = !this.isPagesMenuOpen
        },
        // Modal

        openModal() {
            this.isModalOpen = true
            this.trapCleanup = focusTrap(document.querySelector('#modal'))
        },
        closeModal() {
            this.isModalOpen = false
            this.trapCleanup()
        },
    }

}
</script>

<style scoped>

</style>

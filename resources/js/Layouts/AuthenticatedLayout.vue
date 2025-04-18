<script setup>
import { ref } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import Footer from "@/Components/Footer.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import { Link } from "@inertiajs/vue3";

const showingNavigationDropdown = ref(false);
const props = defineProps({
  settings: Object,
});
</script>

<template>
  <div>
    <div
      v-if="$page.props.flash.message"
      class="p-4 mb-4 text-sm text-blue-700 bg-blue-100 dark:bg-blue-400 dark:text-blue-800 flex justify-center"
      role="alert"
    >
      <div class="max-w-7xl mx-auto">{{ $page.props.flash.message }}</div>
    </div>
    <div class="min-h-screen bg-gray-100">
      <nav class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex justify-between h-16">
            <div class="flex">
              <!-- Logo -->
              <div class="shrink-0 flex items-center">
                <Link :href="route('admindashboard')">
                  <div class="text-center">
                    <img
                      :src="settings.logo"
                      alt="Logo"
                      class="mx-auto h-8 w-auto"
                    />
                  </div>
                </Link>
              </div>

              <!-- Navigation Links -->
              <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                <NavLink
                  :href="route('admindashboard')"
                  :active="route().current('admindashboard')"
                >
                  Dashboard
                </NavLink>
                <NavLink
                  :href="route('advertisements.index')"
                  :active="route().current('advertisements.index')"
                >
                  Advertisements
                </NavLink>

                <NavLink
                  :href="route('reviews.index')"
                  :active="route().current('reviews.index')"
                >
                  Reviews
                </NavLink>
                <NavLink
                  :href="route('settings.index')"
                  :active="route().current('S=settings.index')"
                >
                  Settings
                </NavLink>
              </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
              <span class="text-gray-700 font-medium">{{
                $page.props.auth.user.username
              }}</span>
              <Link
                :href="route('logout')"
                method="post"
                as="button"
                class="ml-4"
              >
                <button
                  type="submit"
                  class="px-3 py-2 bg-red-500 text-white text-sm font-semibold rounded-md hover:bg-red-600 transition"
                >
                  Log Out
                </button>
              </Link>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
              <button
                @click="showingNavigationDropdown = !showingNavigationDropdown"
                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
              >
                <svg
                  class="h-6 w-6"
                  stroke="currentColor"
                  fill="none"
                  viewBox="0 0 24 24"
                >
                  <path
                    :class="{
                      hidden: showingNavigationDropdown,
                      'inline-flex': !showingNavigationDropdown,
                    }"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"
                  />
                  <path
                    :class="{
                      hidden: !showingNavigationDropdown,
                      'inline-flex': showingNavigationDropdown,
                    }"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M6 18L18 6M6 6l12 12"
                  />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </nav>
      <!-- Page Content -->
      <main>
        <slot />
      </main>
    </div>
    <!-- Footer -->
    <Footer :settings="settings" />
  </div>
</template>

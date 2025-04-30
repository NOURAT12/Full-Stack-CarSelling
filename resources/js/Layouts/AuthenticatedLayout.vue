<script setup>
import NavLink from "@/Components/NavLink.vue";
import Footer from "@/Components/Footer.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import { Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import { ref, onMounted, watch } from "vue";
const showingNavigationDropdown = ref(false);
const props = defineProps({
  settings: Object,
  translations: Object,
  locale: String,
});
const localeState = ref(localStorage.getItem("locale") || props.locale || "en");

function toggleLang() {
  const newLang = localeState.value === "en" ? "ar" : "en";
  localeState.value = newLang;
  localStorage.setItem("locale", newLang);

  router.reload({
    preserveScroll: true,
    preserveState: true,
    headers: {
      "X-Locale": newLang,
    },
  });
}
function updateDirection(lang) {
  document.documentElement.setAttribute("dir", lang === "ar" ? "rtl" : "ltr");
}

// تحديث الاتجاه أول ما يشتغل
onMounted(() => {
  updateDirection(localeState.value);

  const serverLocale = props.locale;
  const clientLocale = localeState.value;

  if (serverLocale !== clientLocale) {
    router.reload({
      preserveScroll: true,
      preserveState: true,
      headers: {
        "X-Locale": clientLocale,
      },
    });
  }
});
// تحديث الاتجاه كل ما تتغير اللغة
watch(localeState, (newLang) => {
  updateDirection(newLang);
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
              <div class="shrink-0 flex items-center" v-if="settings">
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
              <div class="hidden space-x-8 rtl:space-x-reverse sm:-my-px sm:ms-10 sm:flex">
                <NavLink
                  :href="route('admindashboard')"
                  :active="route().current('admindashboard')"
                >
                {{ translations.dashboard }}
                </NavLink>
                <NavLink
                  :href="route('advertisements.index')"
                  :active="route().current('advertisements.index')"
                >
                {{ translations.advertisements }}
                </NavLink>

                <NavLink
                  :href="route('reviews.index')"
                  :active="route().current('reviews.index')"
                >
                {{ translations.reviews }}
                </NavLink>
                <NavLink
                  :href="route('settings.index')"
                  :active="route().current('settings.index')"
                >
                {{ translations.settings }}
                </NavLink>
              </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
              <span class="text-gray-700 font-medium">{{
                $page.props.auth.user.username
              }}</span>
              <!-- زر تبديل اللغة -->
              <button
                @click="toggleLang"
                class="flex items-center ms-4 space-x-2 rtl:space-x-reverse bg-gray-100 px-3 py-1 rounded hover:bg-gray-200"
              >
                <span class="text-lg">🌐</span>
                <span>{{ locale === "en" ? "العربية" : "English" }}</span>
              </button>
              <Link
                :href="route('logout')"
                method="post"
                as="button"
                class="ms-4"
              >
                <button
                  type="submit"
                  class="px-3 py-2 bg-red-500 text-white text-sm font-semibold rounded-md hover:bg-red-600 transition"
                >
                {{ translations.log_out }}
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
      <!-- Responsive Navigation Menu -->
      <div v-if="showingNavigationDropdown" class="sm:hidden">
        <div class="pt-2 pb-3 space-y-1 rtl:space-y-reverse">
          <ResponsiveNavLink
            :href="route('admindashboard')"
            :active="route().current('admindashboard')"
          >
          {{ translations.dashboard }}
          </ResponsiveNavLink>
          <ResponsiveNavLink
            :href="route('advertisements.index')"
            :active="route().current('advertisements.index')"
          >
          {{ translations.advertisements }}
          </ResponsiveNavLink>
          <ResponsiveNavLink
            :href="route('reviews.index')"
            :active="route().current('reviews.index')"
          >
          {{ translations.reviews }}
          </ResponsiveNavLink>
          <ResponsiveNavLink
            :href="route('settings.index')"
            :active="route().current('settings.index')"
          >
          {{ translations.settings }}
          </ResponsiveNavLink>
        </div>

        <!-- User info & logout for mobile -->
        <div class="pt-4 pb-1 border-t border-gray-200">
          <div class="px-4 text-gray-700 font-medium">
            {{ $page.props.auth.user.username }}
          </div>
          <!-- زر تبديل اللغة -->
          <button
            @click="toggleLang"
            class="flex items-center ms-4 space-x-2 rtl:space-x-reverse bg-gray-100 px-3 py-1 rounded hover:bg-gray-200"
          >
            <span class="text-lg">🌐</span>
            <span>{{ locale === "en" ? "العربية" : "English" }}</span>
          </button>
          <div class="mt-3 space-y-1 rtl:space-y-reverse">
            <ResponsiveNavLink
              :href="route('logout')"
              method="post"
              as="button"
            >
            {{ translations.log_out }}
            </ResponsiveNavLink>
          </div>
        </div>
      </div>

      <!-- Page Content -->
      <main>
        <slot />
      </main>
    </div>
    <!-- Footer -->
    <div v-if="settings" dir="ltr">
      <Footer :settings="settings" />
    </div>
  </div>
</template>

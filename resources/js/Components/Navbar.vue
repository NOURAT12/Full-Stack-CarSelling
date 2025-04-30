<template>
  <nav class="bg-white shadow sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
      <!-- Logo -->
      <div
        class="flex items-center space-x-3 rtl:space-x-reverse"
        v-if="settings"
      >
        <span class="font-bold text-xl text-blue-600">
          {{ settings.website_name }}
        </span>
        <img :src="settings.logo" alt="Logo" class="h-10 w-auto" />
      </div>

      <!-- Desktop Links -->
      <div class="hidden md:flex items-center space-x-6 rtl:space-x-reverse">
        <a href="#latest-cars" class="hover:text-blue-600 font-medium"
          >{{translations.latest}}</a
        >
        <a href="#featured-cars" class="hover:text-blue-600 font-medium"
          >{{translations.featured}}</a
        >
        <a href="#sold-cars" class="hover:text-blue-600 font-medium"
          >{{translations.sold_car}}</a
        >
        <a href="#reviews" class="hover:text-blue-600 font-medium">{{translations.reviews}}</a>
        <a href="#contact" class="hover:text-blue-600 font-medium">{{translations.contact}}</a>

        <!-- زر تبديل اللغة -->
        <button
          @click="toggleLang"
          class="flex items-center space-x-2 rtl:space-x-reverse bg-gray-100 px-3 py-1 rounded hover:bg-gray-200"
        >
          <span class="text-lg">🌐</span>
          <span>{{ locale === "en" ? "العربية" : "English" }}</span>
        </button>
      </div>

      <!-- Mobile menu button -->
      <button
        @click="isMobileMenuOpen = !isMobileMenuOpen"
        class="md:hidden focus:outline-none"
      >
        <svg
          class="h-6 w-6 text-gray-800"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            v-if="!isMobileMenuOpen"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M4 6h16M4 12h16M4 18h16"
          />
          <path
            v-else
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M6 18L18 6M6 6l12 12"
          />
        </svg>
      </button>
    </div>

    <!-- Mobile Links -->
    <div v-if="isMobileMenuOpen" class="md:hidden px-4 pb-4 space-y-2">
      <a
        href="#latest-cars"
        class="block py-2 text-gray-800 hover:text-blue-600"
        @click="isMobileMenuOpen = false"
        >{{translations.latest}}</a
      >
      <a
        href="#featured-cars"
        class="block py-2 text-gray-800 hover:text-blue-600"
        @click="isMobileMenuOpen = false"
        >{{translations.featured}}</a
      >
      <a
        href="#sold-cars"
        class="block py-2 text-gray-800 hover:text-blue-600"
        @click="isMobileMenuOpen = false"
        >{{translations.sold}}</a
      >
      <a
        href="#reviews"
        class="block py-2 text-gray-800 hover:text-blue-600"
        @click="isMobileMenuOpen = false"
        >{{translations.reviews}}</a
      >
      <a
        href="#contact"
        class="block py-2 text-gray-800 hover:text-blue-600"
        @click="isMobileMenuOpen = false"
        >{{translations.contact}}</a
      >
      <!-- زر تبديل اللغة في الموبايل -->
      <button
        @click="toggleLang"
        class="flex items-center space-x-2 rtl:space-x-reverse bg-gray-100 px-3 py-2 rounded hover:bg-gray-200 w-full mt-2"
      >
        <span class="text-lg">🌐</span>
        <span>{{ locale === "en" ? "العربية" : "English" }}</span>
      </button>
    </div>
  </nav>
</template>

  <script setup>
import { router } from "@inertiajs/vue3";
import { ref, onMounted, watch } from "vue";

const props = defineProps({
  settings: Object,
  locale: String,
  translations: Object,
});

const isMobileMenuOpen = ref(false);
const localeState = ref(localStorage.getItem('locale') || props.locale || 'en');

function toggleLang() {
  const newLang = localeState.value === "en" ? "ar" : "en";
  localeState.value = newLang;
  localStorage.setItem('locale', newLang);

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

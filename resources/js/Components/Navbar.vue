<template>
  <nav class="bg-white shadow sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
      <!-- Logo -->
      <div class="flex items-center space-x-3 rtl:space-x-reverse">
        <img :src="settings.logo" alt="Logo" class="h-10 w-auto" />
        <span class="font-bold text-xl text-blue-600">{{
          settings.siteName
        }}</span>
      </div>

      <!-- Links -->
      <div class="hidden md:flex space-x-6 rtl:space-x-reverse">
        <a href="#latest-cars" class="hover:text-blue-600 font-medium"
          >Latest cars</a
        >
        <a href="#featured-cars" class="hover:text-blue-600 font-medium"
          >Featured cars</a
        >
        <a href="#sold-cars" class="hover:text-blue-600 font-medium"
          >Sold cars</a
        >
        <a href="#reviews" class="hover:text-blue-600 font-medium">Reviews</a>
        <a href="#contact" class="hover:text-blue-600 font-medium">Contact</a>
        <!-- Language Switcher -->
        <button
          @click="switchLang"
          class="text-sm bg-gray-200 px-3 py-1 rounded"
        >
          {{ currentLang === "ar" ? "EN" : "ع" }}
        </button>
      </div>
    </div>
  </nav>
</template>

  <script setup>
import { ref } from "vue";
const props = defineProps({
  settings: Object,
});

const currentLang = ref("ar");
const showDropdown = ref(false);

const toggleDropdown = () => {
  showDropdown.value = !showDropdown.value;
};

const switchLang = () => {
  currentLang.value = currentLang.value === "ar" ? "en" : "ar";
  // ممكن ترسل طلب تغيير اللغة للسيرفر أو تستخدم LocalStorage
};
</script>

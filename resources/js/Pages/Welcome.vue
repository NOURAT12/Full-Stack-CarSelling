<template>
    <div class="min-h-screen bg-gray-100 flex flex-col justify-between">
      <!-- Header -->
      <header class="flex items-center justify-between px-6 py-4 bg-white shadow">
        <!-- Logo and Website Name -->
        <div class="flex items-center space-x-4">
          <!-- Logo -->
          <img :src="settings.logo" alt="Logo" class="h-8 w-auto" />

          <h1 class="text-2xl font-bold text-blue-700">{{ settings.website_name }}</h1>
        </div>

        <div class="flex space-x-4">
          <Link :href="route('login')" class="btn">Login</Link>
          <Link :href="route('register')" class="btn bg-green-600 hover:bg-green-700">Register</Link>
          <button @click="toggleLanguage" class="btn bg-gray-200">🌐 {{ currentLang }}</button>
        </div>
      </header>

      <!-- Hero Section -->
      <section class="relative h-[70vh] flex items-center justify-center text-white">
        <img :src="currentImage" alt="hero" class="absolute inset-0 w-full h-full object-cover opacity-70" />
        <div class="relative z-10 text-center">
          <h2 class="text-4xl font-bold mb-4 animate-fade">{{ currentTitle }}</h2>
          <Link :href="route('userhome')" class="btn bg-blue-600 hover:bg-blue-700 mt-4">Explore Cars</Link>
        </div>
      </section>

      <!-- CTA for Sellers -->
      <section class="bg-blue-50 py-10 text-center">
        <h3 class="text-2xl font-semibold mb-4">Are you a car seller?</h3>
        <p class="mb-4 text-gray-700">Join us now and showcase your cars to thousands of buyers.</p>
        <Link :href="route('register')" class="btn bg-green-600 hover:bg-green-700">Start Selling</Link>
      </section>

      <!-- Footer -->
      <Footer :settings="settings" />

    </div>
  </template>

  <script setup>
  import { Link } from '@inertiajs/vue3'
  import { ref, onMounted } from 'vue'
  import Footer from "@/Components/Footer.vue";


  const props = defineProps({
    settings: Object,
  })

  const currentLang = ref('EN')
  function toggleLanguage() {
    currentLang.value = currentLang.value === 'EN' ? 'AR' : 'EN'
  }
const titles = JSON.parse(props.settings.titles || '[]');
const images = JSON.parse(props.settings.images || '[]');

const currentTitle = ref(titles[0] || '');
const currentImage = ref(images[0] || '');

let titleIndex = 0;
let imageIndex = 0;

onMounted(() => {
  setInterval(() => {
    titleIndex = (titleIndex + 1) % titles.length;
    imageIndex = (imageIndex + 1) % images.length;

    currentTitle.value = titles[titleIndex];
    currentImage.value = images[imageIndex];
  }, 4000);
}); // كل ٤ ثواني
  </script>

  <style scoped>
  .btn {
    @apply px-4 py-2 rounded-md text-white font-semibold bg-blue-600 hover:bg-blue-700 transition;
  }
  .animate-fade {
    animation: fade 2s ease-in-out infinite alternate;
  }

  @keyframes fade {
    0% { opacity: 0.2; }
    100% { opacity: 1; }
  }

  </style>

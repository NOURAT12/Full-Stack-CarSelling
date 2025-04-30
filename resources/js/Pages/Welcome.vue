<template>
  <div class="min-h-screen bg-gray-100 flex flex-col justify-between">
    <!-- Header -->
    <header class="flex items-center justify-between px-6 py-4 bg-white shadow">
      <div class="flex items-center space-x-4" v-if="settings">
        <img :src="settings.logo" alt="Logo" class="h-8 w-auto" />
        <h1 class="text-2xl font-bold text-blue-700">
          {{ settings.website_name }}
        </h1>
    </div>
      <div class="flex space-x-4 rtl:space-x-reverse ">
        <Link :href="route('login')" class="btn">{{translations.login}}</Link>
        <Link
          :href="route('register')"
          class="btn"
          >{{translations.register}}</Link
        >
        <button @click="toggleLang" class="lang-btn flex items-center space-x-2">
            <span class="text-lg">🌐</span>
            <span>{{ locale === 'en' ? 'العربية' : 'English' }}</span>
          </button>



      </div>
    </header>
    <div v-if="settings">
      <!-- Hero Section -->
      <section
        class="relative h-[70vh] md:h-[60vh] lg:h-[50vh] flex items-center justify-center text-white"
      >
        <img
          :src="currentImage"
          alt="hero"
          class="absolute inset-0 w-full h-full object-cover opacity-70"
        />
        <div class="relative z-10 text-center">
          <h2 class="text-4xl md:text-3xl font-bold mb-4 animate-fade">
            {{ currentTitle }}
          </h2>
          <Link
            :href="route('userhome')"
            class="btn bg-blue-600 hover:bg-blue-700 mt-4"
            >{{translations.explore}}</Link
          >
        </div>
      </section>
    </div>
    <!-- CTA for Sellers -->
    <section class="bg-blue-50 py-10 text-center">
      <h3 class="text-2xl font-semibold mb-4">{{translations.explore}}</h3>
      <p class="mb-4 text-gray-700">
        {{translations.join}}
      </p>
      <Link
        :href="route('register')"
        class="btn bg-green-600 hover:bg-green-700"
        >{{translations.start}}</Link
      >
    </section>

    <!-- Footer -->
    <div v-if="settings" dir="ltr">
      <Footer :settings="settings"  />
    </div>
  </div>
</template>

  <script setup>
import { Link } from "@inertiajs/vue3";
import { ref, onMounted ,watch} from "vue";
import Footer from "@/Components/Footer.vue";
import { router } from '@inertiajs/vue3';


const props = defineProps({
  settings: Object,
  locale: String,
  translations: Object,
});
const locale = ref(localStorage.getItem('locale') || props.locale || 'en');
    router.reload({
      preserveScroll: true,
      preserveState: true,
      headers: {
        "X-Locale": locale.value,
      },
    });
function toggleLang() {
  const newLang = locale.value === 'en' ? 'ar' : 'en';
  locale.value = newLang;
  localStorage.setItem('locale', newLang); // <--- اضف هذه


  router.reload({
    preserveScroll: true,
    preserveState: true,
    headers: {
      'X-Locale': newLang,
    },
  });
}


function updateDirection(lang) {
  document.documentElement.setAttribute("dir", lang === "ar" ? "rtl" :  "ltr");
}

// تحديث الاتجاه أول ما يشتغل
onMounted(() => {
  updateDirection(locale.value);
});

// تحديث الاتجاه كل ما تتغير اللغة
watch(locale, (newLang) => {
  updateDirection(newLang);
});

const titles = JSON.parse(props.settings.titles || "[]");
const images = JSON.parse(props.settings.images || "[]");

const currentTitle = ref(titles[0] || "");
const currentImage = ref(images[0] || "");


let titleIndex = 0;
let imageIndex = 0;

onMounted(() => {
  setInterval(() => {
    titleIndex = (titleIndex + 1) % titles.length;
    imageIndex = (imageIndex + 1) % images.length;

    currentTitle.value = titles[titleIndex];
    currentImage.value = images[imageIndex];
  }, 4000);
});

</script>

  <style scoped>
.btn {
  @apply px-4 py-2 rounded-md text-white font-semibold bg-blue-600 hover:bg-blue-700 transition;
  font-size: 1rem;
  padding: 0.75rem 1.5rem;
}
.lang-btn {
    @apply px-4 py-2 rounded-md border border-blue-600 text-blue-600 font-medium hover:bg-blue-600 hover:text-white transition duration-300;
  }


.animate-fade {
  animation: fade 2s ease-in-out infinite alternate;
}

@keyframes fade {
  0% {
    opacity: 0.2;
  }
  100% {
    opacity: 1;
  }
}

@media (max-width: 768px) {
  /* For small devices */
  .text-4xl {
    font-size: 2rem;
  }
  .btn {
    font-size: 0.875rem;
    padding: 0.5rem 1.25rem;
  }
}

@media (max-width: 480px) {
  /* For extra small devices */
  .text-2xl {
    font-size: 1.5rem;
  }
  .text-4xl {
    font-size: 1.875rem;
  }
  .btn {
    font-size: 0.75rem;
    padding: 0.5rem 1rem;
  }
}
</style>

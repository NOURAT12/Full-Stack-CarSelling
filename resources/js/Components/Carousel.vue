<template>
    <div class="w-full ">
      <div class="max-w-7xl mx-auto  relative overflow-hidden">
        <!-- الحاوية الرئيسية التي تحتوي على الصور -->
        <div
          class="flex transition-transform duration-500 ease-in-out"
          :style="{ transform: `translateX(-${currentIndex * 100}%)` }"
        >
          <div
            v-for="(image, index) in images"
            :key="index"
            class="w-full flex-shrink-0 relative"
          >
            <img
              :src="image"
              alt="Carousel Image"
              class="w-full h-64 object-cover"
            />
            <div class="absolute top-0 left-0 w-full h-full bg-black bg-opacity-40 flex items-center justify-center">
              <h3 class="text-2xl font-bold text-white">
                {{ titles[index] }}
              </h3>
            </div>
          </div>
        </div>

        <!-- أزرار التنقل اليدوي -->
        <button
          @click="prev"
          class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-white p-2 rounded-full shadow hover:bg-gray-100"
        >
          ‹
        </button>
        <button
          @click="next"
          class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-white p-2 rounded-full shadow hover:bg-gray-100"
        >
          ›
        </button>
      </div>
    </div>
  </template>

  <script setup>
  import { ref, onMounted, onBeforeUnmount } from "vue";

  const props = defineProps({
    images: Array,
    titles: Array,
  });

  const currentIndex = ref(0);

  // دالة الانتقال للصور التالية
  const next = () => {
    currentIndex.value = (currentIndex.value + 1) % props.images.length;
  };

  // دالة الانتقال للصور السابقة
  const prev = () => {
    currentIndex.value =
      (currentIndex.value - 1 + props.images.length) % props.images.length;
  };

  // دالة التبديل التلقائي كل فترة معينة
  let autoSwitchInterval;
  const startAutoSwitch = () => {
    autoSwitchInterval = setInterval(next, 3000); // 3000 ملي ثانية = 3 ثواني
  };

  // إيقاف التبديل التلقائي
  const stopAutoSwitch = () => {
    clearInterval(autoSwitchInterval);
  };

  // إيقاف التبديل التلقائي عند التنقل يدويًا
  const handleUserInteraction = () => {
    stopAutoSwitch();
    startAutoSwitch();
  };

  // عند تحميل الصفحة نبدأ التبديل التلقائي
  onMounted(() => {
    startAutoSwitch();
  });

  // عند مغادرة الصفحة نوقف التبديل التلقائي
  onBeforeUnmount(() => {
    stopAutoSwitch();
  });
  </script>

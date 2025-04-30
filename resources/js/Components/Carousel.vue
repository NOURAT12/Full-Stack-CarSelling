<template>
  <div class="w-full">
    <div
      class="max-w-7xl mx-auto relative overflow-hidden"
      :dir="isRtl ? 'rtl' : 'ltr'"
    >
      <!-- الحاوية الرئيسية التي تحتوي على الصور -->
      <div
        class="flex transition-transform duration-500 ease-in-out"
        :style="{
          transform: `translateX(${
            isRtl ? currentIndex * 100 : -currentIndex * 100
          }%)`,
        }"
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
          <div
            class="absolute top-0 left-0 w-full h-full bg-black bg-opacity-40 flex items-center justify-center"
          >
            <h3 class="text-2xl font-bold text-white">
              {{ titles[index] }}
            </h3>
          </div>
        </div>
      </div>

      <!-- أزرار التنقل اليدوي -->
      <!-- زر الرجوع -->
      <button
        @click="isRtl ? next() : prev()"
        class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-white p-2 rounded-full shadow hover:bg-gray-100"
      >
      <div v-if="isRtl">›</div>
      <div v-else>‹</div>
      </button>

      <!-- زر التقدم -->
      <button
        @click="isRtl ? prev() : next()"
        class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-white p-2 rounded-full shadow hover:bg-gray-100"
      >
      <div v-if="isRtl">‹</div>
      <div v-else>›</div>

      </button>
    </div>
  </div>
</template>

  <script setup>
import { ref, computed, onMounted, onBeforeUnmount } from "vue";

const props = defineProps({
  images: Array,
  titles: Array,
});

const locale = ref(localStorage.getItem("locale") || "en");
const isRtl = computed(() => locale.value === "ar");

const currentIndex = ref(0);

const next = () => {
  currentIndex.value = (currentIndex.value + 1) % props.images.length;
};

const prev = () => {
  currentIndex.value =
    (currentIndex.value - 1 + props.images.length) % props.images.length;
};

let autoSwitchInterval;
const startAutoSwitch = () => {
  autoSwitchInterval = setInterval(() => {
    isRtl.value ? prev() : next();
  }, 3000);
};

const stopAutoSwitch = () => {
  clearInterval(autoSwitchInterval);
};

onMounted(() => {
  startAutoSwitch();
});

onBeforeUnmount(() => {
  stopAutoSwitch();
});
</script>

  <style scoped>
button {
  transition: background-color 0.3s ease;
}
</style>

<template>
  <div
    v-if="currentAd"
    class="relative w-full overflow-hidden rounded-xl shadow-lg"
  >
    <!-- الصورة -->
    <img
      :src="currentAd.image"
      alt="Banner"
      class="w-full h-[300px] object-contain bg-black cursor-pointer"
      @click="handleBannerClick"
    />


    <!-- المحتوى فوق الصورة -->
    <div
      class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4 text-white"
    >
      <h3 class="text-xl font-semibold truncate">{{ currentAd.full_name }}</h3>
      <p class="text-sm opacity-90">{{ currentAd.location }}</p>
    </div>

    <!-- أزرار التبديل اليدوي -->
    <button
      @click.stop="prevAd"
      class="absolute left-2 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/70 text-white p-2 rounded-full"
    >
      ‹
    </button>
    <button
      @click.stop="nextAd"
      class="absolute right-2 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/70 text-white p-2 rounded-full"
    >
      ›
    </button>
  </div>
</template>

  <script setup>
import { ref, onMounted, onUnmounted } from "vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
  ads: Array,
  intervalSeconds: {
    type: Number,
    default: 5,
  },
});

const currentIndex = ref(0);
const currentAd = ref(props.ads[0]);

let interval;

const startAutoSlide = () => {
  interval = setInterval(() => {
    nextAd();
  }, props.intervalSeconds * 1000);
};

const resetAutoSlide = () => {
  clearInterval(interval);
  startAutoSlide();
};

const nextAd = () => {
  currentIndex.value = (currentIndex.value + 1) % props.ads.length;
  currentAd.value = props.ads[currentIndex.value];
  resetAutoSlide();
};

const prevAd = () => {
  currentIndex.value =
    (currentIndex.value - 1 + props.ads.length) % props.ads.length;
  currentAd.value = props.ads[currentIndex.value];
  resetAutoSlide();
};

onMounted(() => {
  if (props.ads.length > 1) {
    startAutoSlide();
  }
});

onUnmounted(() => {
  clearInterval(interval);
});

const handleBannerClick = () => {
  const ad = currentAd.value;
  const form = useForm({
    ad_id: ad.id,
  });

  form.post(route("ads.incrementHit", { id: ad.id }), {
    onSuccess: () => console.log("Hit incremented!"),
    onError: (error) => console.error("Error:", error),
  });

  window.location.href = ad.ad_url;
};
</script>

  <style scoped>
button {
  transition: background-color 0.3s ease;
}
</style>

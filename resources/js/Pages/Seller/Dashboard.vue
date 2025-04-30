<script setup>
import SellerAuthenticatedLayout from "@/Layouts/SellerAuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import Card from "@/Components/Card.vue";
import { router } from "@inertiajs/vue3";
import { ref , onMounted } from "vue";
const props = defineProps({
  cars: Object,
  settings: Object,
  locale: String,
  translations: Object,
});
const localeState = ref(localStorage.getItem("locale") || props.locale || "en");
router.reload({
  preserveScroll: true,
  preserveState: true,
  headers: {
    "X-Locale": localeState.value,
  },

});
function updateDirection(lang) {
  document.documentElement.setAttribute("dir", lang === "ar" ? "rtl" : "ltr");
}
onMounted(() => {
  updateDirection(localeState.value);
});
</script>

<template>
  <Head title="Dashboard" />

  <SellerAuthenticatedLayout :locale="locale" :translations="translations" :settings="settings">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Cars</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- عرض السيارات -->
        <div v-if="cars.data.length > 0">
          <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            <Card :translations="translations" v-for="car in cars.data" :key="car.id" :car="car"> </Card>
          </div>

          <!-- روابط التصفح -->
          <div class="mt-8 flex justify-center">
            <nav class="inline-flex items-center space-x-1">
              <template v-for="(link, index) in cars.links" :key="index">
                <Link
                  v-if="link.url"
                  :href="link.url"
                  :class="[
                    'px-4 py-2 border text-sm rounded',
                    link.active
                      ? 'bg-indigo-500 text-white'
                      : 'bg-white text-gray-700 hover:bg-gray-100',
                  ]"
                >
                  <span v-html="link.label" />
                </Link>
                <span
                  v-else
                  class="px-4 py-2 border text-sm text-gray-400 rounded cursor-not-allowed"
                >
                  <span v-html="link.label" />
                </span>
              </template>
            </nav>
          </div>
        </div>

        <!-- لا توجد سيارات -->
        <div v-else class="text-center text-gray-500 text-lg mt-10">
          {{ translations.you }}
        </div>
      </div>
    </div>
  </SellerAuthenticatedLayout>
</template>

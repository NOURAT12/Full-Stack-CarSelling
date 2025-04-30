<script setup>
import ComplaintCard from "@/Components/ComplaintCard.vue";
import SellerAuthenticatedLayout from "@/Layouts/SellerAuthenticatedLayout.vue";
import { router } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import { ref, computed } from "vue";

const props = defineProps({
  reviews: Object,
  settings: Object,
  locale: String,
  translations: Object,
});
const filterStatus = ref("all");

const filteredReviews = computed(() => {
  if (filterStatus.value === "approved") {
    return props.reviews.data.filter((review) => review.status === 1);
  } else if (filterStatus.value === "rejected") {
    return props.reviews.data.filter((review) => review.status === 0);
  }
  return props.reviews.data;
});
const handleReviewAction = (id, status) => {
  router.post(route("reviews.status", id), { status });
};
</script>

<template>
  <SellerAuthenticatedLayout :locale="locale" :translations="translations" :settings="settings">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{translations.reviews}}</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div v-if="reviews.data.length > 0">
          <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            <ComplaintCard
            :translations="translations"
              v-for="review in reviews.data"
              :key="review.id"
              :review="review"
            />
          </div>

          <div class="mt-8 flex justify-center">
            <nav class="inline-flex items-center space-x-1">
              <template v-for="(link, index) in reviews.links" :key="index">
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

        <div v-else class="text-center text-gray-500 text-lg mt-10">
            {{translations.You_review}}
        </div>
      </div>
    </div>
  </SellerAuthenticatedLayout>
</template>

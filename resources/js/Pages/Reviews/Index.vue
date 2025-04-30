<script setup>
import ComplaintCard from "@/Components/ComplaintCard.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { router, Link } from "@inertiajs/vue3";
import {  ref } from "vue";

const props = defineProps({
  reviews: Object,
  settings: Object,
  filterStatus: {
    type: String,
    default: "all",
  },
  translations: Object,
  locale: String,
});

const filterStatus = ref(props.filterStatus);

const fetchFilteredReviews = (status) => {
  filterStatus.value = status;

  const params = {};
  if (status !== "all") {
    params.status = status;
  }

  router.get(route("reviews.index"), params, {
    preserveScroll: true,
    preserveState: true,
  });

};
const handleReviewAction = (id, status) => {
    const locale = localStorage.getItem('locale') || props.locale || 'en';

    router.post(route("reviews.status", id), { status } ,{
       onSuccess: () => {
      router.reload({
        preserveScroll: true,
        preserveState: true,
        headers: {
          'X-Locale': locale,
        },
      });
    }
    });

  };



</script>

<template>
  <AuthenticatedLayout :translations="translations" :locale="locale" :settings="settings">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{translations.reviews}}</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- أزرار الفلترة -->
        <div class="flex gap-2 mb-4">
          <button
            class="px-4 py-2 rounded text-sm font-medium"
            :class="filterStatus === 'all' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700'"
            @click="fetchFilteredReviews('all')"
          >
          {{translations.all}}
          </button>
          <button
            class="px-4 py-2 rounded text-sm font-medium"
            :class="filterStatus === 'approved' ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700'"
            @click="fetchFilteredReviews('approved')"
          >
          {{translations.approved}}
          </button>
          <button
            class="px-4 py-2 rounded text-sm font-medium"
            :class="filterStatus === 'rejected' ? 'bg-red-600 text-white' : 'bg-gray-200 text-gray-700'"
            @click="fetchFilteredReviews('rejected')"
          >
          {{translations.rejected}}
          </button>
        </div>

        <!-- عرض المراجعات -->
        <div v-if="reviews.data.length > 0">
          <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            <ComplaintCard
            :translations="translations"
              v-for="review in reviews.data"
              :key="review.id"
              :review="review"
              @approve="handleReviewAction"
              @reject="handleReviewAction"
            />
          </div>

          <!-- روابط التصفح -->
          <div class="mt-8 flex justify-center">
            <nav class="inline-flex items-center space-x-1">
              <template v-for="(link, index) in reviews.links" :key="index">
                <Link
                  v-if="link.url"
                  :href="link.url"
                  :preserve-scroll="true"
                  :preserve-state="true"
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

        <!-- لا توجد مراجعات -->
        <div v-else class="text-center text-gray-500 text-lg mt-10">
            {{translations.you_review}}
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

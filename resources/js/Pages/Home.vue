<template>
  <Head title="Home" />
  <UserAuthenticatedLayout :settings="settings">
  <!-- Navbar -->
    <Navbar :settings="settings" :locale="locale" :translations="translations"/>


    <!-- Sections -->

    <div class="max-w-7xl mx-auto mt-10 px-4 space-y-10">
      <!-- Carousel -->
      <Carousel :images="settings.images" :titles="settings.titles" />

      <!-- Banner -->
      <div class="mt-10">
        <h2 class="text-2xl font-bold text-gray-700">{{translations.advertisements}}</h2>
        <Banner  :ads="ads" :interval-seconds="7" />
      </div>

      <CarSearch :translations="translations" />

      <!-- آخر 6 سيارات تمت إضافتها -->
      <div id="latest-cars" >
        <h2 class="text-2xl font-bold mb-4 text-gray-700">{{translations.latest}}</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <Card :translations="translations" v-for="car in latestCars" :key="car.id" :car="car" />
        </div>
      </div>

      <!-- 3 سيارات عشوائية -->
      <div id="featured-cars">
        <h2 class="text-2xl font-bold mb-4 text-gray-700">{{translations.featured}}</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <Card :translations="translations" v-for="car in randomCars" :key="car.id" :car="car" />
        </div>
      </div>

      <!-- 5 سيارات تم بيعها -->
      <div id="sold-cars">
        <h2 class="text-2xl font-bold mb-4 text-gray-700">{{translations.sold_car}}</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <Card :translations="translations" v-for="car in soldCars" :key="car.id" :car="car" />
        </div>
      </div>

      <!-- تقييمات العملاء -->
      <div class="mt-10 " id="reviews">
        <div class="flex justify-between items-center ">
          <h2 class="text-2xl font-bold text-gray-700">{{translations.reviews}}</h2>
          <button
            @click="showReviewForm = true"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition mb-2"
          >
          {{translations.add_review}}
          </button>
        </div>
        <div>
          <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 mb-2">
            <Complaint
            :translations="translations"
              v-for="review in reviews"
              :key="review.id"
              :review="review"
            />
          </div>
        </div>
      </div>
      <!-- Modal -->
      <div
        v-if="showReviewForm"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
      >
        <div class="bg-white rounded-lg w-full max-w-md p-6">
          <h3 class="text-xl font-bold mb-4 text-gray-700">{{translations.send_review}}</h3>
          <form @submit.prevent="submitReview">
            <div class="mb-3">
              <label class="block text-sm text-gray-600 mb-1">{{translations.name}}</label>
              <input
                v-model="form.name"
                type="text"
                class="w-full border px-3 py-2 rounded"
                required
              />
            </div>
            <div class="mb-3">
              <label class="block text-sm text-gray-600 mb-1">{{translations.phone}}</label>
              <input
                v-model="form.phone"
                type="text"
                class="w-full border px-3 py-2 rounded"
                required
              />
            </div>
            <div class="mb-3">
              <label class="block text-sm text-gray-600 mb-1">{{translations.content}}</label>
              <textarea
                v-model="form.content"
                rows="3"
                class="w-full border px-3 py-2 rounded"
                required
              ></textarea>
            </div>

            <div class="flex justify-end space-x-2">
              <button
                type="button"
                @click="showReviewForm = false"
                class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
              >
              {{translations.cancle}}
              </button>
              <button
                type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
              >
              {{translations.send}}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </UserAuthenticatedLayout>
</template>

  <script setup>
import { Head, useForm } from "@inertiajs/vue3";
import Navbar from "@/Components/Navbar.vue";
import Carousel from "@/Components/Carousel.vue";
import Banner from "@/Components/Banner.vue";
import CarSearch from "@/Components/CarSearch.vue";
import Card from "@/Components/Card.vue";
import Complaint from "@/Components/Complaint.vue";
import UserAuthenticatedLayout from "@/Layouts/UserAuthenticatedLayout.vue";
import { ref } from "vue";


const props = defineProps({
  settings: Object,
  ads: Object,
  latestCars: Object,
  randomCars: Object,
  soldCars: Object,
  reviews: Object,
  locale: String,
  translations: Object,
});

const showReviewForm = ref(false);

const form = useForm({
  name: "",
  phone: "",
  content: "",
  is_public: "1",
});

const submitReview = () => {
  form.post(route("reviews.store"), {
    onSuccess: () => {
      form.reset(); // يعيد تعيين النموذج
      showReviewForm.value = false; // يغلق المودال
    },
    onError: (errors) => {
      console.error("حدثت أخطاء في الإرسال:", errors);
    },
  });
};
</script>

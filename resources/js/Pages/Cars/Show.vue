<script setup>
import SellerAuthenticatedLayout from "@/Layouts/SellerAuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";

const props=defineProps({
  car: Object,
  user: Object,
  settings: Object,
  locale: String,
  translations: Object,
});
const showReviewForm = ref(false);

const form = useForm({
  name: "",
  phone: "",
  content: "",
  is_public: "0",
  car_id: props.car.id
});

const submitReview = () => {
  form.post(route("user.reviews"), {
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

<template>
  <Head :title="`${car.brand} ${car.model}`" />

  <SellerAuthenticatedLayout  :locale="locale" :translations="translations" :settings="settings">
    <div class="max-w-6xl mx-auto py-12 px-6">
      <div class="mb-10 flex justify-between   items-center">
        <div class="mb-10">
          <h1 class="text-4xl font-extrabold text-gray-900">
            {{ car.brand }} {{ car.model }}
            <span class="text-gray-500">({{ car.year }})</span>
          </h1>
          <p class="mt-2 text-lg text-gray-600">{{ car.description }}</p>
        </div>
        <div>
          <!-- تقييمات العملاء -->
          <div class="mt-10" id="reviews">
            <div class="flex justify-between items-center">
              <button
                @click="showReviewForm = true"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition mb-2"
              >
              {{translations.add_review}}
              </button>
            </div>
            <div>
              <div
                class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 mb-2"
              >
                <Complaint
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
              <h3 class="text-xl font-bold mb-4 text-gray-700">{{translations.send_review}}
            </h3>
              <form @submit.prevent="submitReview">
                <div class="mb-3">
                  <label class="block text-sm text-gray-600 mb-1">{{translations.name}}
                </label>
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
                  <label class="block text-sm text-gray-600 mb-1"
                    >{{translations.content}}</label
                  >
                  <textarea
                    v-model="form.content"
                    rows="3"
                    class="w-full border px-3 py-2 rounded"
                    required
                  ></textarea>
                </div>

                <div class="flex justify-end space-x-2 rtl:space-x-reverse">
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
      </div>

      <!-- Image Gallery -->
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5 mb-10">
        <img
          v-for="(image, index) in car.images"
          :key="index"
          :src="image"
          class="w-full h-60 object-cover rounded-lg shadow-md hover:scale-105 transition-transform duration-300"
          alt="Car Image"
        />
      </div>

      <!-- Car Details -->
      <div
        class="bg-white shadow-lg rounded-lg p-6 space-y-4 text-base text-gray-800"
      >
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
          <div>
            <strong class="text-gray-700">{{translations.price}}</strong>
            <p class="text-green-600 font-semibold text-xl mt-1">
              {{ car.price }} $
            </p>
          </div>
          <div>
            <strong class="text-gray-700">{{translations.status}}</strong>
            <p
              :class="car.sold === '1' ? 'text-red-600' : 'text-green-500'"
              class="mt-1"
            >
              {{ car.sold == "1" ? translations.sold : translations.available }}
            </p>
          </div>
          <div>
            <strong class="text-gray-700">{{translations.color}}</strong>
            <p class="mt-1 capitalize">{{ car.color }}</p>
          </div>
          <div>
            <strong class="text-gray-700">{{translations.city}}</strong>
            <p class="mt-1">{{ car.city }}</p>
          </div>
          <div>
            <strong class="text-gray-700">{{translations.country}}</strong>
            <p class="mt-1">{{ car.country }}</p>
          </div>
          <div>
            <strong class="text-gray-700">{{translations.year}}:</strong>
            <p class="mt-1">{{ car.year }}</p>
          </div>
          <!-- New Contact Info Fields -->
          <div v-if="user">
            <div>
              <strong class="text-gray-700">{{translations.mobile_number}}</strong>
              <p class="mt-1">{{ user.mobileno }}</p>
            </div>
            <div>
              <strong class="text-gray-700 block">{{translations.email}}</strong>
              <a
                :href="`mailto:${user.email}`"
                class="mt-1 text-black-600 hover:underline break-all"
              >
                {{ user.email }}
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </SellerAuthenticatedLayout>
</template>

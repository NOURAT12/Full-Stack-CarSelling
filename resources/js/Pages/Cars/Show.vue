<script setup>
import SellerAuthenticatedLayout from "@/Layouts/SellerAuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

defineProps({
  car: Object,
  user: Object,
  settings: Object,
});
</script>

<template>
  <Head :title="`${car.brand} ${car.model}`" />

  <SellerAuthenticatedLayout :settings="settings">
    <div class="max-w-6xl mx-auto py-12 px-6">
      <div class="mb-10">
        <h1 class="text-4xl font-extrabold text-gray-900">
          {{ car.brand }} {{ car.model }}
          <span class="text-gray-500">({{ car.year }})</span>
        </h1>
        <p class="mt-2 text-lg text-gray-600">{{ car.description }}</p>
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
            <strong class="text-gray-700">Price:</strong>
            <p class="text-green-600 font-semibold text-xl mt-1">
              {{ car.price }} $
            </p>
          </div>
          <div>
            <strong class="text-gray-700">Status:</strong>
            <p
              :class="car.sold ? 'text-red-600' : 'text-green-500'"
              class="mt-1"
            >
              {{ car.sold ? "Sold" : "Available" }}
            </p>
          </div>
          <div>
            <strong class="text-gray-700">Color:</strong>
            <p class="mt-1 capitalize">{{ car.color }}</p>
          </div>
          <div>
            <strong class="text-gray-700">City:</strong>
            <p class="mt-1">{{ car.city }}</p>
          </div>
          <div>
            <strong class="text-gray-700">Country:</strong>
            <p class="mt-1">{{ car.country }}</p>
          </div>
          <div>
            <strong class="text-gray-700">Year:</strong>
            <p class="mt-1">{{ car.year }}</p>
          </div>
          <!-- New Contact Info Fields -->
          <div v-if="user">
          <div >
            <strong class="text-gray-700">Mobile Number:</strong>
            <p class="mt-1">{{ user.mobileno }}</p>
          </div>
          <div>
            <strong class="text-gray-700 block">Email:</strong>
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

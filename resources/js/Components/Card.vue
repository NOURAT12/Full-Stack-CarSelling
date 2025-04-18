<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
  car: Object,
});
</script>

<template>
  <Link :href="route('cars.show', car.id)" class="block">
    <div class="bg-white overflow-hidden shadow-lg rounded-lg p-4 hover:shadow-xl transition-shadow duration-300">
      <img
        v-if="car.image"
        class="w-full h-48 object-cover rounded-lg mb-4"
        :src="car.image"
        :alt="`${car.brand} ${car.model}`"
      />
      <div v-else class="w-full h-48 bg-gray-200 rounded-lg mb-4 flex items-center justify-center text-gray-500">
        No Image
      </div>

      <h3 class="text-xl font-semibold text-gray-800 mb-2">
        {{ car.brand }} {{ car.model }} - {{ car.year }}
      </h3>

      <p class="text-sm text-gray-600 mb-2">
        {{ car.description }}
      </p>

      <div class="flex items-center justify-between mt-4">
        <span class="text-green-600 font-bold">{{ car.price }} $</span>
        <span
          class="text-xs font-medium"
          :class="car.sold ? 'text-red-600' : 'text-green-500'"
        >
          {{ car.sold ? "Sold" : "Available" }}
        </span>
      </div>
    </div>
  </Link>
</template>

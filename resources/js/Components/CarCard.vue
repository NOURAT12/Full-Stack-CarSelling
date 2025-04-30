<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
  car: Object,
  translations: Object,

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
        {{translations.no_image}}
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
          :class="car.sold === '1'?  'text-red-600' : 'text-green-500'"
        >
        {{ car.sold == "1" ? translations.sold : translations.available }}
    </span>
      </div>

      <!-- Edit and Delete buttons -->
      <div class="mt-4 flex space-x-4 rtl:space-x-reverse justify-end">
        <Link
          :href="route('cars.edit', car.id)"
          class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 text-white rounded-md text-sm"
        >
        {{translations.edit}}
        </Link>
        <Link
        :href="route('cars.destroy', car.id)"
        method="delete"
        as="button"
        type="button"
        class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-md text-sm"
        >{{translations.delete}}
      </Link>
      </div>
    </div>
  </Link>
</template>

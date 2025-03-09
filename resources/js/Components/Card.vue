<script setup>
import { Link } from "@inertiajs/vue3";
defineProps({
  car: Object,
});
</script>
<template>
  <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
    <div class="mb-6">
      <img class="w-full h-px-200 rounded-2xl" :src="car.path" :alt="car.name" />
    </div>

    <h3 class="group-hover:text-light-tail-500 text-xl font-semibold capitalize mb-3">
      {{ car.name }}
    </h3>

    <div class="flex items-center space-x-2">
      <span class="text-lg font-semibold text-green-500">
        {{ car.price }}$
      </span>
      <span class="text-sm text-gray-500 line-through">
        {{ 100 }}$
      </span>
    </div>
  </div>
</template>

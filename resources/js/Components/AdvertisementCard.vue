<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
  advertisement: Object,
  translations: Object,
});
</script>

<template>
  <Link :href="route('advertisements.show', advertisement.id)" class="block">
    <div
      class="bg-white overflow-hidden shadow-lg rounded-lg p-4 hover:shadow-xl transition-shadow duration-300"
    >
      <!-- صورة الإعلان -->
      <img
        v-if="advertisement.image"
        class="w-full h-48 object-cover rounded-lg mb-4"
        :src="advertisement.image"
        :alt="advertisement.full_name"
      />
      <div
        v-else
        class="w-full h-48 bg-gray-200 rounded-lg mb-4 flex items-center justify-center text-gray-500"
      >
      {{ translations.no_image }}

      </div>

      <!-- الاسم الكامل -->
      <h3 class="text-xl font-semibold text-gray-800">
        {{ advertisement.full_name }}
      </h3>
           <!-- أزرار التعديل والحذف -->
     <div class="mt-4 flex space-x-4 rtl:space-x-reverse justify-end">
        <Link
          :href="route('advertisements.edit', advertisement.id)"
          class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 text-white rounded-md text-sm"
        >
        {{ translations.edit }}
        </Link>
        <Link
          :href="route('advertisements.destroy', advertisement.id)"
          method="delete"
          as="button"
          type="button"
          class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-md text-sm"
        >
        {{ translations.delete }}
        </Link>
      </div>
    </div>
  </Link>

</template>

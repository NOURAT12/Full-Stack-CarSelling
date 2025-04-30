<template>
    <div class="search-box w-full  p-6 bg-white rounded-2xl shadow-md">
      <h2 class="text-2xl font-semibold text-gray-800 mb-4">{{translations.search_for}}</h2>

      <form @submit.prevent="handleSearch" class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-600 mb-1">
            {{translations.search_by}}
          </label>
          <select
            v-model="searchType"
            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
          >
            <option value="brand">{{translations.brand}}</option>
            <option value="year">{{translations.year}}</option>
          </select>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-600 mb-1">
            {{ searchType === 'year' ? translations.enter_year : translations.enter_brand }}
          </label>
          <input
            v-model="searchQuery"
            type="text"
            :placeholder="searchType === 'year' ? 'e.g. 2021' : 'e.g. Toyota Corolla'"
            class="w-full border border-gray-300 rounded-lg p-2 shadow-sm focus:ring-blue-500 focus:border-blue-500"
          />
        </div>

        <button
          type="submit"
          class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200"
        >
        {{translations.search}}
        </button>
      </form>
    </div>
  </template>

  <script setup>
  import { ref } from 'vue'
  import { router } from '@inertiajs/vue3'
  const props = defineProps({
  translations: Object,
});
  const searchQuery = ref('')
  const searchType = ref('brand')

  const handleSearch = () => {
    if (!searchQuery.value.trim()) return

    router.get(route('search.results'), {
      query: searchQuery.value,
      type: searchType.value,
    })
  }
  </script>

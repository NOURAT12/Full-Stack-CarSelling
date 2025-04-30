<script setup>
import { ref } from "vue";
defineProps({ review: Object, translations: Object });

const showModal = ref(false);
</script>

<template>
  <div
    class="bg-white p-4 shadow-md rounded-lg space-y-3 h-50"
    v-if="review.is_public"
  >
    <!-- الاسم -->
    <h3 class="text-lg font-bold text-gray-800 truncate" :title="review.name">
      {{ review.name }}
    </h3>

    <!-- الرقم -->
    <div class="text-sm text-gray-600 break-words">📞 {{ review.phone }}</div>

    <div>
      <p class="text-gray-700 text-sm line-clamp-3 break-words">
        {{ review.content }}
      </p>

      <button
        class="text-indigo-600 text-sm mt-1 hover:underline"
        @click="showModal = true"
      >
      {{translations.see_more}}

      </button>
    </div>
    <!-- Modal -->
    <div
      v-if="showModal"
      class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    >
      <div class="bg-white p-6 rounded-lg max-w-lg w-full space-y-4 shadow-lg">
        <h3 class="text-lg font-semibold text-gray-800">{{translations.content_of_review}}
        </h3>
        <p class="text-gray-700 text-sm whitespace-pre-line break-words">
          {{ review.content }}
        </p>
        <div class="text-right">
          <button
            class="px-4 py-1 bg-gray-600 text-white text-sm rounded hover:bg-gray-700"
            @click="showModal = false"
          >
          {{translations.close}}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>

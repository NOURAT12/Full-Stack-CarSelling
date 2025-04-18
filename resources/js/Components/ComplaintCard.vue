<script setup>
import { ref } from "vue";
defineProps({ review: Object });

const showModal = ref(false);

</script>

<template>
  <div class="bg-white p-4 shadow-md rounded-lg space-y-3 h-max">
    <!-- الاسم -->
    <h3 class="text-lg font-bold text-gray-800 truncate" :title="review.name">
      {{ review.name }}
    </h3>

    <!-- الرقم -->
    <div class="text-sm text-gray-600 break-words">📞 {{ review.phone }}</div>

    <!-- نوع العرض -->
    <div class="text-sm text-gray-500">
        Type:
      <span :class="review.is_public ? 'text-green-600' : 'text-blue-600'">
        {{ review.is_public === 1 ? " Public " : "البائع (Seller)" }}
      </span>
    </div>

    <div>
      <p class="text-gray-700 text-sm line-clamp-3 break-words">
        {{ review.content }}
      </p>

      <button
        class="text-indigo-600 text-sm mt-1 hover:underline"
        @click="showModal = true"
      >
      see more
    </button>
    </div>

    <!-- أزرار القبول والرفض -->
    <div
      v-if="review.status == 2 "
      class="flex justify-end space-x-4"
    >
      <button
        class="px-4 py-1 bg-green-600 text-white text-sm rounded-md hover:bg-green-700"
        @click="$emit('approve', review.id, 1)"
      >
        Approve
      </button>
      <button
        class="px-4 py-1 bg-red-600 text-white text-sm rounded-md hover:bg-red-700"
        @click="$emit('reject', review.id, 0)"
      >
        Reject
      </button>
    </div><div v-else>
            <!-- الحالة -->
    <div class="text-sm font-medium text-gray-500">
        Status:
        <span
        :class="{
            'text-green-600': Number(review.status) === 1,
            'text-red-600': Number(review.status) === 0,
          }"
        >
          {{ review.status === 1 ? " Approved " : "Rejected" }}
        </span>
      </div>

    </div>

    <!-- Modal -->
    <div
      v-if="showModal"
      class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    >
      <div class="bg-white p-6 rounded-lg max-w-lg w-full space-y-4 shadow-lg">
        <h3 class="text-lg font-semibold text-gray-800">Content of Review</h3>
        <p class="text-gray-700 text-sm whitespace-pre-line break-words">
          {{ review.content }}
        </p>
        <div class="text-right">
          <button
            class="px-4 py-1 bg-gray-600 text-white text-sm rounded hover:bg-gray-700"
            @click="showModal = false"
          >
            Close
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

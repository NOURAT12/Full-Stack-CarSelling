<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

defineProps({
  advertisement: Object,
  user: Object,
  settings: Object,
  translations: Object,
  locale: String,
});
</script>

<template>
  <Head :title="advertisement.full_name" />

  <AuthenticatedLayout :translations="translations" :locale="locale" :settings="settings">
    <div class="max-w-6xl mx-auto py-12 px-6">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
        <!-- نصف لعرض الصورة -->
        <div class="flex justify-center items-center">
          <div class="w-full h-150 relative">
            <img
              v-if="advertisement.image"
              :src="advertisement.image"
              alt="Advertisement Image"
              class="w-full h-full object-cover rounded-lg shadow-lg"
            />
            <div
              v-else
              class="w-full h-full bg-gray-200 rounded-lg flex items-center justify-center text-gray-500"
            >
              {{translations.no_image}}
            </div>
          </div>
        </div>

        <!-- نصف لعرض المعلومات -->
        <div class="space-y-6">
          <h1 class="text-4xl font-extrabold text-gray-900">
            {{ advertisement.full_name }}
          </h1>

          <!-- Advertisement Details -->
          <div
            class="bg-white shadow-lg rounded-lg p-6 text-base text-gray-800"
          >
            <div class="space-y-4">
              <div>
                <strong class="text-gray-700 block">{{translations.URL}}:</strong>
                <a
                  :href="advertisement.ad_url"
                  target="_blank"
                  class="text-blue-600 hover:underline"
                >
                  {{ advertisement.ad_url }}
                </a>
              </div>
              <div>
                <strong class="text-gray-700">{{translations.location}}:</strong>
                <p>{{ advertisement.location }}</p>
              </div>
              <div>
                <strong class="text-gray-700">{{translations.views}}:</strong>
                <p>{{ advertisement.hit }}</p>
              </div>
              <div>
                <strong class="text-gray-700">{{translations.start_date}}:</strong>
                <p>{{ advertisement.start_date }}</p>
              </div>
              <div>
                <strong class="text-gray-700">{{translations.end_date}}:</strong>
                <p>{{ advertisement.end_date }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

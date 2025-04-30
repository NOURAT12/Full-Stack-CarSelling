<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import AdvertisementCard from "@/Components/AdvertisementCard.vue"; // تأكد من المسار الصحيح

defineProps({
  advertisements: Object,
  settings: Object,
  translations: Object,
  locale: String,
});
</script>

<template>
  <Head title="Advertisements Index" />

  <AuthenticatedLayout :translations="translations" :locale="locale" :settings="settings">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Advertisements</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- زر إنشاء -->
        <div class="flex justify-end mb-6">
          <Link
            :href="route('advertisements.create')"
            class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 text-white rounded-md"
          >
          {{ translations.new_advertisement }}
        </Link>
        </div>

        <!-- عرض السيارات -->
        <div v-if="advertisements.data.length > 0">
          <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            <advertisementCard
            :translations="translations" 
              v-for="advertisement in advertisements.data"
              :key="advertisement.id"
              :advertisement="advertisement"
            >
            </advertisementCard>
          </div>

          <!-- روابط التصفح -->
          <div class="mt-8 flex justify-center">
            <nav class="inline-flex items-center space-x-1">
              <template
                v-for="(link, index) in advertisements.links"
                :key="index"
              >
                <Link
                  v-if="link.url"
                  :href="link.url"
                  :class="[
                    'px-4 py-2 border text-sm rounded',
                    link.active
                      ? 'bg-indigo-500 text-white'
                      : 'bg-white text-gray-700 hover:bg-gray-100',
                  ]"
                >
                  <span v-html="link.label" />
                </Link>
                <span
                  v-else
                  class="px-4 py-2 border text-sm text-gray-400 rounded cursor-not-allowed"
                >
                  <span v-html="link.label" />
                </span>
              </template>
            </nav>
          </div>
        </div>

        <!-- لا توجد سيارات -->
        <div v-else class="text-center text-gray-500 text-lg mt-10">
            {{ translations.you_ad }}
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

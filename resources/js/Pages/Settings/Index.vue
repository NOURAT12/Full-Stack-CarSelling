
<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
  settings: Object,
});
</script>

<template>
  <Head title="Website Settings" />

  <AuthenticatedLayout :settings="props.settings">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Website Settings
      </h2>
    </template>
    <div class="py-12 px-6 max-w-7xl mx-auto">
      <div class="bg-white shadow rounded-lg p-6">
        <!-- زر إنشاء -->
        <div class="flex justify-end mb-6">
          <Link
            :href="route('settings.edit', settings.id)"
            class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 text-white rounded-md"
          >
            Edit Setting
          </Link>
        </div>
        <!-- Basic Info -->
        <h3 class="text-lg font-semibold mb-4">Basic Info</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div><strong>Website Name:</strong> {{ settings.website_name }}</div>
          <div><strong>Phone:</strong> {{ settings.phone }}</div>
          <div><strong>Mobile:</strong> {{ settings.mobile }}</div>
          <div><strong>WhatsApp:</strong> {{ settings.whatsapp }}</div>
          <div>
            <strong>Facebook:</strong>
            <a
              :href="settings.facebook"
              class="text-blue-600 underline"
              target="_blank"
              >{{ settings.facebook }}</a
            >
          </div>
          <div>
            <strong>Instagram:</strong>
            <a
              :href="settings.instgram"
              class="text-pink-600 underline"
              target="_blank"
              >{{ settings.instgram }}</a
            >
          </div>
          <!-- عرض العناوين -->
          <ul v-if="settings.titles && Array.isArray(settings.titles)">
            <h3 class="text-lg font-semibold mb-2">Titels</h3>
            <li v-for="(title, i) in settings.titles" :key="i">{{ title }}</li>
          </ul>
        </div>

        <!-- Logo -->
        <div class="mt-6">
          <h3 class="text-lg font-semibold mb-2">Logo</h3>
          <img :src="settings.logo" alt="Logo" class="h-24" />
        </div>

        <!-- عرض الصور -->
        <h3 class="text-lg font-semibold mb-2">Website Images</h3>
        <div
          v-if="settings.website_image && Array.isArray(settings.website_image)"
        >
          <img v-for="(img, i) in settings.website_image" :key="i" :src="img" />
        </div>

        <!-- عرض الصور -->

        <div v-if="settings.images && Array.isArray(settings.images)">
          <h3 class="text-lg font-semibold mt-4 mb-2">Images</h3>

          <img v-for="(img, i) in settings.images" :key="i" :src="img" />
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

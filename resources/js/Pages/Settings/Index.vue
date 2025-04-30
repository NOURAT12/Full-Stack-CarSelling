
<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
  settings: Object,
  translations: Object,
  locale: String,
});
</script>

<template>
  <Head title="Website Settings" />

  <AuthenticatedLayout
    :translations="translations"
    :locale="locale"
    :settings="props.settings"
  >
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Website Settings
      </h2>
    </template>
    <div class="py-12 px-6 max-w-7xl mx-auto">
      <div class="bg-white shadow rounded-lg p-6">
        <!-- زر إنشاء -->
        <div class="flex justify-end mb-6" v-if="settings">
          <Link
            :href="route('settings.edit', settings.id)"
            class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 text-white rounded-md"
          >
            {{ translations.edit_setting }}
          </Link>
        </div>
        <div class="flex justify-end mb-6" v-else>
          <Link
            :href="route('settings.create')"
            class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 text-white rounded-md"
          >
            {{ translations.create_setting }}
          </Link>
        </div>
        <!-- Basic Info -->
        <div v-if="settings">
          <h3 class="text-lg font-semibold mb-4">
            {{ translations.basic_info }}
          </h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <strong> {{ translations.website_name }} </strong>
              {{ settings.website_name }}
            </div>
            <div><strong>{{ translations.phone }}:</strong> {{ settings.phone }}</div>
            <div><strong>{{ translations.mobile_number }}:</strong> {{ settings.mobile }}</div>
            <div><strong>{{ translations.whatsApp }}:</strong> {{ settings.whatsapp }}</div>
            <div>
              <strong>{{ translations.facebook }}:</strong>
              <a
                :href="settings.facebook"
                class="text-blue-600 underline"
                target="_blank"
                >{{ settings.facebook }}</a
              >
            </div>
            <div>
              <strong>{{ translations.instgram }}:</strong>
              <a
                :href="settings.instgram"
                class="text-pink-600 underline"
                target="_blank"
                >{{ settings.instgram }}</a
              >
            </div>
            <!-- عرض العناوين -->
            <ul v-if="settings.titles && Array.isArray(settings.titles)">
              <h3 class="text-lg font-semibold mb-2">{{ translations.titles }}</h3>
              <li v-for="(title, i) in settings.titles" :key="i">
                {{ title }}
              </li>
            </ul>
          </div>

          <!-- Logo -->
          <div class="mt-6">
            <h3 class="text-lg font-semibold mb-2">{{ translations.logo }}</h3>
            <img :src="settings.logo" alt="Logo" class="h-24" />
          </div>

          <!-- عرض الصور -->
          <!-- Website Images Section -->
          <h3 class="text-lg font-semibold mb-2">{{ translations.website_images }}</h3>
          <div
            v-if="
              settings.website_image && Array.isArray(settings.website_image)
            "
            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"
          >
            <div
              v-for="(img, i) in settings.website_image"
              :key="'web-img-' + i"
              class="bg-gray-100 rounded-lg shadow overflow-hidden"
            >
              <img
                :src="img"
                alt="Website Image"
                class="w-full h-48 object-cover"
              />
            </div>
          </div>

          <!-- Images Section -->
          <h3 class="text-lg font-semibold mt-6 mb-2">{{ translations.images }}</h3>
          <div
            v-if="settings.images && Array.isArray(settings.images)"
            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"
          >
            <div
              v-for="(img, i) in settings.images"
              :key="'img-' + i"
              class="bg-gray-100 rounded-lg shadow overflow-hidden"
            >
              <img :src="img" alt="Image" class="w-full h-48 object-cover" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

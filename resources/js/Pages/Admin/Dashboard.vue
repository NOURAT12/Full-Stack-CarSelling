<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head  } from "@inertiajs/vue3";
import Card from "@/Components/Card.vue";
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
  cars: Object,
  settings: Object,
  translations: Object,
  locale: String,
});
const Cars = ref(props.cars.data);
Cars.value = props.cars.data;
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout :translations="translations" :locale="locale" :settings="settings">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Cars ADMIN
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid gap-y-12 lg:grid-cols-4 lg:gap-8">
          <Card :translations="translations" v-for="car in Cars" :key="car.id" :car="car" />
        </div>
        <!-- روابط التصفح -->
        <div class="mt-8 flex justify-center">
          <nav class="inline-flex items-center space-x-1">
            <template v-for="(link, index) in cars.links" :key="index">
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
    </div>
  </AuthenticatedLayout>
</template>

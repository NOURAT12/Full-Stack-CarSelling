<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import Card from "@/Components/Card.vue";
import { ref } from "vue";
const props = defineProps({
  cars: Object,
});
const Cars = ref(props.cars.data);
Cars.value = props.cars.data;
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Cars
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="grid gap-y-12 lg:grid-cols-4 lg:gap-8">
            <Card
              v-for="car in Cars"
              :key="car.id"
              :car="car"
            />
          </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<template>
  <Head title="New Car" />

  <SellerAuthenticatedLayout :locale="locale" :translations="translations" :settings="settings">
    <template #header>
      <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
        {{translations.add_car}}
      </h2>
    </template>

    <div class="py-12">
      <div
        class="max-w-3xl mx-auto sm:px-6 lg:px-8 bg-white rounded-lg shadow-md"
      >
        <form class="p-6" @submit.prevent="submit">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
              <InputLabel for="brand" :value="translations.brand" />
              <input
                id="brand"
                type="text"
                class="mt-1 block w-full rounded border-gray-300"
                v-model="form.brand"
              />
              <InputError class="mt-2" :message="form.errors.brand" />
            </div>
            <div>
              <InputLabel for="model" :value="translations.model" />
              <input
                id="model"
                type="text"
                class="mt-1 block w-full rounded border-gray-300"
                v-model="form.model"
              />
              <InputError class="mt-2" :message="form.errors.model" />
            </div>
            <!-- Year Dropdown -->
            <div>
              <InputLabel for="year" :value="translations.year" />
              <select
                id="year"
                class="mt-1 block w-full rounded border-gray-300"
                v-model="form.year"
              >
                <option disabled value="">{{translations.select_year}}</option>
                <option v-for="y in years" :key="y" :value="y">{{ y }}</option>
              </select>
              <InputError class="mt-2" :message="form.errors.year" />
            </div>

            <div>
                <InputLabel for="price" :value="translations.price" />
                <input
                  id="price"
                  type="number"
                  class="mt-1 block w-full rounded border-gray-300"
                  v-model="form.price"
                />
                <InputError class="mt-2" :message="form.errors.price" />
              </div>
            <div>
                <InputLabel for="color" :value="translations.color" />
                <input
                  id="color"
                  type="text"
                  class="mt-1 block w-full rounded border-gray-300"
                  v-model="form.color"
                />
                <InputError class="mt-2" :message="form.errors.color" />
              </div>
            <div>
                <InputLabel for="city" :value="translations.city" />
                <input
                  id="city"
                  type="text"
                  class="mt-1 block w-full rounded border-gray-300"
                  v-model="form.city"
                />
                <InputError class="mt-2" :message="form.errors.city" />
              </div>
            <div>
                <InputLabel for="country" :value="translations.country" />
                <input
                  id="country"
                  type="text"
                  class="mt-1 block w-full rounded border-gray-300"
                  v-model="form.country"
                />
                <InputError class="mt-2" :message="form.errors.country" />
              </div>

            <!-- Sold Selector -->
            <div>
              <InputLabel for="sold" :value="translations.status" />
              <select
                id="sold"
                class="mt-1 block w-full rounded border-gray-300"
                v-model="form.sold"
              >
                <option value="0">{{translations.available}}</option>
                <option value="1">{{translations.sold}}</option>
              </select>
              <InputError class="mt-2" :message="form.errors.sold" />
            </div>

            <!-- Image Upload -->
            <div class="sm:col-span-2">
              <InputLabel for="carimages" :value="translations.car_image" />
              <input
                id="carimages"
                type="file"
                multiple
                class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                @change="handleImageUpload"
              />
              <InputError class="mt-2" :message="form.errors.carimages" />
            </div>

            <!-- Description -->
            <div class="sm:col-span-2">
              <InputLabel for="description" :value="translations.description" />
              <textarea
                id="description"
                rows="4"
                class="mt-1 block w-full border-gray-300 rounded"
                v-model="form.description"
              ></textarea>
              <InputError class="mt-2" :message="form.errors.description" />
            </div>
          </div>

          <div class="flex justify-end mt-6">
            <PrimaryButton
              :disabled="form.processing"
              :class="{ 'opacity-50': form.processing }"
            >
            {{translations.store}}
            </PrimaryButton>
          </div>
        </form>
      </div>
    </div>
  </SellerAuthenticatedLayout>
</template>

  <script setup>
import SellerAuthenticatedLayout from "@/Layouts/SellerAuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

defineProps({
  settings: Object,
  locale: String,
  translations: Object,
});
// Current year logic
const currentYear = new Date().getFullYear();
const years = Array.from({ length: currentYear - 1989 }, (_, i) => 1990 + i);

const form = useForm({
  brand: "",
  model: "",
  year: "",
  price: "",
  color: "",
  city: "",
  country: "",
  sold: "0",
  carimages: [],
  description: "",
});

const handleImageUpload = (e) => {
  form.carimages = Array.from(e.target.files);
};

const submit = () => {
  form.post(route("cars.store"), {
    forceFormData: true,
  });
};
</script>

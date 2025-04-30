<template>
    <Head title="Edit Car" />

    <SellerAuthenticatedLayout :locale="locale" :translations="translations" :settings="settings">
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{translations.edit_car}}
        </h2>
      </template>

      <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 bg-white shadow rounded">
          <form class="p-6 space-y-4" @submit.prevent="submit" enctype="multipart/form-data">
            <!-- Name -->
            <div>
              <InputLabel for="brand" :value="translations.brand" />
              <TextInput
                id="brand"
                type="text"
                class="mt-1 block w-full"
                v-model="form.brand"
                autocomplete="brand"
              />
              <InputError class="mt-2" :message="$page.props.errors.brand" />
            </div>

            <!-- Model -->
            <div>
              <InputLabel for="model" :value="translations.model" />
              <TextInput
                id="model"
                type="text"
                class="mt-1 block w-full"
                v-model="form.model"
                autocomplete="model"
              />
              <InputError class="mt-2" :message="$page.props.errors.model" />
            </div>

            <!-- Year -->
            <div>
              <InputLabel for="year" :value="translations.year" />
              <TextInput
                id="year"
                type="number"
                class="mt-1 block w-full"
                v-model="form.year"
                autocomplete="year"
              />
              <InputError class="mt-2" :message="$page.props.errors.year" />
            </div>

            <!-- Price -->
            <div>
              <InputLabel for="price" :value="translations.price" />
              <TextInput
                id="price"
                type="text"
                class="mt-1 block w-full"
                v-model="form.price"
                autocomplete="price"
              />
              <InputError class="mt-2" :message="$page.props.errors.price" />
            </div>

            <!-- Color -->
            <div>
              <InputLabel for="color" :value="translations.color" />
              <TextInput
                id="color"
                type="text"
                class="mt-1 block w-full"
                v-model="form.color"
                autocomplete="color"
              />
              <InputError class="mt-2" :message="$page.props.errors.color" />
            </div>

            <!-- City -->
            <div>
              <InputLabel for="city" :value="translations.city" />
              <TextInput
                id="city"
                type="text"
                class="mt-1 block w-full"
                v-model="form.city"
                autocomplete="city"
              />
              <InputError class="mt-2" :message="$page.props.errors.city" />
            </div>

            <!-- Country -->
            <div>
              <InputLabel for="country" :value="translations.country" />
              <TextInput
                id="country"
                type="text"
                class="mt-1 block w-full"
                v-model="form.country"
                autocomplete="country"
              />
              <InputError class="mt-2" :message="$page.props.errors.country" />
            </div>

            <!-- Description -->
            <div>
              <InputLabel for="description" :value="translations.description" />
              <textarea
                id="description"
                class="mt-1 block w-full rounded border-gray-300 shadow-sm"
                v-model="form.description"
                rows="3"
              ></textarea>
              <InputError
                class="mt-2"
                :message="$page.props.errors.description"
              />
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

            <!-- Submit -->
            <div class="flex justify-end mt-6">
              <PrimaryButton class="ms-4">{{translations.update}}</PrimaryButton>
            </div>
          </form>
        </div>
      </div>
    </SellerAuthenticatedLayout>
  </template>

  <script setup>
  import SellerAuthenticatedLayout from "@/Layouts/SellerAuthenticatedLayout.vue";
  import { Head, useForm } from "@inertiajs/vue3";
  import InputError from "@/Components/InputError.vue";
  import InputLabel from "@/Components/InputLabel.vue";
  import PrimaryButton from "@/Components/PrimaryButton.vue";
  import TextInput from "@/Components/TextInput.vue";

  const props = defineProps({
    car: Object,
    settings: Object,
    locale: String,
    translations: Object,
  });

  const form = useForm({
    brand: props.car.brand,
    model: props.car.model,
    year: props.car.year?.toString(),
    price: props.car.price?.toString(),
    color: props.car.color,
    city: props.car.city,
    country: props.car.country,
    description: props.car.description,
    carimages: [],
  });

  const handleImageUpload = (e) => {
    form.carimages = Array.from(e.target.files);
  };

  const submit = () => {
  // التأكد من وضع المفتاح _method في بيانات النموذج
  form._method = "put";

  form.post(route("cars.update", props.car.id), {
    forceFormData: true,
    preserveScroll: true,
  });
};

  </script>

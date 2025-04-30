<template>
    <Head title="New Advertisement" />

    <AuthenticatedLayout :translations="translations" :locale="locale" :settings="settings">
      <template #header>
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{translations.add_new_advertisement}}
        </h2>
      </template>

      <div class="py-12">
        <div
          class="max-w-3xl mx-auto sm:px-6 lg:px-8 bg-white rounded-lg shadow-md"
        >
          <form class="p-6" @submit.prevent="submit">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
              <!-- Full Name -->
              <div>
                <InputLabel for="full_name" :value="translations.full_name" />
                <input
                  id="full_name"
                  type="text"
                  class="mt-1 block w-full rounded border-gray-300"
                  v-model="form.full_name"
                />
                <InputError class="mt-2" :message="form.errors.full_name" />
              </div>

              <!-- Ad URL -->
              <div>
                <InputLabel for="ad_url" :value="translations.ad_URL" />
                <input
                  id="ad_url"
                  type="text"
                  class="mt-1 block w-full rounded border-gray-300"
                  v-model="form.ad_url"
                />
                <InputError class="mt-2" :message="form.errors.ad_url" />
              </div>

              <!-- Start Date -->
              <div>
                <InputLabel for="start_date" :value="translations.start_date" />
                <input
                  id="start_date"
                  type="date"
                  class="mt-1 block w-full rounded border-gray-300"
                  v-model="form.start_date"
                />
                <InputError class="mt-2" :message="form.errors.start_date" />
              </div>

              <!-- End Date -->
              <div>
                <InputLabel for="end_date" :value="translations.end_date" />
                <input
                  id="end_date"
                  type="date"
                  class="mt-1 block w-full rounded border-gray-300"
                  v-model="form.end_date"
                />
                <InputError class="mt-2" :message="form.errors.end_date" />
              </div>

              <!-- Location -->
              <div>
                <InputLabel for="location" :value="translations.location" />
                <input
                  id="location"
                  type="text"
                  class="mt-1 block w-full rounded border-gray-300"
                  v-model="form.location"
                />
                <InputError class="mt-2" :message="form.errors.location" />
              </div>

              <!-- Hit (hidden) -->
              <input type="hidden" v-model="form.hit" />

              <!-- Image Upload (single) -->
              <div class="sm:col-span-2">
                <InputLabel for="image" :value="translations.advertisement_image" />
                <input
                  id="image"
                  type="file"
                  class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                  @change="handleImageUpload"
                />
                <InputError class="mt-2" :message="form.errors.image" />
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
    </AuthenticatedLayout>
  </template>

  <script setup>
  import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
  import { Head, useForm } from "@inertiajs/vue3";
  import InputLabel from "@/Components/InputLabel.vue";
  import InputError from "@/Components/InputError.vue";
  import PrimaryButton from "@/Components/PrimaryButton.vue";

  // Props
  defineProps({
    settings: Object,
    translations: Object,

  });

  // Form data
  const form = useForm({
    full_name: "",
    image: null,
    ad_url: "",
    hit: 0, // القيمة الافتراضية
    start_date: "",
    end_date: "",
    location: "",
  });

  // Handle file upload
  const handleImageUpload = (e) => {
    form.image = e.target.files[0];
  };

  // Submit
  const submit = () => {
    form.post(route("advertisements.store"), {
      forceFormData: true,
    });
  };
  </script>

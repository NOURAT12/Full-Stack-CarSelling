<template>
    <Head title="Edit Advertisement" />
  
    <AuthenticatedLayout :settings="settings">
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Edit Advertisement
        </h2>
      </template>
  
      <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 bg-white shadow rounded">
          <form class="p-6 space-y-4" @submit.prevent="submit">
            <!-- Full Name -->
            <div>
              <InputLabel for="full_name" value="Full Name" />
              <TextInput
                id="full_name"
                type="text"
                class="mt-1 block w-full"
                v-model="form.full_name"
                autocomplete="full_name"
              />
              <InputError class="mt-2" :message="$page.props.errors.full_name" />
            </div>
  
            <!-- Ad URL -->
            <div>
              <InputLabel for="ad_url" value="Ad URL" />
              <TextInput
                id="ad_url"
                type="url"
                class="mt-1 block w-full"
                v-model="form.ad_url"
                autocomplete="ad_url"
              />
              <InputError class="mt-2" :message="$page.props.errors.ad_url" />
            </div>
  
            <!-- Start Date -->
            <div>
              <InputLabel for="start_date" value="Start Date" />
              <TextInput
                id="start_date"
                type="date"
                class="mt-1 block w-full"
                v-model="form.start_date"
                autocomplete="start_date"
              />
              <InputError class="mt-2" :message="$page.props.errors.start_date" />
            </div>
  
            <!-- End Date -->
            <div>
              <InputLabel for="end_date" value="End Date" />
              <TextInput
                id="end_date"
                type="date"
                class="mt-1 block w-full"
                v-model="form.end_date"
                autocomplete="end_date"
              />
              <InputError class="mt-2" :message="$page.props.errors.end_date" />
            </div>
  
            <!-- Location -->
            <div>
              <InputLabel for="location" value="Location" />
              <TextInput
                id="location"
                type="text"
                class="mt-1 block w-full"
                v-model="form.location"
                autocomplete="location"
              />
              <InputError class="mt-2" :message="$page.props.errors.location" />
            </div>
  
            <!-- Image Upload -->
            <div>
              <InputLabel for="image" value="Advertisement Image" />
              <input
                id="image"
                type="file"
                class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                @change="handleImageUpload"
              />
              <InputError class="mt-2" :message="$page.props.errors.image" />
            </div>
  
            <!-- Submit -->
            <div class="flex justify-end mt-6">
              <PrimaryButton class="ms-4">Update</PrimaryButton>
            </div>
          </form>
        </div>
      </div>
    </AuthenticatedLayout>
  </template>
  
  <script setup>
  import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
  import { Head, useForm } from "@inertiajs/vue3";
  import InputError from "@/Components/InputError.vue";
  import InputLabel from "@/Components/InputLabel.vue";
  import PrimaryButton from "@/Components/PrimaryButton.vue";
  import TextInput from "@/Components/TextInput.vue";
  
  const props = defineProps({
    advertisement: Object,
    settings: Object,
  });
  
  const form = useForm({
    full_name: props.advertisement.full_name,
    ad_url: props.advertisement.ad_url,
    hit: props.advertisement.hit,
    start_date: props.advertisement.start_date,
    end_date: props.advertisement.end_date,
    location: props.advertisement.location,
    image: null,
  });
  
  const handleImageUpload = (e) => {
    form.image = e.target.files[0];
  };
  
  const submit = () => {
    form._method = "put";
    form.post(route("advertisements.update", props.advertisement.id), {
      forceFormData: true,
      preserveScroll: true,
    });
  };
  </script>
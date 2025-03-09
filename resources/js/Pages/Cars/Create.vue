<template>
  <Head title="New Car" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        New Car
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-md mx-auto sm:px-6 lg:px-8 bg-white">
        <form class="p-4" @submit.prevent="submit">
          <div>
            <InputLabel for="name" value="name" />
            <TextInput
              id="name"
              type="text"
              class="mt-1 block w-full"
              v-model="form.name"
              autofocus
              autocomplete="name"
            />
            <InputError class="mt-2" :message="form.errors.name" />
          </div>
          <div class="mt-2">
            <InputLabel for="price" value="price" />
            <TextInput
              id="price"
              type="text"
              class="mt-1 block w-full"
              v-model="form.price"
              autocomplete="price"
            />
            <InputError class="mt-2" :message="form.errors.price" />
          </div>
          <div class="mt-2">
            <InputLabel for="image" value="Image" />
            <TextInput
              id="image"
              type="file"
              class="mt-1 block w-full"
              @input="form.image = $event.target.files[0]"
            />
            <InputError class="mt-2" :message="form.errors.image" />
          </div>
          <div class="flex items-center justify-end mt-4">
            <PrimaryButton
              class="ms-4"
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
              Store
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
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
const form = useForm({
  name: "",
  price: "",
  image: "null",
});

const submit = () => {
  form.post(route("cars.store"));
};
</script>

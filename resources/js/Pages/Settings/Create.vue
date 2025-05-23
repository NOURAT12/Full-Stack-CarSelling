<template>
    <Head title="Create Settings" />

    <AuthenticatedLayout>
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Create Settings
        </h2>
      </template>

      <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 bg-white shadow rounded">
          <form
            class="p-6 space-y-4"
            @submit.prevent="submit"
            enctype="multipart/form-data"
          >
            <!-- Website Name -->
            <div>
              <InputLabel for="website_name" value="Website Name" />
              <TextInput
                id="website_name"
                type="text"
                class="mt-1 block w-full"
                v-model="form.website_name"
                autocomplete="website_name"
              />
              <InputError class="mt-2" :message="form.errors.website_name" />
            </div>

            <!-- Facebook -->
            <div>
              <InputLabel for="facebook" value="Facebook" />
              <TextInput
                id="facebook"
                type="text"
                class="mt-1 block w-full"
                v-model="form.facebook"
              />
              <InputError class="mt-2" :message="form.errors.facebook" />
            </div>

            <!-- Instagram -->
            <div>
              <InputLabel for="instgram" value="Instagram" />
              <TextInput
                id="instgram"
                type="text"
                class="mt-1 block w-full"
                v-model="form.instgram"
              />
              <InputError class="mt-2" :message="form.errors.instgram" />
            </div>

            <!-- WhatsApp -->
            <div>
              <InputLabel for="whatsapp" value="WhatsApp" />
              <TextInput
                id="whatsapp"
                type="text"
                class="mt-1 block w-full"
                v-model="form.whatsapp"
              />
              <InputError class="mt-2" :message="form.errors.whatsapp" />
            </div>

            <!-- Phone -->
            <div>
              <InputLabel for="phone" value="Phone" />
              <TextInput
                id="phone"
                type="text"
                class="mt-1 block w-full"
                v-model="form.phone"
              />
              <InputError class="mt-2" :message="form.errors.phone" />
            </div>

            <!-- Mobile -->
            <div>
              <InputLabel for="mobile" value="Mobile" />
              <TextInput
                id="mobile"
                type="text"
                class="mt-1 block w-full"
                v-model="form.mobile"
              />
              <InputError class="mt-2" :message="form.errors.mobile" />
            </div>

            <!-- Titles -->
            <div>
              <InputLabel value="Titles" />
              <div
                v-for="(title, index) in form.titles"
                :key="index"
                class="mb-2 flex gap-2"
              >
                <TextInput
                  class="flex-1"
                  type="text"
                  v-model="form.titles[index]"
                />
                <button
                  type="button"
                  @click="removeTitle(index)"
                  class="text-red-600 hover:underline"
                >
                  Remove
                </button>
              </div>
              <button
                type="button"
                @click="addTitle"
                class="text-blue-600 hover:underline"
              >
                Add Title
              </button>
              <InputError class="mt-2" :message="form.errors['titles']" />
            </div>

            <!-- Website Image -->
            <div>
              <InputLabel for="website_image" value="Website Images" />
              <input
                id="website_image"
                name="website_image[]"
                type="file"
                multiple
                @change="handleWebsiteImageUpload"
                class="mt-1 block w-full"
              />
              <InputError class="mt-2" :message="form.errors.website_image" />
            </div>

            <!-- Images -->
            <div>
              <InputLabel for="images" value="Images" />
              <input
                id="images"
                type="file"
                multiple
                @change="handleImagesUpload"
                class="mt-1 block w-full"
              />
              <InputError class="mt-2" :message="form.errors.images" />
            </div>

            <!-- Logo -->
            <div>
              <InputLabel for="logo" value="Logo" />
              <input
                id="logo"
                type="file"
                @change="handleLogoUpload"
                class="mt-1 block w-full"
              />
              <InputError class="mt-2" :message="form.errors.logo" />
            </div>

            <!-- Submit -->
            <div class="flex justify-end mt-6">
              <PrimaryButton>Create</PrimaryButton>
            </div>
          </form>
        </div>
      </div>
    </AuthenticatedLayout>
  </template>

  <script setup>
  import { Head, useForm } from "@inertiajs/vue3";
  import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
  import InputError from "@/Components/InputError.vue";
  import InputLabel from "@/Components/InputLabel.vue";
  import PrimaryButton from "@/Components/PrimaryButton.vue";
  import TextInput from "@/Components/TextInput.vue";

  const form = useForm({
    website_name: "",
    facebook: "",
    instgram: "",
    whatsapp: "",
    phone: "",
    mobile: "",
    titles: [""],
    website_image: [],
    images: [],
    logo: null,
  });

  const addTitle = () => {
    form.titles.push("");
  };

  const removeTitle = (index) => {
    form.titles.splice(index, 1);
  };

  const handleImagesUpload = (e) => {
    form.images = Array.from(e.target.files);
  };

  const handleWebsiteImageUpload = (e) => {
    form.website_image = Array.from(e.target.files);
  };

  const handleLogoUpload = (e) => {
    form.logo = e.target.files[0];
  };

  const submit = () => {
    form.post(route("settings.store"), {
      forceFormData: true,
      preserveScroll: true,
    });
  };
  </script>

<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const props = defineProps({
  settings: Object,
});

const form = useForm({
  username: "",
  email: "",
  password: "",
  password_confirmation: "",
  image: null,
  city: "",
  country: "",
  role: "",
  mobile: ""
});

const submit = () => {
  form.post(route("register"), {
    onFinish: () => form.reset("password", "password_confirmation"),
  });
};
</script>

<template>
  <GuestLayout :settings="settings">
    <Head title="Register" />

    <!-- شعار التطبيق إن توفر -->
    <div class="flex justify-center mb-6">
      <img
        :src="settings?.logo_url"
        alt="Logo"
        class="h-16"
        v-if="settings?.logo_url"
      />
    </div>

    <!-- نموذج التسجيل -->
    <form @submit.prevent="submit" class="p-8 space-y-6 max-w-xl mx-auto">
      <h2 class="text-2xl font-semibold text-center text-gray-800">
        Create your account
      </h2>

      <!-- Username -->
      <div>
        <InputLabel for="username" value="Username" />
        <TextInput
          id="username"
          type="text"
          class="mt-1 block w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
          v-model="form.username"
          required
          autofocus
        />
        <InputError class="mt-2" :message="form.errors.username" />
      </div>

      <!-- Email -->
      <div>
        <InputLabel for="email" value="Email" />
        <TextInput
          id="email"
          type="email"
          class="mt-1 block w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
          v-model="form.email"
          required
        />
        <InputError class="mt-2" :message="form.errors.email" />
      </div>

      <!-- Password -->
      <div>
        <InputLabel for="password" value="Password" />
        <TextInput
          id="password"
          type="password"
          class="mt-1 block w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
          v-model="form.password"
          required
        />
        <InputError class="mt-2" :message="form.errors.password" />
      </div>

      <!-- Confirm Password -->
      <div>
        <InputLabel for="password_confirmation" value="Confirm Password" />
        <TextInput
          id="password_confirmation"
          type="password"
          class="mt-1 block w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
          v-model="form.password_confirmation"
          required
        />
        <InputError class="mt-2" :message="form.errors.password_confirmation" />
      </div>

      <!-- Image Upload -->
      <div>
        <InputLabel for="image" value="Profile Image" />
        <input
          id="image"
          type="file"
          class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
          @change="(event) => (form.image = event.target.files[0])"
        />
        <InputError class="mt-2" :message="form.errors.image" />
      </div>
      <!-- Mobile Number -->
      <div>
        <InputLabel for="mobile" value="Mobile Number" />
        <TextInput
          id="mobile"
          type="tel"
          class="mt-1 block w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
          v-model="form.mobile"
          required
          autocomplete="tel"
          placeholder="+1234567890"
        />
        <InputError class="mt-2" :message="form.errors.mobile" />
      </div>

      <!-- City -->
      <div>
        <InputLabel for="city" value="City" />
        <TextInput
          id="city"
          type="text"
          class="mt-1 block w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
          v-model="form.city"
          required
        />
        <InputError class="mt-2" :message="form.errors.city" />
      </div>

      <!-- Country -->
      <div>
        <InputLabel for="country" value="Country" />
        <TextInput
          id="country"
          type="text"
          class="mt-1 block w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
          v-model="form.country"
          required
        />
        <InputError class="mt-2" :message="form.errors.country" />
      </div>

      <!-- Role -->
      <div>
        <InputLabel for="role" value="Role" />
        <select
          id="role"
          v-model="form.role"
          class="mt-1 block w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
          required
        >
          <option disabled value="">Select Role</option>
          <option value="admin">Admin</option>
          <option value="seller">Seller</option>
        </select>
        <InputError class="mt-2" :message="form.errors.role" />
      </div>

      <!-- Submit -->
      <div class="flex items-center justify-between">
        <Link
          :href="route('login')"
          class="text-sm text-indigo-600 hover:text-indigo-800 transition"
        >
          Already registered?
        </Link>

        <PrimaryButton
          class="ml-4"
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        >
          Register
        </PrimaryButton>
      </div>
    </form>
  </GuestLayout>
</template>

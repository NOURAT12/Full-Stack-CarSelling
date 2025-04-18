<template>
    <div>
      <InputLabel :for="id" :value="label" />
      <TextInput
        :id="id"
        type="text"
        class="mt-1 block w-full"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
      />
      <InputError class="mt-2" :message="error" />
    </div>
  </template>

  <script setup>
  import InputLabel from "@/Components/InputLabel.vue";
  import InputError from "@/Components/InputError.vue";
  import TextInput from "@/Components/TextInput.vue";

  const props = defineProps({
    label: String,
    modelValue: String,
    error: String,
  });

  const id = props.label?.toLowerCase().replace(/\s+/g, "-");
  </script>

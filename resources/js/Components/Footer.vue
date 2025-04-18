<template>
    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-6 px-6 text-center ">
        <p>&copy; {{ new Date().getFullYear() }} {{ settings.website_name }}. All rights reserved.</p>
        <div class="flex justify-center space-x-4 mt-2">
          <a v-if="settings.facebook" :href="settings.facebook" target="_blank">Facebook</a>
          <a v-if="settings.whatsapp" :href="settings.whatsapp" target="_blank">WhatsApp</a>
          <a v-if="settings.instgram" :href="settings.instgram" target="_blank">Instagram</a>
        </div>
      </footer>
</template>
<script setup>
const props = defineProps({
  settings: Object,
})

</script>

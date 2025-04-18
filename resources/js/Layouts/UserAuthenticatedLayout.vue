<script setup>
import { ref } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import Footer from "@/Components/Footer.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";

const props = defineProps({
  settings: Object,
});
</script>

<template>
  <div>
    <div class="min-h-screen bg-gray-100">
      <!-- Page Content -->
      <main>
        <slot />
      </main>
    </div>
    <!-- Footer -->
    <Footer :settings="settings" />
  </div>
</template>

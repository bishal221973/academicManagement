<script setup>
import { Link } from '@inertiajs/vue3';
</script>
<template>
  <div class="bg-white w-[200px] px-5">
    <span class="uppercase block py-3">Configuration</span>
    <hr class="mb-5" />
    <Link class="text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'SystemSetup' ? 'text-main/80' : ''" :href="route('configuration')">
      System Setup
    </Link>
    <!-- <Link class="text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'Sidebar' ? 'text-main/80' : ''" :href="route('config.sidebar')">
      Sidebar Management
    </Link> -->
    <Link class="text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'Course' ? 'text-main/80' : ''" :href="route('course.index')">
      Course Management
    </Link>
  </div>
</template>

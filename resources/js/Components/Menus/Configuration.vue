<script setup>
import { Link } from '@inertiajs/vue3';
</script>
<template>
  <div class="bg-white w-[175px] px-5">
    <span class="uppercase block py-3">Configuration</span>
    <hr class="mb-5" />
    <Link class="text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'SystemSetup' ? 'text-main/80' : ''" :href="route('configuration')">
      System Setup
    </Link>
    <Link class="text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'AcademySetup' ? 'text-main/80' : ''" :href="route('academy-setup')">
      Academy Setup
    </Link>
    <!-- <Link class="text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'Sidebar' ? 'text-main/80' : ''" :href="route('config.sidebar')">
      Sidebar Management
    </Link> -->
    <Link class="text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'Icard' ? 'text-main/80' : ''" :href="route('icard.index')">
      ID Card
    </Link>
    <Link class="text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'AcademicYear' ? 'text-main/80' : ''" :href="route('academic.year')">
      Academic Year
    </Link>
    <Link class="text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'Tax' ? 'text-main/80' : ''" :href="route('tax.index')">
      Taxes
    </Link>
  </div>
</template>

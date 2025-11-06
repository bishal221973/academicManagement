<script setup>
import { Link } from '@inertiajs/vue3';
</script>
<template>
  <div class="bg-white w-[175px] px-5">
    <span class="uppercase block py-3">Academic</span>
    <hr class="mb-5" />
   <Link class="text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'Course' ? 'text-main/80' : ''" :href="route('course.index')">
      Course Management
    </Link>
    <Link class="text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'Section' ? 'text-main/80' : ''" :href="route('section.index')">
      Section Management
    </Link>
    <Link class="text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'Group' ? 'text-main/80' : ''" :href="route('group.index')">
      Group Management
    </Link>
    <Link class="text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'Subject' ? 'text-main/80' : ''" :href="route('subject.index')">
      Subject Management
    </Link>
    <!-- <Link class="text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'Group' ? 'text-main/80' : ''" :href="route('course.index')">
      Class Routine
    </Link> -->
  </div>
</template>

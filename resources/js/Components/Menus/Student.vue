<script setup>
import { Link } from '@inertiajs/vue3';
import AddStudent from '../AddForm/AddStudent.vue';
</script>
<template>
  <div class="bg-white w-[200px] px-5">
    <span class="uppercase block py-3">Students</span>
    <hr class="mb-5" />
    
    <Link class="text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'Student' ? 'text-main/80' : ''" :href="route('student.index')">
      Student List
    </Link>
    <AddStudent :title="'Admin Student'"/>
    <!-- <Link class="text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'Promotion' ? 'text-main/80' : ''" :href="route('student.promotion.index')">
      Student promotion
    </Link>
    <Link class="text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'Group' ? 'text-main/80' : ''" :href="route('course.index')">
      Bulk Admission
    </Link>
    <Link class="text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'Group' ? 'text-main/80' : ''" :href="route('course.index')">
      Online Admission
    </Link> -->
    <Link class="text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'ICard' ? 'text-main/80' : ''" :href="route('student.icard.index')">
      Student ID Card
    </Link>
    <Link class="text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'Import' ? 'text-main/80' : ''" :href="route('student.import.index')">
      Admit Bulk Students
    </Link>
    <Link style="pointer-events:none"  class="text-gray-400 text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'Group' ? 'text-main/80' : ''" :href="route('course.index')">
      Admition Request
    </Link>
    <Link style="pointer-events:none"  class="text-gray-400 text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'Group' ? 'text-main/80' : ''" :href="route('course.index')">
      Admition Inquery
    </Link>
    <Link style="pointer-events:none"  class="text-gray-400 text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'Group' ? 'text-main/80' : ''" :href="route('course.index')">
      Send SMS To Inqueries
    </Link>
    <Link style="pointer-events:none"  class="text-gray-400 text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'Group' ? 'text-main/80' : ''" :href="route('course.index')">
      Admition Form
    </Link>
    <Link style="pointer-events:none"  class="text-gray-400 text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'Group' ? 'text-main/80' : ''" :href="route('course.index')">
      Student Promotion
    </Link>
    <Link style="pointer-events:none"  class="text-gray-400 text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'Group' ? 'text-main/80' : ''" :href="route('course.index')">
      Transfer Students
    </Link>
    <Link style="pointer-events:none"  class="text-gray-400 text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'Group' ? 'text-main/80' : ''" :href="route('course.index')">
      Student Certificate
    </Link>
    
  </div>
</template>

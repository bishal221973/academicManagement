<script setup>
import { Link } from '@inertiajs/vue3';
import AddStudent from '../AddForm/AddStudent.vue';
</script>
<template>
  <div class="bg-white w-[175px] px-5 print:hidden">
    <span class="uppercase block py-3">Inventory Management</span>
    <hr class="mb-5" />
    
    <Link class="text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'Store' ? 'text-main/80' : ''" :href="route('store.index')">
      Store
    </Link>
    <AddStudent :title="'Admin Student'"/>
   
    <Link class="text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'ICard' ? 'text-main/80' : ''" :href="route('student.icard.index')">
      Product Category
    </Link>
    <Link class="text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'Import' ? 'text-main/80' : ''" :href="route('student.import.index')">
      Product
    </Link>
    <Link class="text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'Transfer' ? 'text-main/80' : ''" :href="route('student.transfer.index')">
      Stock Management
    </Link>
    <Link class="text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'AdmitionForm' ? 'text-main/80' : ''" :href="route('admission-form.index')">
      Sell Product
    </Link>
    
  </div>
</template>

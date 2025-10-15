<script setup>
import { Link } from '@inertiajs/vue3';
</script>
<template>
  <div class="bg-white w-[200px] px-5">
    <span class="uppercase block py-3">Hostel</span>
    <hr class="mb-5" />
    <Link class="text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'Hostel' ? 'text-main/80' : ''" :href="route('hostel.index')">
      Hostel List
    </Link>
    <Link class="text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'Room' ? 'text-main/80' : ''" :href="route('room.index')">
      Room Management
    </Link>
    <!-- <Link class="text-[14px] hover:text-main/80 flex items-center gap-3 mb-5" :class="$page?.props?.menu == 'Icard' ? 'text-main/80' : ''" :href="route('icard.index')">
      ID Card
    </Link> -->
  </div>
</template>

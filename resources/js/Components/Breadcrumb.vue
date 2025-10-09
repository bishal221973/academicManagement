<!-- components/PremiumBreadcrumb.vue -->
<template>
  <nav
    class="flex items-center text-sm text-slate-500 bg-white/10 backdrop-blur-md rounded-xl"
  >
    <!-- Home icon -->
    <Link href="/dashboard" class="flex items-center text-main transition-colors">
      <component :is="Home" class="h-[15px]"/>
      <b class="text-[13px]">Dashboard</b>
    </Link>

    <!-- Separator -->
    <span class="mx-2">/</span>

    <!-- Dynamic breadcrumbs -->
    <template v-for="(crumb, index) in breadcrumbs" :key="index">
      <span v-if="index < breadcrumbs.length - 1" class="flex items-center">
        <Link :href="crumb.href" class="hover:text-[#D9A250] transition-colors">
          {{ crumb.label }}
        </Link>
        <span class="mx-2">/</span>
      </span>
      <span v-else class="text-slate-900 text-[13px]">{{ crumb.label }}</span>
    </template>
  </nav>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { Home } from 'lucide-vue-next';
defineProps({
  breadcrumbs: {
    type: Array,
    required: true,
    default: () => [],
  },
});
</script>

<style scoped>
nav {
  backdrop-filter: blur(10px);
}
</style>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/vue3";
import { ArrowRight } from "lucide-vue-next";
import Configuration from "@/Components/Menus/Configuration.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
</script>
<template>
  <AppLayout>
    <template #sidebar>
      <Configuration />
    </template>

    <template #content>
      <Breadcrumb :breadcrumbs="[{ label: 'System Setup' }]" />
      <div class="bg-white p-3 rounded w-full shadow">
        <div class="grid grid-cols-12">
          <div class="col-span-3">
            <label class="text-[14px]">Date Format *</label>
            <select class="rounded w-full py-[7px] border-gray-300 text-[14px]">
                <option value="">Select Option</option>
                <option value="AD">AD Format</option>
                <option value="BS">BS Format</option>
            </select>
          </div>
        </div>
      </div>
    </template>
  </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/vue3";
import { ArrowRight } from "lucide-vue-next";
import Configuration from "@/Components/Menus/Configuration.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import { Move } from "lucide-vue-next";
import {
  Home,
  Users,
  BookOpen,
  GraduationCap,
  FileCheck,
  UserCog,
  Bed,
  ShoppingCart,
  Library,
  Wallet,
  Bus,
  BarChart3,
  Settings,
} from "lucide-vue-next";
const props=defineProps({
    sidebars:Object,
})

const iconMap = {
  Home,
  Users,
  BookOpen,
  GraduationCap,
  FileCheck,
  UserCog,
  Bed,
  ShoppingCart,
  Library,
  Wallet,
  Bus,
  BarChart3,
  Settings,
};
</script>
<template>
  <AppLayout>
    <template #sidebar>
      <Configuration />
    </template>

    <template #content>
      <Breadcrumb :breadcrumbs="[{ label: 'Sidebar Management' }]" />
      <div class="flex">
        <div class="bg-white p-3 rounded w-[200px] shadow">

            <div class="flex bg-gray-100 px-3 py-2 mb-1 rounded-md cursor-move" v-for="sidebar in sidebars" :key="sidebar.id">
                <span class="text-[13px] flex items-center gap-3">
                    <component :is="iconMap[sidebar.icon]" class="h-[16px]"/>
                    {{ sidebar?.title }}
                </span>
            </div>
      </div>
      </div>
    </template>
  </AppLayout>
</template>

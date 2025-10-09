<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/vue3";
import { ArrowRight, Move } from "lucide-vue-next";
import Configuration from "@/Components/Menus/Configuration.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import axios from "axios";
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

import { ref, unref } from "vue";

const props = defineProps({
  sidebars: Object,
});

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

// Reactive local copy of sidebars
const localSidebars = ref([...props.sidebars]);

// For drag-and-drop tracking
const dragIndex = ref(null);
const dragPosition = ref(null);

// Start dragging
function handleDragStart(index, position) {
  dragIndex.value = index;
  dragPosition.value = unref(position); // ensure raw value
}

// Allow drop
function handleDragOver(event) {
  event.preventDefault();
}

// Handle drop logic
function handleDrop(dropIndex, position) {
  const fromIndex = dragIndex.value;
  const toIndex = dropIndex;

  const fromPosition = unref(dragPosition);
  const toPosition = unref(position);

  if (
    fromIndex === null ||
    fromIndex === toIndex ||
    fromIndex < 0 ||
    toIndex < 0
  ) {
    return;
  }

  // Move item in array
  const draggedItem = localSidebars.value[fromIndex];
  localSidebars.value.splice(fromIndex, 1);
  localSidebars.value.splice(toIndex, 0, draggedItem);

  // Optional: Update positions if backend requires it
  localSidebars.value.forEach((item, idx) => {
    item.position = idx;
  });

  // Reset drag index
  dragIndex.value = null;

  // Send updated order to backend
  axios
    .post(route("update.sidebar"), {
      sidebars: localSidebars.value,
      from: fromPosition,
      to: toPosition,
    })
    .then((response) => {
      console.log("Sidebar order updated successfully:", response.data);
    })
    .catch((error) => {
      console.error("Error updating sidebar order:", error);
    });
}
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
          <div
            class="flex bg-gray-100 px-3 py-2 mb-1 rounded-md cursor-move"
            v-for="(sidebar, index) in localSidebars"
            :key="sidebar.id"
            draggable="true"
            @dragstart="handleDragStart(index, sidebar.position)"
            @dragover="handleDragOver"
            @drop="handleDrop(index, sidebar.position)"
          >
            <span class="text-[13px] flex items-center gap-3">
              <component :is="iconMap[sidebar.icon]" class="h-[16px]" />
              {{ sidebar?.title }}
            </span>
          </div>
        </div>
      </div>
    </template>
  </AppLayout>
</template>

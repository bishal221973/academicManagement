<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Student from "@/Components/Menus/Student.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import { ref, onMounted, reactive } from "vue";
import { useForm, Link } from "@inertiajs/vue3";
import axios from "axios";
import { Mail } from "lucide-vue-next";
import { Phone } from "lucide-vue-next";

const props = defineProps({
  admissionFields: Object,
  student: Object,
});
const fields = reactive(JSON.parse(JSON.stringify(props.admissionFields)));
// This ref will store the parent container width (the grid)
const gridWidth = ref(0);

onMounted(() => {
  const grid = document.querySelector(".grid");
  if (grid) {
    gridWidth.value = grid.offsetWidth;
  }
});

// Utility function to calculate col-span based on width
function getColSpan(width, gridWidthValue) {
  // Tailwind grid-cols-12 → each span is roughly (gridWidth / 12)
  const oneCol = gridWidthValue / 12;
  return Math.min(12, Math.max(1, Math.round(width / oneCol)));
}

function onRightClick(item, event) {
    
  event.preventDefault(); // Prevent default browser context menu
  
  resize(item.id);
  // You can call any other function here
}
const resize = async (id) => {
  try {
    const response = await axios.get(route('admission-form.resize', id));
    const updatedField = response.data.data;

    // Loop through admissionFields to find and update the item
    for (const section of Object.values(fields)) {
      const field = section.find(f => f.id === updatedField.id);
      if (field) {
        field.size = updatedField.size; // Update class live
        break;
      }
    }
  } catch (error) {
    console.error('Resize failed:', error);
  }
};

</script>

<template>
  <AppLayout>
    <template #sidebar>
      <Student />
    </template>

    <template #content>
      <div class="flex items-center justify-between mb-3">
        <Breadcrumb :breadcrumbs="[{ label: 'Student Management' },{label:'Admission Form'}]" />
      </div>

      <div class="flex w-full gap-3">
        <div class="w-full">
          <div class="w-full print:shadow-none shadow-md rounded-xl bg-white p-3 min-h-[calc(100vh-125px)] relative">
            <div class="border-[1px] w-[100px] h-[100px] flex justify-center items-center absolute right-0 top-[50px]">
                photo
            </div>
            <img :src="$page?.props?.academy?.logo" class="absolute" style="opacity: 0.05;" alt="">
            <label class="block text-center text-[25px] font-bold uppercase">{{ $page?.props?.academy?.name }}</label>
            <label class="block text-center text-[18px]">{{ $page?.props?.academy?.address }}</label>
            <div class="flex justify-center items-center gap-3">
                <component :is="Mail" class="h-[16px]" style="opacity: 0.4;"/>
                <label class="block text-center">{{ $page?.props?.academy?.academy_email }}</label>
            </div>
            <div class="flex justify-center items-center gap-3">
                <component :is="Phone" class="h-[16px]" style="opacity: 0.4;"/>
                <label class="block text-center">{{ $page?.props?.academy?.phone }}</label>
            </div>
            <div
              class="grid grid-cols-12 gap-2"
              v-for="(admissionField, index) in fields"
              :key="admissionField.id"
            >
              <div class="col-span-12">
                <div class="border-b-[1px] px-3 mb-1">
                  <span class="text-[13px] font-bold">{{ index }}</span>
                </div>
              </div>

              <div
                v-for="item in admissionField"
                :key="item.id"
                :class="[item.size, 'dragable-border', 'relative', 'px-2', ]"
                @contextmenu.prevent="onRightClick(item, $event)"
              >
                <span class="text-[14px]">{{ item.name }}</span>
                <input
                  type="text"
                  class="w-full border-gray-300 rounded-md bg-white"
                  :readonly="true"
                  style="pointer-events: none;"
                  :value="item.value"
                  readonly
                >

                <!-- Resize handle -->
                <div
                  class="resize-handle absolute right-0 top-0 h-full w-2 cursor-ew-resize"
                  @mousedown="enableResize($event, item)"
                ></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>
  </AppLayout>
</template>

<style scoped>
.dragable-border {
  border: 1px solid transparent;
  transition: border 0.2s;
  position: relative;
  cursor: move;
}
.dragable-border:hover {
  border: 1px solid rgba(0, 0, 255, 0.494);
  border-radius: 5px;
}

.resize-handle {
  background: transparent;
}
.resize-handle:hover {
  background: rgba(255, 0, 0, 0.1);
  cursor: move;
}
input{
    background-color: transparent !important;
}
</style>

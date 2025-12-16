<script setup>
import { Link } from "@inertiajs/vue3";
import {
  Home,
  Users,
  GraduationCap,
  Library,
  Settings,
  ChevronDown,
  Printer,
  Bed,
  ShoppingCart,
  PiggyBank,
  Minus
} from "lucide-vue-next";
import { ref, onMounted } from "vue";
import AddStudent from "./AddForm/AddStudent.vue";

/* -------------------------------
   Sidebar Menu Structure
-------------------------------- */
const menus = ref([
  { title: "Dashboard", icon: Home, url: "dashboard" },
  {
    title: "Front Office",
    icon: Printer,
    children: [
      { title: "Admission Enquiry", url: "dashboard" },
      { title: "Phone Call Log", url: "dashboard" },
      { title: "Postal Dispatch", url: "dashboard" },
      { title: "Postal Dispatch", url: "dashboard" },
      { title: "Postal Receive", url: "dashboard" },
      { title: "Complain", url: "dashboard" },
    ],
  },
  {
    title: "Students",
    icon: Users,
    children: [
      { title: "New Student", url: "student.index" },
      { title: "Student List", url: "student.index" },
      { title: "ID Card", url: "student.icard.index" },
    ],
  },
  {
    title: "Academic",
    icon: GraduationCap,
    children: [
      { title: "Course Management", url: "course.index" },
      { title: "Section Management", url: "section.index" },
      { title: "Group Management", url: "group.index" },
      { title: "Subject Management", url: "subject.index" },
    ],
  },
  {
    title: "Hostel",
    icon: Bed,
    children: [
      { title: "Hostel List", url: "hostel.index" },
      { title: "Room Management", url: "room.index" },
      { title: "Booking Management", url: "hostelStudent.index" },
      { title: "Hostel Facilities", url: "hostelFeature.index" },
    ],
  },
  {
    title: "Inventory",
    icon: ShoppingCart,
    children: [
      { title: "Sell", url: "dashboard" },
      { title: "Purchase", url: "dashboard" },
      { title: "Stock Management", url: "dashboard" },
      { title: "Category", url: "dashboard" },
      { title: "Unit", url: "dashboard" },
      { title: "Product", url: "dashboard" },
      { title: "Supplier", url: "dashboard" },
    ],
  },

  { title: "Billing", icon: PiggyBank, url: "billing.index" },
  // { title: "Settings", icon: Settings, url: "tax.index" },
  {
    title: "Settings",
    icon: Settings,
    children: [
      { title: "System Setup", url: "configuration" },
      { title: "Academy Management", url: "academy-setup" },
      { title: "ID Card", url: "icard.index" },
      { title: "Academic Year", url: "academic.year" },
      { title: "Taxes", url: "tax.index" },
      { title: "Mail Setup", url: "mail.setup.index" },
      { title: "Mail Format", url: "mail.format.index" },
      { title: "Payment Mode", url: "paymentMode.index" },
    ],
  },
]);

/* -------------------------------
   States
-------------------------------- */
const openMenu = ref(null);
const hoveredMenu = ref(null);

const toggleMenu = (title) => {
  openMenu.value = openMenu.value === title ? null : title;
};

/* -------------------------------
   Auto-open active menu
-------------------------------- */
onMounted(() => {
  menus.value.forEach(menu => {
    if (
      menu.children &&
      menu.children.some(child => route().current(child.url))
    ) {
      openMenu.value = menu.title;
    }
  });
});
</script>

<template>
  <div class="w-[200px] h-screen print:hidden">
    <div class="bg-white h-full border-r shadow flex flex-col">
      <div class="flex-1 py-4 space-y-1">

        <div
          v-for="menu in menus"
          :key="menu.title"
          class="menu-wrapper"
          @mouseenter="hoveredMenu = menu.title"
          @mouseleave="hoveredMenu = null"
        >
          <!-- Parent -->
          <div
            class="flex items-center justify-between px-3 h-[40px] cursor-pointer transition"
            :class="[
              hoveredMenu === menu.title || openMenu === menu.title
                ? 'bg-[#ef4444] text-white'
                : '',
              $page.props.sidebar === menu.title
                ? 'bg-[#ef4444] text-white'
                : ''
            ]"
            @click="menu.children ? toggleMenu(menu.title) : null"
          >
            <!-- Single -->
            <Link
              v-if="!menu.children"
              :href="route(menu.url)"
              class="flex items-center gap-3 w-full"
            >
              <component :is="menu.icon" class="w-4 h-4" />
              <span class="text-sm">{{ menu.title }}</span>
            </Link>

            <!-- Parent -->
            <template v-else>
              <div class="flex items-center gap-3">
                <component :is="menu.icon" class="w-4 h-4" />
                <span class="text-sm">{{ menu.title }}</span>
              </div>

              <ChevronDown
                class="w-4 h-4 transition-transform"
                :class="openMenu === menu.title ? 'rotate-180' : ''"
              />
            </template>
          </div>

          <!-- Submenu -->
          <div
            v-if="menu.children && openMenu === menu.title"
            class=" space-y-1 animate-slide"
            :class="hoveredMenu === menu.title ? 'bg-red-100' : '',$page.props.sidebar === menu.title
                ? 'bg-red-100'
                : ''"
          >
            <div
            v-for="child in menu.children"
            >
          <AddStudent :title="'Admin Student'" v-if="child.title =='New Student'"/>
            <Link
            v-else
            :key="child.title"
            :href="route(child.url)"
            class="block py-2 px-3 text-[12px] rounded
            hover:text-main hover:bg-gray-100 transition flex gap-3"
            :class="child.title == $page?.props?.menu ? 'bg-white' : ''"
            >
            <component :is="Minus" class="w-4 h-4" />
            {{ child.title }} 
          </Link>
        </div>
          </div>

        </div>

      </div>
    </div>
  </div>
</template>

<style scoped>
@keyframes slide {
  from {
    opacity: 0;
    transform: translateY(-6px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-slide {
  animation: slide 0.2s ease-in-out;
}
</style>

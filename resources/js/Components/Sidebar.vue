<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import {
  Home,
  Users,
  GraduationCap,
  Printer,
  Bed,
  ShoppingCart,
  PiggyBank,
  Settings,
  ChevronDown,
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
      {title:"Visitor Book",url:"visitor.index"},
      { title: "Phone Call Log", url: "callLog.index" },
      { title: "Admission Enquiry", url: "dashboard" },
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
      { title: "Sell", url: "sell.index" },
      { title: "Purchase", url: "productPurchase.index" },
      { title: "Stock Management", url: "stock.manager" },
      { title: "Category", url: "productCategory.index" },
      { title: "Unit", url: "unit.index" },
      { title: "Product", url: "product.index" },
      { title: "Supplier", url: "supplier.index" },
    ],
  },

  { title: "Billing", icon: PiggyBank, url: "billing.index" },

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
const openSubMenu = ref(null);
const hoveredMenu = ref(null);

const toggleMenu = title => {
  openMenu.value = openMenu.value === title ? null : title;
};

/* -------------------------------
   Auto-open active menu
-------------------------------- */
onMounted(() => {
  menus.value.forEach(menu => {
    if (menu.children?.some(child => route().current(child.url))) {
      openMenu.value = menu.title;
    }
  });

  openMenu.value = usePage().props?.sidebar;
  openSubMenu.value = usePage().props?.menu;
});
</script>

<template>
  <div class="w-[200px] h-screen print:hidden">
    <div class="bg-[#05007c] h-full border-r shadow flex flex-col">
      <div class="flex-1 py-4 space-y-1">

        <div v-for="menu in menus" :key="menu.title" @mouseenter="hoveredMenu = menu.title"
          @mouseleave="hoveredMenu = null">
          <!-- {{ openMenu }} -->
          <!-- ================= Parent ================= -->
          <div class="flex items-center justify-between px-3 h-[40px] cursor-pointer transition-colors" :class="{
            'bg-white/90 text-[#05007c]': openMenu === menu.title || hoveredMenu === menu.title,
            'text-white/80': openMenu !== menu.title && hoveredMenu !== menu.title
          }" @click="menu.children ? toggleMenu(menu.title) : null">
            <!-- Single Menu -->
            <Link v-if="!menu.children" :href="route(menu.url)" class="flex items-center gap-3 w-full">
            <component :is="menu.icon" class="w-4 h-4" />
            <span class="text-sm">{{ menu.title }}</span>
            </Link>

            <!-- Parent Menu -->
            <template v-else>
              <div class="flex items-center gap-3">
                <component :is="menu.icon" class="w-4 h-4" />
                <span class="text-sm">{{ menu.title }}</span>
              </div>

              <ChevronDown class="w-4 h-4 transition-transform" :class="openMenu === menu.title ? 'rotate-180' : ''" />
            </template>
          </div>

          <!-- ================= Children ================= -->
          <div v-if="menu.children && openMenu === menu.title" class="space-y-1 animate-slide mt-1">
            <div v-for="child in menu.children" :key="child.title">
              <AddStudent v-if="child.title === 'New Student'" title="Admin Student" />

              <Link v-else :href="route(child.url)"
                class="hover:bg-white/10 hover:text-white mx-2 flex items-center gap-3 py-1 px-3 text-[12px] rounded transition-colors"
                :class="{
                  'bg-white/10 text-white': openSubMenu === child.title,
                  'text-white/70 hover:bg-white/5': openSubMenu !== child.title,
                }">
              <component :is="Minus" class="w-3 h-3" />
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

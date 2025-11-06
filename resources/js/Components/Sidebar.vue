<script setup>
import { Link } from "@inertiajs/vue3";
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
  BookCopy,
} from "lucide-vue-next";
import axios from "axios";
import { onMounted, ref } from "vue";

// const menus = [
//   { title: "Dashboard", icon: Home },
//   { title: "Front Office", icon: Users },
//   { title: "Administration", icon: BookOpen },
//   { title: "Students", icon: GraduationCap },
//   { title: "Exam", icon: FileCheck },
//   { title: "HR", icon: UserCog },
//   { title: "Hostel", icon: Bed },
//   { title: "Shop", icon: ShoppingCart },
//   { title: "Library", icon: Library },
//   { title: "Account", icon: Wallet },
//   { title: "Vehicle", icon: Bus },
//   { title: "Reports", icon: BarChart3 },
//   { title: "Settings", icon: Settings },
// ];
const menus=ref([]);

onMounted(()=>{
    fetchSidebar();
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
  BookCopy
};

const fetchSidebar=async()=>{
    const response=await axios.get(route('fetch.sidebar'));
    console.log(response.data)
   menus.value = response.data.datas.map((item) => ({
    ...item,
    icon: iconMap[item.icon],
  }));
}
</script>

<template>
  <div class="w-[40px] h-screen flex print:hidden">
    <div class="w-full bg-white h-full border-r py-5 flex flex-col shadow shadow-main/60">
      <div class=" flex-1 flex flex-col items-center">
        <div
          v-for="menu in menus"
          :key="menu.title"
          class="w-full"
        >
          <Link  :href="menu.url ? route(menu.url) : '#'"
            class=" flex justify-center items-center h-[40px] mb-2 hover:text-main transition"
            :class="$page?.props?.sidebar == menu.title ? 'border-l-[4px] border-main text-main' : ''"
            :title="menu.title"
          >
            <component :is="menu.icon" class="h-[20px] w-[20px]" />
          </Link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";
import ApplicationMark from "@/Components/ApplicationMark.vue";
import Banner from "@/Components/Banner.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import Sidebar from "@/Components/Sidebar.vue";
import Navbar from "@/Components/Navbar.vue";
import { ArrowLeft } from "lucide-vue-next";
defineProps({
  title: String,
  sidebar:String,
  breadcrumb:Array,
});

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
  router.put(
    route("current-team.update"),
    {
      team_id: team.id,
    },
    {
      preserveState: false,
    }
  );
};

const logout = () => {
  router.post(route("logout"));
};
</script>

<template>
  <div>
    <Head :title="title" />

    <Banner />

    <div class="flex h-[100vh] bg-gray-100">
      <div class="w-auto flex">
        <Sidebar />
        <slot name="sidebar"/>
      </div>
      <div class="w-full px-3 py-1">
        <Navbar />
        <div class="w-full py-3 gap-3">
            <slot name="content"/>
        </div>
      </div>
    </div>
  </div>
</template>

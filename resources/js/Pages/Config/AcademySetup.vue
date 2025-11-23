<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, useForm } from "@inertiajs/vue3";
import { ArrowRight } from "lucide-vue-next";
import Configuration from "@/Components/Menus/Configuration.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import { onMounted, ref, watch } from "vue";
import SelectComponent from "@/Components/SelectComponent.vue";
import ImageUploader from "@/Components/ImageUploader.vue";
// Extracting settings from props
const props = defineProps({
  settings: Array,
  
});
const selectedImages = ref([]);
// Find date_type from the settings array and set it as initial form value
const academyName = props.settings.find((setting) => setting.key === "academy_name");
const academyEmail = props.settings.find((setting) => setting.key === "academy_email");
const regDate = props.settings.find((setting) => setting.key === "reg_date_bs");
const contactNo = props.settings.find((setting) => setting.key === "academy_contact_no");
const vat = props.settings.find((setting) => setting.key === "vat_pan");
const address = props.settings.find((setting) => setting.key === "address");
const logo = props.settings.find((setting) => setting.key === "logo");
const form = useForm({
  academy_name: academyName ? academyName.value : "",
  academy_email: academyEmail ? academyEmail.value : "",
  address: address ? address.value : "",
  reg_date: regDate ? regDate.value : "",
  academy_contact_no: contactNo ? contactNo.value : "",
  vat_no: vat ? vat.value : "",
  logo: logo ? "/storage/"+logo.value : "",
});

onMounted(() => {
  // Debugging purpose
  console.log("Component Mounted with settings", props.settings);
});

</script>

<template>
  <AppLayout>
    <template #sidebar>
      <Configuration />
    </template>

    <template #content>
      <Breadcrumb :breadcrumbs="[{ label: 'Configuration' },{ label: 'Academy Setup' }]" />
      <div class="bg-white p-3 rounded w-full shadow mt-3">
        <form @submit.prevent="form.post(route('academy-setup.store'))">
          <div class="grid grid-cols-12 gap-3">
            <div class="col-span-4">
              <label class="text-[14px]">Academy Name *</label>
              <input type="text" v-model="form.academy_name" placeholder="Academy name" class="w-full border-gray-300 rounded">
            </div>
            <div class="col-span-4">
              <label class="text-[14px]">Email *</label>
              <input type="text" v-model="form.academy_email" placeholder="Academy email" class="w-full border-gray-300 rounded">
            </div>
            <div class="col-span-4">
              <label class="text-[14px]">Address</label>
              <input type="text" v-model="form.address" placeholder="Academy address" class="w-full border-gray-300 rounded">
            </div>
            <div class="col-span-4">
              <label class="text-[14px]">Contact No. *</label>
              <input type="text" v-model="form.academy_contact_no" placeholder="Academy contact number" class="w-full border-gray-300 rounded">
            </div>
            <div class="col-span-4">
              <label class="text-[14px]">Reg. Date *</label>
              <input type="text" v-model="form.reg_date" placeholder="Academy registration date" class="w-full border-gray-300 rounded">
            </div>
            <div class="col-span-4">
              <label class="text-[14px]">Vat/Pan No. *</label>
              <input type="text" v-model="form.vat_no" placeholder="Academy vat/pan number" class="w-full border-gray-300 rounded">
            </div>
            <div class="col-span-12">
                <ImageUploader v-model="form.logo" :maxFiles="1" />
            </div>
            <div class="col-span-12 mt-4 bg-gray-100 p-3 rounded flex justify-end">
              <button :disabled="form.processing" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                type="submit">
                Save Changes
              </button>
            </div>
          </div>
        </form>
      </div>
    </template>
  </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, useForm } from "@inertiajs/vue3";
import { ArrowRight } from "lucide-vue-next";
import Configuration from "@/Components/Menus/Configuration.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import { onMounted, ref } from "vue";
import SelectComponent from "@/Components/SelectComponent.vue";
import Datepicker from "@/Components/Datepicker.vue";
// Extracting settings from props
const props = defineProps({
    settings: Array,
});

// Find date_type from the settings array and set it as initial form value
const dateType = props.settings.find((setting) => setting.key === "date_type");
const dateFormat = props.settings.find((setting) => setting.key === "date_format");
const admissionFees = props.settings.find((setting) => setting.key === "admission_fees");
const form = useForm({
    date_type: dateType ? dateType.value : "",
    // date_format: dateFormat ? dateFormat.value : "",
    admission_fees: admissionFees ? admissionFees.value : "",
});

onMounted(() => {
    // Debugging purpose
    console.log("Component Mounted with settings", props.settings);
});

const dateOptions = [
    { label: "AD Date", value: "ad" },
    { label: "BS Date", value: "bs" },
    // Add as many options as needed
];

const dateFormats = [
    { label: "YYYY-MM-DD", value: "Y-m-d" },
    { label: "MM-DD-YYYY", value: "m-d-Y" },
    { label: "YYYY/MM/DD", value: "Y/m/d" },
    { label: "MM/DD/YYYY", value: "m/d/Y" },
    // Add as many options as needed
];
</script>

<template>
    <AppLayout>
        <template #sidebar>
            <Configuration />
        </template>

        <template #content>
            <Breadcrumb :breadcrumbs="[{ label: 'System Setup' }]" />
            <div class="bg-white p-3 rounded w-full shadow mt-3">
               <form @submit.prevent="form.post(route('configuration.update'))">
                 <div class="grid grid-cols-12 gap-3">
                    <div class="col-span-3">
                        <label class="text-[14px]">Date Type *</label>
                        <SelectComponent
                            v-model="form.date_type"
                            :options="dateOptions"
                            label="Date Format *"
                            class="mt-[6px]"
                            placeholder="Search Date Format "
                        />
                    </div>
                    <div class="col-span-3">
                        <label class="text-[14px]">Admission Fees *</label>
                        <input type="number" v-model="form.admission_fees"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter admission fees" />
                        <!-- <Datepicker v-model="form.admission_fees" /> -->
                    </div>
                    <div
                        class="col-span-12 mt-4 bg-gray-100 p-3 rounded flex justify-end"
                    >
                        <button
                            :disabled="form.processing"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                            type="submit"
                        >
                            Save Changes
                        </button>
                    </div>
                </div>
               </form>
            </div>
        </template>
    </AppLayout>
</template>

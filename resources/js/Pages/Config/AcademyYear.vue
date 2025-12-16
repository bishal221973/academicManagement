<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import { ArrowRight } from "lucide-vue-next";
import Configuration from "@/Components/Menus/Configuration.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import { computed, onMounted, ref, watch } from "vue";
import SelectComponent from "@/Components/SelectComponent.vue";
import ImageUploader from "@/Components/ImageUploader.vue";
import Table from "@/Components/Table.vue";
import AddAcademicYear from "@/Components/AddForm/AddAcademicYear.vue";
// Extracting settings from props
const props = defineProps({
  settings: Array,
  academicYears:Object,
  academicYear:Object,
  
});

const columns = [
    { label: "S.N.", key: "sn" },
    { label: "Name", key: "name" },
    { label: "From", key: "from" },
    { label: "To", key: "to" },
    { label: "Status", key: "status" },

    { label: "Actions", key: "actions" },
];

const tableData = computed(() =>
    props.academicYears.map((item, index) => ({
        sn: index + 1,
        name: item?.name,
        status: item?.status,
        from: usePage()?.props?.date_type == 'bs' ? item?.from_bs : item?.from,
        to: usePage()?.props?.date_type == 'bs' ? item?.to_bs : item?.to,

        actions: item.id,
    }))
);
</script>

<template>
  <AppLayout>
    <!-- <template #sidebar>
      <Configuration />
    </template> -->
    
    <template #content>
      <div class="flex items-center justify-between mb-3">
        <Breadcrumb :breadcrumbs="[{ label: 'Configuration' },{label:'Academic Year'}]" />
        <AddAcademicYear :academicYear="academicYear"/>
                <!-- <AddStudent :student="student" /> -->
            </div>
            <div class="flex w-full gap-3">
                <div style="width: 100%;">
                    
                    <Table :columns="columns" :data="tableData" exportTitle="Student List" :filters="filters"
                        :status="'academic.status'" :edit="'academic.edit'" :deleteUrl="'academic.delete'">

                    </Table>
                </div>
            </div>

        </template>
  </AppLayout>
</template>

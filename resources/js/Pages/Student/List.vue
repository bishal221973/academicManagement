<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Student from "@/Components/Menus/Student.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import { computed, onMounted, ref } from "vue";
import Table from "@/Components/Table.vue";
import Academic from "@/Components/Menus/Academic.vue";
import AddStudent from "@/Components/AddForm/AddStudent.vue";

const props = defineProps({
    students: Object,
});

const columns = [
    { label: "S.N.", key: "sn" },
    { label: "Student", key: "student" },
    { label: "Registration No.", key: "reg_number" },
    { label: "Reg. Date", key: "reg_date" },

    { label: "Actions", key: "actions" },
];

const tableData = computed(() =>
    props.students.map((item, index) => ({
        sn: index + 1,
        student: item?.name,
        reg_number: item?.registration_number,
        reg_date: item?.registration_date,

        actions: item.id,
    }))
);
</script>

<template>
    <AppLayout>
        <template #sidebar>
            <Academic />
        </template>

        <template #content>
            <div class="flex items-center justify-between mb-3">
                <Breadcrumb :breadcrumbs="[{ label: 'Student Management' },{label:'Student List'}]" />
                <AddStudent :group="group" />
            </div>
            <div class="flex w-full gap-3">
                <div style="width: 100%;">
                    
                    <Table :columns="columns" :data="tableData" exportTitle="Student List" :filters="filters"
                        :status="'group.update.status'" :edit="'group.edit'" :deleteUrl="'group.delete'">

                    </Table>
                </div>
            </div>

        </template>
    </AppLayout>
</template>
<style scoped>
tr,
td {
    border: 1px solid #e2e8f0;
    padding: 8px;
    text-align: left;
    font-size: 13px;
}
</style>
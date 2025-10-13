<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Student from "@/Components/Menus/Student.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import { computed, onMounted, ref } from "vue";
import Table from "@/Components/Table.vue";
import AddStudent from "@/Components/AddForm/AddStudent.vue";
import SelectCourse from "@/Components/Select/SelectCourse.vue";
import SelectSection from "@/Components/Select/SelectSection.vue";
const props = defineProps({
    students: Object,
    student: Object,
});

const columns = [
    { label: "S.N.", key: "sn" },
    { label: "Roll No.", key: "roll_no" },
    { label: "Student", key: "student" },
    { label: "Registration No.", key: "reg_number" },
    { label: "Reg. Date", key: "reg_date" },
    { label: "Course", key: "course" },

    { label: "Actions", key: "actions" },
];

const tableData = computed(() =>
    props.students.map((item, index) => ({
        sn: index + 1,
        roll_no: item?.roll_number,
        student: item?.name,
        reg_number: item?.registration_number,
        reg_date: item?.registration_date,
        course: item?.course?.name ?? 'N/A',

        actions: item.id,
    }))
);
</script>

<template>
    <AppLayout>
        <template #sidebar>
            <Student />
        </template>

        <template #content>
            <div class="flex items-center justify-between mb-3">
                <Breadcrumb :breadcrumbs="[{ label: 'Student Management' },{label:'Student Promotion'}]" />
            </div>
            <div class="flex w-full gap-3">
                <div style="width: 100%;">
                    <div class="bg-white p-3 rounded shadow">
                        <div class="grid grid-cols-12 gap-3">
                            <div class="col-span-5">
                                <SelectCourse/>
                            </div>
                            <div class="col-span-5">
                                <SelectSection/>
                            </div>
                        </div>
                    </div>
                    
                    <!-- <Table :columns="columns" :data="tableData" exportTitle="Student List" :filters="filters"
                        :status="'group.update.status'" :edit="'student.edit'" :deleteUrl="'student.delete'">

                    </Table> -->
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
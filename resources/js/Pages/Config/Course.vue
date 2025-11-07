<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Student from "@/Components/Menus/Student.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import { computed, onMounted, ref } from "vue";
import Table from "@/Components/Table.vue";
import Academic from "@/Components/Menus/Academic.vue";
import AddCourse from "@/Components/AddForm/AddCourse.vue";
const props = defineProps({
    settings: Object,
    courses: Object,
    course: Object,
});

const columns = [
    { label: "S.N.", key: "sn" },
    { label: "Course", key: "course" },
    { label: "Code", key: "code" },
    { label: "Monthly Fees", key: "fees" },
    { label: "Status", key: "status" },

    { label: "Actions", key: "actions" },
];

const tableData = computed(() =>
    props.courses.map((student, index) => ({
        sn: index + 1,
        course: student?.name,
        code: student?.code,
        fees: 'Rs. '+student?.fees,
        status: student?.status,

        actions: student.id,
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
                <Breadcrumb :breadcrumbs="[{ label: 'Course Management' }]" />
                <AddCourse :course="course" />
            </div>
            <div class="flex w-full gap-3">
                <div style="width: 100%;">
                    <Table :columns="columns" :data="tableData" exportTitle="Student List" :filters="filters"
                        :status="'course.update.status'" :edit="'course.edit'" :deleteUrl="'course.delete'">

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
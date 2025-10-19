<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Student from "@/Components/Menus/Student.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import { computed, onMounted, ref } from "vue";
import Table from "@/Components/Table.vue";
import AddStudent from "@/Components/AddForm/AddStudent.vue";
import { useForm } from "@inertiajs/vue3";
import SelectCourse from "@/Components/Select/SelectCourse.vue";
import SelectSection from "@/Components/Select/SelectSection.vue";
import SelectStudent from "@/Components/Select/SelectStudent.vue";
const props = defineProps({
    students: Object,
    student: Object,
});

const form = useForm({
    course_id: "",
    section_id: "",
    student_id:"",
    school:"",
    reason:"",
})

const saveData=()=>{
    form.post(route('student.transfer.format'))
}

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
                <Breadcrumb :breadcrumbs="[{ label: 'Student Management' }, { label: 'Student Transfer' }]" />
            </div>
            <div class="flex w-full gap-3">
                <div style="width: 100%;">
                    <div class="w-full shadow-md rounded-xl bg-white p-3">
                        <form @submit.prevent="saveData()">
                            <div class="grid grid-cols-12 gap-3">

                                <div class="col-span-3">
                                    <SelectCourse v-model="form.course_id" />
                                </div>
                                <div class="col-span-3">
                                    <SelectSection v-model="form.section_id" :courseId="form.course_id" />
                                </div>
                                <div class="col-span-3">
                                    <SelectStudent v-model="form.student_id" :sectionId="form.section_id"/>
                                </div>

                                <div class="col-span-3">
                                    <input type="text" v-model="form.school"
                                        class="w-full border border-gray-300 rounded px-3 py-[6.5px] focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="Transfered School" />
                                </div>

                                <div class="col-span-12">
                                    <textarea type="text" v-model="form.reason"
                                        class="w-full border border-gray-300 rounded px-3 py-[6.5px] focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="Reason"></textarea>
                                </div>
                                <div class="col-span-12 mt-1 bg-gray-100 p-3 rounded flex justify-end">
                                    <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                                        type="submit">
                                        Transfer Students
                                    </button>
                                </div>

                            </div>
                        </form>

                    
                    </div>
                    <!-- <Table :columns="columns" :data="tableData" exportTitle="Student List" :filters="filters"
                        :status="'group.update.status'" :edit="'student.edit'" :deleteUrl="'student.delete'">

                    </Table> -->
                </div>
            </div>

            <div class="flex w-full gap-3">
                <div style="width: 100%;">
                    
                    <Table :columns="columns" :data="tableData" exportTitle="Student List" :filters="filters"
                        :status="'group.update.status'" :edit="'student.edit'" :deleteUrl="'student.delete'">

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
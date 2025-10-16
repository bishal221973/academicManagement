<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Student from "@/Components/Menus/Student.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import { computed, onMounted, ref } from "vue";
import Table from "@/Components/Table.vue";
import AddStudent from "@/Components/AddForm/AddStudent.vue";
import SelectCourse from "@/Components/Select/SelectCourse.vue";
import SelectSection from "@/Components/Select/SelectSection.vue";
import { useForm, Link } from "@inertiajs/vue3";
// import Link from "@inertiajs/vue3";
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

const form=useForm({
    course_id:"",
    section_id:"",
    file:"",
})

function handleFileChange(event) {
  const file = event.target.files[0];
  if (file) {
    form.file = file;
  }
}

const submitForm=()=>{
    form.post(route('student.import.student'))
}
</script>

<template>
    <AppLayout>
        <template #sidebar>
            <Student />
        </template>

        <template #content>
            <div class="flex items-center justify-between mb-3">
                <Breadcrumb :breadcrumbs="[{ label: 'Student Management' },{label:'Student List'}]" />
                <AddStudent :student="student" />
            </div>
            <div class="flex w-full gap-3">
                <div style="width: 100%;">
                    
                  
                    <div class="w-full shadow-md rounded-xl bg-white p-3 min-h-[calc(100vh-125px)]">
                        <div class="grid grid-cols-12 gap-3">
                            <div class="col-span-4"> 
                                <div class="bg-white border-[1px] border-gray-300 rounded p-[6px]">
                                    {{ $page?.props?.academy?.name }}

                                </div>
                            </div>
                            <div class="col-span-4">
                                <SelectCourse v-model="form.course_id"/>
                            </div>
                            <div class="col-span-4">
                                <SelectSection v-model="form.section_id"/>
                            </div>
                            
                        </div>

                        <hr class="my-3">

                        <div class="mt-[50px]">
                            <p class="text-[20px] block text-center font-bold uppercase text-main">Bulk Admition</p>
                            <div class="flex justify-center mt-3">
                                <input type="file" @change="handleFileChange" class="border-[1px] border-gray-300 rounded p-3">
                            </div>

                            <div class="flex justify-center mt-3">
                                <button @click="submitForm" type="button" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Admit Student</button>
                            </div>
                        </div>

                        <div class="mt-[50px]">
                            <p class="text-[20px] block text-center font-bold uppercase">Or</p>
                            
                            
                            <div class="flex justify-center mt-3">
                                <u class="text-[15px] block text-center text-blue-500">
                                    <a :href="route('student.import.format')">Download Excel Format</a>
                                </u>
                            </div>
                        </div>
                    </div>
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
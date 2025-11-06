<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Student from "@/Components/Menus/Student.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import { computed, onMounted, ref } from "vue";
import Table from "@/Components/Table.vue";
import AddStudent from "@/Components/AddForm/AddStudent.vue";
import { Printer, Pen, DollarSign,Key,ThumbsDown } from "lucide-vue-next";
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

// const tableData = computed(() =>
//     props.students.map((item, index) => ({
//         sn: index + 1,
//         roll_no: item?.roll_number,
//         student: item?.name,
//         reg_number: item?.registration_number,
//         reg_date: item?.registration_date,
//         course: item?.course?.name ?? 'N/A',

//         actions: item.id,
//     }))
// );
</script>

<template>
    <AppLayout>
        <template #sidebar>
            <Student />
        </template>

        <template #content>
            <div class="flex items-center justify-between mb-3">
                <Breadcrumb :breadcrumbs="[{ label: 'Student Management' }, { label: 'Student' }, { label: 'Show' }]" />
                <!-- <AddStudent :student="student" /> -->
            </div>
            <div class="flex w-full gap-3">
                <div style="width: 100%;">

                    <div class="flex ">
                        <div style="width: 250px;">
                            <div class="bg-white rounded-lg mb-1 shadow p-3 w-full flex gap-3 items-center">
                                <img :src="'/student.png'" class="h-[50px]" alt="">

                                <div>
                                    <label class="block font-bold text-[15px]">{{ student?.name }}</label>
                                    <label class="block text-[10px]">Reg. no.: {{ student?.registration_number }}</label>
                                    <label class="block text-[10px]">Roll no.: {{ student?.roll_number }}</label>
                                </div>
                            </div>

                            <div class="bg-white rounded-lg shadow px-3 py-2 w-full flex mb-1 gap-3 items-center justify-between">
                                <button title="Print" class="w-full border-r hover:text-red-500"><component :is="Printer" class="h-[13px]"/></button>
                                <button title="Edit" class="w-full border-r hover:text-red-500"><component :is="Pen" class="h-[13px]"/></button>
                                <button title="Collect Fees" class="w-full border-r hover:text-red-500"><component :is="DollarSign" class="h-[13px]"/></button>
                                <button title="Login Details" class="w-full border-r hover:text-red-500"><component :is="Key" class="h-[13px]"/></button>
                                <button title="Disable" class="w-full hover:text-red-500"><component :is="ThumbsDown" class="h-[13px]"/></button>
                            </div>
                            <div class="bg-white rounded-lg shadow p-3 w-full gap-3">
                                <div class="flex justify-between w-full">
                                    <span class="text-[12px] font-bold">Course</span>
                                    <span class="text-[12px]">{{ student?.course?.name }}</span>
                                </div>
                                <hr class="my-2 border-gray-100"/>
                                <div class="flex justify-between w-full">
                                    <span class="text-[12px] font-bold">Section</span>
                                    <span class="text-[12px]">{{ student?.section?.name }}</span>
                                </div>
                                <hr class="my-2 border-gray-100"/>
                                <div class="flex justify-between w-full">
                                    <span class="text-[12px] font-bold">Group</span>
                                    <span class="text-[12px]">{{ student?.group?.name }}</span>
                                </div>
                                <hr class="my-2 border-gray-100"/>
                                <div class="flex justify-between w-full">
                                    <span class="text-[12px] font-bold">Gender</span>
                                    <span class="text-[12px]">{{ student?.gender }}</span>
                                </div>
                                <hr class="my-2 border-gray-100"/>
                                <div class="flex justify-between w-full">
                                    <span class="text-[12px] font-bold">Barcode</span>
                                    <span class="text-[12px]">{{ student?.course?.name }}</span>
                                </div>
                                <hr class="my-2 border-gray-100"/>
                                <div class="flex justify-between w-full">
                                    <span class="text-[12px] font-bold">Qr code</span>
                                    <span class="text-[12px]">{{ student?.course?.name }}</span>
                                </div>
                                <hr class="my-2 border-gray-100"/>
                                
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
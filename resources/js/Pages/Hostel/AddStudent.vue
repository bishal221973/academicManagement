<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Student from "@/Components/Menus/Student.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import { computed, onMounted, ref, watch } from "vue";
import Table from "@/Components/Table.vue";
import Hostel from "@/Components/Menus/Hostel.vue";
import AddHostel from "@/Components/AddForm/AddHostel.vue";
import AddRoom from "@/Components/AddForm/AddRoom.vue";
import SelectCourse from "@/Components/Select/SelectCourse.vue";
import { useForm } from "@inertiajs/vue3";
import SelectStudent from "@/Components/Select/SelectStudent.vue";
import SelectStudent1 from "@/Components/Select/SelectStudent1.vue";
import SelectHostel from "@/Components/Select/SelectHostel.vue";
import SelectHostelRoom from "@/Components/Select/SelectHostelRoom.vue";
import axios from "axios";
import Datepicker from "@/Components/Datepicker.vue";
const props = defineProps({
    rooms: Object,
    room: Object,
    hostelStudents:Object,
    hostelStudent:Object,
});

const columns = [
    { label: "S.N.", key: "sn" },
    { label: "Hostel", key: "hostel" },
    { label: "Room", key: "room" },
    { label: "Student", key: "student" },
    { label: "Checkin Date", key: "checkin" },
    { label: "Price", key: "price" },
    { label: "Bed No.", key: "bed_no" },

    { label: "Actions", key: "actions" },
];

const tableData = computed(() =>
    props.hostelStudents.map((item, index) => ({
        sn: index + 1,
        hostel: item?.hostel?.name,
        room:item.room?.name,
        student: item.student?.name,
        checkin: item.check_in_date,
        price: "Rs."+ item.price,
        bed_no: item.bed_no ? "Bed No. " + item.bed_no : '',

        actions: item.id,
    }))
);

const form = useForm({
    hostel_id: "",
    course_id: "",
    student_id: "",
    room_id: "",
    price: "0",
    check_in_date: "",
})

onMounted(() => {
    if(props.hostelStudent?.id){
        form.hostel_id = props.hostelStudent.hostel_id;
        form.course_id = props.hostelStudent.student?.course_id;
        form.student_id = props.hostelStudent.student_id;
        form.room_id = props.hostelStudent.room_id;
        form.price = props.hostelStudent.price;
        form.check_in_date = props.hostelStudent.check_in_date;
    }});
watch(() => form.room_id, async () => {
    const response = await axios.get(route('room.show', form.room_id));
    form.price = response.data.room.price;
});

const submit = () => {
    if(props?.hostelStudent?.id){
        updateData();
    }else{
        saveData();
    }
}

const saveData = async () => {
    form.post(route('hostelStudent.store'), {
        onSuccess: () => {
            form.reset();
        }
    });
}

const updateData = async () => {
    form.put(route('hostelStudent.update',props?.hostelStudent?.id), {
        onSuccess: () => {
            form.reset();
        }
    });
}
</script>

<template>
    <AppLayout>
        <template #sidebar>
            <Hostel />
        </template>

        <template #content>
            <div class="flex items-center justify-between mb-3">
                <Breadcrumb :breadcrumbs="[{ label: 'Hostel Management' }, { label: 'Booking Management' }]" />
            </div>
            <div class="flex w-full gap-3">
                <div style="width: 100%;">
                    <div class="grid grid-cols-12 gap-3">
                        <!-- <div class="col-span-4">
                            <form @submit.prevent="submit">
                                <div class="rounded-lg shadow p-3 bg-white">
                                    <div class="mb-1">
                                        <label class="text-[14px]">Hostel*</label>
                                        <SelectHostel v-model="form.hostel_id" />
                                        <small class="text-red-600">{{ form.errors.hostel_id }}</small>
                                    </div>
                                    <div class="mb-1">
                                        <label class="text-[14px]">Course*</label>
                                        <SelectCourse v-model="form.course_id" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="text-[14px]">Student*</label>
                                        <SelectStudent1 v-model="form.student_id" :courseId="form.course_id" />
                                    </div>

                                    <div class="mb-1">
                                        <label class="text-[14px]">Room*</label>
                                        <SelectHostelRoom :hostelId="form.hostel_id" v-model="form.room_id" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="text-[14px]">Price *</label>
                                        <input type="text" v-model="form.price"
                                            class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            placeholder="Enter price" />
                                        <small class="text-red-600">{{ form.errors.price }}</small>
                                    </div>
                                    <div class="mb-1">
                                        <label class="text-[14px]">Checkin Date *</label>
                                        <Datepicker v-model="form.check_in_date" />
                                        <small class="text-red-600">{{ form.errors.check_in_date }}</small>
                                    </div>

                                    <div class=" flex justify-end">
                                        <button
                                            class="bg-blue-600 w-full text-white px-4 py-2 rounded hover:bg-blue-700"
                                            type="submit">
                                            {{ hostelStudent?.id ? 'Update Student' : 'Save Student' }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div> -->

                        <div class="col-span-12">

                            <Table :columns="columns" :data="tableData" exportTitle="Student List" :filters="filters"
                                 :edit="'hostelStudent.edit'" :deleteUrl="'hostelStudent.delete'">

                            </Table>
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
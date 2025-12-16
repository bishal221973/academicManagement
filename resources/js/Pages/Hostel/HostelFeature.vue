<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Student from "@/Components/Menus/Student.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import { computed, onMounted, ref, watch } from "vue";
import Table from "@/Components/Table.vue";
import { useForm } from "@inertiajs/vue3";
import axios from "axios";
import AddFeature from "@/Components/AddForm/AddFeature.vue";
const props = defineProps({
    features: Object,
    room: Object,
    hostelStudents:Object,
    hostelStudent:Object,
    hostelFeature:Object,
});

const columns = [
    { label: "S.N.", key: "sn" },
    { label: "Title", key: "title" },
    { label: "Price", key: "price" },
    { label: "Description", key: "description" },
    { label: "Status", key: "status" },

    { label: "Actions", key: "actions" },
];

const tableData = computed(() =>
    props.features.map((item, index) => ({
        sn: index + 1,
       title:item?.title,
       price:"Rs. "+item?.price,
       description:item?.description,
       status:item?.status,

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
        <!-- <template #sidebar>
            <Hostel />
        </template> -->

        <template #content>
            <div class="flex items-center justify-between mb-3">
                <Breadcrumb :breadcrumbs="[{ label: 'Hostel Management' }, { label: 'Booking Management' }]" />
                <AddFeature :hostelFeature="hostelFeature"/>
                <!-- {{ hostelFeature }} -->
            </div>
            <div class="flex w-full gap-3">
                <div style="width: 100%;">
                    <div class="grid grid-cols-12 gap-3">

                        <div class="col-span-12">
                            <Table :columns="columns" :data="tableData" exportTitle="Student List" :filters="filters"
                                   :status="'hostelFeature.update.status'" :edit="'hostelFeature.edit'" :deleteUrl="'hostelFeature.delete'">

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
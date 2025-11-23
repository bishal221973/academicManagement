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
import Configuration from "@/Components/Menus/Configuration.vue";
const props = defineProps({
    rooms: Object,
    room: Object,
    paymentModes:Object,
    paymentMode:Object,
});

const columns = [
    { label: "S.N.", key: "sn" },
    { label: "Payment Mode", key: "paymentMode" },
    { label: "Description", key: "description" },
    { label: "Status", key: "status" },

    { label: "Actions", key: "actions" },
];

const tableData = computed(() =>
    props.paymentModes.map((item, index) => ({
        sn: index + 1,
        paymentMode:item?.name,
        description:item?.description,
        actions: item.id,
        status: item.status,
    }))
);

const form = useForm({
    name: props?.paymentMode?.name ?? "",
    description: props?.paymentMode?.description ?? "",
   
})


const submit = () => {
    if(props?.paymentMode?.id){
        updateData();
    }else{
        saveData();
    }
}

const saveData = async () => {
    form.post(route('paymentMode.store'), {
        onSuccess: () => {
            form.reset();
        }
    });
}

const updateData = async () => {
    form.put(route('paymentMode.update',props?.paymentMode?.id), {
        onSuccess: () => {
            form.reset();
            form.name="";
            form.description="";
        }
    });
}
</script>

<template>
    <AppLayout>
        <template #sidebar>
            <Configuration />
        </template>

        <template #content>
            <div class="flex items-center justify-between mb-3">
                <Breadcrumb :breadcrumbs="[{ label: 'Configuration' }, { label: 'Payment Mode' }]" />
            </div>
            <div class="flex w-full gap-3">
                <div style="width: 100%;">
                    <div class="flex gap-3 ">
                        <div style="width: 400px;">
                            <form @submit.prevent="submit">
                                <div class="rounded-lg shadow p-3 bg-white">
                                    
                                    <div class="mb-1">
                                        <label class="text-[14px]">Payment Mode *</label>
                                        <input type="text" v-model="form.name"
                                            class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            placeholder="Enter payment mode" />
                                        <small class="text-red-600">{{ form.errors.name }}</small>
                                    </div>
                                    <div class="mb-1">
                                        <label class="text-[14px]">Description</label>
                                        <textarea placeholder="Description here.." v-model="form.description" class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                        <small class="text-red-600">{{ form.errors.description }}</small>
                                    </div>
                                   

                                    <div class=" flex justify-end">
                                        <button
                                            class="bg-blue-600 w-full text-white px-4 py-2 rounded hover:bg-blue-700"
                                            type="submit">
                                            {{ paymentMode?.id ? 'Update Payment Mode' : 'Save Payment Mode' }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="w-full">
                            <Table :columns="columns" :data="tableData" exportTitle="Student List" :filters="filters"
                                  :deleteUrl="'paymentMode.delete'" :edit="'paymentMode.edit'"  :status="'paymentMode.status'">

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
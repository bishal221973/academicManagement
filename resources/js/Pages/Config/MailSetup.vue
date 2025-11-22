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
    mailSetup: Object,
});


const form = useForm({
    mailer: props?.mailSetup?.mailer ?? "",
    host: props?.mailSetup?.host ?? "",
    port: props?.mailSetup?.port ?? "",
    username: props?.mailSetup?.username ?? "",
    password: props?.mailSetup?.password ?? "",
    encryption: props?.mailSetup?.encryption ?? "",
    from_address: props?.mailSetup?.from_address ?? "",
    from_name: props?.mailSetup?.from_name ?? "",

})


const submit = () => {
    if (props?.tax?.id) {
        updateData();
    } else {
        saveData();
    }
}

const saveData = async () => {
    form.post(route('mail.setup.store'), {
        onSuccess: () => {
            // form.reset();
        }
    });
}

const updateData = async () => {
    form.put(route('tax.update', props?.tax?.id), {
        onSuccess: () => {
            form.reset();
            form.name = "";
            form.percentage = "";
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
            <!-- {{ mailSetup }} -->
            <div class="flex items-center justify-between mb-3">
                <Breadcrumb :breadcrumbs="[{ label: 'Hostel Management' }, { label: 'Mail Setup' }]" />
            </div>
            <div class="flex w-full gap-3">
                <div style="width: 100%;">
                    <form @submit.prevent="submit">
                        <div class="rounded-lg shadow p-3 bg-white">
                            <div class="grid grid-cols-12 gap-3">

                                <div class="mb-1 col-span-3">
                                    <label class="text-[14px]">Mailer *</label>
                                    <input type="text" v-model="form.mailer"
                                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="Enter mailer" />
                                    <small class="text-red-600">{{ form.errors.mailer }}</small>
                                </div>
                                <div class="mb-1 col-span-3">
                                    <label class="text-[14px]">host *</label>
                                    <input type="text" v-model="form.host"
                                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="Enter host" />
                                    <small class="text-red-600">{{ form.errors.host }}</small>
                                </div>
                                <div class="mb-1 col-span-3">
                                    <label class="text-[14px]">Port *</label>
                                    <input type="text" v-model="form.port"
                                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="Enter port" />
                                    <small class="text-red-600">{{ form.errors.port }}</small>
                                </div>
                                <div class="mb-1 col-span-3">
                                    <label class="text-[14px]">User Name *</label>
                                    <input type="text" v-model="form.username"
                                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="Enter username" />
                                    <small class="text-red-600">{{ form.errors.username }}</small>
                                </div>
                                <div class="mb-1 col-span-3">
                                    <label class="text-[14px]">Password *</label>
                                    <input type="text" v-model="form.password"
                                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="Enter password" />
                                    <small class="text-red-600">{{ form.errors.password }}</small>
                                </div>
                                <div class="mb-1 col-span-3">
                                    <label class="text-[14px]">Encryption*</label>
                                    <input type="text" v-model="form.encryption"
                                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="Enter encryption" />
                                    <small class="text-red-600">{{ form.errors.encryption }}</small>
                                </div>
                                <div class="mb-1 col-span-3">
                                    <label class="text-[14px]">From Address *</label>
                                    <input type="text" v-model="form.from_address"
                                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="Enter from address" />
                                    <small class="text-red-600">{{ form.errors.from_address }}</small>
                                </div>
                                <div class="mb-1 col-span-3">
                                    <label class="text-[14px]">From Name *</label>
                                    <input type="text" v-model="form.from_name"
                                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="Enter from name" />
                                    <small class="text-red-600">{{ form.errors.from_name }}</small>
                                </div>
                            </div>


                            <div class=" flex justify-end">
                                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                                    type="submit">
                                    Update Mail Setup
                                </button>
                            </div>
                        </div>
                    </form>
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
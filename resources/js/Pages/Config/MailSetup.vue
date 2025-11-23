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

const mailForm=useForm({
    email:"",
    message:"",
    subject:"",
})
const sendMail=()=>{
    mailForm.post(route('mail.setup.sendTestMail'),{
        onSuccess:()=>{
            mailForm.reset();
        }
    })
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
                <Breadcrumb :breadcrumbs="[{ label: 'Configuration' }, { label: 'Mail Setup' }]" />
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
                                        placeholder="smtp" />
                                    <small class="text-red-600">{{ form.errors.mailer }}</small>
                                </div>
                                <div class="mb-1 col-span-3">
                                    <label class="text-[14px]">host *</label>
                                    <input type="text" v-model="form.host"
                                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="smtp.gmail.com" />
                                    <small class="text-red-600">{{ form.errors.host }}</small>
                                </div>
                                <div class="mb-1 col-span-3">
                                    <label class="text-[14px]">Port *</label>
                                    <input type="text" v-model="form.port"
                                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="587" />
                                    <small class="text-red-600">{{ form.errors.port }}</small>
                                </div>
                                <div class="mb-1 col-span-3">
                                    <label class="text-[14px]">User Name *</label>
                                    <input type="text" v-model="form.username"
                                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="test@gmail.com" />
                                    <small class="text-red-600">{{ form.errors.username }}</small>
                                </div>
                                <div class="mb-1 col-span-3">
                                    <label class="text-[14px]">Password *</label>
                                    <input type="text" v-model="form.password"
                                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="password" />
                                    <small class="text-red-600">{{ form.errors.password }}</small>
                                </div>
                                <div class="mb-1 col-span-3">
                                    <label class="text-[14px]">Encryption*</label>
                                    <input type="text" v-model="form.encryption"
                                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="tls" />
                                    <small class="text-red-600">{{ form.errors.encryption }}</small>
                                </div>
                                <div class="mb-1 col-span-3">
                                    <label class="text-[14px]">From Address *</label>
                                    <input type="text" v-model="form.from_address"
                                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="test@gmail.com"/>
                                    <small class="text-red-600">{{ form.errors.from_address }}</small>
                                </div>
                                <div class="mb-1 col-span-3">
                                    <label class="text-[14px]">From Name *</label>
                                    <input type="text" v-model="form.from_name"
                                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="from name" />
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

                    <div class="bg-white mt-3 rounded-xl shadow p-3">
                        <div class="flex justify-between items-center">
                            <small><b>Send Test Mail</b></small>

                        </div>
                        <hr class="my-1">

                        <form @submit.prevent="sendMail">
                            <div class="flex gap-3">
                                <input v-model="mailForm.subject" type="text" placeholder="Subject" class="border-gray-300 w-full rounded"></input>
                                <input v-model="mailForm.email" type="text" placeholder="Mail to" class="border-gray-300 w-full rounded"></input>
                            </div>
                            <textarea v-model="mailForm.message" class="w-full rounded border-gray-300 mt-3" placeholder="Message"
                                id=""></textarea>
                            <div class="flex justify-end">

                                <button class="bg-green-400 px-3 py-1 text-white rounded">Send</button>
                            </div>
                        </form>
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
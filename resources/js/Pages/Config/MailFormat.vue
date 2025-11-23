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
import TextEditor from "@/Components/TextEditor.vue";
const props = defineProps({
    mailFormats: Object,
});


const form = useForm({
    title: props?.mailFormats[0]?.title ?? "",
    format: props?.mailFormats[0]?.format ?? "",


})

const setTitle = (title) => {
    form.title = title;
    console.log(title);

    const data = props.mailFormats.find((format) => {
        return format.title === title;   // <-- FIXED
    });
    form.format = data?.format ?? "";
    console.log(data)
};

const submit = () => {

    saveData();
}

const saveData = async () => {
    form.post(route('mail.format.store'), {
        onSuccess: () => {
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

const sendMail = () => {
    mailForm.post(route('mail.setup.sendTestMail'), {
        onSuccess: () => {
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
                <Breadcrumb :breadcrumbs="[{ label: 'Configuration' }, { label: 'Mail Format' }]" />
            </div>
            <div class="flex w-full gap-3">
                <div style="width: 100%;">
                    <!-- {{  }} -->
                    <div class="flex gap-3 mb-2">
                        <button v-for="(item, index) in mailFormats" :key="index" @click="setTitle(item.title)"
                            class=" px-3 rounded py-2"
                            :class="item.title == form.title ? 'bg-red-300 text-red-500' : 'bg-gray-200'">
                            <small>{{ item?.title }}</small>
                        </button>
                    </div>

                    <div class="mt-3 rounded-xl bg-white shadow p-3 " style="height: calc(100vh - 170px);">

                        <form @submit.prevent="submit">
                            <div style="height: calc(100vh - 240px);" class="overflow-auto">
                           
                                <TextEditor v-model="form.format" />

                            </div>
                            <div class="flex justify-end mt-5">

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
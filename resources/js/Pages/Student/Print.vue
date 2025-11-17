<script setup>
import { Printer, Pen, DollarSign, Key, ThumbsDown } from "lucide-vue-next";
import Modal from "@/Components/Modal.vue";
import { ref } from "vue";
import QrCode from "@/Components/QrCode.vue";

const props = defineProps({
    student: Object,
});

const openModal = ref(false);

const toggleOpenModal = () => {
    openModal.value = !openModal.value;
}

</script>
<template>
    <button @click="toggleOpenModal" title="Print" class="w-full border-r hover:text-red-500">
        <component :is="Printer" class="h-[13px]" />
    </button>

    <Modal :show="openModal" :max-width="'4xl'" @close="toggleOpenModal">

        <img :src="$page?.props?.academy?.logo" class="absolute opacity-5" alt="" />
        <label class="block text-center text-[25px] font-bold uppercase">
            {{ $page?.props?.academy?.name }}
        </label>
        <label class="block text-center text-[18px]">
            {{ $page?.props?.academy?.address }}
        </label>
        <div class="flex justify-center items-center gap-3">
            <Mail class="h-[16px] opacity-40" />
            <label>{{ $page?.props?.academy?.academy_email }}</label>
        </div>
        <div class="flex justify-center items-center gap-3">
            <Phone class="h-[16px] opacity-40" />
            <label>{{ $page?.props?.academy?.phone }}</label>
        </div>

        <hr class="my-2">
        <small class="font-bold uppercase">Student Details</small>
        <div class="flex gap-3 justify-between">
            <table class="w-full border-[1px]">
                <tr>
                    <td class="border-[1px] px-3 text-[12px] font-bold">Roll Number</td>
                    <td class="border-[1px] px-3 text-[12px]">{{ student?.roll_number }}</td>
                    <td class="border-[1px] px-3 text-[12px] font-bold">Name</td>
                    <td class="border-[1px] px-3 text-[12px]">{{ student?.name }}</td>
                </tr>
                <tr>
                    <td class="border-[1px] px-3 text-[12px] font-bold">Registration No.</td>
                    <td class="border-[1px] px-3 text-[12px]">{{ student?.registration_number }}</td>
                    <td class="border-[1px] px-3 text-[12px] font-bold">Registration Date</td>
                    <td class="border-[1px] px-3 text-[12px]">{{ student?.registration_date }}</td>
                </tr>
                <tr>
                    <td class="border-[1px] px-3 text-[12px] font-bold">Birth Date</td>
                    <td class="border-[1px] px-3 text-[12px]">{{ student?.birth_date }}</td>
                    <td class="border-[1px] px-3 text-[12px] font-bold">Gender</td>
                    <td class="border-[1px] px-3 text-[12px]">{{ student?.gender }}</td>
                </tr>
                <tr>
                    <td class="border-[1px] px-3 text-[12px] font-bold">Religion</td>
                    <td class="border-[1px] px-3 text-[12px]">{{ student?.religion }}</td>
                    <td class="border-[1px] px-3 text-[12px] font-bold">Cast</td>
                    <td class="border-[1px] px-3 text-[12px]">{{ student?.cast }}</td>
                </tr>
                <tr>
                    <td class="border-[1px] px-3 text-[12px] font-bold">Phone</td>
                    <td class="border-[1px] px-3 text-[12px]">{{ student?.phone }}</td>
                    <td class="border-[1px] px-3 text-[12px] font-bold">Email</td>
                    <td class="border-[1px] px-3 text-[12px]">{{ student?.email }}</td>
                </tr>
                <tr class="border-[1px]">
                    <td class="border-[1px] px-3 text-[12px] font-bold">National ID</td>
                    <td class="border-[1px] px-3 text-[12px]" colspan="3">{{ student?.national_id }}</td>
                </tr>
            </table>
            <div class="w-[150px]">
                <div class="mb-3 p-1 border-[1px] w-[100px] h-[100px] flex justify-center items-center ">
                    <img :src="'/student.png'" alt="">
                </div>

                <QrCode :value="student?.registration_number" class="h-[70px]"
                                        :src="'/student.png'" />
            </div>
        </div>






        <small class="font-bold uppercase mt-3 block">Academic Information</small>
        <div class="flex gap-3 justify-between">
            <table class="w-full border-[1px]">
                <tr>
                    <td class="border-[1px] px-3 text-[12px] font-bold">Course</td>
                    <td class="border-[1px] px-3 text-[12px]">{{ student?.course?.name }}</td>
                    <td class="border-[1px] px-3 text-[12px] font-bold">Section</td>
                    <td class="border-[1px] px-3 text-[12px]">{{ student?.section?.name }}</td>
                    <td class="border-[1px] px-3 text-[12px] font-bold">Group</td>
                    <td class="border-[1px] px-3 text-[12px]">{{ student?.group?.name }}</td>
                </tr>
            </table>
            
        </div>
        <small class="font-bold uppercase mt-3 block">Father's Information</small>
        <div class="flex gap-3 justify-between">
            <table class="w-full border-[1px]">
                <tr>
                    <td class="border-[1px] px-3 text-[12px] font-bold">Name</td>
                    <td class="border-[1px] px-3 text-[12px]">{{ student?.father_name }}</td>
                    <td class="border-[1px] px-3 text-[12px] font-bold">Phone</td>
                    <td class="border-[1px] px-3 text-[12px]">{{ student?.father_phone }}</td>
                </tr>
                 <tr>
                    <td class="border-[1px] px-3 text-[12px] font-bold">Education</td>
                    <td class="border-[1px] px-3 text-[12px]">{{ student?.father_education }}</td>
                    <td class="border-[1px] px-3 text-[12px] font-bold">Profession</td>
                    <td class="border-[1px] px-3 text-[12px]">{{ student?.father_profession }}</td>
                </tr>
            </table>
            
        </div>
        <small class="font-bold uppercase mt-3 block">Mother's Information</small>
        <div class="flex gap-3 justify-between">
            <table class="w-full border-[1px]">
                <tr>
                    <td class="border-[1px] px-3 text-[12px] font-bold">Name</td>
                    <td class="border-[1px] px-3 text-[12px]">{{ student?.mother_name }}</td>
                    <td class="border-[1px] px-3 text-[12px] font-bold">Phone</td>
                    <td class="border-[1px] px-3 text-[12px]">{{ student?.mother_phone }}</td>
                </tr>
                 <tr>
                    <td class="border-[1px] px-3 text-[12px] font-bold">Education</td>
                    <td class="border-[1px] px-3 text-[12px]">{{ student?.mother_education }}</td>
                    <td class="border-[1px] px-3 text-[12px] font-bold">Profession</td>
                    <td class="border-[1px] px-3 text-[12px]">{{ student?.mother_profession }}</td>
                </tr>
            </table>
            
        </div>
        <small class="font-bold uppercase mt-3 block">Address Information</small>
        <div class="flex gap-3 justify-between">
            <table class="w-full border-[1px]">
                <tr>
                    <td class="border-[1px] px-3 text-[12px] font-bold">Present</td>
                    <td class="border-[1px] px-3 text-[12px]">{{ student?.present_address }}</td>
                    <td class="border-[1px] px-3 text-[12px] font-bold">Permanent</td>
                    <td class="border-[1px] px-3 text-[12px]">{{ student?.permanent_address }}</td>
                </tr>
            </table>
            
        </div>
        <small class="font-bold uppercase mt-3 block">Previus School</small>
        <div class="flex gap-3 justify-between">
            <table class="w-full border-[1px]">
                <tr>
                    <td class="border-[1px] px-3 text-[12px] font-bold">School Name</td>
                    <td class="border-[1px] px-3 text-[12px]">{{ student?.prev_school }}</td>
                    <td class="border-[1px] px-3 text-[12px] font-bold">Class</td>
                    <td class="border-[1px] px-3 text-[12px]">{{ student?.prev_class }}</td>
                </tr>
            </table>
            
        </div>
    </Modal>
</template>
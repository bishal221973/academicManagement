<script setup>
import { Printer, Mail, Phone } from "lucide-vue-next";
import Modal from "@/Components/Modal.vue";
import QrCode from "@/Components/QrCode.vue";
import { ref } from "vue";

const props = defineProps({
    student: Object,
});

// Modal open/close
const openModal = ref(false);
const toggleOpenModal = () => {
    openModal.value = !openModal.value;
};

const downloadNow = () => {
    const tds = document.querySelectorAll('.pdf-container td');

    // Store original inline style for full restore
    const originalStyles = [];

    tds.forEach((td, i) => {
        // Save the original entire inline style (best way)
        originalStyles[i] = td.getAttribute("style");

        // Apply PDF padding with !important
        td.style.setProperty('padding', '2px 6px 15px 6px', 'important');
    });

    pdf.value.download().finally(() => {
        // Restore original styles exactly as before
        tds.forEach((td, i) => {
            if (originalStyles[i]) {
                td.setAttribute("style", originalStyles[i]); // restore original inline style
            } else {
                td.removeAttribute("style"); // remove inline style if none existed
            }
        });
    });
};

// PDF options
const pdfOptions = {
    margin: 15,
    image: {
        type: 'jpeg',
        quality: 1,
    },
    html2canvas: { scale: 3 },
    jsPDF: {
        unit: 'mm',
        format: 'a4',
        orientation: 'p',
    },
};

// PDF filename
const exportFilename = 'student-details.pdf';

const pdf = ref(true)

</script>

<template>
    <button @click="toggleOpenModal" title="Print" class="w-full border-r hover:text-red-500">
        <component :is="Printer" class="h-[13px]" />
    </button>
    <Modal :show="openModal" :max-width="'4xl'" @close="toggleOpenModal">
        <v-pdf ref="pdf" :options="pdfOptions" :filename="exportFilename">



            <!-- <img :src="$page?.props?.academy?.logo" class="absolute opacity-5" alt="" /> -->

            <div class="pdf-container">
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
                <small class="font-bold uppercase mb-1">Student Details</small>
                <div class="flex gap-3 justify-between">
                    <table class="w-full border-[1px] mt-2">
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
                        <QrCode :value="student?.registration_number" class="h-[70px]" :src="'/student.png'" />
                    </div>
                </div>






                <small class="font-bold uppercase mt-3 block">Academic Information</small>
                <div class="flex gap-3 justify-between">
                    <table class="w-full border-[1px] mt-2">
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
                    <table class="w-full border-[1px] mt-2">
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
                    <table class="w-full border-[1px] mt-2">
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
                    <table class="w-full border-[1px] mt-2">
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
                    <table class="w-full border-[1px] mt-2">
                        <tr>
                            <td class="border-[1px] px-3 text-[12px] font-bold">School Name</td>
                            <td class="border-[1px] px-3 text-[12px]">{{ student?.prev_school }}</td>
                            <td class="border-[1px] px-3 text-[12px] font-bold">Class</td>
                            <td class="border-[1px] px-3 text-[12px]">{{ student?.prev_class }}</td>
                        </tr>
                    </table>

                </div>
            </div>
        </v-pdf>
        <div class="flex justify-end">
            <button @click="downloadNow" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mt-3"><i class="fa fa-download"></i> Download PDF</button>
        </div>
    </Modal>

</template>

<style>
td {
    padding: 1px 6px 1px 6px !important;
    vertical-align: middle !important;
    line-height: 14px !important;
    height: 30px !important;
}
</style>
<style id="pdf-style" disabled></style>

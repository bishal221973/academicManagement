<script setup>
import { onMounted, ref } from "vue";
import Modal from "../Modal.vue";
import { Link, useForm } from "@inertiajs/vue3";
import { Plus } from "lucide-vue-next";
import Datepicker from "../Datepicker.vue";
import SelectComponent from "@/Components/SelectComponent.vue";
import SelectCourse from "../Select/SelectCourse.vue";
import SelectSection from "../Select/SelectSection.vue";
import SelectGroup from "../Select/SelectGroup.vue";
const props = defineProps({
    isSelect: {
        type: Boolean,
        default: false,
    },
    student: {
        type: Object,
        default: null,
    },
    title: String,
});
const openModal = ref(false);

const toggleModal = () => {
    openModal.value = !openModal.value;
};

const form = useForm({
    name: '',
    registration_number: '',
    registration_date: '',
    birth_date: '',
    gender: '',
    religion: '',
    cast: '',
    phone: '',
    email: '',
    national_id: '',
    course_id: '',
    section_id: '',
    group_id: '',
    father_name: '',
    father_phone: '',
    father_education: '',
    father_profession: '',
    mother_name: '',
    mother_phone: '',
    mother_education: '',
    mother_profession: '',
    present_address: '',
    permanent_address: '',
    prev_school: '',
    prev_class: '',
    transfer_certificate: '',
});


const submit = () => {
    if (props.student?.id) {
        updateData();
    } else {
        saveData();
    }
}
onMounted(() => {
    if (props.student?.id) {
        toggleModal();
        form.name = props.student.name;
        form.registration_number = props.student.registration_number;
        form.registration_date = props.student.registration_date;
        form.birth_date = props.student.birth_date;
        form.gender = props.student.gender;
        form.religion = props.student.religion;
        form.cast = props.student.cast;
        form.phone = props.student.phone;
        form.email = props.student.email;
        form.national_id = props.student.national_id;
        form.course_id = props.student.course_id;
        form.section_id = props.student.section_id;
        form.group_id = props.student.group_id;
        form.father_name = props.student.father_name;
        form.father_phone = props.student.father_phone;
        form.father_education = props.student.father_education;
        form.father_profession = props.student.father_profession;
        form.mother_name = props.student.mother_name;
        form.mother_phone = props.student.mother_phone;
        form.mother_education = props.student.mother_education;
        form.mother_profession = props.student.mother_profession;
        form.present_address = props.student.present_address;
        form.permanent_address = props.student.permanent_address;
        form.prev_school = props.student.prev_school;
        form.prev_class = props.student.prev_class;
        form.transfer_certificate = props.student.transfer_certificate;
    }
});

const saveData = () => {
    form.post(route('student.store'), {
        onSuccess: () => {
            form.reset();
            toggleModal();
        }
    })
}

const updateData = () => {
    form.put(route('student.update', props.student), {
        onSuccess: () => {
            form.reset();
            toggleModal();
        }
    })
}

const dateOptions = [
    { label: "Male", value: "Male" },
    { label: "Female", value: "Female" },
];
const religionOptions = [
    { label: "Hindu", value: "Hindu" },
    { label: "Muslim", value: "Muslim" },
    { label: "Christian", value: "Christian" },
    { label: "Buddhist", value: "Buddhist" },
    { label: "Other", value: "Other" },
];

const castOptions = [
    { label: "Brahmin", value: "Brahmin" },
    { label: "Chhetri", value: "Chhetri" },
    { label: "Magar", value: "Magar" },
    { label: "Rai", value: "Rai" },
    { label: "Limbu", value: "Limbu" },
    { label: "Newar", value: "Newar" },
    { label: "Tharu", value: "Tharu" },
    { label: "Tamang", value: "Tamang" },
    { label: "Dalit", value: "Dalit" },
    { label: "Other", value: "Other" },
];
function handleFileChange(event) {
  const file = event.target.files[0];
  if (file) {
    form.transfer_certificate = file; // Assign the file to the form field
    console.log('Selected file:', file);
  }
}
</script>
<template>
    <button @click="toggleModal" class="" v-if="isSelect" type="button">
        <component :is="Plus" />
    </button>
    <div v-else>

        <button @click="toggleModal" type="button" class="text-[14px] hover:text-main/80 flex items-center gap-3 mb-5"
            v-if="title">{{ title }}</button>
        <button @click="toggleModal" type="button" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
            v-else>Add Student</button>
    </div>

    <Modal :show="openModal" maxWidth="3xl" :title="student?.id ? 'Edit Student' : 'Add Student'" @close="toggleModal"
        :selectedData="student">

        <form @submit.prevent="submit">
            <div class="grid grid-cols-12 gap-3">
                <div class="col-span-12">
                    <div class="bg-gray-100 py-2 px-3 rounded">
                        <span class="text-[14px]">Basic Information :</span>
                    </div>
                </div>
                <div class="col-span-3">
                    <label class="text-[14px]">Name *</label>
                    <input type="text" v-model="form.name"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter student name" />
                    <small class="text-red-600">{{ form.errors.name }}</small>
                </div>
                <div class="col-span-3">
                    <label class="text-[14px]">Registration No. *</label>
                    <input type="text" v-model="form.registration_number"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter student name" />
                    <small class="text-red-600">{{ form.errors.registration_number }}</small>
                </div>
                <div class="col-span-3">
                    <label class="text-[14px]">Registration Date *</label>
                    <Datepicker v-model="form.registration_date" />
                    <small class="text-red-600">{{ form.errors.registration_date }}</small>
                </div>
                <div class="col-span-3">
                    <label class="text-[14px]">Birth Date</label>
                    <Datepicker v-model="form.birth_date" />
                    <small class="text-red-600">{{ form.errors.birth_date }}</small>
                </div>
                <div class="col-span-3">
                    <label class="text-[14px]">Gender</label>
                    <SelectComponent v-model="form.gender" :options="dateOptions" label="Date Format *"
                        placeholder="Select gender" class="mt-[5px]" />
                    <small class="text-red-600">{{ form.errors.gender }}</small>
                </div>
                <div class="col-span-3">
                    <label class="text-[14px]">Religion</label>
                    <SelectComponent v-model="form.religion" :options="religionOptions" label="Date Format *"
                        placeholder="Select gender" class="mt-[5px]" />
                    <small class="text-red-600">{{ form.errors.religion }}</small>
                </div>
                <div class="col-span-3">
                    <label class="text-[14px]">Cast</label>
                    <SelectComponent v-model="form.cast" :options="castOptions" label="Date Format *"
                        placeholder="Select gender" class="mt-[5px]" />
                    <small class="text-red-600">{{ form.errors.cast }}</small>
                </div>
                <div class="col-span-3">
                    <label class="text-[14px]">Phone</label>
                    <input type="text" v-model="form.phone"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter student name" />
                    <small class="text-red-600">{{ form.errors.phone }}</small>
                </div>
                <div class="col-span-3">
                    <label class="text-[14px]">Email</label>
                    <input type="text" v-model="form.email"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter student name" />
                    <small class="text-red-600">{{ form.errors.email }}</small>
                </div>
                <div class="col-span-3">
                    <label class="text-[14px]">National ID</label>
                    <input type="text" v-model="form.national_id"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter student name" />
                    <small class="text-red-600">{{ form.errors.national_id }}</small>
                </div>

                <!-- ========================== -->
                <div class="col-span-12">
                    <div class="bg-gray-100 py-2 px-3 rounded">
                        <span class="text-[14px]">Academic Information :</span>
                    </div>
                </div>
                <div class="col-span-12">
                    <div class="flex gap-3">
                        <div class="w-full">
                            <label class="text-[14px]">Course *</label>
                            <SelectCourse class="mt-[5px]" v-model="form.course_id" />
                            <small class="text-red-600">{{ form.errors.course_id }}</small>
                        </div>
                        <div class="w-full">
                            <label class="text-[14px]">Section</label>
                            <SelectSection class="mt-[5px]" v-model="form.section_id" />
                            <small class="text-red-600">{{ form.errors.section_id }}</small>
                        </div>
                        <div class="w-full">
                            <label class="text-[14px]">Group</label>
                            <SelectGroup class="mt-[5px]" v-model="form.group_id" />
                            <small class="text-red-600">{{ form.errors.group_id }}</small>
                        </div>
                    </div>
                </div>

                <!-- =============================== -->
                <div class="col-span-12">
                    <div class="bg-gray-100 py-2 px-3 rounded">
                        <span class="text-[14px]">Father's Information :</span>
                    </div>
                </div>
                <div class="col-span-3">
                    <label class="text-[14px]">Father Name</label>
                    <input type="text" v-model="form.father_name"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter student name" />
                    <small class="text-red-600">{{ form.errors.father_name }}</small>
                </div>
                <div class="col-span-3">
                    <label class="text-[14px]">Phone</label>
                    <input type="text" v-model="form.father_phone"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter student name" />
                    <small class="text-red-600">{{ form.errors.father_phone }}</small>
                </div>
                <div class="col-span-3">
                    <label class="text-[14px]">Education</label>
                    <input type="text" v-model="form.father_education"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter student name" />
                    <small class="text-red-600">{{ form.errors.father_education }}</small>
                </div>
                <div class="col-span-3">
                    <label class="text-[14px]">Profession</label>
                    <input type="text" v-model="form.father_profession"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter student name" />
                    <small class="text-red-600">{{ form.errors.father_profession }}</small>
                </div>




                <!-- =============================== -->
                <div class="col-span-12">
                    <div class="bg-gray-100 py-2 px-3 rounded">
                        <span class="text-[14px]">Mother's Information :</span>
                    </div>
                </div>
                <div class="col-span-3">
                    <label class="text-[14px]">Mother Name</label>
                    <input type="text" v-model="form.mother_name"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter student name" />
                    <small class="text-red-600">{{ form.errors.mother_name }}</small>
                </div>
                <div class="col-span-3">
                    <label class="text-[14px]">Phone</label>
                    <input type="text" v-model="form.mother_phone"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter student name" />
                    <small class="text-red-600">{{ form.errors.mother_phone }}</small>
                </div>
                <div class="col-span-3">
                    <label class="text-[14px]">Education</label>
                    <input type="text" v-model="form.mother_education"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter student name" />
                    <small class="text-red-600">{{ form.errors.mother_education }}</small>
                </div>
                <div class="col-span-3">
                    <label class="text-[14px]">Profession</label>
                    <input type="text" v-model="form.mother_profession"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter student name" />
                    <small class="text-red-600">{{ form.errors.mother_profession }}</small>
                </div>

                <!-- =============================== -->
                <div class="col-span-12">
                    <div class="bg-gray-100 py-2 px-3 rounded">
                        <span class="text-[14px]">Address Information :</span>
                    </div>
                </div>
                <div class="col-span-6">
                    <label class="text-[14px]">Present</label>
                    <input type="text" v-model="form.present_address"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter student name" />
                    <small class="text-red-600">{{ form.errors.present_address }}</small>
                </div>
                <div class="col-span-6">
                    <label class="text-[14px]">Permanent</label>
                    <input type="text" v-model="form.permanent_address"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter student name" />
                    <small class="text-red-600">{{ form.errors.permanent_address }}</small>
                </div>

                <!-- ========================== -->
                <div class="col-span-12">
                    <div class="bg-gray-100 py-2 px-3 rounded">
                        <span class="text-[14px]">Previous School :</span>
                    </div>
                </div>
                <div class="col-span-12">
                    <div class="flex gap-3">
                        <div class="w-full">
                            <label class="text-[14px]">School Name</label>
                            <input type="text" v-model="form.prev_school"
                                class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter student name" />
                            <small class="text-red-600">{{ form.errors.prev_school }}</small>
                        </div>
                        <div class="w-full">
                            <label class="text-[14px]">Class</label>
                            <input type="text" v-model="form.prev_class"
                                class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter student name" />
                            <small class="text-red-600">{{ form.errors.prev_class }}</small>
                        </div>
                        <div class="w-full">
                            <label class="text-[14px]">Transfer Certificate</label>
                            <input type="file"
                            @change="handleFileChange"
                                class="w-full border border-gray-300 rounded px-3 py-[5px] mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter student name" />
                            <small class="text-red-600">{{ form.errors.transfer_certificate }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-12 mt-4 bg-gray-100 p-3 rounded flex justify-end">
                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" type="submit">
                    {{ student?.id ? 'Update Student' : 'Save Student' }}
                </button>
            </div>
        </form>
    </Modal>
</template>
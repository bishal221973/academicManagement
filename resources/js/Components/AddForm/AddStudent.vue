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
    group: {
        type: Object,
        default: null,
    },
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
    if (props.group?.id) {
        updateData();
    } else {
        saveData();
    }
}
onMounted(() => {
    if (props.group?.id) {
        toggleModal();
        form.name = props.group.name;
        form.code = props.group.code;
        form.description = props.group.description;
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
    form.put(route('student.update', props.group), {
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

</script>
<template>
    <button @click="toggleModal" class="" v-if="isSelect" type="button">
        <component :is="Plus" />
    </button>
    <button @click="toggleModal" type="button" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
        v-else>Add Student</button>

    <Modal :show="openModal" maxWidth="3xl" :title="group?.id ? 'Edit Student' : 'Add Student'" @close="toggleModal"
        :selectedData="group">

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
                    <Datepicker v-model="form.registration_date"/>
                    <small class="text-red-600">{{ form.errors.registration_date }}</small>
                </div>
                <div class="col-span-3">
                    <label class="text-[14px]">Birth Date</label>
                    <Datepicker v-model="form.birth_date"/>
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
                            <SelectCourse class="mt-[5px]" v-model="form.course_id"/>
                            <small class="text-red-600">{{ form.errors.course_id }}</small>
                        </div>
                        <div class="w-full">
                            <label class="text-[14px]">Section</label>
                            <SelectSection class="mt-[5px]" v-model="form.section_id"/>
                            <small class="text-red-600">{{ form.errors.section_id }}</small>
                        </div>
                        <div class="w-full">
                            <label class="text-[14px]">Group</label>
                            <SelectGroup class="mt-[5px]" v-model="form.group_id"/>
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
                            <input type="text" v-model="form.transfer_certificate"
                                class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter student name" />
                            <small class="text-red-600">{{ form.errors.transfer_certificate }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-12 mt-4 bg-gray-100 p-3 rounded flex justify-end">
                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" type="submit">
                    {{ group?.id ? 'Update Student' : 'Save Student' }}
                </button>
            </div>
        </form>
    </Modal>
</template>
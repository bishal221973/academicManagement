<script setup>
import { onMounted, ref } from "vue";
import Modal from "../Modal.vue";
import { Link, useForm } from "@inertiajs/vue3";
import { Plus } from "lucide-vue-next";
import Datepicker from "../Datepicker.vue";
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
    code: '',
    description: '',
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
    form.post(route('group.store'), {
        onSuccess: () => {
            form.reset();
            toggleModal();
        }
    })
}

const updateData = () => {
    form.put(route('group.update', props.group), {
        onSuccess: () => {
            form.reset();
            toggleModal();
        }
    })
}
</script>
<template>
    <button @click="toggleModal" class="" v-if="isSelect" type="button">
        <component :is="Plus" />
    </button>
    <button @click="toggleModal" type="button" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
        v-else>Add Student</button>

    <Modal :show="openModal" maxWidth="3xl" :title="group?.id ? 'Edit Group' : 'Add Group'" @close="toggleModal"
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
                    <label class="text-[14px]">Admission No. *</label>
                    <input type="text"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter student name" />
                    <small class="text-red-600">{{ form.errors.name }}</small>
                </div>
                <div class="col-span-3">
                    <label class="text-[14px]">Admission Date *</label>
                    <Datepicker/>
                    <!-- <input type="text"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter student name" /> -->
                    <small class="text-red-600">{{ form.errors.name }}</small>
                </div>
                <div class="col-span-3">
                    <label class="text-[14px]">Birth Date *</label>
                    <input type="text"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter student name" />
                    <small class="text-red-600">{{ form.errors.name }}</small>
                </div>
                <div class="col-span-3">
                    <label class="text-[14px]">Gender *</label>
                    <input type="text"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter student name" />
                    <small class="text-red-600">{{ form.errors.name }}</small>
                </div>
                <div class="col-span-3">
                    <label class="text-[14px]">Religion *</label>
                    <input type="text"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter student name" />
                    <small class="text-red-600">{{ form.errors.name }}</small>
                </div>
                <div class="col-span-3">
                    <label class="text-[14px]">Cast *</label>
                    <input type="text"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter student name" />
                    <small class="text-red-600">{{ form.errors.name }}</small>
                </div>
                <div class="col-span-3">
                    <label class="text-[14px]">Phone *</label>
                    <input type="text"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter student name" />
                    <small class="text-red-600">{{ form.errors.name }}</small>
                </div>
                <div class="col-span-3">
                    <label class="text-[14px]">Email *</label>
                    <input type="text"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter student name" />
                    <small class="text-red-600">{{ form.errors.name }}</small>
                </div>
                <div class="col-span-3">
                    <label class="text-[14px]">National ID *</label>
                    <input type="text"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter student name" />
                    <small class="text-red-600">{{ form.errors.name }}</small>
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
                            <input type="text" v-model="form.name"
                                class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter student name" />
                            <small class="text-red-600">{{ form.errors.name }}</small>
                        </div>
                        <div class="w-full">
                            <label class="text-[14px]">Section *</label>
                            <input type="text"
                                class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter student name" />
                            <small class="text-red-600">{{ form.errors.name }}</small>
                        </div>
                        <div class="w-full">
                            <label class="text-[14px]">Group *</label>
                            <input type="text"
                                class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter student name" />
                            <small class="text-red-600">{{ form.errors.name }}</small>
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
                    <label class="text-[14px]">Father Name *</label>
                    <input type="text" v-model="form.name"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter student name" />
                    <small class="text-red-600">{{ form.errors.name }}</small>
                </div>
                <div class="col-span-3">
                    <label class="text-[14px]">Phone *</label>
                    <input type="text"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter student name" />
                    <small class="text-red-600">{{ form.errors.name }}</small>
                </div>
                <div class="col-span-3">
                    <label class="text-[14px]">Education</label>
                    <input type="text"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter student name" />
                    <small class="text-red-600">{{ form.errors.name }}</small>
                </div>
                <div class="col-span-3">
                    <label class="text-[14px]">Profession</label>
                    <input type="text"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter student name" />
                    <small class="text-red-600">{{ form.errors.name }}</small>
                </div>




                 <!-- =============================== -->
                 <div class="col-span-12">
                    <div class="bg-gray-100 py-2 px-3 rounded">
                        <span class="text-[14px]">Mother's Information :</span>
                    </div>
                </div>
                <div class="col-span-3">
                    <label class="text-[14px]">Mother Name *</label>
                    <input type="text" v-model="form.name"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter student name" />
                    <small class="text-red-600">{{ form.errors.name }}</small>
                </div>
                <div class="col-span-3">
                    <label class="text-[14px]">Phone *</label>
                    <input type="text"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter student name" />
                    <small class="text-red-600">{{ form.errors.name }}</small>
                </div>
                <div class="col-span-3">
                    <label class="text-[14px]">Education</label>
                    <input type="text"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter student name" />
                    <small class="text-red-600">{{ form.errors.name }}</small>
                </div>
                <div class="col-span-3">
                    <label class="text-[14px]">Profession</label>
                    <input type="text"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter student name" />
                    <small class="text-red-600">{{ form.errors.name }}</small>
                </div>

                 <!-- =============================== -->
                 <div class="col-span-12">
                    <div class="bg-gray-100 py-2 px-3 rounded">
                        <span class="text-[14px]">Address Information :</span>
                    </div>
                </div>
                <div class="col-span-6">
                    <label class="text-[14px]">Present *</label>
                    <input type="text" v-model="form.name"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter student name" />
                    <small class="text-red-600">{{ form.errors.name }}</small>
                </div>
                <div class="col-span-6">
                    <label class="text-[14px]">Permanent *</label>
                    <input type="text"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter student name" />
                    <small class="text-red-600">{{ form.errors.name }}</small>
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
                            <label class="text-[14px]">School Name *</label>
                            <input type="text" v-model="form.name"
                                class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter student name" />
                            <small class="text-red-600">{{ form.errors.name }}</small>
                        </div>
                        <div class="w-full">
                            <label class="text-[14px]">Class</label>
                            <input type="text"
                                class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter student name" />
                            <small class="text-red-600">{{ form.errors.name }}</small>
                        </div>
                        <div class="w-full">
                            <label class="text-[14px]">Transfer Certificate</label>
                            <input type="text"
                                class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter student name" />
                            <small class="text-red-600">{{ form.errors.name }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-12 mt-4 bg-gray-100 p-3 rounded flex justify-end">
                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" type="submit">
                    {{ group?.id ? 'Update Group' : 'Save Group' }}
                </button>
            </div>
        </form>
    </Modal>
</template>
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
    academicYear: {
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
    from: '',
    to: '',
    status: '',
});


const submit = () => {
    if (props.academicYear?.id) {
        updateData();
    } else {
        saveData();
    }
}
onMounted(() => {
    if (props.academicYear?.id) {
        toggleModal();

        form.name = props.academicYear.name;
        form.from = props.academicYear.from;
        form.to = props.academicYear.to;
        form.status = props.academicYear.status;
    }
});

const saveData = () => {
    form.post(route('academic.store'), {
        onSuccess: () => {
            form.reset();
            toggleModal();
        }
    })
}

const updateData = () => {
    form.put(route('academic.update', props.academicYear), {
        onSuccess: () => {
            form.reset();
            toggleModal();
        }
    })
}

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
            v-else>Add Academic Year</button>
    </div>

    <Modal :show="openModal" maxWidth="sm" :title="academicYear?.id ? 'Edit Academic Year' : 'Add Academic Year'" @close="toggleModal"
        :selectedData="academicYear">

        <form @submit.prevent="submit">
            <div class="grid grid-cols-12 gap-3">
                
                <div class="col-span-12">
                    <label class="text-[14px]">Name *</label>
                    <input type="text" v-model="form.name"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter name" />
                    <small class="text-red-600">{{ form.errors.name }}</small>
                </div>
               
               
                <div class="col-span-12">
                    <label class="text-[14px]">From *</label>
                    <Datepicker v-model="form.from" />
                    <small class="text-red-600">{{ form.errors.from }}</small>
                </div>
                <div class="col-span-12">
                    <label class="text-[14px]">To</label>
                    <Datepicker v-model="form.to" />
                    <small class="text-red-600">{{ form.errors.to }}</small>
                </div>
               
            </div>

            <div class="col-span-12 mt-4 bg-gray-100 p-3 rounded flex justify-end">
                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" type="submit">
                    {{ academicYear?.id ? 'Update' : 'Save' }}
                </button>
            </div>
        </form>
    </Modal>
</template>
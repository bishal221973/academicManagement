<script setup>
import { onMounted, ref } from "vue";
import Modal from "../Modal.vue";
import { Link, useForm } from "@inertiajs/vue3";
import { Plus } from "lucide-vue-next";
const props = defineProps({
    isSelect: {
        type: Boolean,
        default: false,
    },
    course: {
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
    if(props.course?.id){
        updateData();
    }else{
        saveData();
    }
}
onMounted(() => {
    if (props.course?.id) {
        toggleModal();
        form.name = props.course.name;
        form.code = props.course.code;
        form.description = props.course.description;
    }
});

const saveData = () => {
    form.post(route('course.store'), {
        onSuccess: () => {
            form.reset();
            toggleModal();
        }
    })
}

const updateData = () => {
    form.put(route('course.update', props.course), {
        onSuccess: () => {
            form.reset();
            toggleModal();
        }
    })
}
</script>
<template>
    <button @click="toggleModal" class="" v-if="isSelect">
        <component :is="Plus" />
    </button>
    <button @click="toggleModal" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" v-else>Add Course</button>
    
    <Modal :show="openModal" maxWidth="sm" :title="course?.id ? 'Edit Course' : 'Add Course'" @close="toggleModal" :selectedData="course">
    
        <form @submit.prevent="submit">
            <div class="mb-3">
                <label class="text-[14px]">Course Name *</label>
                <input type="text" v-model="form.name"
                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter course name" />
                    <small class="text-red-600">{{ form.errors.name }}</small>
            </div>
            <div class="mb-3">
                <label class="text-[14px]">Course Code *</label>
                <input type="text" v-model="form.code"
                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter course code" />
                <small class="text-red-600">{{ form.errors.code }}</small>
            </div>
            <div class="mb-3">
                <label class="text-[14px]">Description</label>
                <textarea type="text" v-model="form.description"
                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter description"></textarea>
            </div>
            <div class="col-span-12 mt-4 bg-gray-100 p-3 rounded flex justify-end">
                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" type="submit">
                    {{course?.id ? 'Update Course' : 'Save Course'}}
                </button>
            </div>
        </form>
    </Modal>
</template>
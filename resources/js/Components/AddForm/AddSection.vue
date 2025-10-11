<script setup>
import { onMounted, ref } from "vue";
import Modal from "../Modal.vue";
import { Link, useForm } from "@inertiajs/vue3";
import { Plus } from "lucide-vue-next";
import SelectCourse from "../Select/SelectCourse.vue";
const props = defineProps({
    isSelect: {
        type: Boolean,
        default: false,
    },
    section: {
        type: Object,
        default: null,
    },
});
const openModal = ref(false);

const toggleModal = () => {
    openModal.value = !openModal.value;
};

const form = useForm({
    course_id:'',
    name: '',
    description: '',
});


const submit = () => {
    if(props.section?.id){
        updateData();
    }else{
        saveData();
    }
}
onMounted(() => {
    if (props.section?.id) {
        // alert('here');
        toggleModal();
        form.course_id = props.section.course_id;
        form.name = props.section.name;
        form.description = props.section.description;
    }
});

const saveData = () => {
    form.post(route('section.store'), {
        onSuccess: () => {
            form.reset();
            toggleModal();
        }
    })
}

const updateData = () => {
    form.put(route('section.update', props.section), {
        onSuccess: () => {
            form.reset();
            toggleModal();
        }
    })
}
</script>
<template>
    <button @click="toggleModal" type="button" class="" v-if="isSelect">
        <component :is="Plus" />
    </button>
    <button @click="toggleModal" type="button" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" v-else>Add Section</button>
    
    <Modal :show="openModal" maxWidth="sm" :title="section?.id ? 'Edit Section' : 'Add Section'" @close="toggleModal" :selectedData="section">
    
        <form @submit.prevent="submit">
            <div class="mb-3">
                <label class="text-[14px]">Course *</label>
                <SelectCourse v-model="form.course_id" />
                    <small class="text-red-600">{{ form.errors.course_id }}</small>
            </div>
            <div class="mb-3">
                <label class="text-[14px]">Section Name *</label>
                <input type="text" v-model="form.name"
                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter course code" />
                <small class="text-red-600">{{ form.errors.name }}</small>
            </div>
            <div class="mb-3">
                <label class="text-[14px]">Description</label>
                <textarea type="text" v-model="form.description"
                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter description"></textarea>
            </div>
            <div class="col-span-12 mt-4 bg-gray-100 p-3 rounded flex justify-end">
                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" type="submit">
                    {{section?.id ? 'Update Course' : 'Save Course'}}
                </button>
            </div>
        </form>
    </Modal>
</template>
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
    subject: {
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
    code: '',
    description: '',
});


const submit = () => {
    if(props.subject?.id){
        updateData();
    }else{
        saveData();
    }
}
onMounted(() => {
    if (props.subject?.id) {
        toggleModal();
        form.course_id = props.subject.course_id;
        form.name = props.subject.name;
        form.code = props.subject.code;
        form.description = props.subject.description;
    }
});

const saveData = () => {
    form.post(route('subject.store'), {
        onSuccess: () => {
            form.reset();
            toggleModal();
        }
    })
}

const updateData = () => {
    form.put(route('subject.update', props.subject), {
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
    <button @click="toggleModal" type="button" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" v-else>Add Subject</button>
    
    <Modal :show="openModal" maxWidth="sm" :title="subject?.id ? 'Edit Subject' : 'Add Subject'" @close="toggleModal" :selectedData="subject">
    
        <form @submit.prevent="submit">
            <div class="mb-3">
                <label class="text-[14px]">Course *</label>
                <SelectCourse v-model="form.course_id"/>
                    <small class="text-red-600">{{ form.errors.course_id }}</small>
            </div>
            <div class="mb-3">
                <label class="text-[14px]">Subject Name *</label>
                <input type="text" v-model="form.name"
                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter subject name" />
                    <small class="text-red-600">{{ form.errors.name }}</small>
            </div>
            <div class="mb-3">
                <label class="text-[14px]">Subject Code *</label>
                <input type="text" v-model="form.code"
                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter code" />
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
                    {{subject?.id ? 'Update Subject' : 'Save Subject'}}
                </button>
            </div>
        </form>
    </Modal>
</template>
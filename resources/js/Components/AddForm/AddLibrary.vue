<script setup>
import { onMounted, ref } from "vue";
import Modal from "../Modal.vue";
import { Link, useForm } from "@inertiajs/vue3";
import { Plus } from "lucide-vue-next";
import SelectComponent from "@/Components/SelectComponent.vue";
import SelectHostel from "../Select/SelectHostel.vue";
import SelectCourse from "../Select/SelectCourse.vue";
const props = defineProps({
    isSelect: {
        type: Boolean,
        default: false,
    },
    hostel: {
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
    address: '',
    type: '',
    remarks: '',
});


const submit = () => {
    if(props.hostel?.id){
        updateData();
    }else{
        saveData();
    }
}
onMounted(() => {
    if (props.hostel?.id) {
        toggleModal();
        form.name = props.hostel.name;
        form.address = props.hostel.address;
        form.type = props.hostel.type;
        form.remarks = props.hostel.remarks;
    }
});

const saveData = () => {
    form.post(route('hostel.store'), {
        onSuccess: () => {
            form.reset();
            toggleModal();
        }
    })
}

const updateData = () => {
    form.put(route('hostel.update', props.hostel), {
        onSuccess: () => {
            form.reset();
            toggleModal();
        }
    })
}

const dateOptions = [
    { label: "Girls", value: "Girls" },
    { label: "Boys", value: "Boys" },
    { label: "Girls/Boys", value: "Girls/Boys" },
];
</script>
<template>
    <button @click="toggleModal" class="" v-if="isSelect" type="button">
        <component :is="Plus" />
    </button>
    <button @click="toggleModal" type="button" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" v-else>Add Library</button>
    
    <Modal :show="openModal" maxWidth="3xl" :title="hostel?.id ? 'Edit Hostel' : 'Add Hostel'" @close="toggleModal" :selectedData="hostel">
        <div class="grid grid-cols-12" style="min-height: 300px;">
            <div class="col-span-6">
                <div class="shadow p-3 rounded">
                    <SelectCourse/>
                </div>
            </div>
        </div>
    </Modal>
</template>
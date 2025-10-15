<script setup>
import { onMounted, ref } from "vue";
import Modal from "../Modal.vue";
import { Link, useForm } from "@inertiajs/vue3";
import { Plus } from "lucide-vue-next";
import SelectComponent from "@/Components/SelectComponent.vue";
import SelectHostel from "../Select/SelectHostel.vue";
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
    <button @click="toggleModal" type="button" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" v-else>Add Hostel</button>
    
    <Modal :show="openModal" maxWidth="sm" :title="hostel?.id ? 'Edit Hostel' : 'Add Hostel'" @close="toggleModal" :selectedData="hostel">
    
        <form @submit.prevent="submit">
            <div class="mb-3">
                <label class="text-[14px]">Hostel Name *</label>
                <input type="text" v-model="form.name"
                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter hostel name" />
                    <small class="text-red-600">{{ form.errors.name }}</small>
            </div>
            <div class="mb-3">
                <label class="text-[14px]">Address</label>
                <input type="text" v-model="form.address"
                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter address" />
                <small class="text-red-600">{{ form.errors.address }}</small>
            </div>
            <div class="mb-3">
                <label class="text-[14px]">Type</label>
                <SelectComponent
                            v-model="form.type"
                            :options="dateOptions"
                            label="Date Format *"
                            placeholder="Select hostel type"
                        />
                <small class="text-red-600">{{ form.errors.code }}</small>
            </div>
            <div class="mb-3">
                <label class="text-[14px]">Description</label>
                <textarea type="text" v-model="form.remarks"
                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter description"></textarea>
            </div>
            <div class="col-span-12 mt-4 bg-gray-100 p-3 rounded flex justify-end">
                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" type="submit">
                    {{hostel?.id ? 'Update Hostel' : 'Save Hostel'}}
                </button>
            </div>
        </form>
    </Modal>
</template>
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
    room: {
        type: Object,
        default: null,
    },
    type: {
        type: String,
        default: 'type0'
    },
    hostelId:String
});
const openModal = ref(false);

const toggleModal = () => {
    openModal.value = !openModal.value;
};

const form = useForm({
    hostel_id: props?.hostelId ?? '',
    name: '',
    type: '',
    no_of_bed: '',
    price: '',
    remarks: '',
});


const submit = () => {
    if (props.room?.id) {
        updateData();
    } else {
        saveData();
    }
}
onMounted(() => {
    if (props.room?.id) {
        toggleModal();
        form.hostel_id = props.room.hostel_id;
        form.name = props.room.name;
        form.type = props.room.type;
        form.no_of_bed = props.room.no_of_bed;
        form.price = props.room.price;
        form.remarks = props.room.remarks;
    }
});

const saveData = () => {
    form.post(route('room.store'), {
        onSuccess: () => {
            form.reset();
            toggleModal();
        }
    })
}

const updateData = () => {
    form.put(route('room.update', props.room), {
        onSuccess: () => {
            form.reset();
            toggleModal();
        }
    })
}

const roomOptions = [
    { label: "AC", value: "AC" },
    { label: "Non AC", value: "Non AC" },
];
</script>
<template>
    <button @click="toggleModal" class="" v-if="isSelect" type="button">
        <component :is="Plus" />
    </button>
    <button v-else-if="type == 'type1'" @click="toggleModal"
        class="w-full text-[12px] px-3 py-3 border-gray-300 mb-1 rounded btn-border text-left flex justify-center border border-dashed">
        <i class="fa fa-plus text-gray-500"></i>
    </button>
    <button @click="toggleModal" type="button" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
        v-else>Add Room</button>

    <Modal :show="openModal" maxWidth="sm" :title="room?.id ? 'Edit Room' : 'Add Room'" @close="toggleModal"
        :selectedData="hostel">

        <form @submit.prevent="submit">
            <div class="mb-3">
                <label class="text-[14px]">Hostel Name *</label>
                <SelectHostel v-model="form.hostel_id"     :class="hostelId ? 'pointer-events-none opacity-50' : ''"/>
                <small class="text-red-600">{{ form.errors.hostel_id }}</small>
            </div>

            <div class="mb-3">
                <label class="text-[14px]">Room Name *</label>
                <input type="text" v-model="form.name"
                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter room name" />
                <small class="text-red-600">{{ form.errors.name }}</small>
            </div>
            <div class="mb-3">
                <label class="text-[14px]">Room Type</label>
                <SelectComponent v-model="form.type" :options="roomOptions" label="Date Format *"
                    placeholder="Select room type" />
                <small class="text-red-600">{{ form.errors.type }}</small>
            </div>
            <!-- <div class="mb-3">
                <label class="text-[14px]">Number Of Bed *</label>
                <input type="number" v-model="form.no_of_bed"
                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter no. of bed" />
                <small class="text-red-600">{{ form.errors.no_of_bed }}</small>
            </div> -->
            <div class="mb-3">
                <label class="text-[14px]">Price *</label>
                <input type="number" v-model="form.price" step="0.01"
                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter price" />
                <small class="text-red-600">{{ form.errors.price }}</small>
            </div>
            <div class="mb-3">
                <label class="text-[14px]">Description</label>
                <textarea type="text" v-model="form.remarks"
                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter description"></textarea>
            </div>
            <div class="col-span-12 mt-4 bg-gray-100 p-3 rounded flex justify-end">
                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" type="submit">
                    {{ room?.id ? 'Update Room' : 'Save Room' }}
                </button>
            </div>
        </form>
    </Modal>
</template>
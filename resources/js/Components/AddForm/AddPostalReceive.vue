<script setup>
import { onMounted, ref, watch } from "vue";
import Modal from "../Modal.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import { Plus } from "lucide-vue-next";
import axios from "axios";
const props = defineProps({
    isSelect: {
        type: Boolean,
        default: false,
    },
    postalReceive: {
        type: Object,
        default: null,
    },
    title: String,
    bill: Object,
});
const openModal = ref(false);

const toggleModal = () => {
    openModal.value = !openModal.value;
};

const form = useForm({
    to_title: props.postalReceive?.to_title ?? '',
    from_title: props.postalReceive?.from_title ?? '',
    reference: props.postalReceive?.reference ?? '',
    phone_number: props.postalReceive?.phone_number ?? '',
    date: props.postalReceive?.date ?? '',
    remarks: props.postalReceive?.remarks ?? '',

});

const submit = () => {
    if (props.postalReceive?.id) {
        updateData();
    } else {
        saveData();
    }
}


const saveData = () => {
    form.post(route('postalReceive.store'), {
        onSuccess: () => {
            form.to_title="";
            form.from_title="";
            form.reference="";
            form.phone_number="";
            form.date="";
            form.remarks="";
            toggleModal();
        }
    })
}

const updateData = () => {
    form.put(route('postalReceive.update', props.postalReceive), {
        onSuccess: () => {
            form.to_title="";
            form.from_title="";
            form.reference="";
            form.date="";
            form.remarks="";
            toggleModal();
        }
    })
}

const taxes = ref([]);

onMounted(() => {
    if (props.postalReceive?.id) {
        
        toggleModal();
    }

});


</script>
<template>
    <button @click="toggleModal" class="" v-if="isSelect" type="button">
        <component :is="Plus" />
    </button>
    <div v-else>
        <button @click="toggleModal" type="button" class="text-[14px] hover:text-main/80 flex items-center gap-3 mb-5"
            v-if="title">{{ title }}</button>
        <button @click="toggleModal" type="button" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
            v-else>Add Postal Receive</button>

    </div>

    <Modal :show="openModal" maxWidth="xl" :title="postalReceive?.id ? 'Edit Postal Receive' : 'Add Postal Receive'" @close="toggleModal"
        :selectedData="postalReceive">

        <form @submit.prevent="submit">
            <div class="grid grid-cols-12 gap-3">
                <div class="col-span-6">
                    <label class="text-[14px]">To Title *</label>
                    <input type="text" v-model="form.to_title"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="To Title" />
                    <small class="text-red-600">{{ form.errors.to_title }}</small>
                </div>
                 <div class="col-span-6">
                    <label class="text-[14px]">From Title *</label>
                    <input type="text" v-model="form.from_title"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="From Title" />
                    <small class="text-red-600">{{ form.errors.from_title }}</small>
                </div>
                <div class="col-span-6">
                    <label class="text-[14px]">Reference *</label>
                    <input type="text" v-model="form.reference"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Reference" />
                    <small class="text-red-600">{{ form.errors.reference }}</small>
                </div>

               
                <div class="col-span-6">
                    <label class="text-[14px]">Date*</label>
                   <input type="date" v-model="form.date"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="To Phone Number" />
                    <small class="text-red-600">{{ form.errors.date }}</small>
                </div>
                

                <div class="col-span-12">
                    <label class="text-[14px]">Remarks</label>
                    <textarea v-model="form.remarks"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Remarks">

                </textarea>

                    <small class="text-red-600">{{ form.errors.address }}</small>
                </div>

                <div class="col-span-12 mt-4 bg-gray-100 p-3 rounded flex justify-end">
                    <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" type="submit">
                        {{ postalReceive?.id ? 'Update Postal Receive' : 'Save Postal Receive' }}
                    </button>
                </div>
            </div>
        </form>
    </Modal>
</template>

<style scoped>
.checkbox-wrapper {
    display: flex;
    align-items: center;
    cursor: pointer;
    font-size: 16px;
}

/* Hide default checkbox */
.checkbox-wrapper input[type="checkbox"] {
    opacity: 0;
    width: 0;
    height: 0;
}

/* Custom checkmark box */
.checkmark {
    width: 18px;
    height: 18px;
    border: 2px solid #4a90e2;
    border-radius: 4px;
    margin-right: 8px;
    position: relative;
    transition: all 0.2s ease;
}

/* Checkmark indicator */
.checkbox-wrapper input:checked+.checkmark {
    background-color: #4a90e2;
    border-color: #4a90e2;
}

.checkmark::after {
    content: "";
    position: absolute;
    display: none;
}

.checkbox-wrapper input:checked+.checkmark::after {
    display: block;
    left: 5px;
    top: 2px;
    width: 4px;
    height: 8px;
    border: solid white;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}
</style>
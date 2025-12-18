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
    callLog: {
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
    name: props.callLog?.name ?? '',
    phone: props.callLog?.phone ?? '',
    follow_up_date: props.callLog?.follow_up_date ?? '',
    call_type: props.callLog?.call_type ?? 'Incomming Call',
    remarks: props.callLog?.remarks ?? '',

});

const submit = () => {
    if (props.callLog?.id) {
        updateData();
    } else {
        saveData();
    }
}


const saveData = () => {
    form.post(route('callLog.store'), {
        onSuccess: () => {
            form.name="";
            form.phone="";
            form.follow_up_date="";
            form.call_type="Incomming Call";
            form.remarks="";
            toggleModal();
        }
    })
}

const updateData = () => {
    form.put(route('callLog.update', props.callLog), {
        onSuccess: () => {
            form.name="";
            form.phone="";
            form.follow_up_date="";
            form.call_type="Incomming Call";
            form.remarks="";
            toggleModal();
        }
    })
}

const taxes = ref([]);

onMounted(() => {
    fetchTaxes();
    if (props.callLog?.id) {
        toggleModal();
    }

});

const fetchTaxes = async () => {
    const response = await axios.get(route('tax.all'));
    taxes.value = response.data.taxes;

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
            v-else>Add Call Log</button>

    </div>

    <Modal :show="openModal" maxWidth="xl" :title="callLog?.id ? 'Edit callLog' : 'Add callLog'" @close="toggleModal"
        :selectedData="callLog">

        <form @submit.prevent="submit">
            <div class="grid grid-cols-12 gap-3">
                <div class="col-span-12">
                    <label class="text-[14px]">Full Name *</label>
                    <input type="text" v-model="form.name"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Full Name" />
                    <small class="text-red-600">{{ form.errors.name }}</small>
                </div>
                <div class="col-span-4">
                    <label class="text-[14px]">Phone *</label>
                    <input type="text" v-model="form.phone"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Phone number" />
                    <small class="text-red-600">{{ form.errors.phone }}</small>
                </div>

                <div class="col-span-4">
                    <label class="text-[14px]">Next Follow Date *</label>
                    <input type="date" v-model="form.follow_up_date"
                        class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Store Address" />
                    <small class="text-red-600">{{ form.errors.follow_up_date }}</small>
                </div>
                <div class="col-span-4">
                    <label class="text-[14px]">Call Type*</label>
                    <select v-model="form.call_type" class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="Incomming Call">Incomming Call</option>
                        <option value="Outgoing Call">Outgoing Call</option>
                    </select>
                    <small class="text-red-600">{{ form.errors.in_time }}</small>
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
                        {{ callLog?.id ? 'Update Call Log' : 'Save Call Log' }}
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
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
    store: {
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
    name: props.store?.name ?? '',
    address: props.store?.address ?? '',
    
});

const submit = () => {
    if (props.store?.id) {
        updateData();
    } else {
        saveData();
    }
}


const saveData = () => {
    form.post(route('store.store'), {
        onSuccess: () => {
            form.reset();
            toggleModal();
        }
    })
}

const updateData = () => {
    form.put(route('store.update', props.store), {
        onSuccess: () => {
            form.reset();
            toggleModal();
        }
    })
}

const taxes = ref([]);

onMounted(() => {
    fetchTaxes();
    if(props.store?.id){
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
            v-else>Add Store</button>

    </div>

    <Modal :show="openModal" maxWidth="sm" :title="store?.id ? 'Edit Store' : 'Add Store'" @close="toggleModal"
        :selectedData="store">

        <form @submit.prevent="submit">
            <div class="col-span-3">
                <label class="text-[14px]">Store Name *</label>
                <input type="text" v-model="form.name"
                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Store Name" />
                <small class="text-red-600">{{ form.errors.name }}</small>
            </div>
            <div class="col-span-3">
                <label class="text-[14px]">Store Address *</label>
                <input type="text" v-model="form.address"
                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Store Address" />
                <small class="text-red-600">{{ form.errors.address }}</small>
            </div>

            <div class="col-span-12 mt-4 bg-gray-100 p-3 rounded flex justify-end">
                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" type="submit">
                    {{ store?.id ? 'Update Store' : 'Save Store' }}
                </button>
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
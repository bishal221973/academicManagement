<script setup>
import { onMounted, ref, watch } from "vue";
import Modal from "../Modal.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import { Plus } from "lucide-vue-next";
import axios from "axios";
import SelectProduct from "../Select/SelectProduct.vue";
import SelectProductCategory from "../Select/SelectProductCategory.vue";
import Datepicker from "../Datepicker.vue";
import SelectSupplier from "../Select/SelectSupplier.vue";
const props = defineProps({
    isSelect: {
        type: Boolean,
        default: false,
    },
    productPurchase: {
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
    product_category_id: "",
    product_id: props.productPurchase?.product_id ?? '',
    supplier_id: props.productPurchase?.supplier_id ?? '',
    purchase_date: props.productPurchase?.purchase_date ?? '',
    purchase_qty: props.productPurchase?.purchase_qty ?? '',

});

const submit = () => {
    if (props.productPurchase?.id) {
        updateData();
    } else {
        saveData();
    }
}


const saveData = () => {
    form.post(route('productPurchase.store'), {
        onSuccess: () => {
            form.reset();
            toggleModal();
        }
    })
}

const updateData = () => {
    form.put(route('productPurchase.update', props.productPurchase), {
        onSuccess: () => {
            form.reset();
            toggleModal();
        }
    })
}

const taxes = ref([]);

onMounted(() => {
    fetchTaxes();
    if (props.productPurchase?.id) {
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
            v-else>Add Purchase</button>
    </div>

    <Modal :show="openModal" maxWidth="sm" :title="productPurchase?.id ? 'Edit Purchase' : 'Add Purchase'" @close="toggleModal"
        :selectedData="productPurchase">

        <form @submit.prevent="submit">
            <div class="col-span-3">
                <label class="text-[14px]">Category *</label>
                <SelectProductCategory v-model="form.product_category_id" />
                <small class="text-red-600">{{ form.errors.product_category_id }}</small>
            </div>
            <div class="col-span-3">
                <label class="text-[14px]">Product *</label>
                <SelectProduct v-model="form.product_id" :categoryId="form.product_category_id"/>
                <small class="text-red-600">{{ form.errors.name }}</small>
            </div>
            <div class="col-span-3">
                <label class="text-[14px]">Supplier *</label>
                <SelectSupplier v-model="form.supplier_id" :categoryId="form.product_category_id"/>
                <small class="text-red-600">{{ form.errors.supplier_id }}</small>
            </div>
            <div class="col-span-3">
                <label class="text-[14px]">Purchase Date</label>
                <Datepicker v-model="form.purchase_date"/>
                <small class="text-red-600">{{ form.errors.email }}</small>
            </div>
            <div class="col-span-3">
                <label class="text-[14px]">Quantity</label>
                <input type="number" step="0.01" v-model="form.purchase_qty"
                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Purchase Qty" />
                <small class="text-red-600">{{ form.errors.purchase_qty }}</small>
            </div>

            <div class="col-span-12 mt-4 bg-gray-100 p-3 rounded flex justify-end">
                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" type="submit">
                    {{ supplier?.id ? 'Update Supplier' : 'Save Supplier' }}
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
<script setup>
import { onMounted, ref, watch } from "vue";
import Modal from "../Modal.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import { Plus } from "lucide-vue-next";
import Datepicker from "../Datepicker.vue";
import SelectComponent from "@/Components/SelectComponent.vue";
import SelectCourse from "../Select/SelectCourse.vue";
import SelectSection from "../Select/SelectSection.vue";
import SelectGroup from "../Select/SelectGroup.vue";
import ImageUploader from "../ImageUploader.vue";
import ImageUploader1 from "../ImageUploader1.vue";
import Switch from "../Switch.vue";
import Toggle from "../Toggle.vue";
import axios from "axios";
import MultiMonthSelect from "../MultiMonthSelect.vue";
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

const addTax = () => {
    form.taxes.push({ tax_id: null, percentage: 0 })
}

const removeTax = (index) => {
    form.taxes.splice(index, 1)
}

const isSelected = (tax) => {
    return form.taxes.some(t => t.tax_id === tax.id)
}

const toggleTax = (tax) => {
    const index = form.taxes.findIndex(t => t.tax_id === tax.id)
    if (index === -1) {
        // Add tax
        form.taxes.push({ tax_id: tax.id, name: tax.name, percentage: tax.percentage })
    } else {
        // Remove tax
        form.taxes.splice(index, 1)
    }
    computeTotalAmount(netTotalAmount.value)
}
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

const dateOptions = [
    { label: "Male", value: "Male" },
    { label: "Female", value: "Female" },
];
const religionOptions = [
    { label: "Hindu", value: "Hindu" },
    { label: "Muslim", value: "Muslim" },
    { label: "Christian", value: "Christian" },
    { label: "Buddhist", value: "Buddhist" },
    { label: "Other", value: "Other" },
];

const castOptions = [
    { label: "Brahmin", value: "Brahmin" },
    { label: "Chhetri", value: "Chhetri" },
    { label: "Magar", value: "Magar" },
    { label: "Rai", value: "Rai" },
    { label: "Limbu", value: "Limbu" },
    { label: "Newar", value: "Newar" },
    { label: "Tharu", value: "Tharu" },
    { label: "Tamang", value: "Tamang" },
    { label: "Dalit", value: "Dalit" },
    { label: "Other", value: "Other" },
];
function handleFileChange(event) {
    const file = event.target.files[0];
    if (file) {
        form.transfer_certificate = file;
        console.log('Selected file:', file);
    }
}

const isTaxOpen = ref(false);
const toggleTaxes = () => {
    isTaxOpen.value = !isTaxOpen.value;
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
const monthlyFees = ref(0);
watch(
    () => form.course_id,
    async (newVal, oldVal) => {
        if (!newVal) return

        try {
            const response = await axios.get(route('course.find', newVal))
            monthlyFees.value = response.data?.course?.fees;

            computeTutionFee();
        } catch (error) {
            console.error('Failed to fetch course details:', error)
        }
    }
)
watch(
    () => form.months,
    (newVal, oldVal) => {
        computeTutionFee();
    }
)

const computeTutionFee = () => {
    const fees = monthlyFees.value * form.months.length;
    form.tution_fees = fees ?? 0;
}


const netTotalAmount = ref(0);
const discountAmount = ref(0)
const computeNetTotal = (netAmount, discount) => {
    const netAmt = Number(netAmount) - Number(discount);
    netTotalAmount.value = Number(netAmt).toFixed(2);
    form.net_total = netAmt;
    computeTotalAmount(netAmt)
}

const totalAmountVal = ref(0);
const computeTotalAmount = (amt) => {
    let totalAmt = 0;

    
    const total = Number(amt) + Number(totalAmt);
    totalAmountVal.value = total;
    form.total_amount = total;
}

const subTotal = ref(0);
const computeSubTotal = (admittionFee) => {

    const tutionFees = form.tution_fees;
    subTotal.value = Number(admittionFee) + Number(tutionFees)
    computeNetTotal(subTotal.value, discountAmount.value)
    form.sub_total = Number(admittionFee) + Number(tutionFees);
}
watch(
    [() => form.months, () => form.course_id, () => form.admission_fees],
    () => computeSubTotal(form.admition_fees),
    { immediate: true }
)


const computeDiscount = () => {
    if (form.is_percentage) {
        if (subTotal.value > 0) {
            const discount = subTotal.value * form.discount / 100;
            discountAmount.value = discount.toFixed(2);
        } else {
            discountAmount.value = '0.0';
        }
    } else {
        discountAmount.value = Number(form.discount).toFixed(2);
    }
    computeNetTotal(subTotal.value, discountAmount.value)
}
watch(
    [() => form.is_percentage, () => form.discount],
    () => {
        // alert('hello')
        computeDiscount()
    }
)

const computePercentageAmount = (netAmt, percent) => {
    const percentage = netAmt * percent / 100;
    return percentage;
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
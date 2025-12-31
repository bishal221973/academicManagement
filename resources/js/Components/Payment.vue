<script setup>
import { ref, watch } from "vue";
import Modal from "./Modal.vue";
import SelectInvoice from "./Select/SelectInvoice.vue";
import SelectPaymentMode from "./Select/SelectPaymentMode.vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
  billID: String,
  studentId: String
});
const openModal = ref(false);

const toggleModal = () => {
  openModal.value = !openModal.value;
};

const bill_id = ref(props.billID);


const payment_date = ref(
  new Date().toISOString().split('T')[0]
);

const form=useForm({
  bill_id:"",
  payment_mode_id:1,
  payment_date:payment_date.value,
  amount:0,
  remarks:"",
  student_id:props.studentId
})
const fetchBill=async(newVal)=>{
  const response = await axios.get(route("billing.find",newVal));
  console.log(response.data)
  form.bill_id=response.data.id;
  form.amount=response.data.total_amount - response.data.total_paid;
}

watch(
  () => props.billID,
  (newVal) => {
    if(!newVal) return
    bill_id.value = newVal;
    // alert(bill_id.value);
    fetchBill(newVal)

  },
  { immediate: true }
);

const submit = () => {
  form.post(route("payment.store"),{
    onSuccess:()=>{
      form.reset();
      toggleModal();
    }
  });
}
</script>
<template>
  <button @click="toggleModal" class="text-blue-600 hover:underline">
    <i class="fa fa-money-bill"></i> Make Payment
  </button>
  <Modal :show="openModal" :title="'Make Payment'" :maxWidth="'md'" @close="toggleModal">
    <form @submit.prevent="submit">
      <div class="mb-3">
        <label for="">Bill Number</label>
        <SelectInvoice v-model="form.bill_id"/>
      </div>
      <div class="mb-3">
        <label for="">Payment Mode</label>
        <SelectPaymentMode v-model="form.payment_mode_id"/>
      </div>
      <div class="mb-3">
        <label for="">Payment Date</label>
        <input
            v-model="form.payment_date"
          type="date"
          class="text-[12px] w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
      </div>
       <div class="mb-3">
        <label for="">Amount</label>
        <input
            v-model="form.amount"
          type="number"
          step="0.05"
          placeholder="Amount"
          class="text-[12px] w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
      </div>
      <div class="mb-3">
        <label for="">Remarks</label>
        <textarea
          v-model="form.remarks"
          placeholder="Remarks"
          rows="4"
          class="text-[12px] w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
        ></textarea>
      </div>

      <div class="flex justify-end">
        <button
          class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
          type="submit"
        >
          Make Payment
        </button>
      </div>
    </form>
  </Modal>
</template>

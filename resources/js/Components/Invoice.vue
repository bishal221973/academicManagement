<script setup>
import { Link, useForm, usePage } from "@inertiajs/vue3";
import Modal from "./Modal.vue";
import { computed, ref } from "vue";
import Logo from "./Logo.vue";
const openModal = ref(false);
const props = defineProps({
  invoiceID: String,
});

const toggleModal = () => {
  openModal.value = !openModal.value;
};
const bill = ref([]);
const fetchBill = async () => {
  const response = await axios.get(route("billing.findBillingID", props.invoiceID));
  console.log(response.data);
  bill.value = response.data;
  toggleModal();
};

//     const academyName = props.settings.find((setting) => setting.key === "academy_name");
// const academyEmail = props.settings.find((setting) => setting.key === "academy_email");
// const regDate = props.settings.find((setting) => setting.key === "reg_date_bs");
// const contactNo = props.settings.find((setting) => setting.key === "academy_contact_no");
// const vat = props.settings.find((setting) => setting.key === "vat_pan");
// const address = props.settings.find((setting) => setting.key === "address");

const academy = usePage().props.academy;

const formattedDate = computed(() =>
  bill?.value?.created_at
    ? new Date(bill?.value?.created_at).toISOString().split("T")[0]
    : ""
);

const nepaliMonthsEn = [
  "", // index 0 unused
  "Baisakh",
  "Jestha",
  "Ashadh",
  "Shrawan",
  "Bhadra",
  "Ashwin",
  "Kartik",
  "Mangsir",
  "Poush",
  "Magh",
  "Falgun",
  "Chaitra",
];
const numberToWords = (num) => {
  if (!num || isNaN(num)) return "";

  const a = [
    "", "One", "Two", "Three", "Four", "Five",
    "Six", "Seven", "Eight", "Nine", "Ten",
    "Eleven", "Twelve", "Thirteen", "Fourteen",
    "Fifteen", "Sixteen", "Seventeen", "Eighteen", "Nineteen"
  ];

  const b = [
    "", "", "Twenty", "Thirty", "Forty",
    "Fifty", "Sixty", "Seventy", "Eighty", "Ninety"
  ];

  const inWords = (n) => {
    if (n < 20) return a[n];
    if (n < 100)
      return b[Math.floor(n / 10)] + (n % 10 ? " " + a[n % 10] : "");
    if (n < 1000)
      return (
        a[Math.floor(n / 100)] +
        " Hundred" +
        (n % 100 ? " " + inWords(n % 100) : "")
      );
    if (n < 100000)
      return (
        inWords(Math.floor(n / 1000)) +
        " Thousand" +
        (n % 1000 ? " " + inWords(n % 1000) : "")
      );
    if (n < 10000000)
      return (
        inWords(Math.floor(n / 100000)) +
        " Lakh" +
        (n % 100000 ? " " + inWords(n % 100000) : "")
      );

    return "";
  };

  return inWords(Number(num)) + " Only";
};

const subTotalInWords = computed(() =>
  bill?.value?.sub_total
    ? numberToWords(bill.value.sub_total)
    : ""
);
</script>
<template>
  <button class="text-blue-500" @click="fetchBill">{{ invoiceID }}</button>
  <Modal :show="openModal" @close="toggleModal" title="Invoice">
    <div>
      <div class="flex gap-3 items-center">
        <Logo class="h-[50px]" />
        <div>
          <span class="text-[20px] block font-bold">{{ academy.name }}</span>
          <span class="text-[15px] block">{{ academy.address }}</span>
          <span class="text-[15px] mr-5" v-if="academy.academy_email"
            ><i class="fa fa-envelope text-[12px] text-blue-400 mr-1"></i
            >{{ academy.academy_email }}</span
          >
          <span class="text-[15px]" v-if="academy.phone">
            <i class="fa fa-phone text-[12px] text-blue-400 mr-1"></i
            >{{ academy.phone }}</span
          >
        </div>
      </div>

      <div class="mt-5">
        <span class="text-[15px]">Invoice To</span>

        <div class="flex justify-between">
          <div>
            <b class="text-[18px]">{{ bill?.student?.name }}</b>
            <span class="text-[14px] block" v-if="bill?.student?.phone">
              <i class="fa fa-phone text-[12px] text-gray-400 mr-1"></i
              >{{ bill?.student?.phone }}</span
            >
            <span class="text-[14px] block" v-if="bill?.student?.email">
              <i class="fa fa-envelope text-[12px] text-gray-400 mr-1"></i
              >{{ bill?.student?.email }}</span
            >
          </div>
          <div>
            <div class="flex">
              <b class="block w-[100px]">Bill number:</b
              ><span class="block">{{ bill?.bill_no }}</span>
            </div>
            <div class="flex">
              <b class="block w-[100px]">Date:</b
              ><span class="block">{{ formattedDate }}</span>
            </div>
          </div>
        </div>
      </div>

      <div>
        <table class="w-full mt-5">
          <thead class="bg-blue-400">
            <tr>
              <th class="text-left p-2 text-white">S.N.</th>
              <th class="text-left p-2 text-white">Description</th>
              <th class="text-left p-2 text-white">Rate</th>
              <th class="text-left p-2 text-white">Qty</th>
              <th class="text-left p-2 text-white">Amount</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in bill?.items" :key="index" :class="index%2==1 ? 'bg-gray-100' : ''">
              <td class="text-left p-2">{{ index + 1 }}</td>
              <td class="text-left p-2">
                {{ item?.title }}
                <div v-if="item.title == 'Tution Fees'">
                  (<span > {{ bill.months.map(m => nepaliMonthsEn[m.month]).join(' / ') }}</span>)
                </div>
              </td>
              <td class="text-left p-2">
                <div v-if="item.title == 'Tution Fees'">
                  Rs. {{ bill.months[0]?.amount }}
                </div>
                <div v-else>
                  Rs. {{ item?.amount }}
                </div>
              </td>
              <td class="text-left p-2">
                <div v-if="item.title == 'Tution Fees'">
                  {{ bill.months.length }}
                </div>
                <div v-else>
                  {{ item?.qty <= 0 ? 1 : item?.qty }}
                </div></td>
              <td class="text-left p-2">Rs. {{ item?.amount }}</td>
            </tr>

          </tbody>
        </table>
        <div class="flex mt-3 justify-between">
            <div class="block">
                <b class="text-[18px] uppercase block">Payment Info</b>
                <small>{{ numberToWords(bill.total_amount)  }}</small>
            </div>

            <div>
                <div class="flex border-b-[2px] py-2">
                    <b>Sub Total:</b><b class="ml-2">Rs. {{ bill.sub_total }}</b>
                </div>
                 <div class="flex border-b-[2px] py-2">
                    <b>Discount:</b><b class="ml-2">Rs. {{ bill?.discount }}</b>
                </div>
                <div class="flex border-b-[2px] py-2" v-for="tax in bill?.taxes" :key="tax.id">
                    <b>{{ tax?.tax?.name }}({{ tax?.tax?.percentage }}%):</b><b class="ml-2">Rs. {{ tax?.amount }}</b>
                </div>
                <div class="flex border-b-[2px] py-2">
                    <b>Total:</b><b class="ml-2">Rs. {{ bill.total_amount }}</b>
                </div>
            </div>
        </div>
      </div>
    </div>
  </Modal>
</template>

<script setup>
import axios from 'axios';
import { onMounted, ref } from 'vue';

const props = defineProps({
    title: String,
    count: String,
    color: String,
    icon: String
})

onMounted(()=>{
    countStudents();
});

const totalAmount=ref(0);
const countStudents=async()=>{
    const response=await axios.get(route('billing.totalReceivable'));
    totalAmount.value=response.data;
}
</script>
<template>
    <div class=" p-3 rounded-md shadow-md bg-yellow-50">
        <div class="flex items-center gap-3">
            <div>
                <i class="fa fa-money-bill text-[50px] text-yellow-300"></i>
                <!-- <i class="fa-solid fa-graduation-cap text-[50px] text-red-300"></i> -->
            </div>
            <div class="block">
                <span class="block text-[12px] text-gray-700 bold uppercase">
                    Total Amount
                </span>
                <span class="text-[20px] bold font-bold text-yellow-400">
                    Rs. {{ totalAmount }}
                </span>
            </div>
        </div>
    </div>

</template>
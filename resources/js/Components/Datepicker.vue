<script setup>
import axios from 'axios';
import { onMounted, ref } from 'vue';

onMounted(()=>{
    fetchData();
})
const datas=ref([]);
const fetchData=async()=>{
    const response=await axios.get(route('configuration.api'));

    console.log(response.data)
    datas.value=response.data;
}
</script>
<template>
    <div class="w-full">
        <!-- {{ datas['date_type'] }} -->
        <input v-if="datas['date_type'] == 'ad'" type="date" class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <input type="text" placeholder="YYYY-MM-DD" v-else class="nepali-datepicker w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
</template>
<script setup>
import axios from 'axios';
import { onMounted, ref } from 'vue';
import NepaliDatePicker from 'vue3-nepali-date-picker';
import 'vue3-nepali-date-picker/dist/style.css';
const props = defineProps({
  modelValue: [String, Number] // the value coming from parent
});
onMounted(()=>{
    fetchData();
})
const datas=ref([]);
const fetchData=async()=>{
    const response=await axios.get(route('configuration.api'));

    console.log(response.data)
    datas.value=response.data;
}
const emit = defineEmits(['update:modelValue']);
</script>
<template>
    <div class="w-full">
        <!-- {{ datas['date_type'] }} -->
        <input v-if="datas['date_type'] == 'ad'" :value="modelValue"
  @input="(e) => emit('update:modelValue', e.target.value)" type="date" class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <div v-else class="w-full border-[1px] border-gray-300 rounded pl-3 pr-[3px] py-[2.4px] mt-[3px]">
            <NepaliDatePicker class="date-picker" @update:modelValue="(value) => emit('update:modelValue', value)" :language="'english'"/>

        </div>
        <!-- <input type="text" placeholder="YYYY-MM-DD" v-else class="nepali-datepicker w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"> -->
    </div>
</template>

<style scoped>
::v-deep(.date-picker-wrapper .label) {
  display: none !important;
}

::v-deep(.date-picker-wrapper input) {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 5px;
  border: none;
  padding: 0px !important;
}

::v-deep(.date-picker-wrapper input:focus) {
  border: none;
  box-shadow: none;
}

/* ::v-deep(.date-picker-wrapper span) {
 display: none;
} */
::v-deep(.date-picker-wrapper) {
 /* margin-top: 4px; */
}
</style>
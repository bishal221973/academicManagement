<script setup>
import axios from 'axios';
import { onMounted, ref, watch } from 'vue';
import NepaliDatePicker from 'vue3-nepali-date-picker';
import 'vue3-nepali-date-picker/dist/style.css';

const props = defineProps({
  modelValue: [String, Number]
});
const emit = defineEmits(['update:modelValue']);

const datas = ref([]);
const localDate = ref(props.modelValue || null); // Local proxy

// Sync incoming prop updates
watch(() => props.modelValue, (newVal) => {
  localDate.value = newVal;
});

// Emit to parent when localDate changes
watch(localDate, (newVal) => {
  emit('update:modelValue', newVal);
});

onMounted(() => {
  fetchData();
  if(!props.modelValue ){

      localDate.value = null; // Start empty
  }
});

const fetchData = async () => {
  const response = await axios.get(route('configuration.api'));
  datas.value = response.data;
};
</script>

<template>
  <div class="w-full">
    <input v-if="datas['date_type'] === 'ad'"
           :value="localDate"
           @input="(e) => localDate = e.target.value"
           type="date"
           class="w-full border border-gray-300 rounded px-3 py-[7px] mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500" />

    <div v-else class="w-full border-[1px] border-gray-300 rounded pl-3 pr-[3px] py-[2.4px] mt-[3px]">
      <NepaliDatePicker
        class="date-picker"
        :modelValue="localDate"
        @update:modelValue="(value) => localDate = value"
        :language="'english'"
      />
    </div>
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
<script setup>
import SelectComponent from '../SelectComponent.vue';
import AddCourse from '../AddForm/AddCourse.vue';
import { computed, onMounted, ref } from 'vue';
import AddUnit from '../AddForm/AddUnit.vue';
import AddProductCategory from '../AddForm/AddProductCategory.vue';
const props = defineProps({
  modelValue: [String, Number]
});

const emit = defineEmits(["update:modelValue"]);

const courseList = ref([]);

const fetchData = async () => {
  const response = await axios.get(route("unit.get.all"));
  courseList.value = response.data.units;
};

onMounted(() => {
  fetchData();

  Pusher.logToConsole = true;

  var pusher = new Pusher('09a7a9ef059d4f63aa24', {
      cluster: 'ap2'
    });

  const channel = pusher?.subscribe("my-channel");

  channel.bind("unit-event", () => {
    fetchData();
  });
});

const transformData = (data) => {
  if (data) {
    return data.map((item) => ({
      label: item?.name,
      value: item.id,
    }));
  }
  return [];
};
const formattedServiceData = computed(() => transformData(courseList.value));
</script>
<template>
    <div class="w-full border-[1px] border-gray-300 rounded-md flex px-3">
        <SelectComponent :options="formattedServiceData" 
        label="Date Format *"
         placeholder="Select unit"
          :isForm="true"
          @update:modelValue="val => emit('update:modelValue', val)"
          :modelValue="modelValue" />
        <AddUnit :isSelect="true"/>
    </div>
</template>
<script setup>
import SelectComponent from '../SelectComponent.vue';
import AddSection from '../AddForm/AddSection.vue';
import { computed, onMounted, ref } from 'vue';
import AddHostel from '../AddForm/AddHostel.vue';
const dateOptions = [
    { label: "AD Date", value: "ad" },
    { label: "BS Date", value: "bs" },
    // Add as many options as needed
];

const props = defineProps({
  modelValue: [String, Number], // the value coming from parent
  course_id: [String, Number]
});

const emit = defineEmits(["update:modelValue"]);

const courseList = ref([]);

const fetchSection = async () => {
  const response = await axios.get(route("hostel.all"));
  courseList.value = response.data.hostels;
};

onMounted(() => {
  fetchSection();

  Pusher.logToConsole = true;

  var pusher = new Pusher('09a7a9ef059d4f63aa24', {
      cluster: 'ap2'
    });

  const channel = pusher.subscribe("my-channel");

  channel.bind("hostel-event", () => {
    fetchSection();
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
         placeholder="Select section"
          :isForm="true"
          @update:modelValue="val => emit('update:modelValue', val)"
          :modelValue="modelValue" />
        <AddHostel :isSelect="true"/>
    </div>
</template>
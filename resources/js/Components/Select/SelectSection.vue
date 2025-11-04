<script setup>
import SelectComponent from '../SelectComponent.vue';
import AddSection from '../AddForm/AddSection.vue';
import { computed, onMounted, ref, watch } from 'vue';
const dateOptions = [
    { label: "AD Date", value: "ad" },
    { label: "BS Date", value: "bs" },
    // Add as many options as needed
];

const props = defineProps({
  modelValue: [String, Number], // the value coming from parent
  courseId: [String, Number]
});

const emit = defineEmits(["update:modelValue"]);

const courseList = ref([]);

const fetchSection = async (courseId=null) => {
  const response = await axios.get(route("section.all")+'?course_id='+courseId);
  courseList.value = response.data.sections;
};

onMounted(() => {
  fetchSection();

  Pusher.logToConsole = true;

  var pusher = new Pusher('09a7a9ef059d4f63aa24', {
      cluster: 'ap2'
    });

  const channel = pusher.subscribe("my-channel");

  channel.bind("section-event", () => {
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
watch(() => props.courseId, (newVal) => {
  fetchSection(newVal)
});

</script>
<template>
    <div class="w-full border-[1px] border-gray-300 rounded-md flex px-3">
        <SelectComponent :options="formattedServiceData" 
        label="Date Format *"
         placeholder="Select section"
          :isForm="true"
          @update:modelValue="val => emit('update:modelValue', val)"
          :modelValue="modelValue" />
        <AddSection :isSelect="true"/>
    </div>
</template>
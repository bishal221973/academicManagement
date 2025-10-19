<script setup>
import SelectComponent from '../SelectComponent.vue';
import AddCourse from '../AddForm/AddCourse.vue';
import { computed, onMounted, ref } from 'vue';
const dateOptions = [
    { label: "AD Date", value: "ad" },
    { label: "BS Date", value: "bs" },
];

const props = defineProps({
  modelValue: [String, Number]
});

const emit = defineEmits(["update:modelValue"]);

const courseList = ref([]);

const fetchCourse = async () => {
  const response = await axios.get(route("course.getCourse"));
  courseList.value = response.data.courses;
};

onMounted(() => {
  fetchCourse();

  // Pusher.logToConsole = true;

  // var pusher = new Pusher('09a7a9ef059d4f63aa24', {
  //     cluster: 'ap2'
  //   });

  // const channel = pusher?.subscribe("my-channel");

  // channel.bind("course-event", () => {
  //   fetchCourse();
  // });
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
         placeholder="Select course"
          :isForm="true"
          @update:modelValue="val => emit('update:modelValue', val)"
          :modelValue="modelValue" />
        <AddCourse :isSelect="true"/>
    </div>
</template>
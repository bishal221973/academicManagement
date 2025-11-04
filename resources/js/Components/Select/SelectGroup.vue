<script setup>
import SelectComponent from '../SelectComponent.vue';
import AddGroup from '../AddForm/AddGroup.vue';
import { computed, onMounted, ref } from 'vue';

const props = defineProps({
  modelValue: [String, Number]
});

const emit = defineEmits(["update:modelValue"]);

const courseList = ref([]);

const fetchGroup = async () => {
  const response = await axios.get(route("group.all"));
  courseList.value = response.data.groups;
};

onMounted(() => {
  fetchGroup();

  Pusher.logToConsole = true;

  var pusher = new Pusher('09a7a9ef059d4f63aa24', {
      cluster: 'ap2'
    });

  const channel = pusher?.subscribe("my-channel");

  channel.bind("group-event", () => {
    fetchGroup();
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
         placeholder="Select group"
          :isForm="true"
          @update:modelValue="val => emit('update:modelValue', val)"
          :modelValue="modelValue" />
        <AddGroup :isSelect="true"/>
    </div>
</template>